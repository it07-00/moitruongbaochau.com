<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\ContentTagsAndViewCountSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class FrontendDatabaseContentTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_service_detail_uses_database_metadata(): void
    {
        $service = Service::factory()->create([
            'view_count' => 1234,
            'tags' => ['DichVuTuDatabase'],
            'rating_average' => 4.8,
            'rating_count' => 17,
            'published_at' => now()->subDays(3),
        ]);

        $this->get(route('services.show', $service->slug))
            ->assertOk()
            ->assertSee('1,235 lượt xem')
            ->assertSee('#DichVuTuDatabase')
            ->assertSee('4.8/5')
            ->assertSee('(17 bình chọn)')
            ->assertSee($service->published_at->format('d/m/Y'))
            ->assertDontSee('2,480 lượt xem');
    }

    public function test_shared_header_footer_and_editor_content_use_database_settings(): void
    {
        Setting::query()->create([
            'key' => 'content_editor_name',
            'value' => 'Ban nội dung riêng từ database',
            'group' => 'content',
        ]);
        Setting::query()->create([
            'key' => 'content_editor_bio',
            'value' => 'Tiểu sử biên tập viên lấy trực tiếp từ database.',
            'group' => 'content',
        ]);
        Setting::query()->create([
            'key' => 'footer_sales_contacts',
            'value' => json_encode([
                ['phone' => '0901 234 567', 'name' => 'Nhân sự database'],
            ], JSON_THROW_ON_ERROR),
            'type' => 'json',
            'group' => 'contact',
        ]);

        $service = Service::factory()->create([
            'name' => 'Dịch vụ nổi bật từ database',
            'is_featured' => true,
        ]);

        $this->get(route('services.show', $service->slug))
            ->assertOk()
            ->assertSee('Dịch vụ nổi bật từ database')
            ->assertSee('Ban nội dung riêng từ database')
            ->assertSee('Tiểu sử biên tập viên lấy trực tiếp từ database.')
            ->assertSee('0901 234 567')
            ->assertSee('Nhân sự database');
    }

    public function test_tag_seeder_transliterates_vietnamese_and_preserves_view_count(): void
    {
        $service = Service::factory()->create([
            'name' => 'Kiểm kê khí nhà kính đặc biệt',
            'slug' => 'dich-vu-tag-tu-dong',
            'tags' => null,
            'view_count' => 42,
        ]);
        $customizedService = Service::factory()->create([
            'tags' => ['TagQuanTriDaSua'],
            'view_count' => 73,
        ]);

        $this->seed(ContentTagsAndViewCountSeeder::class);

        $service->refresh();
        $customizedService->refresh();

        $this->assertContains('KiemKeKhiNhaKinhDacBiet', $service->tags);
        $this->assertSame(42, $service->view_count);
        $this->assertSame(['TagQuanTriDaSua'], $customizedService->tags);
        $this->assertSame(73, $customizedService->view_count);
    }

    public function test_post_detail_uses_database_metadata_and_author(): void
    {
        $author = User::factory()->create(['name' => 'Tác giả từ database']);
        $post = Post::factory()->for($author, 'author')->create([
            'content' => '<h2 id="noi-dung-db">Nội dung riêng từ database</h2>',
            'view_count' => 2345,
            'tags' => ['BaiVietTuDatabase'],
            'rating_average' => 4.6,
            'rating_count' => 9,
        ]);

        $this->get(route('posts.show', $post->slug))
            ->assertOk()
            ->assertSee('2,346 lượt xem')
            ->assertSee('#BaiVietTuDatabase')
            ->assertSee('Tác giả từ database')
            ->assertSee('4.6/5')
            ->assertSee('(9 bình chọn)')
            ->assertDontSee('3,420 lượt xem')
            ->assertDontSee('Giấy phép môi trường là gì?');
    }

    public function test_project_detail_uses_database_metadata(): void
    {
        $project = Project::factory()->create([
            'view_count' => 3456,
            'tags' => ['DuAnTuDatabase'],
            'rating_average' => 4.7,
            'rating_count' => 6,
        ]);

        $this->get(route('projects.show', $project->slug))
            ->assertOk()
            ->assertSee('3,457 lượt xem')
            ->assertSee('#DuAnTuDatabase')
            ->assertSee('4.7/5')
            ->assertSee('(6 bình chọn)')
            ->assertDontSee('5/5 - (1 bình chọn)');
    }

    public function test_recruitment_detail_uses_database_metadata(): void
    {
        $job = JobPosting::factory()->create([
            'view_count' => 4567,
            'tags' => ['TuyenDungTuDatabase'],
            'rating_average' => 4.9,
            'rating_count' => 3,
        ]);

        $this->get(route('recruitment.show', $job->slug))
            ->assertOk()
            ->assertSee('4,568 lượt xem')
            ->assertSee('#TuyenDungTuDatabase')
            ->assertSee('4.9/5')
            ->assertSee('(3 bình chọn)')
            ->assertDontSee('5/5 - (Tuyệt vời)');
    }
}
