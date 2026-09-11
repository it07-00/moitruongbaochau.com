<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_content_page_has_canonical_social_meta_and_json_ld(): void
    {
        $service = Service::factory()->create([
            'name' => 'Quan trắc môi trường định kỳ',
            'meta_title' => 'Quan trắc môi trường định kỳ trọn gói',
            'meta_description' => 'Dịch vụ quan trắc môi trường định kỳ đúng quy định.',
            'thumbnail' => 'uploads/services/quan-trac.webp',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $response = $this->get(route('services.show', $service->slug).'?utm_source=test&fbclid=abc');

        $response->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('services.show', $service->slug).'">', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('name="twitter:card"', false)
            ->assertSee('property="og:locale" content="vi_VN"', false)
            ->assertSee('property="og:site_name" content="Môi Trường Bảo Châu"', false)
            ->assertSee('content="'.asset('storage/uploads/services/quan-trac.webp').'"', false)
            ->assertSee('max-image-preview:large', false)
            ->assertSee('hreflang="vi-VN"', false)
            ->assertSee('"@type":"Service"', false)
            ->assertDontSee('utm_source', false)
            ->assertDontSee('fbclid', false);
    }

    public function test_homepage_organization_schema_uses_database_settings(): void
    {
        Setting::query()->create([
            'key' => 'company_short_name',
            'value' => 'Doanh nghiệp SEO từ database',
            'group' => 'general',
        ]);
        Setting::query()->create([
            'key' => 'hotline',
            'value' => '0909 888 777',
            'group' => 'contact',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Doanh nghiệp SEO từ database')
            ->assertSee('0909 888 777');
    }

    public function test_article_outputs_complete_social_metadata_and_structured_data(): void
    {
        $post = Post::factory()->create([
            'title' => 'Bài viết SEO chuyên sâu',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk()
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('property="article:published_time"', false)
            ->assertSee('property="article:modified_time"', false)
            ->assertSee('"mainEntityOfPage"', false)
            ->assertSee('"publisher"', false)
            ->assertSee('"dateModified"', false);
    }

    public function test_job_posting_schema_contains_required_live_job_data(): void
    {
        $job = JobPosting::factory()->create([
            'title' => 'Kỹ sư môi trường',
            'content' => '<p>Nội dung công việc đầy đủ từ database.</p>',
            'requirements' => '<ul><li>Tốt nghiệp chuyên ngành môi trường.</li></ul>',
            'location' => 'Thành phố Hồ Chí Minh',
            'published_at' => now()->subDay(),
            'expires_at' => now()->addMonth(),
        ]);

        $response = $this->get(route('recruitment.show', $job->slug));

        $response->assertOk()
            ->assertSee('"@type":"JobPosting"', false)
            ->assertSee('"title":"Kỹ sư môi trường"', false)
            ->assertSee('Nội dung công việc đầy đủ từ database.', false)
            ->assertSee('Tốt nghiệp chuyên ngành môi trường.', false)
            ->assertSee('"datePosted"', false)
            ->assertSee('"validThrough"', false)
            ->assertSee('"hiringOrganization"', false)
            ->assertSee('"addressCountry":"VN"', false);
    }

    public function test_paginated_listing_has_page_specific_canonical_and_navigation_links(): void
    {
        Service::factory()->count(13)->create();

        $response = $this->get(route('services.index', ['page' => 2]));

        $response->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('services.index', ['page' => 2]).'">', false)
            ->assertSee('<link rel="prev" href="'.route('services.index').'">', false)
            ->assertSee('"url":"'.route('services.index', ['page' => 2]).'"', false);
    }

    public function test_sitemap_only_contains_published_indexable_content_and_robots_points_to_it(): void
    {
        $publishedPost = Post::factory()->create([
            'canonical_url' => 'https://canonical.example/bai-viet-chuan',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        $templatePage = Page::factory()->create([
            'slug' => 'dich-vu-trung-lap',
            'template' => 'services',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        $draftPost = Post::factory()->create(['status' => ContentStatus::Draft]);
        $noIndexProject = Project::factory()->create([
            'robots' => 'noindex,follow',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('https://canonical.example/bai-viet-chuan', false)
            ->assertDontSee(route('posts.show', $publishedPost->slug), false)
            ->assertDontSee(route('pages.show', $templatePage->slug), false)
            ->assertDontSee(route('posts.show', $draftPost->slug), false)
            ->assertDontSee(route('projects.show', $noIndexProject->slug), false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin/')
            ->assertSee('Disallow: /tim-kiem')
            ->assertSee(route('sitemap'));

        $staticRobots = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Disallow: /tim-kiem', $staticRobots);
        $this->assertStringContainsString('https://moitruongbaochau.com/sitemap.xml', $staticRobots);
    }
}
