<?php

namespace App\Services;

use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GhgDeclarationExcelExport
{
    public function downloadDeclaration(GhgDeclaration $declaration): StreamedResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        return $this->download('khai-bao-khi-nha-kinh-'.$declaration->reference.'.xlsx', fn (string $path) => $this->writeDeclaration($declaration, $path));
    }

    /** @param iterable<GhgDeclaration> $declarations */
    public function downloadList(iterable $declarations): StreamedResponse
    {
        abort_unless(auth()->user()?->is_admin, 403);

        return $this->download('danh-sach-khai-bao-khi-nha-kinh-'.now()->format('Ymd-His').'.xlsx', fn (string $path) => $this->writeList($declarations, $path));
    }

    private function download(string $filename, callable $write): StreamedResponse
    {
        return response()->streamDownload(function () use ($write): void {
            $path = tempnam(sys_get_temp_dir(), 'ghg-excel-');
            try {
                $write($path);
                readfile($path);
            } finally {
                if (is_file($path)) {
                    unlink($path);
                }
            }
        }, $filename, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    public function writeDeclaration(GhgDeclaration $declaration, string $path): void
    {
        $writer = new Writer;
        $writer->openToFile($path);
        try {
            $writer->getCurrentSheet()->setName('Thông tin chung');
            $this->header($writer, ['Thông tin', 'Giá trị']);
            foreach (['Mã phiếu' => $declaration->reference, 'Trạng thái' => $this->status($declaration), 'Ngày nộp' => $declaration->submitted_at?->format('d/m/Y H:i')] as $label => $value) {
                $this->row($writer, [$label, $value]);
            }
            foreach (GhgSurveyDefinition::generalFields() as $key => $field) {
                $this->row($writer, [$field['label'], $this->value($declaration->data[1][$key] ?? null, $field)]);
            }
            foreach (range(2, 6) as $step) {
                $writer->addNewSheetAndMakeItCurrent()->setName(GhgSurveyDefinition::steps()[$step]);
                foreach (GhgSurveyDefinition::sections($step) as $key => $section) {
                    $this->header($writer, [$section['label']]);
                    $this->header($writer, array_column($section['fields'], 'label'));
                    foreach ($declaration->data[$step][$key] ?? [] as $record) {
                        $values = [];
                        foreach ($section['fields'] as $fieldKey => $field) {
                            $values[] = $this->value($record[$fieldKey] ?? null, $field);
                        }
                        $this->row($writer, $values);
                    }
                    $this->row($writer, []);
                }
            }
            $writer->addNewSheetAndMakeItCurrent()->setName('Chứng từ');
            $this->header($writer, ['Tên tệp', 'Nhóm chứng từ', 'Ghi chú', 'Dung lượng (byte)']);
            foreach ($declaration->evidence ?? [] as $file) {
                $this->row($writer, [$file['name'], $file['category'] ?? '', $file['note'] ?? '', $file['size']]);
            }
        } finally {
            $writer->close();
        }
    }

    /** @param iterable<GhgDeclaration> $declarations */
    public function writeList(iterable $declarations, string $path): void
    {
        $writer = new Writer;
        $writer->openToFile($path);
        try {
            $writer->getCurrentSheet()->setName('Danh sách phiếu');
            $fields = GhgSurveyDefinition::generalFields();
            $this->header($writer, array_merge(['Mã phiếu', 'Trạng thái', 'Bước đang nhập', 'Ngày nộp', 'Cập nhật'], array_column($fields, 'label')));
            foreach ($declarations as $declaration) {
                $values = [$declaration->reference, $this->status($declaration), $declaration->current_step, $declaration->submitted_at?->format('d/m/Y H:i'), $declaration->updated_at->format('d/m/Y H:i')];
                foreach ($fields as $key => $field) {
                    $values[] = $this->value($declaration->data[1][$key] ?? null, $field);
                }
                $this->row($writer, $values);
            }
        } finally {
            $writer->close();
        }
    }

    private function status(GhgDeclaration $declaration): string
    {
        return $declaration->status === 'submitted' ? 'Đã nộp' : 'Bản nháp';
    }

    /** @param array<string, mixed> $field */
    private function value(mixed $value, array $field): string|int|float|null
    {
        if ($value === null || $value === '') {
            return null;
        }
        if ($field['type'] === 'select') {
            return $field['options'][$value] ?? (string) $value;
        }
        if (in_array($field['type'], ['number', 'decimal'], true) && is_numeric($value)) {
            return $field['type'] === 'number' ? (int) $value : (float) $value;
        }

        return (string) $value;
    }

    /** @param list<string|int|float|null> $values */
    private function header(Writer $writer, array $values): void
    {
        $this->row($writer, $values, (new Style)->setFontBold()->setFontColor('800000')->setBackgroundColor('FDF2F2')->setShouldWrapText());
    }

    /** @param list<string|int|float|null> $values */
    private function row(Writer $writer, array $values, ?Style $style = null): void
    {
        $cells = array_map(fn (string|int|float|null $value): Cell => is_string($value) ? new StringCell($value, null) : Cell::fromValue($value), $values);
        $writer->getCurrentSheet()->setColumnWidthForRange(28, 1, max(2, count($values)));
        $writer->addRow(new Row($cells, $style ?? (new Style)->setShouldWrapText()));
    }
}
