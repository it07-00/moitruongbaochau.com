<?php

namespace Tests\Feature;

use App\CtaType;
use App\Filament\Resources\PageViews\Pages\ListPageViews;
use App\Models\Contact;
use App\Models\CtaClick;
use App\Models\EnvironmentSurvey;
use App\Models\GhgDeclaration;
use App\Models\PageView;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class DailyActivityReportSheetSyncTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const ENDPOINT = 'https://script.google.com/macros/s/test-deployment/exec';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'ghg_landing.sheets_webhook_url' => self::ENDPOINT,
            'ghg_landing.sheets_webhook_token' => str_repeat('b', 48),
            'ghg_landing.sheets_spreadsheet_id' => 'test-sheet-id',
            'ghg_landing.daily_report_tab_name' => 'DAILY REPORT',
        ]);

        Http::preventStrayRequests();
    }

    public function test_daily_report_command_aggregates_all_website_activity_and_sends_to_google_sheet(): void
    {
        PageView::factory()->count(3)->create([
            'page_key' => 'landing:ghg-service',
            'page_type' => 'landing',
            'created_at' => now(),
        ]);

        PageView::factory()->count(2)->create([
            'page_key' => 'service:giay-phep-moi-truong',
            'page_type' => 'service',
            'created_at' => now(),
        ]);

        CtaClick::factory()->count(2)->create([
            'type' => CtaType::Hotline,
            'created_at' => now(),
        ]);

        Contact::factory()->create([
            'source' => route('contact.index'),
            'created_at' => now(),
        ]);

        Contact::factory()->create([
            'source' => route('ghg-service.index'),
            'created_at' => now(),
        ]);

        EnvironmentSurvey::factory()->create([
            'status' => 'submitted',
            'submitted_at' => now(),
            'created_at' => now(),
        ]);

        GhgDeclaration::factory()->create([
            'status' => 'submitted',
            'submitted_at' => now(),
            'created_at' => now(),
        ]);

        Http::fake(fn ($request) => Http::response([
            'ok' => true,
            'request_id' => $request['request_id'],
        ]));

        $todayString = now('Asia/Ho_Chi_Minh')->toDateString();

        $this->artisan('report:daily-sheet', ['--date' => $todayString])
            ->assertSuccessful();

        Http::assertSent(function ($request) use ($todayString): bool {
            return $request->url() === self::ENDPOINT
                && $request['sheet_name'] === 'DAILY REPORT'
                && $request['request_id'] === 'daily-report-'.$todayString
                && $request['values'][3] === '5' // total views
                && $request['values'][4] === '3' // GHG landing views
                && $request['values'][6] === '2' // total CTA
                && $request['values'][8] === '40%' // 2 / 5 = 40%
                && $request['values'][9] === '1' // general contact
                && $request['values'][10] === '1'; // GHG consultation
        });
    }

    public function test_admin_can_trigger_daily_report_sync_from_filament_list_page_views(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        Http::fake(fn ($request) => Http::response([
            'ok' => true,
            'request_id' => $request['request_id'],
        ]));

        $todayString = now('Asia/Ho_Chi_Minh')->toDateString();

        Livewire::test(ListPageViews::class)
            ->callAction('syncDailyReportToSheet', data: [
                'report_date' => $todayString,
            ])
            ->assertHasNoActionErrors()
            ->assertNotified('Đã đồng bộ lên Google Sheets');

        Http::assertSentCount(1);
    }
}
