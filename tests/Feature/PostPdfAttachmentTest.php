<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostPdfAttachmentTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_post_detail_renders_pdf_download_box_when_pdf_is_present(): void
    {
        $category = PostCategory::factory()->create(['name' => 'Văn bản pháp luật']);
        $post = Post::factory()->create([
            'post_category_id' => $category->id,
            'title' => 'Nghị định số 08/2022/NĐ-CP Quy định chi tiết Luật Bảo vệ Môi trường',
            'status' => ContentStatus::Published,
            'pdf_file' => 'uploads/posts/documents/nghi-dinh-08-2022.pdf',
            'published_at' => now(),
        ]);

        $this->assertSame(route('posts.pdf', $post->slug), $post->pdf_url);
        $this->assertSame('nghi-dinh-08-2022.pdf', $post->pdf_file_name);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertSee('Tài liệu PDF');
        $response->assertSee('Toàn màn hình');
        $response->assertSee('Tải về');
        $response->assertSee($post->pdf_url);
        $response->assertSee($post->pdf_download_url);
        $response->assertSee('<iframe', false);
    }

    public function test_pdf_is_served_inline_and_downloaded_with_its_original_bytes(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        $path = 'uploads/posts/documents/nghi-dinh.pdf';
        $contents = "%PDF-1.4\nDocument contents\n%%EOF";
        Storage::disk('public')->put($path, $contents);
        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'pdf_file' => $path,
        ]);

        $this->get($post->pdf_url)
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'inline; filename=nghi-dinh.pdf')
            ->assertStreamedContent($contents);

        $this->get($post->pdf_download_url)
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertDownload('nghi-dinh.pdf')
            ->assertStreamedContent($contents);
    }

    public function test_pdf_previously_stored_on_local_disk_can_be_downloaded(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        $path = 'uploads/posts/documents/old.pdf';
        Storage::disk('local')->put($path, '%PDF-1.4 old');
        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'pdf_file' => 'storage/'.$path,
        ]);

        $this->get($post->pdf_download_url)->assertOk()->assertDownload('old.pdf')
            ->assertStreamedContent('%PDF-1.4 old');
    }

    public function test_missing_pdf_returns_not_found_without_download_headers(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'published_at' => now(),
            'pdf_file' => 'uploads/posts/documents/missing.pdf',
        ]);

        $this->get($post->pdf_download_url)->assertNotFound()->assertHeaderMissing('Content-Disposition');
    }

    public function test_pdf_endpoint_rejects_unpublished_posts_and_unsafe_paths(): void
    {
        Storage::fake('public');
        Storage::fake('local');
        Storage::disk('public')->put('uploads/posts/documents/report.pdf', '%PDF-1.4');

        foreach ([
            [ContentStatus::Draft, now(), 'uploads/posts/documents/report.pdf'],
            [ContentStatus::Published, now()->addDay(), 'uploads/posts/documents/report.pdf'],
            [ContentStatus::Published, now(), null],
            [ContentStatus::Published, now(), 'uploads/posts/documents/../../../private.pdf'],
            [ContentStatus::Published, now(), 'uploads/posts/documents/..\\secret.pdf'],
            [ContentStatus::Published, now(), 'uploads/posts/documents/%2e%2e/secret.pdf'],
            [ContentStatus::Published, now(), 'uploads/posts/documents/report.htm'],
            [ContentStatus::Published, now(), 'https://example.com/report.pdf'],
        ] as [$status, $publishedAt, $path]) {
            $post = Post::factory()->create([
                'status' => $status, 'published_at' => $publishedAt, 'pdf_file' => $path,
            ]);

            $this->get(route('posts.pdf', ['slug' => $post->slug, 'download' => 1]))->assertNotFound();
        }
    }

    public function test_external_pdf_links_are_preserved(): void
    {
        $post = new Post(['pdf_file' => 'https://example.com/report.pdf']);

        $this->assertSame('https://example.com/report.pdf', $post->pdf_url);
        $this->assertSame('https://example.com/report.pdf', $post->pdf_download_url);
    }

    public function test_post_detail_does_not_render_pdf_box_when_pdf_is_null(): void
    {
        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'pdf_file' => null,
            'published_at' => now(),
        ]);

        $this->assertNull($post->pdf_url);
        $this->assertNull($post->pdf_download_url);
        $this->assertNull($post->pdf_file_name);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertDontSee('Toàn màn hình');
        $response->assertDontSee('<iframe', false);
    }
}
