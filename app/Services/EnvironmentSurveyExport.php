<?php

namespace App\Services;

use App\Models\EnvironmentSurvey;
use App\Support\EnvironmentSurveyDefinition as Definition;
use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class EnvironmentSurveyExport
{
    public function download(EnvironmentSurvey $survey): StreamedResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        return response()->streamDownload(function () use ($survey): void {
            $path = tempnam(sys_get_temp_dir(), 'bvmt-excel-');
            try {
                $this->write($survey, $path);
                readfile($path);
            } finally {
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }, 'BVMT-2026-'.$survey->reference.'.xlsx', ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    public function write(EnvironmentSurvey $survey, string $path): void
    {
        $survey->loadMissing('files');
        $data = $survey->data ?? [];
        $writer = new Writer;
        $writer->openToFile($path);
        try {
            foreach (Definition::steps() as $step => $title) {
                $sheet = $step === 1 ? $writer->getCurrentSheet() : $writer->addNewSheetAndMakeItCurrent();
                $sheet->setName($title);
                $sheet->setColumnWidthForRange(30, 1, 8);
                if ($step === 1) {
                    $this->row($writer, ['Mã phiếu', $survey->reference]);
                    $this->row($writer, ['Trạng thái', Definition::statuses()[$survey->status]]);
                    $this->row($writer, ['Ngày gửi', $survey->submitted_at?->format('d/m/Y H:i')]);
                    $this->row($writer, ['Nguồn số liệu 2025', ($data['has_environment_report_2025'] ?? false) ? 'Báo cáo công tác BVMT năm 2025' : 'Doanh nghiệp nhập trực tiếp']);
                }
                foreach (Definition::fields($step) as $key => $field) {
                    if (Definition::visible($field, $data)) {
                        $this->row($writer, [$field['label'], $this->value($data[$key] ?? null, $field)]);
                    }
                }
                foreach (Definition::tables($step) as $key => $table) {
                    $fields = array_filter($table['fields'], fn (array $field): bool => Definition::visible($field, $data));
                    $this->row($writer, [$table['label']], true);
                    $this->row($writer, array_column($fields, 'label'), true);
                    foreach ($data[$key] ?? [] as $record) {
                        $values = [];
                        foreach ($fields as $name => $field) {
                            $values[] = $this->value($record[$name] ?? null, $field);
                        }
                        $this->row($writer, $values);
                    }
                }
                if ($step === 6) {
                    $this->row($writer, ['Hồ sơ', 'Trạng thái', 'Ghi chú', 'Số tệp'], true);
                    foreach (Definition::documents() as $category => $label) {
                        $document = $data['documents'][$category] ?? [];
                        $this->row($writer, [$label, ['available' => 'Có', 'not_available' => 'Không có', 'pending' => 'Đang bổ sung'][$document['status'] ?? ''] ?? 'Chưa khai báo', $document['note'] ?? '', $survey->files->where('category', $category)->count()]);
                    }
                }
            }
            $writer->addNewSheetAndMakeItCurrent()->setName('Tệp đính kèm');
            $this->row($writer, ['Nhóm hồ sơ', 'Tên tệp', 'MIME', 'Dung lượng (byte)', 'Thời gian tải'], true);
            foreach ($survey->files as $file) {
                $this->row($writer, [Definition::documents()[$file->category] ?? $file->category, $file->original_name, $file->mime_type, $file->size, $file->uploaded_at->format('d/m/Y H:i')]);
            }
            $writer->addNewSheetAndMakeItCurrent()->setName('Lịch sử');
            $this->row($writer, ['Thời gian', 'Hành động', 'Bước', 'Trạng thái', 'Ghi chú'], true);
            foreach ($survey->history ?? [] as $event) {
                $this->row($writer, [$event['at'], $event['action'], $event['step'] ?? null, Definition::statuses()[$event['status'] ?? ''] ?? '', $event['note'] ?? '']);
            }
        } finally {
            $writer->close();
        }
    }

    public function archive(EnvironmentSurvey $survey): BinaryFileResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);
        $survey->loadMissing('files');
        abort_if($survey->files->isEmpty(), 404, 'Phiếu chưa có tệp đính kèm.');
        $path = tempnam(sys_get_temp_dir(), 'bvmt-zip-');
        $zip = new ZipArchive;
        try {
            if ($zip->open($path, ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Không tạo được ZIP.');
            }
            foreach ($survey->files as $file) {
                if (! Storage::disk('local')->exists($file->path)) {
                    throw new \RuntimeException('Không tìm thấy tệp '.$file->original_name.'.');
                }
                $name = preg_replace('/[\\\\\/:*?"<>|\x00-\x1F]/u', '_', $file->original_name);
                $zip->addFile(Storage::disk('local')->path($file->path), $file->category.'/'.$file->id.'-'.$name);
            }
            $zip->close();
        } catch (\Throwable $exception) {
            if (is_file($path)) {
                unlink($path);
            }
            throw $exception;
        }

        return response()->download($path, 'Ho-so-BVMT-2026-'.$survey->reference.'.zip')->deleteFileAfterSend(true);
    }

    /** @param array<string, mixed> $field */
    private function value(mixed $value, array $field): string|int|float|null
    {
        if ($value === null || $value === '') {
            return null;
        }
        if (in_array($field['type'], ['boolean', 'checkbox'], true)) {
            return $value ? 'Có' : 'Không';
        }
        if ($field['type'] === 'select') {
            return $field['options'][$value] ?? (string) $value;
        }
        if (in_array($field['type'], ['integer', 'decimal', 'month'], true)) {
            return $field['type'] === 'decimal' ? (float) $value : (int) $value;
        }

        return (string) $value;
    }

    /** @param list<string|int|float|null> $values */
    private function row(Writer $writer, array $values, bool $header = false): void
    {
        $style = (new Style)->setShouldWrapText();
        if ($header) {
            $style->setFontBold()->setBackgroundColor('E7F3EC');
        }
        $writer->addRow(new Row(array_map(fn (mixed $value): Cell => is_string($value) ? new StringCell($value, null) : Cell::fromValue($value), $values), $style));
    }
}
