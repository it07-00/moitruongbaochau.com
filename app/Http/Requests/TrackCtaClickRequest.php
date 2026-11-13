<?php

namespace App\Http\Requests;

use App\CtaType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrackCtaClickRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::enum(CtaType::class)],
            'label' => ['nullable', 'string', 'max:255'],
            'target_url' => ['nullable', 'string', 'max:500'],
            'page_url' => ['nullable', 'string', 'max:500'],
            'position' => ['nullable', 'string', 'max:100'],
            'metadata' => ['nullable', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'type' => $this->string('type')->trim()->lower()->toString(),
            'label' => $this->string('label')->trim()->limit(255, '')->toString() ?: null,
            'target_url' => $this->string('target_url')->trim()->limit(500, '')->toString() ?: null,
            'page_url' => $this->string('page_url')->trim()->limit(500, '')->toString() ?: null,
            'position' => $this->string('position')->trim()->limit(100, '')->toString() ?: null,
        ]);
    }
}
