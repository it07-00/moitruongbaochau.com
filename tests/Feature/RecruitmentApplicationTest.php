<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RecruitmentApplicationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_candidate_can_submit_job_application_with_cv_file(): void
    {
        Storage::fake('public');

        $job = JobPosting::factory()->create([
            'title' => 'Kỹ sư ĐTM Môi trường',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $cv = UploadedFile::fake()->create('nguyen_van_a_cv.pdf', 500, 'application/pdf');

        $response = $this->post(route('recruitment.apply', $job->slug), [
            'fullname' => 'Nguyễn Văn A',
            'contact_phone' => '0912345678',
            'contact_email' => 'nguyenvana@example.com',
            'message' => 'Tôi có 3 năm kinh nghiệm lập báo cáo ĐTM.',
            'cv_file' => $cv,
        ]);

        $response->assertRedirect(route('recruitment.show', $job->slug).'#form-ung-tuyen');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('job_applications', [
            'job_posting_id' => $job->id,
            'job_title' => $job->title,
            'fullname' => 'Nguyễn Văn A',
            'phone' => '0912345678',
            'email' => 'nguyenvana@example.com',
            'status' => 'new',
        ]);

        $application = JobApplication::first();
        $this->assertNotNull($application);
        Storage::disk('public')->assertExists($application->cv_path);
    }

    public function test_application_validation_requires_mandatory_fields_and_valid_cv(): void
    {
        $job = JobPosting::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $response = $this->post(route('recruitment.apply', $job->slug), [
            'fullname' => '',
            'contact_phone' => 'invalid-phone',
            'contact_email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['fullname', 'contact_phone', 'contact_email', 'cv_file']);
    }
}
