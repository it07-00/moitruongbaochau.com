<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function after(): array
    {
        return [function ($validator): void {
            $allowedKeys = [
                'company_name', 'logo', 'favicon', 'phone', 'email', 'address', 'facebook',
                'youtube', 'zalo', 'google_map', 'seo_default_title', 'seo_default_description',
                'seo_default_image',
            ];

            foreach (array_keys($this->input('settings', [])) as $key) {
                if (! in_array($key, $allowedKeys, true)) {
                    $validator->errors()->add("settings.$key", 'Thiết lập không được hỗ trợ.');
                }
            }
        }];
    }
}
