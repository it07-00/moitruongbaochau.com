<?php

namespace App\Livewire\Frontend;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\WithFileUploads;

class JobApplicationForm extends Component
{
    use WithFileUploads;

    public string $fullname = '';

    public string $contact_phone = '';

    public string $contact_email = '';

    public ?string $job_posting_id = '';

    public string $custom_position = '';

    public string $message = '';

    public mixed $cv_file = null;

    public string $cvFileName = '';

    public bool $isSuccess = false;

    public string $successMessage = '';

    public ?int $preselectedJobId = null;

    public function mount(?int $preselectedJobId = null): void
    {
        $this->preselectedJobId = $preselectedJobId;
        if ($preselectedJobId) {
            $this->job_posting_id = (string) $preselectedJobId;
        }
    }

    public function updatedCvFile(): void
    {
        $this->validateOnly('cv_file');
        if ($this->cv_file && method_exists($this->cv_file, 'getClientOriginalName')) {
            $this->cvFileName = $this->cv_file->getClientOriginalName();
        }
    }

    public function getDisplayFileNameProperty(): string
    {
        if ($this->cv_file && method_exists($this->cv_file, 'getClientOriginalName')) {
            return $this->cv_file->getClientOriginalName();
        }

        return $this->cvFileName ?: 'Tệp CV đã chọn';
    }

    protected function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:150'],
            'contact_phone' => ['required', 'regex:/^(?:\+?84|0)[0-9\s.\-]{8,14}$/'],
            'contact_email' => ['required', 'email:rfc', 'max:255'],
            'job_posting_id' => ['nullable', 'string', 'max:50'],
            'custom_position' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:3000'],
            'cv_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ];
    }

    protected function messages(): array
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

    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function submit(): void
    {
        $ip = request()->ip() ?? '127.0.0.1';
        $throttleKey = 'job-apply:'.$ip;

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('contact_phone', "Bạn đã gửi quá nhiều hồ sơ. Vui lòng thử lại sau {$seconds} giây.");

            return;
        }

        $this->validate();

        RateLimiter::hit($throttleKey, 120);

        $resumePath = null;
        if ($this->cv_file) {
            $resumePath = $this->cv_file->store('resumes', 'public');
        }

        $selectedJob = is_numeric($this->job_posting_id) ? JobPosting::query()->find($this->job_posting_id) : null;
        $positionTitle = $selectedJob ? $selectedJob->title : (filled($this->custom_position) ? trim($this->custom_position) : 'Ứng tuyển chung');

        JobApplication::query()->create([
            'job_posting_id' => $selectedJob?->id,
            'job_title' => $positionTitle,
            'fullname' => trim($this->fullname),
            'email' => trim($this->contact_email),
            'phone' => trim($this->contact_phone),
            'cv_path' => $resumePath,
            'message' => filled($this->message) ? trim($this->message) : null,
            'ip_address' => $ip,
            'user_agent' => request()->userAgent(),
            'status' => 'new',
        ]);

        $this->reset(['fullname', 'contact_phone', 'contact_email', 'custom_position', 'message', 'cv_file', 'cvFileName']);
        if (! $this->preselectedJobId) {
            $this->job_posting_id = '';
        }
        $this->isSuccess = true;
        $this->successMessage = 'Hồ sơ của bạn đã được gửi thành công! Phòng Nhân sự Môi Trường Bảo Châu sẽ xem xét và phản hồi trong thời gian sớm nhất.';

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Nộp hồ sơ thành công!',
            'text' => 'Phòng Nhân sự Môi Trường Bảo Châu sẽ xem xét CV và liên hệ với bạn trong vòng 24h.',
            'timer' => 5000,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Tuyệt vời',
            'confirmButtonColor' => '#ff4d38',
        ]);
    }

    public function render(): View
    {
        $jobPostings = JobPosting::query()->published()->orderBy('title')->get();

        return view('livewire.frontend.job-application-form', compact('jobPostings'));
    }
}
