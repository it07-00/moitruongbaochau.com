<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Filament\Resources\Services\Pages\EditService;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DeclarationService2026Seeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeclarationService2026Test extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_declaration_pages_use_service_layout_content_and_their_own_form_links(): void
    {
        foreach (Service::DECLARATION_ROUTES as $slug => $routeName) {
            $service = Service::factory()->create([
                'slug' => $slug,
                'name' => 'Nội dung khai báo 2026',
                'content' => '<h2>Nội dung dịch vụ từ quản trị</h2><p>Dữ liệu cần chuẩn bị.</p>',
            ]);

            $this->get('/'.$slug)
                ->assertOk()
                ->assertViewIs('frontend.services.show')
                ->assertSee($service->name)
                ->assertSee('Nội dung dịch vụ từ quản trị')
                ->assertSee('data-toc-source', false)
                ->assertSee('Điền biểu mẫu ngay')
                ->assertSee('href="'.url('/form-'.$slug).'"', false)
                ->assertSee('<link rel="canonical" href="'.route($routeName).'">', false);

            $this->assertSame(1, $service->refresh()->view_count);
            $this->get(route('services.index'))->assertSee('href="'.route($routeName).'"', false);
            $this->get(route('search', ['q' => 'khai báo']))->assertSee('href="'.route($routeName).'"', false);
        }
    }

    public function test_draft_future_and_missing_declaration_pages_are_not_public(): void
    {
        foreach (Service::DECLARATION_ROUTES as $slug => $routeName) {
            $this->get('/'.$slug)->assertNotFound();
            $service = Service::factory()->create(['slug' => $slug, 'status' => ContentStatus::Draft]);
            $this->get('/'.$slug)->assertNotFound();
            $service->update(['status' => ContentStatus::Published, 'published_at' => now()->addDay()]);
            $this->get('/'.$slug)->assertNotFound();
        }
    }

    public function test_regular_services_keep_their_urls_and_have_no_declaration_cta(): void
    {
        $service = Service::factory()->create();

        $this->assertSame(route('services.show', $service->slug), $service->getPublicUrl());
        $this->get($service->getPublicUrl())->assertOk()->assertDontSee('Điền biểu mẫu ngay');
    }

    public function test_sitemap_uses_root_declaration_urls(): void
    {
        foreach (Service::DECLARATION_ROUTES as $slug => $routeName) {
            Service::factory()->create(['slug' => $slug]);
        }

        $response = $this->get(route('sitemap'))->assertOk();

        foreach (Service::DECLARATION_ROUTES as $slug => $routeName) {
            $response->assertSee('<loc>'.route($routeName).'</loc>', false)
                ->assertDontSee('<loc>'.route('services.show', $slug).'</loc>', false);
        }
    }

    public function test_seeder_copies_source_content_and_preserves_later_admin_edits(): void
    {
        $sources = [
            'khai-bao-kiem-ke-khi-nha-kinh-2026' => Service::factory()->create(['slug' => 'kiem-ke-khi-nha-kinh']),
            'khai-bao-kiem-toan-nang-luong-2026' => Service::factory()->create(['slug' => 'kiem-toan-nang-luong-va-giai-phap-tiet-kiem']),
        ];

        $this->seed(DeclarationService2026Seeder::class);

        foreach ($sources as $slug => $source) {
            $declaration = Service::query()->where('slug', $slug)->firstOrFail();
            $this->assertSame($source->content, $declaration->content);
            $this->assertSame($source->service_category_id, $declaration->service_category_id);
            $this->assertSame($source->short_description, $declaration->short_description);
            $this->assertSame(ContentStatus::Published, $declaration->status);
            $declaration->update(['content' => '<h2>Nội dung đã chỉnh sửa</h2>']);
        }

        $this->seed(DeclarationService2026Seeder::class);

        foreach (array_keys($sources) as $slug) {
            $this->assertSame(1, Service::query()->where('slug', $slug)->count());
            $this->assertSame('<h2>Nội dung đã chỉnh sửa</h2>', Service::query()->where('slug', $slug)->value('content'));
        }
    }

    public function test_admin_can_edit_declaration_content(): void
    {
        $service = Service::factory()->create(['slug' => 'khai-bao-kiem-ke-khi-nha-kinh-2026']);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Livewire::test(EditService::class, ['record' => $service->getRouteKey()])
            ->fillForm(['content' => '<h2>Nội dung khai báo cập nhật</h2>'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->get($service->getPublicUrl())->assertOk()->assertSee('Nội dung khai báo cập nhật');
    }
}
