<?php

namespace App\Http\Requests;

use App\Models\EnvironmentSurvey;
use App\Support\EnvironmentSurveyDefinition as Definition;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEnvironmentSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $survey = $this->currentSurvey();
        abort_if($survey instanceof EnvironmentSurvey && ! $survey->isEditable(), 409, 'Phiếu đã gửi được khóa chỉnh sửa.');
        abort_unless(in_array((int) $this->route('step', 1), range(1, 7), true), 404);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $step = (int) $this->route('step', 1);
        $survey = $this->currentSurvey();
        $data = array_replace($survey instanceof EnvironmentSurvey ? ($survey->data ?? []) : [], is_array($this->input('data')) ? $this->input('data') : []);
        $categories = match ($step) {
            1 => ['environment_report_2025'], 4 => ['wastewater', 'air'], 6 => array_keys(Definition::documents()), default => []
        };

        return Definition::rules($step, $data, in_array($this->input('action'), ['next', 'submit'], true)) + [
            'action' => ['required', Rule::in($step === 7 ? ['save', 'back', 'goto', 'submit'] : ['save', 'back', 'goto', 'next'])],
            'target_step' => ['required_if:action,goto', 'nullable', 'integer', 'between:1,7'],
            'website' => ['nullable', 'string', 'max:0'],
            'uploads' => $categories ? ['nullable', 'array:'.implode(',', $categories)] : ['prohibited'],
            'uploads.*' => ['array', 'max:10'],
            'uploads.*.*' => ['file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'extensions:pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'max:20480'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $step = (int) $this->route('step', 1);
        $data = $this->input('data', []);
        if (is_array($data)) {
            foreach (Definition::tables($step) as $key => $table) {
                $data[$key] ??= Definition::defaults($step)[$key];
            }
            if ($step === 6) {
                $data['documents'] ??= [];
            }
        }
        $this->merge(['data' => $data]);
    }

    private function currentSurvey(): ?EnvironmentSurvey
    {
        $reference = $this->session()->get('bvmt_survey.reference');

        return $reference ? EnvironmentSurvey::query()->where('reference', $reference)->first() : null;
    }

    public function attributes(): array
    {
        return Definition::attributes();
    }

    public function messages(): array
    {
        return Definition::messages() + ['uploads.*.*.max' => 'Mỗi tệp tối đa 20 MB.', 'uploads.*.*.mimes' => 'Chỉ nhận PDF, JPG, PNG, DOC, DOCX, XLS, XLSX.', 'uploads.*.max' => 'Mỗi nhóm tối đa 10 tệp.'];
    }
}
