<?php

namespace Tests\Feature;

use App\CtaType;
use App\Filament\Resources\CtaClicks\CtaClickResource;
use App\Filament\Resources\CtaClicks\Pages\ListCtaClicks;
use App\Filament\Widgets\StatsOverview;
use App\Livewire\Frontend\ContactForm;
use App\Models\CtaClick;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CtaTrackingTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_cta_click_can_be_recorded_via_endpoint(): void
    {
        $response = $this->postJson(route('cta.track'), [
            'type' => 'hotline',
            'label' => 'Hotline: 0915 549 148',
            'target_url' => 'tel:0915549148',
            'page_url' => '/dich-vu',
            'position' => 'floating',
            'metadata' => ['device' => 'mobile'],
        ]);

        $response->assertCreated()
            ->assertJson(['ok' => true]);

        $click = CtaClick::query()->sole();
        $this->assertSame(CtaType::Hotline, $click->type);
        $this->assertSame('Hotline: 0915 549 148', $click->label);
        $this->assertSame('tel:0915549148', $click->target_url);
        $this->assertSame('/dich-vu', $click->page_url);
        $this->assertSame('floating', $click->position);
        $this->assertSame(['device' => 'mobile'], $click->metadata);
    }

    public function test_cta_click_endpoint_rejects_invalid_type(): void
    {
        $this->postJson(route('cta.track'), [
            'type' => 'invalid_channel',
            'label' => 'Test',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['type']);

        $this->assertDatabaseCount('cta_clicks', 0);
    }

    public function test_form_submissions_record_cta_conversions_and_dispatch_pixel_events(): void
    {
        config(['ghg_landing.recaptcha_secret_key' => null]);

        // 1. Livewire ContactForm
        Livewire::test(ContactForm::class)
            ->set('name', 'Nguyễn Thị Lan')
            ->set('email', 'lan@example.com')
            ->set('phone', '0915549148')
            ->set('topic', 'Quan trắc môi trường')
            ->set('message', 'Cần báo giá quan trắc môi trường định kỳ.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertDispatched('cta-conversion');

        // 2. GHG Landing Page Consultation Form
        $this->postJson(route('ghg-service.store'), [
            'name' => 'Trần Văn Minh',
            'company_name' => 'Công ty Minh Phát',
            'phone' => '0987654321',
            'email' => 'minh@example.com',
            'message' => 'Tư vấn kiểm kê khí nhà kính.',
            'consultation_type' => 'consultation',
            'form_id' => 'inline-consultation',
            'website' => '',
        ])->assertCreated();

        $this->assertDatabaseCount('cta_clicks', 2);
        $this->assertSame(2, CtaClick::query()->where('type', CtaType::FormSubmit)->count());
    }

    public function test_admin_can_view_and_filter_cta_clicks_in_filament(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $hotlineClick = CtaClick::factory()->create([
            'type' => CtaType::Hotline,
            'label' => 'Gọi 0915 549 148',
            'position' => 'header',
        ]);
        $zaloClick = CtaClick::factory()->create([
            'type' => CtaType::Zalo,
            'label' => 'Chat Zalo tư vấn',
            'position' => 'floating',
        ]);

        Livewire::test(ListCtaClicks::class)
            ->assertCanSeeTableRecords([$hotlineClick, $zaloClick])
            ->filterTable('type', CtaType::Hotline->value)
            ->assertCanSeeTableRecords([$hotlineClick])
            ->assertCanNotSeeTableRecords([$zaloClick]);

        Livewire::test(StatsOverview::class)
            ->assertSee('Lượt tương tác CTA')
            ->assertSee('Hotline & Zalo: 2 lượt');

        $this->assertSame('2', CtaClickResource::getNavigationBadge());

        $this->get(route('filament.admin.resources.cta-clicks.index'))->assertOk();

        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->get(route('filament.admin.resources.cta-clicks.index'))->assertForbidden();
    }

    public function test_frontend_pages_include_cta_tracking_meta_and_pixel_script(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('name="cta-track-url"', false)
            ->assertSee('landing/ghg-service/js/facebook-pixel.js', false);

        $this->get(route('ghg-service.index'))
            ->assertOk()
            ->assertSee('name="cta-track-url"', false)
            ->assertSee('landing/ghg-service/js/facebook-pixel.js', false);
    }
}
