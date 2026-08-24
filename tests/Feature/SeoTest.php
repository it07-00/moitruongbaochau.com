<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\Post;
use App\Models\Service;
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
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $response = $this->get(route('services.show', $service->slug).'?utm_source=test&fbclid=abc');

        $response->assertOk()
            ->assertSee('<link rel="canonical" href="'.route('services.show', $service->slug).'">', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('name="twitter:card"', false)
            ->assertSee('"@type":"Service"', false)
            ->assertDontSee('utm_source', false)
            ->assertDontSee('fbclid', false);
    }

    public function test_sitemap_only_contains_published_content_and_robots_points_to_it(): void
    {
        $publishedPost = Post::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        $draftPost = Post::factory()->create(['status' => ContentStatus::Draft]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('posts.show', $publishedPost->slug), false)
            ->assertDontSee(route('posts.show', $draftPost->slug), false);

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin/')
            ->assertSee(route('sitemap'));
    }
}
