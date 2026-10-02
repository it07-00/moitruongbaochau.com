<?php

namespace App\Services;

use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class GhgDeclarationService
{
    public function current(Request $request): ?GhgDeclaration
    {
        $reference = $request->session()->get('ghg_declaration.reference');

        return $reference ? GhgDeclaration::query()->where('reference', $reference)->first() : null;
    }

    public function assertAccessible(?GhgDeclaration $declaration, int $step): void
    {
        abort_unless($step >= 1 && $step <= 7, 404);
        $completed = array_keys($declaration?->data ?? []);
        $allowed = $completed ? min(7, max($completed) + 1) : 1;
        abort_if($step > $allowed, 403, 'Vui lòng hoàn thành các bước trước.');
    }

    /** @param array<string, mixed> $validated */
    public function save(Request $request, int $step, array $validated): GhgDeclaration
    {
        $current = $this->current($request);
        $this->assertAccessible($current, $step);
        $paths = [];

        try {
            $declaration = DB::transaction(function () use ($current, $step, $validated, &$paths): GhgDeclaration {
                $record = $current ? GhgDeclaration::query()->lockForUpdate()->findOrFail($current->id) : new GhgDeclaration(['reference' => (string) Str::ulid()]);
                abort_unless($record->status === 'draft', 409, 'Phiếu đã nộp không thể chỉnh sửa.');
                $data = $record->data ?? [];
                if ($step < 7) {
                    $data[$step] = $validated['data'];
                }
                $record->data = $data;
                $record->company_name = $data[1]['company_name'] ?? null;
                $record->contact_email = $data[1]['contact_email'] ?? null;
                $evidence = $record->evidence ?? [];
                if (count($evidence) + count($validated['evidence'] ?? []) > 10) {
                    throw ValidationException::withMessages(['evidence' => 'Mỗi phiếu được đính kèm tối đa 10 tệp.']);
                }
                foreach ($validated['evidence'] ?? [] as $file) {
                    $path = $file->store('ghg-declarations/'.$record->reference, 'local');
                    if (! $path) {
                        throw ValidationException::withMessages(['evidence' => 'Không lưu được chứng từ. Vui lòng thử lại.']);
                    }
                    $paths[] = $path;
                    $evidence[] = ['path' => $path, 'name' => $file->getClientOriginalName(), 'size' => $file->getSize(), 'category' => $validated['evidence_category'] ?? '', 'note' => $validated['evidence_note'] ?? ''];
                }
                $record->evidence = $evidence;
                $record->current_step = $validated['action'] === 'next' ? min(7, $step + 1) : $step;

                if ($validated['action'] === 'submit') {
                    abort_unless($step === 7, 403);
                    foreach (range(1, 6) as $checkStep) {
                        Validator::make(['data' => $data[$checkStep] ?? []], GhgSurveyDefinition::rules($checkStep))->validate();
                    }
                    $record->status = 'submitted';
                    $record->submitted_at = now();
                }
                $record->save();

                return $record;
            });
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($paths);
            throw $exception;
        }

        $request->session()->put('ghg_declaration.reference', $declaration->reference);

        return $declaration;
    }
}
