<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Livewire\Frontend\ContactForm;
use App\Livewire\Frontend\JobApplicationForm;
use App\Models\Contact;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class LivewireFormsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_livewire_contact_form_validates_and_submits_lead(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Trần Thị Mai')
            ->set('email', 'mai@example.com')
            ->set('phone', '0915549148')
            ->set('topic', 'Lập báo cáo ĐTM')
            ->set('message', 'Cần tư vấn hồ sơ ĐTM cho dự án nhà máy.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('isSuccess', true);

        $contact = Contact::query()->first();
        $this->assertNotNull($contact);
        $this->assertSame('Trần Thị Mai', $contact->name);
        $this->assertSame('0915549148', $contact->phone);
    }

    public function test_livewire_contact_form_validates_required_fields(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('phone', 'invalid-phone')
            ->set('message', 'ngắn')
            ->call('submit')
            ->assertHasErrors(['name', 'phone', 'message']);

        $this->assertSame(0, Contact::query()->count());
    }

    public function test_livewire_job_application_form_submits_with_cv(): void
    {
        Storage::fake('public');

        $job = JobPosting::factory()->create([
            'title' => 'Kỹ sư Giám sát Môi trường',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $cv = UploadedFile::fake()->create('ung_vien_cv.pdf', 300, 'application/pdf');

        Livewire::test(JobApplicationForm::class, ['preselectedJobId' => $job->id])
            ->set('fullname', 'Lê Hoàng Nam')
            ->set('contact_phone', '0987654321')
            ->set('contact_email', 'nam@example.com')
            ->set('message', 'Tôi có 4 năm kinh nghiệm.')
            ->set('cv_file', $cv)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('isSuccess', true);

        $application = JobApplication::query()->first();
        $this->assertNotNull($application);
        $this->assertSame('Lê Hoàng Nam', $application->fullname);
        $this->assertSame('0987654321', $application->phone);
        $this->assertSame($job->id, $application->job_posting_id);
        Storage::disk('public')->assertExists($application->cv_path);
    }
}
