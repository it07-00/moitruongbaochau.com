<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RedirectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'old_path' => ['required', 'string', 'max:255', 'regex:/^\/(?!\/)/', Rule::unique('redirects', 'old_path')->ignore($this->route('redirect'))],
            'new_path' => ['required', 'string', 'max:255', 'regex:/^\/(?!\/)/', 'different:old_path'],
            'status_code' => ['required', Rule::in([301, 302, 307, 308])],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
