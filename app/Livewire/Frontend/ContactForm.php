<?php

namespace App\Livewire\Frontend;

use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $topic = '';

    public string $message = '';

    public string $website = ''; // Honeypot anti-spam

    public bool $isSuccess = false;

    public string $successMessage = '';

    protected function rules(): array
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

    protected function messages(): array
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

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submit(): void
    {
        $ip = request()->ip() ?? '127.0.0.1';
        $throttleKey = 'contact-form:'.$ip;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('phone', "Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau {$seconds} giây.");

            return;
        }

        $validated = $this->validate();

        if (! empty($validated['website'])) {
            return;
        }

        RateLimiter::hit($throttleKey, 120);

        Contact::query()->create([
            'name' => trim($this->name),
            'email' => filled($this->email) ? trim($this->email) : null,
            'phone' => trim($this->phone),
            'topic' => filled($this->topic) ? trim($this->topic) : 'Tư vấn môi trường',
            'message' => trim($this->message),
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'status' => 'new',
        ]);

        $this->reset(['name', 'email', 'phone', 'topic', 'message', 'website']);
        $this->isSuccess = true;
        $this->successMessage = 'Gửi yêu cầu tư vấn thành công! Chuyên viên Môi Trường Bảo Châu sẽ liên hệ lại với bạn trong thời gian sớm nhất.';

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Gửi thông tin thành công!',
            'text' => 'Chuyên viên Môi Trường Bảo Châu sẽ liên hệ lại với bạn trong thời gian sớm nhất.',
            'timer' => 4500,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Đồng ý',
            'confirmButtonColor' => '#ff4d38',
        ]);
    }

    public function render(): View
    {
        return view('livewire.frontend.contact-form');
    }
}
