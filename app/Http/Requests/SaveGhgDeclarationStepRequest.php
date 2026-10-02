<?php

namespace App\Http\Requests;

use App\Services\GhgDeclarationService;
use App\Support\GhgSurveyDefinition;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SaveGhgDeclarationStepRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $service = app(GhgDeclarationService::class);
        $declaration = $service->current($this);
        $service->assertAccessible($declaration, (int) $this->route('step'));
        abort_if($declaration && $declaration->status !== 'draft', 409, 'Phiếu đã nộp không thể chỉnh sửa.');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $step = (int) $this->route('step');
        $rules = $step === 7 ? [] : GhgSurveyDefinition::rules($step);

        return $rules + [
            'action' => ['required', Rule::in($step === 7 ? ['save', 'submit'] : ['save', 'next'])],
            'website' => ['nullable', 'string', 'max:0'],
            'evidence' => $step === 7 ? ['nullable', 'array', 'max:10'] : ['prohibited'],
            'evidence.*' => ['file', 'mimes:pdf,jpg,jpeg,png,xlsx,docx', 'max:10240'],
            'evidence_category' => ['nullable', 'string', 'max:100'],
            'evidence_note' => ['nullable', 'string', 'max:500'],
            'confirmation' => $this->input('action') === 'submit' ? ['required', 'accepted'] : ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return GhgSurveyDefinition::attributes((int) $this->route('step')) + [
            'confirmation' => 'xác nhận dữ liệu', 'evidence' => 'chứng từ', 'evidence.*' => 'tệp chứng từ',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Vui lòng nhập :attribute.', 'email' => ':attribute không hợp lệ.',
            'numeric' => ':attribute phải là số.', 'integer' => ':attribute phải là số nguyên.',
            'min' => ':attribute phải từ :min trở lên.', 'max' => ':attribute không được vượt quá :max.',
            'in' => 'Vui lòng chọn :attribute hợp lệ.', 'distinct' => 'Không được trùng tháng trong cùng bảng.',
            'size' => 'Bảng phải có đủ 12 tháng.', 'confirmation.accepted' => 'Vui lòng xác nhận dữ liệu trước khi nộp phiếu.',
            'evidence.*.mimes' => 'Chứng từ chỉ nhận PDF, JPG, PNG, XLSX hoặc DOCX.',
            'evidence.*.max' => 'Mỗi tệp chứng từ không được vượt quá 10MB.',
            'data.contact_phone.regex' => 'Số điện thoại không hợp lệ.',
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            foreach (['stationary_fuels' => 'purpose', 'mobile_fuels' => 'equipment_type'] as $section => $groupField) {
                $seen = [];
                foreach ((array) $this->input('data.'.$section, []) as $index => $row) {
                    if (! is_array($row) || ! is_scalar($row['month'] ?? null) || ! is_scalar($row['fuel_type'] ?? null) || ! is_scalar($row[$groupField] ?? null)) {
                        continue;
                    }
                    $key = implode('|', [$row['month'], $row['fuel_type'], $row[$groupField]]);
                    if (isset($seen[$key])) {
                        $validator->errors()->add('data.'.$section.'.'.$index.'.month', 'Dòng cùng tháng, nhiên liệu và mục đích / phương tiện đã tồn tại. Vui lòng gộp lượng sử dụng.');
                    }
                    $seen[$key] = true;
                }
            }
            foreach (['domestic_wastewater', 'industrial_wastewater'] as $section) {
                foreach ((array) $this->input('data.'.$section, []) as $index => $row) {
                    if (is_array($row) && is_numeric($row['flow_volume_m3'] ?? null) && $row['flow_volume_m3'] > 0 && blank($row['treatment_type'] ?? null)) {
                        $validator->errors()->add('data.'.$section.'.'.$index.'.treatment_type', 'Vui lòng chọn hệ thống xử lý khi có lưu lượng nước thải.');
                    }
                }
            }
        }];
    }

    protected function prepareForValidation(): void
    {
        $step = (int) $this->route('step');
        $data = $this->input('data', []);
        if (is_array($data) && $step > 1 && $step < 7) {
            foreach (GhgSurveyDefinition::sections($step) as $key => $section) {
                if (! $section['monthly'] && ! array_key_exists($key, $data)) {
                    $data[$key] = [];
                }
            }
        }
        $this->merge(['data' => $data]);
    }
}
