<?php

namespace Tests\Feature;

use App\Filament\Resources\JobPostings\Pages\EditJobPosting;
use App\Models\JobPosting;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class RecruitmentImageUploadTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_replace_a_job_posting_thumbnail(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $job = JobPosting::factory()->create(['thumbnail' => null]);
        $replacement = UploadedFile::fake()->image('replacement.png', 1600, 900);

        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(EditJobPosting::class, ['record' => $job->getRouteKey()])
            ->fillForm(['thumbnail' => $replacement])
            ->call('save')
            ->assertHasNoFormErrors();

        $thumbnail = $job->refresh()->thumbnail;

        $this->assertNotNull($thumbnail);
        $this->assertStringStartsWith('uploads/job-postings/', $thumbnail);
        Storage::disk('public')->assertExists($thumbnail);
    }

    public function test_job_detail_renders_the_thumbnail_saved_from_admin(): void
    {
        $job = JobPosting::factory()->create([
            'thumbnail' => 'uploads/job-postings/replacement.webp',
        ]);

        $this->get(route('recruitment.show', $job->slug))
            ->assertOk()
            ->assertSee('/storage/uploads/job-postings/replacement.webp', false)
            ->assertDontSee('/assets/images/Bai-Dang-Bao-Chau-1024x572.png', false);
    }
}
