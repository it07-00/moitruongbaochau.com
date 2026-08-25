<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email:rfc', 'max:255'],
            'phone' => ['required', 'regex:/^(?:\+?84|0)[0-9\s.\-]{8,14}$/'],
            'topic' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'website' => ['nullable', 'string', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'name.max' => 'Họ và tên không được vượt quá 120 ký tự.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'phone.regex' => 'Số điện thoại không hợp lệ (ví dụ: 0915 549 148).',
            'message.required' => 'Vui lòng nhập nội dung cần tư vấn.',
            'message.min' => 'Nội dung yêu cầu tư vấn tối thiểu 10 ký tự.',
            'website.max' => 'Yêu cầu không hợp lệ (Spam detected).',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->string('name')->trim()->toString(),
            'phone' => $this->string('phone')->trim()->toString(),
            'topic' => $this->string('topic')->trim()->toString(),
            'message' => $this->string('message')->trim()->toString(),
        ]);
    }
}
