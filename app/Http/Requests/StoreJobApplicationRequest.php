<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:150'],
            'contact_phone' => ['required', 'regex:/^(?:\+?84|0)[0-9\s.\-]{8,14}$/'],
            'contact_email' => ['required', 'email:rfc', 'max:255'],
            'job_posting_id' => ['nullable', 'string', 'max:50'],
            'custom_position' => ['nullable', 'string', 'max:150'],
            'position' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:3000'],
            'cv_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Vui lòng nhập họ và tên ứng viên.',
            'contact_phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'contact_phone.regex' => 'Số điện thoại không đúng định dạng hợp lệ.',
            'contact_email.required' => 'Vui lòng nhập địa chỉ email.',
            'contact_email.email' => 'Địa chỉ email không hợp lệ.',
            'cv_file.required' => 'Vui lòng tải lên file hồ sơ CV của bạn.',
            'cv_file.mimes' => 'File CV phải có định dạng: PDF, DOC hoặc DOCX.',
            'cv_file.max' => 'Dung lượng file CV không được vượt quá 10MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'fullname' => $this->string('fullname')->trim()->toString(),
            'contact_phone' => $this->filled('contact_phone') ? $this->string('contact_phone')->trim()->toString() : $this->string('phone')->trim()->toString(),
            'contact_email' => $this->filled('contact_email') ? $this->string('contact_email')->trim()->toString() : $this->string('email')->trim()->toString(),
            'job_posting_id' => $this->filled('job_posting_id') ? $this->string('job_posting_id')->trim()->toString() : $this->string('position')->trim()->toString(),
            'custom_position' => $this->string('custom_position')->trim()->toString(),
            'message' => $this->string('message')->trim()->toString(),
        ]);
    }
}
