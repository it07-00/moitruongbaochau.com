<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use Database\Seeders\CapabilityProfileSeeder;
use Database\Seeders\WebsiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CapabilityProfileContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_capability_profile_seeds_all_eighteen_service_areas_with_detail_content(): void
    {
        $this->seed([WebsiteSeeder::class, CapabilityProfileSeeder::class]);

        $profileServiceNames = [
            'Tư vấn, lập báo cáo phát triển bền vững (ESG)',
            'Tư vấn tiêu chí về cảng xanh',
            'Kiểm kê khí nhà kính và tư vấn kế hoạch giảm phát thải',
            'Lập báo cáo CBAM',
            'Đánh giá vòng đời và dấu chân carbon sản phẩm theo ISO 14067:2018',
            'Kiểm toán năng lượng & giải pháp tiết kiệm năng lượng',
            'Tư vấn hồ sơ môi trường',
            'Quan trắc môi trường',
            'Quan trắc môi trường lao động và phân loại lao động',
            'Thu gom, vận chuyển và xử lý chất thải',
            'Xây dựng bản đồ tiếng ồn (Noise Map)',
            'Tư vấn, thiết kế và thi công hệ thống xử lý khí thải & nước thải',
            'Ứng phó sự cố môi trường',
            'Nghiên cứu khoa học môi trường',
            'Cung cấp giải pháp chuyển đổi công nghệ',
            'Tư vấn, thiết kế và thi công hệ thống điện mặt trời',
            'Tư vấn, thiết kế và thi công hệ thống quan trắc tự động',
            'Tư vấn EPR cho doanh nghiệp',
        ];

        $services = Service::query()->whereIn('name', $profileServiceNames)->get();

        $this->assertCount(18, $services);
        $this->assertTrue($services->every(fn (Service $service): bool => filled($service->short_description)));
        $this->assertTrue($services->every(fn (Service $service): bool => str_contains($service->content, 'Phạm vi triển khai')));
        $this->assertTrue($services->every(fn (Service $service): bool => str_contains($service->content, 'Quy trình đồng hành')));
        $this->assertTrue($services->every(fn (Service $service): bool => str_contains($service->content, 'Căn cứ pháp lý và tiêu chuẩn áp dụng')));
        $this->assertTrue($services->every(fn (Service $service): bool => str_contains($service->content, 'Cập nhật pháp lý đến tháng 09/2026')));
        $this->assertTrue($services->every(fn (Service $service): bool => count($service->tags ?? []) >= 10));

        $allServices = Service::query()->published()->get();

        $this->assertCount(20, $allServices);
        $this->assertTrue($allServices->every(
            fn (Service $service): bool => count($service->tags ?? []) >= 10
                && str_contains($service->content, 'Hồ sơ và kết quả bàn giao')
                && str_contains($service->content, 'Cập nhật pháp lý đến tháng 09/2026'),
        ));
        $this->assertContains('ThongTu092026', Service::query()->where('slug', 'giay-phep-moi-truong')->firstOrFail()->tags);
        $greenhouseGasService = Service::query()->where('slug', 'kiem-ke-khi-nha-kinh')->firstOrFail();
        $this->assertContains('QuyetDinh422026', $greenhouseGasService->tags);
        $this->assertStringContainsString('2.441 cơ sở', $greenhouseGasService->content);
        $this->assertStringContainsString('có hiệu lực từ 25/09/2026', $greenhouseGasService->content);
        $this->assertContains('CBAM2026', Service::query()->where('slug', 'tu-van-cbam-esg-lca')->firstOrFail()->tags);
        $this->assertContains('NghiDinh2432026', Service::query()->where('slug', 'he-thong-dien-mat-troi')->firstOrFail()->tags);

        $menu = Menu::query()->where('location', 'primary')->firstOrFail();
        $this->assertSame(18, $menu->items()->whereIn('label', $profileServiceNames)->where('is_active', true)->count());

        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->withCount(['services' => fn ($query) => $query->published()])
            ->orderBy('sort_order')
            ->get();
        $this->assertSame([
            'Phát triển bền vững & ESG',
            'Khí nhà kính & Carbon',
            'Năng lượng & Công nghệ xanh',
            'Pháp lý & Ứng phó môi trường',
            'Quan trắc & An toàn lao động',
            'Kỹ thuật xử lý & Nghiên cứu',
        ], $categories->pluck('name')->all());
        $this->assertSame([3, 3, 3, 3, 4, 4], $categories->pluck('services_count')->all());

        foreach ($allServices as $service) {
            $this->get(route('services.show', $service->slug))
                ->assertOk()
                ->assertSee($service->name)
                ->assertSee('Căn cứ pháp lý và tiêu chuẩn áp dụng')
                ->assertSee('Phạm vi triển khai')
                ->assertSee('Quy trình đồng hành');
        }
    }

    public function test_about_page_uses_capability_profile_company_vision_mission_and_journey_content(): void
    {
        $this->seed([WebsiteSeeder::class, CapabilityProfileSeeder::class]);

        $page = Page::query()->where('slug', 'gioi-thieu')->firstOrFail();

        $this->assertStringContainsString('TP. Hồ Chí Minh, Hải Phòng, Khánh Hòa và Gia Lai', $page->content);
        $this->assertStringContainsString('đơn vị tư vấn hàng đầu được doanh nghiệp lựa chọn', $page->metadata['vision_desc_1']);
        $this->assertStringContainsString('giải pháp công nghệ tiên tiến', $page->metadata['mission_2_desc']);
        $this->assertStringContainsString('18 nhóm dịch vụ', $page->metadata['timeline_desc']);
    }

    public function test_services_index_paginates_the_complete_profile(): void
    {
        $this->seed([WebsiteSeeder::class, CapabilityProfileSeeder::class]);

        $response = $this->get(route('services.index'));

        $response->assertOk()
            ->assertSee('18 lĩnh vực dịch vụ môi trường &amp; phát triển bền vững', false)
            ->assertSee('Tư vấn, lập báo cáo phát triển bền vững (ESG)');
        $response->assertViewHas('services', fn ($services): bool => $services->total() === 20 && $services->perPage() === 12);

        $this->get(route('services.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('Tư vấn EPR cho doanh nghiệp');
    }
}
