<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Services\GhgGoogleSheetSync;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class GhgGoogleSheetSyncTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const ENDPOINT = 'https://script.google.com/macros/s/test-deployment/exec';

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'ghg_landing.recaptcha_secret_key' => null,
            'ghg_landing.sheets_webhook_url' => self::ENDPOINT,
            'ghg_landing.sheets_webhook_token' => str_repeat('a', 48),
        ]);
        Http::preventStrayRequests();
    }

    private function consultation(): Contact
    {
        return Contact::factory()->create([
            'source' => route('ghg-service.index'),
            'sheets_sync_key' => (string) Str::uuid(),
            'sheets_payload' => ['company_name' => 'Bảo Châu', 'message' => '=IMPORTXML("example")', 'consultation_type' => 'Đăng ký tư vấn'],
        ]);
    }

    public function test_form_saves_then_sends_structured_customer_fields_without_technical_data(): void
    {
        Http::fake(fn ($request) => Http::response(['ok' => true, 'request_id' => $request['request_id']]));
        $this->postJson(route('ghg-service.store'), [
            'name' => 'Nguyễn Văn An', 'phone' => '0915549148', 'email' => 'an@example.com',
            'company_name' => 'Công ty ABC', 'message' => 'Cần báo giá',
            'consultation_type' => 'consultation', 'form_id' => 'inline-consultation', 'website' => '',
        ])->assertCreated();
        $contact = Contact::sole();
        $this->assertNotNull($contact->sheets_synced_at);
        Http::assertSent(fn ($request) => $request->url() === self::ENDPOINT
            && $request['values'][0] === $contact->sheets_sync_key
            && $request['values'][3] === '0915549148'
            && $request['values'][5] === 'Công ty ABC'
            && $request['values'][7] === 'Cần báo giá'
            && ! isset($request['ip_address']) && ! isset($request['user_agent']));
    }

    public function test_disabled_connection_keeps_form_data_pending_without_external_requests(): void
    {
        config(['ghg_landing.sheets_webhook_url' => null]);
        Http::fake();
        $this->postJson(route('ghg-service.store'), [
            'name' => 'Khách gọi lại', 'phone' => '0915549148',
            'consultation_type' => 'callback', 'form_id' => 'inline-callback', 'website' => '',
        ])->assertCreated();
        $contact = Contact::sole();
        $this->assertNotNull($contact->sheets_sync_key);
        $this->assertNull($contact->sheets_synced_at);
        Http::assertNothingSent();
    }

    public function test_failed_request_is_retried_with_same_id_and_successful_rows_are_not_sent_again(): void
    {
        $contact = $this->consultation();
        Http::fakeSequence()->push([], 503)->push(['ok' => true, 'request_id' => $contact->sheets_sync_key]);
        $sync = app(GhgGoogleSheetSync::class);
        $this->assertFalse($sync->sync($contact));
        $this->assertNull($contact->fresh()->sheets_synced_at);
        $this->assertSame('rejected', $contact->fresh()->sheets_sync_error);
        $this->assertTrue($sync->sync($contact));
        $this->assertTrue($sync->sync($contact));
        Http::assertSentCount(2);
        Http::assertSent(fn ($request) => $request['request_id'] === $contact->sheets_sync_key);
    }

    public function test_invalid_acknowledgment_and_connection_errors_leave_customer_record_available(): void
    {
        $contact = $this->consultation();
        Http::fake([self::ENDPOINT => Http::response(['ok' => true, 'request_id' => 'wrong-id'])]);
        $this->assertFalse(app(GhgGoogleSheetSync::class)->sync($contact));
        $this->assertNull($contact->fresh()->sheets_synced_at);
        Http::fake([self::ENDPOINT => Http::failedConnection()]);
        $this->assertFalse(app(GhgGoogleSheetSync::class)->sync($contact));
        $this->assertSame('connection_failed', $contact->fresh()->sheets_sync_error);
        $this->assertModelExists($contact);
    }

    public function test_retry_command_skips_general_legacy_synced_and_recently_failed_records(): void
    {
        $pending = $this->consultation();
        $recent = $this->consultation();
        $recent->forceFill(['sheets_last_attempt_at' => now()])->save();
        $done = $this->consultation();
        $done->forceFill(['sheets_synced_at' => now()])->save();
        Contact::factory()->create(['source' => route('ghg-service.index')]);
        Contact::factory()->create(['source' => route('contact.index')]);
        Http::fake(fn ($request) => Http::response(['ok' => true, 'request_id' => $request['request_id']]));
        $this->artisan('ghg-sheets:sync')->assertSuccessful();
        Http::assertSentCount(1);
        $this->assertNotNull($pending->fresh()->sheets_synced_at);
        $this->assertNull($recent->fresh()->sheets_synced_at);
    }

    public function test_untrusted_endpoint_and_general_contacts_never_send_customer_data(): void
    {
        $contact = $this->consultation();
        config(['ghg_landing.sheets_webhook_url' => 'https://example.com/exec']);
        Http::fake();
        $this->assertFalse(app(GhgGoogleSheetSync::class)->sync($contact));
        config(['ghg_landing.sheets_webhook_url' => self::ENDPOINT]);
        $contact->update(['source' => route('contact.index')]);
        $this->assertFalse(app(GhgGoogleSheetSync::class)->sync($contact));
        Http::assertNothingSent();
    }
}
