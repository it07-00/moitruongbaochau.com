<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
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

        $this->assertSame(asset('storage/uploads/posts/documents/nghi-dinh-08-2022.pdf'), $post->pdf_url);
        $this->assertSame('nghi-dinh-08-2022.pdf', $post->pdf_file_name);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertSee('Tài liệu PDF');
        $response->assertSee('Toàn màn hình');
        $response->assertSee('Tải về');
        $response->assertSee(asset('storage/uploads/posts/documents/nghi-dinh-08-2022.pdf'));
        $response->assertSee('<iframe', false);
    }

    public function test_post_detail_does_not_render_pdf_box_when_pdf_is_null(): void
    {
        $post = Post::factory()->create([
            'status' => ContentStatus::Published,
            'pdf_file' => null,
            'published_at' => now(),
        ]);

        $this->assertNull($post->pdf_url);
        $this->assertNull($post->pdf_file_name);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertOk();
        $response->assertDontSee('Toàn màn hình');
        $response->assertDontSee('<iframe', false);
    }
}
