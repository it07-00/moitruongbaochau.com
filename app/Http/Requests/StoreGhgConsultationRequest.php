<?php

namespace App\Http\Requests;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreGhgConsultationRequest extends StoreContactRequest
{
    protected $redirectRoute = 'ghg-service.index';

    public function rules(): array
    {
        return [
            ...parent::rules(),
            'company_name' => ['nullable', 'string', 'max:180'],
            'message' => ['nullable', 'string', 'max:4000'],
            'consultation_type' => ['required', Rule::in(['consultation', 'callback'])],
            'form_id' => ['required', Rule::in(['inline-consultation', 'inline-callback', 'modal-consultation', 'modal-callback'])],
            'g-recaptcha-response' => [config('ghg_landing.recaptcha_secret_key') ? 'required' : 'nullable', 'string', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            ...parent::messages(),
            'company_name.max' => 'Tên doanh nghiệp không được vượt quá 180 ký tự.',
            'message.max' => 'Nội dung yêu cầu không được vượt quá 4.000 ký tự.',
            'consultation_type.required' => 'Vui lòng chọn hình thức tư vấn.',
            'consultation_type.in' => 'Hình thức tư vấn không hợp lệ.',
            'form_id.required' => 'Biểu mẫu không hợp lệ. Vui lòng tải lại trang.',
            'form_id.in' => 'Biểu mẫu không hợp lệ. Vui lòng tải lại trang.',
            'g-recaptcha-response.required' => 'Vui lòng hoàn tất xác minh reCAPTCHA.',
        ];
    }

    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        $this->merge([
            'company_name' => $this->string('company_name')->trim()->toString(),
            'email' => $this->string('email')->trim()->toString() ?: null,
        ]);
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            $secret = config('ghg_landing.recaptcha_secret_key');

            if (! $secret || $validator->errors()->isNotEmpty()) {
                return;
            }

            try {
                $response = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secret,
                    'response' => $this->input('g-recaptcha-response'),
                    'remoteip' => $this->ip(),
                ]);

                $result = $response->json();
                $valid = $response->successful()
                    && ($result['success'] ?? false) === true
                    && ($result['action'] ?? null) === 'ghg_consultation'
                    && ($result['hostname'] ?? null) === $this->getHost()
                    && is_numeric($result['score'] ?? null)
                    && (float) $result['score'] >= (float) config('ghg_landing.recaptcha_min_score', 0.5);
            } catch (ConnectionException) {
                $valid = false;
            }

            if (! $valid) {
                $validator->errors()->add('g-recaptcha-response', 'Không thể xác minh reCAPTCHA. Vui lòng thử gửi lại yêu cầu.');
            }
        }];
    }
}
