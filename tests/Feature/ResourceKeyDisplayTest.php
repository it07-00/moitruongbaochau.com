<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResourceKeyDisplayTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_post_displays_single_line_key_bar_when_configured(): void
    {
        $category = PostCategory::factory()->create(['name' => 'Tài nguyên']);
        $post = Post::factory()->create([
            'post_category_id' => $category->id,
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'resource_password_hint' => 'Key giải nén tài liệu:',
            'resource_password' => 'MBC-2026-KEY',
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertSee('Key giải nén tài liệu:');
        $response->assertSee('MBC-2026-KEY');
        $response->assertSee('Sao chép');
    }

    public function test_post_hides_key_bar_when_resource_password_is_empty(): void
    {
        $category = PostCategory::factory()->create(['name' => 'Tin tức']);
        $post = Post::factory()->create([
            'post_category_id' => $category->id,
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'resource_password' => null,
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertDontSee('data-resource-key-bar', false);
    }

    public function test_post_pdf_remains_accessible_even_when_key_is_displayed(): void
    {
        Storage::fake('public');
        $path = 'uploads/posts/documents/tai-lieu.pdf';
        $contents = "%PDF-1.4\nSample\n%%EOF";
        Storage::disk('public')->put($path, $contents);

        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'pdf_file' => $path,
            'resource_password' => 'MBC-PDF-123',
        ]);

        $this->get(route('posts.pdf', $post->slug))
            ->assertOk()
            ->assertStreamedContent($contents);
    }

    public function test_service_displays_single_line_key_bar_when_configured(): void
    {
        $service = Service::factory()->create([
            'status' => ContentStatus::Published,
            'resource_password_hint' => 'Mật khẩu tải biểu mẫu:',
            'resource_password' => 'SVC-KEY-999',
        ]);

        $response = $this->get(route('services.show', $service->slug));

        $response->assertOk();
        $response->assertSee('Mật khẩu tải biểu mẫu:');
        $response->assertSee('SVC-KEY-999');
        $response->assertSee('Sao chép');
    }

    public function test_page_displays_single_line_key_bar_when_configured(): void
    {
        $page = Page::factory()->create([
            'slug' => 'tai-nguyen-chia-se',
            'template' => 'default',
            'status' => ContentStatus::Published,
            'resource_password' => 'PAGE-KEY-2026',
        ]);

        $response = $this->get(route('pages.show', $page->slug));

        $response->assertOk();
        $response->assertSee('Key / Mật khẩu:');
        $response->assertSee('PAGE-KEY-2026');
        $response->assertSee('Sao chép');
    }

    public function test_ghg_landing_page_displays_single_line_key_bar_when_configured(): void
    {
        $this->get(route('ghg-service.index'))
            ->assertOk()
            ->assertDontSee('data-resource-key-bar', false);

        Setting::query()->create([
            'key' => 'ghg_landing_resource_password_hint',
            'value' => 'Key tài liệu khí nhà kính:',
            'type' => 'string',
            'group' => 'content',
        ]);
        Setting::query()->create([
            'key' => 'ghg_landing_resource_password',
            'value' => 'GHG-2026-KEY',
            'type' => 'string',
            'group' => 'content',
        ]);

        $response = $this->get(route('ghg-service.index'));

        $response->assertOk();
        $response->assertSee('data-resource-key-bar', false);
        $response->assertSee('Key tài liệu khí nhà kính:');
        $response->assertSee('GHG-2026-KEY');
        $response->assertSee('Sao chép');
    }
}
