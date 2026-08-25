<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AutoSeoTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_post_automatically_generates_seo_attributes_when_blank(): void
    {
        $category = PostCategory::factory()->create();
        $author = User::factory()->create();

        $post = Post::create([
            'post_category_id' => $category->id,
            'author_id' => $author->id,
            'title' => 'Báo cáo ĐTM mới nhất năm 2026',
            'slug' => 'bao-cao-dtm-moi-nhat-nam-2026',
            'excerpt' => 'Hướng dẫn chi tiết thủ tục lập báo cáo đánh giá tác động môi trường ĐTM.',
            'content' => '<p>Chi tiết quy trình thực hiện ĐTM trọn gói uy tín chất lượng cao.</p>',
            'thumbnail' => 'uploads/posts/dtm-2026.webp',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->assertEquals('Báo cáo ĐTM mới nhất năm 2026', $post->meta_title);
        $this->assertEquals('Hướng dẫn chi tiết thủ tục lập báo cáo đánh giá tác động môi trường ĐTM.', $post->meta_description);
        $this->assertEquals('index,follow', $post->robots);
        $this->assertEquals('Báo cáo ĐTM mới nhất năm 2026', $post->og_title);
        $this->assertEquals('Hướng dẫn chi tiết thủ tục lập báo cáo đánh giá tác động môi trường ĐTM.', $post->og_description);
        $this->assertEquals('uploads/posts/dtm-2026.webp', $post->og_image);
        $this->assertEquals('Báo cáo ĐTM mới nhất năm 2026', $post->twitter_title);
        $this->assertEquals('Hướng dẫn chi tiết thủ tục lập báo cáo đánh giá tác động môi trường ĐTM.', $post->twitter_description);
    }

    public function test_service_automatically_generates_seo_attributes_from_name_and_content(): void
    {
        $category = ServiceCategory::factory()->create();

        $service = Service::create([
            'service_category_id' => $category->id,
            'name' => 'Tư vấn giấy phép môi trường',
            'slug' => 'tu-van-giay-phep-moi-truong',
            'short_description' => 'Dịch vụ xin cấp giấy phép môi trường nhanh chóng, đúng chuẩn.',
            'content' => '<p>Hồ sơ và quy trình cấp phép môi trường cho nhà máy xí nghiệp.</p>',
            'thumbnail' => 'uploads/services/gpmt.webp',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->assertEquals('Tư vấn giấy phép môi trường', $service->meta_title);
        $this->assertEquals('Dịch vụ xin cấp giấy phép môi trường nhanh chóng, đúng chuẩn.', $service->meta_description);
        $this->assertEquals('index,follow', $service->robots);
        $this->assertEquals('Tư vấn giấy phép môi trường', $service->og_title);
        $this->assertEquals('uploads/services/gpmt.webp', $service->og_image);
    }

    public function test_project_and_job_and_page_automatically_generate_seo_attributes(): void
    {
        $project = Project::create([
            'title' => 'Xử lý nước thải KCN Tân Bình',
            'slug' => 'xu-ly-nuoc-thai-kcn-tan-binh',
            'summary' => 'Dự án xử lý nước thải công suất 2000m3/ngày đêm.',
            'content' => 'Chi tiết kỹ thuật dự án trạm xử lý.',
            'thumbnail' => 'uploads/projects/tan-binh.webp',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $job = JobPosting::create([
            'title' => 'Kỹ sư Quản lý Môi trường',
            'slug' => 'ky-su-quan-ly-moi-truong',
            'summary' => 'Tuyển dụng kỹ sư môi trường có kinh nghiệm lập hồ sơ cấp phép.',
            'content' => 'Chi tiết công việc.',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $page = Page::create([
            'title' => 'Giới thiệu Môi Trường Bảo Châu',
            'slug' => 'gioi-thieu',
            'excerpt' => 'Công ty cổ phần Môi Trường Bảo Châu với hơn 10 năm kinh nghiệm.',
            'content' => 'Nội dung trang giới thiệu.',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->assertEquals('Xử lý nước thải KCN Tân Bình', $project->meta_title);
        $this->assertEquals('Dự án xử lý nước thải công suất 2000m3/ngày đêm.', $project->meta_description);
        $this->assertEquals('index,follow', $project->robots);

        $this->assertEquals('Kỹ sư Quản lý Môi trường', $job->meta_title);
        $this->assertEquals('Tuyển dụng kỹ sư môi trường có kinh nghiệm lập hồ sơ cấp phép.', $job->meta_description);

        $this->assertEquals('Giới thiệu Môi Trường Bảo Châu', $page->meta_title);
        $this->assertEquals('Công ty cổ phần Môi Trường Bảo Châu với hơn 10 năm kinh nghiệm.', $page->meta_description);
    }

    public function test_custom_seo_attributes_are_not_overwritten(): void
    {
        $category = PostCategory::factory()->create();
        $author = User::factory()->create();

        $post = Post::create([
            'post_category_id' => $category->id,
            'author_id' => $author->id,
            'title' => 'Tiêu đề gốc của bài viết',
            'slug' => 'tieu-de-goc',
            'excerpt' => 'Mô tả tóm tắt gốc',
            'content' => 'Nội dung gốc',
            'meta_title' => 'Custom Meta Title Tối Ưu Riêng',
            'meta_description' => 'Custom Meta Description Tối Ưu Riêng',
            'robots' => 'noindex,follow',
            'og_title' => 'Custom OG Title Cho Facebook',
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->assertEquals('Custom Meta Title Tối Ưu Riêng', $post->meta_title);
        $this->assertEquals('Custom Meta Description Tối Ưu Riêng', $post->meta_description);
        $this->assertEquals('noindex,follow', $post->robots);
        $this->assertEquals('Custom OG Title Cho Facebook', $post->og_title);
    }
}
