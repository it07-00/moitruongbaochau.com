<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class FrontendContentTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_homepage_loads_featured_database_content(): void
    {
        $service = Service::factory()->create([
            'name' => 'Kiểm kê khí nhà kính doanh nghiệp',
            'status' => ContentStatus::Published,
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee($service->name);
    }

    public function test_service_detail_renders_the_content_saved_from_admin(): void
    {
        $service = Service::factory()->create([
            'content' => '<h2>Hồ sơ ĐTM gồm những gì?</h2><figure><img src="/storage/uploads/services/content/replacement.webp" alt="Ảnh ĐTM mới"></figure>',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('services.show', $service->slug))
            ->assertOk()
            ->assertSee('data-toc-spy', false)
            ->assertSee('data-toc-source', false)
            ->assertSee('Hồ sơ ĐTM gồm những gì?')
            ->assertSee('/storage/uploads/services/content/replacement.webp', false)
            ->assertSee('Ảnh ĐTM mới')
            ->assertDontSee('/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png', false);
    }

    public function test_published_content_details_are_public_and_drafts_are_not(): void
    {
        $publishedService = Service::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        $draftPost = Post::factory()->create(['status' => ContentStatus::Draft]);
        $publishedProject = Project::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        $publishedJob = JobPosting::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('services.show', $publishedService->slug))->assertOk();
        $this->get(route('posts.show', $draftPost->slug))->assertNotFound();
        $this->get(route('projects.show', $publishedProject->slug))->assertOk();
        $this->get(route('recruitment.show', $publishedJob->slug))->assertOk();
    }

    public function test_public_listings_paginate_database_content(): void
    {
        Service::factory()->count(13)->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('services.index'))
            ->assertOk()
            ->assertViewHas('services', fn ($services): bool => $services->perPage() === 12);
    }

    public function test_recruitment_page_renders_database_jobs(): void
    {
        $job = JobPosting::factory()->create([
            'title' => 'Kỹ sư Lập ĐTM và Giấy phép môi trường',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('recruitment.index'))
            ->assertOk()
            ->assertSee($job->title);

        $this->get(route('recruitment.show', $job->slug))
            ->assertOk()
            ->assertSee($job->title);
    }
}
