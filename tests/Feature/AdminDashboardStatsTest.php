<?php

namespace Tests\Feature;

use App\ContactStatus;
use App\ContentStatus;
use App\Filament\Widgets\DetailedActivityBreakdownWidget;
use App\Models\Contact;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class AdminDashboardStatsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_dashboard_renders_detailed_activity_breakdown_widget(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('filament.admin.pages.dashboard'));

        $response->assertOk();
        $response->assertSee('Thống kê chi tiết hoạt động theo Ngày / Tuần / Tháng / Năm');
        $response->assertSee('Bài đăng mới (Tin tức)');
        $response->assertSee('Dịch vụ mới');
        $response->assertSee('Tin tuyển dụng (Vị trí tuyển)');
        $response->assertSee('Đơn tuyển dụng (Hồ sơ ứng viên)');
        $response->assertSee('Liên hệ khách hàng');
        $response->assertSee('Tư vấn Khí nhà kính');
        $response->assertSee('Xuất Excel (.xlsx)');
    }

    public function test_admin_can_export_detailed_activity_stats_to_excel(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        Post::factory()->create([
            'title' => 'Bài viết kiểm tra Excel',
            'status' => ContentStatus::Published,
        ]);

        $this->actingAs($admin);

        Livewire::test(DetailedActivityBreakdownWidget::class)
            ->call('exportExcel')
            ->assertFileDownloaded();
    }

    public function test_detailed_activity_breakdown_widget_counts_records_by_period(): void
    {
        Carbon::setTestNow(Carbon::create(2026, 11, 14, 10, 0, 0));

        try {
            $before = collect(Livewire::test(DetailedActivityBreakdownWidget::class)->instance()->getRows())
                ->keyBy('label');

            Post::factory()->create([
                'status' => ContentStatus::Published,
                'created_at' => now(),
            ]);

            $oldPost = Post::factory()->create([
                'status' => ContentStatus::Draft,
            ]);
            $oldPost->forceFill(['created_at' => now()->subYear()])->saveQuietly();

            Service::factory()->create([
                'status' => ContentStatus::Published,
                'created_at' => now(),
            ]);

            $job = JobPosting::factory()->create([
                'status' => ContentStatus::Published,
                'expires_at' => now()->addMonth(),
                'created_at' => now(),
            ]);

            JobApplication::query()->create([
                'job_posting_id' => $job->id,
                'job_title' => $job->title,
                'fullname' => 'Nguyễn Văn A',
                'phone' => '0901234567',
                'email' => 'ungvien@example.com',
                'cv_path' => 'uploads/cv/nguyen-van-a.pdf',
                'status' => 'new',
            ]);

            Contact::factory()->create([
                'status' => ContactStatus::New,
                'source' => '/lien-he',
            ]);

            $after = collect(Livewire::test(DetailedActivityBreakdownWidget::class)->instance()->getRows())
                ->keyBy('label');

            $this->assertSame($before['Bài đăng mới (Tin tức)']['today'] + 1, $after['Bài đăng mới (Tin tức)']['today']);
            $this->assertSame($before['Bài đăng mới (Tin tức)']['year'] + 1, $after['Bài đăng mới (Tin tức)']['year']);
            $this->assertSame($before['Bài đăng mới (Tin tức)']['total'] + 2, $after['Bài đăng mới (Tin tức)']['total']);

            $this->assertSame($before['Dịch vụ mới']['today'] + 1, $after['Dịch vụ mới']['today']);
            $this->assertSame($before['Tin tuyển dụng (Vị trí tuyển)']['today'] + 1, $after['Tin tuyển dụng (Vị trí tuyển)']['today']);
            $this->assertSame($before['Đơn tuyển dụng (Hồ sơ ứng viên)']['today'] + 1, $after['Đơn tuyển dụng (Hồ sơ ứng viên)']['today']);
            $this->assertSame('1 hồ sơ mới', $after['Đơn tuyển dụng (Hồ sơ ứng viên)']['highlight_label']);

            $this->assertSame($before['Liên hệ khách hàng']['today'] + 1, $after['Liên hệ khách hàng']['today']);
            $this->assertSame('1 chưa xử lý', $after['Liên hệ khách hàng']['highlight_label']);
        } finally {
            Carbon::setTestNow();
        }
    }
}
