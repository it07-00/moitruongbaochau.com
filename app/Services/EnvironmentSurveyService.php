<?php

namespace App\Services;

use App\Models\EnvironmentSurvey;
use App\Models\SurveyFile;
use App\Support\EnvironmentSurveyDefinition as Definition;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class EnvironmentSurveyService
{
    /** @param array<string, mixed> $validated */
    public function save(?EnvironmentSurvey $survey, int $step, array $validated): EnvironmentSurvey
    {
        $paths = [];
        try {
            return DB::transaction(function () use ($survey, $step, $validated, &$paths): EnvironmentSurvey {
                $record = $survey ? EnvironmentSurvey::query()->lockForUpdate()->findOrFail($survey->id) : new EnvironmentSurvey;
                abort_unless($record->isEditable(), 409, 'Phiếu đã gửi được khóa chỉnh sửa.');
                $data = $record->data ?? [];
                foreach (Definition::keys($step) as $key) {
                    if (array_key_exists($key, $validated['data'])) {
                        $data[$key] = $validated['data'][$key];
                    } elseif (isset(Definition::fields($step)[$key]) && Definition::visible(Definition::fields($step)[$key], $data)) {
                        $data[$key] = null;
                    }
                }
                $record->data = $data;
                $record->company_name = $data['company_name'] ?? null;
                $record->contact_email = $data['contact_email'] ?? null;
                $record->save();
                foreach ($validated['uploads'] ?? [] as $category => $files) {
                    if ($record->files()->where('category', $category)->count() + count($files) > 10) {
                        throw ValidationException::withMessages(['uploads.'.$category => 'Mỗi nhóm hồ sơ được lưu tối đa 10 tệp.']);
                    }
                    foreach ($files as $file) {
                        $path = $file->store('environment-surveys/'.$record->reference, 'local');
                        if (! $path) {
                            throw ValidationException::withMessages(['uploads.'.$category => 'Không lưu được tệp. Vui lòng thử lại.']);
                        }
                        $paths[] = $path;
                        $record->files()->create([
                            'category' => $category, 'original_name' => mb_substr(basename(str_replace('\\', '/', $file->getClientOriginalName())), 0, 255),
                            'stored_name' => basename($path), 'path' => $path, 'mime_type' => $file->getMimeType(),
                            'size' => $file->getSize(), 'uploaded_at' => now(),
                        ]);
                    }
                    if (isset(Definition::documents()[$category])) {
                        $data['documents'][$category]['status'] = 'available';
                    }
                    if ($category === 'environment_report_2025' && count($files) > 0) {
                        $data['has_environment_report_2025'] = true;
                    }
                }
                if (($data['has_environment_report_2025'] ?? false) && $record->files()->where('category', 'environment_report_2025')->exists()) {
                    $data['documents']['environment_report_2025']['status'] = 'available';
                }
                $data['source_2025'] = ($data['has_environment_report_2025'] ?? false) ? 'environment_report_2025' : 'manual';
                $record->data = $data;
                $action = $validated['action'];
                if ($action === 'next') {
                    $this->validateStep($record, $step)->validate();
                }
                if ($action === 'submit') {
                    $errors = [];
                    foreach (range(1, 7) as $checkStep) {
                        foreach ($this->validateStep($record, $checkStep)->errors()->messages() as $key => $messages) {
                            $errors[$key] = array_map(fn (string $message): string => 'Bước '.$checkStep.': '.$message, $messages);
                        }
                    }
                    if ($errors) {
                        throw ValidationException::withMessages($errors);
                    }
                    $record->status = 'submitted';
                    $record->submitted_at = now();
                }
                $record->current_step = match ($action) {
                    'next' => min(7, $step + 1), 'back' => max(1, $step - 1),
                    'goto' => (int) $validated['target_step'], default => $step,
                };
                $record->history = [...($record->history ?? []), ['action' => $action, 'step' => $step, 'status' => $record->status, 'at' => now()->toIso8601String(), 'actor' => 'company']];
                $record->save();

                return $record;
            });
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($paths);
            throw $exception;
        }
    }

    public function validateStep(EnvironmentSurvey $survey, int $step): \Illuminate\Validation\Validator
    {
        $data = $survey->data ?? [];
        $validator = Validator::make(['data' => Arr::only($data, Definition::keys($step))], Definition::rules($step, $data, true), Definition::messages(), Definition::attributes());
        $validator->after(function (\Illuminate\Validation\Validator $validator) use ($survey, $data, $step): void {
            if ($step === 1 && ($data['has_environment_report_2025'] ?? false) && ! $survey->files()->where('category', 'environment_report_2025')->exists()) {
                $validator->errors()->add('uploads.environment_report_2025', 'Vui lòng tải Báo cáo công tác BVMT năm 2025.');
            }
            if ($step === 6) {
                $counts = $survey->files()->selectRaw('category, COUNT(*) as total')->groupBy('category')->pluck('total', 'category');
                foreach (Definition::documents() as $category => $label) {
                    $status = $data['documents'][$category]['status'] ?? '';
                    if ($status === 'available' && ! ($counts[$category] ?? 0)) {
                        $validator->errors()->add('data.documents.'.$category.'.status', 'Hồ sơ “'.$label.'” chọn Có cần ít nhất một tệp.');
                    }
                    if ($status !== 'available' && ($counts[$category] ?? 0)) {
                        $validator->errors()->add('data.documents.'.$category.'.status', 'Hồ sơ “'.$label.'” đã có tệp; chọn Có hoặc xóa tệp trước.');
                    }
                }
            }
        });

        return $validator;
    }

    /** @return list<int> */
    public function completedSteps(EnvironmentSurvey $survey): array
    {
        return array_values(array_filter(range(1, 6), fn (int $step): bool => $this->validateStep($survey, $step)->passes()));
    }

    /** @return array<string, string> */
    public function missingDocuments(EnvironmentSurvey $survey): array
    {
        return array_diff_key(Definition::documents(), array_flip($survey->files->pluck('category')->all()));
    }

    public function changeStatus(EnvironmentSurvey $survey, string $status, ?string $note = null): void
    {
        abort_unless(auth()->user()?->is_admin, 403);
        DB::transaction(function () use ($survey, $status, $note): void {
            $record = EnvironmentSurvey::query()->lockForUpdate()->findOrFail($survey->id);
            $allowed = match ($record->status) {
                'submitted' => ['revision_required', 'completed'], 'completed' => ['revision_required'], default => [],
            };
            if (! in_array($status, $allowed, true)) {
                throw ValidationException::withMessages(['status' => 'Chuyển trạng thái không hợp lệ.']);
            }
            $record->status = $status;
            $record->history = [...($record->history ?? []), ['action' => 'status', 'status' => $status, 'note' => $note, 'actor' => auth()->id(), 'at' => now()->toIso8601String()]];
            $record->save();
        });
        $survey->refresh();
    }

    public function deleteFile(EnvironmentSurvey $survey, SurveyFile $file): void
    {
        DB::transaction(function () use ($survey, $file): void {
            $record = EnvironmentSurvey::query()->lockForUpdate()->findOrFail($survey->id);
            abort_unless($record->isEditable(), 409, 'Phiếu đã gửi được khóa chỉnh sửa.');
            abort_unless($file->environment_survey_id === $record->id, 404);
            $file->delete();
            $record->history = [...($record->history ?? []), ['action' => 'delete_file', 'category' => $file->category, 'at' => now()->toIso8601String(), 'actor' => 'company']];
            $record->save();
            DB::afterCommit(fn () => Storage::disk('local')->delete($file->path));
        });
    }
}
