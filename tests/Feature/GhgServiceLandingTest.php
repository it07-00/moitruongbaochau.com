<?php

namespace Tests\Feature;

use App\ContactStatus;
use App\Models\Contact;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GhgServiceLandingTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['ghg_landing.recaptcha_secret_key' => null]);
    }

    public function test_crawlers_receive_valid_service_metadata_and_lightweight_media(): void
    {
        $response = $this->get(route('ghg-service.index'))->assertOk();
        $document = new \DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML($response->getContent());
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $xpath = new \DOMXPath($document);

        $this->assertSame(1, $xpath->query('//head/title')->length);
        $this->assertSame(1, $xpath->query('//h1')->length);
        $this->assertSame(route('ghg-service.index'), $xpath->query('//head/link[@rel="canonical"]')->item(0)->getAttribute('href'));
        $this->assertSame(0, $xpath->query('//img[not(@alt)]')->length);
        $this->assertSame(0, $xpath->query('//video[@autoplay]')->length);
        $this->assertSame('none', $xpath->query('//video')->item(0)->getAttribute('preload'));

        $schema = json_decode($xpath->query('//script[@type="application/ld+json"]')->item(0)->textContent, true, 512, JSON_THROW_ON_ERROR);
        $nodes = collect($schema['@graph'])->keyBy('@type');
        $this->assertSame(route('ghg-service.index'), $nodes['Service']['url']);
        $this->assertSame($nodes['Organization']['@id'], $nodes['Service']['provider']['@id']);
        $this->assertSame($nodes['Service']['@id'], $nodes['WebPage']['mainEntity']['@id']);
        $this->assertSame([route('home'), route('services.index'), route('ghg-service.index')], array_column($nodes['BreadcrumbList']['itemListElement'], 'item'));
        $response->assertDontSee('cdn.tailwindcss.com')->assertSee('landing/ghg-service/css/tailwind.css');

        foreach ($xpath->query('//img[@src]') as $image) {
            $path = parse_url($image->getAttribute('src'), PHP_URL_PATH);
            if (str_starts_with($path ?? '', '/landing/ghg-service/')) {
                $this->assertFileExists(public_path(ltrim($path, '/')));
            }
        }
    }

    private function payload(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Nguyễn Văn An',
            'company_name' => 'Công ty ABC',
            'phone' => '0915549148',
            'email' => 'an@example.com',
            'message' => 'Cần báo giá kiểm kê cho nhà máy.',
            'consultation_type' => 'consultation',
            'form_id' => 'inline-consultation',
            'website' => '',
        ], $overrides);
    }

    public function test_landing_renders_consultation_forms_and_its_own_assets(): void
    {
        $response = $this->get(route('ghg-service.index'));
        $response->assertOk()->assertSee('lang="vi"', false)
            ->assertSee(route('ghg-service.index'))
            ->assertSee('landing/ghg-service/js/consultation-form.js')
            ->assertSee('landing/ghg-service/kkknk-intro-4k.mp4')
            ->assertDontSee('name="password"', false)
            ->assertDontSee('ĐĂNG KÝ TÀI KHOẢN')
            ->assertDontSee('recaptcha/api.js');

        foreach (['inline-consultation', 'inline-callback', 'modal-consultation', 'modal-callback'] as $formId) {
            $response->assertSee('id="'.$formId.'"', false);
        }

        $this->assertSame(4, substr_count($response->getContent(), 'data-consultation-form>'));
    }

    public function test_consultation_persists_into_existing_admin_contacts_with_trusted_source(): void
    {
        $this->postJson(route('ghg-service.store'), $this->payload([
            'name' => '  Nguyễn Văn An  ',
            'topic' => 'Untrusted topic',
            'source' => 'https://spam.example',
            'status' => 'closed',
        ]))->assertCreated()->assertJsonStructure(['message']);

        $contact = Contact::query()->sole();
        $this->assertSame('Nguyễn Văn An', $contact->name);
        $this->assertSame(ContactStatus::New, $contact->status);
        $this->assertSame('Tư vấn dịch vụ kiểm kê khí nhà kính', $contact->topic);
        $this->assertSame(route('ghg-service.index'), $contact->source);
        $this->assertStringContainsString('Công ty ABC', $contact->message);
        $this->assertStringContainsString('Cần báo giá', $contact->message);
    }

    public function test_callback_accepts_only_name_and_phone_as_customer_fields(): void
    {
        $this->postJson(route('ghg-service.store'), $this->payload([
            'email' => '', 'message' => '', 'company_name' => '',
            'consultation_type' => 'callback', 'form_id' => 'modal-callback',
        ]))->assertCreated();
        $contact = Contact::query()->sole();
        $this->assertNull($contact->email);
        $this->assertSame('Yêu cầu gọi lại - Kiểm kê khí nhà kính', $contact->topic);
    }

    public function test_invalid_inputs_do_not_create_contacts(): void
    {
        $this->postJson(route('ghg-service.store'), $this->payload([
            'name' => '', 'phone' => 'abc', 'email' => 'invalid',
            'consultation_type' => 'register', 'form_id' => 'unknown',
        ]))->assertUnprocessable()->assertJsonValidationErrors(['name', 'phone', 'email', 'consultation_type', 'form_id']);
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_honeypot_and_long_messages_are_rejected(): void
    {
        $this->postJson(route('ghg-service.store'), $this->payload([
            'website' => 'spam', 'message' => str_repeat('a', 4001),
        ]))->assertUnprocessable()->assertJsonValidationErrors(['website', 'message']);
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_regular_form_redirects_back_with_success(): void
    {
        $this->post(route('ghg-service.store'), $this->payload())
            ->assertRedirect(route('ghg-service.index').'#form-register-login-features')
            ->assertSessionHas('consultation_success')
            ->assertSessionHas('consultation_form_id', 'inline-consultation');
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_regular_validation_preserves_values_only_in_submitted_form(): void
    {
        $this->from(route('ghg-service.index'))->post(route('ghg-service.store'), $this->payload([
            'phone' => 'abc', 'form_id' => 'modal-callback', 'consultation_type' => 'callback',
        ]))->assertRedirect(route('ghg-service.index'))->assertSessionHasErrors('phone');
        $response = $this->get(route('ghg-service.index'))->assertOk();
        $response->assertSee('data-previous-form="modal-callback"', false);
        $this->assertSame(1, substr_count($response->getContent(), 'value="abc"'));
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_submission_is_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->postJson(route('ghg-service.store'), $this->payload())->assertCreated();
        }
        $this->postJson(route('ghg-service.store'), $this->payload())->assertStatus(429);
        $this->assertDatabaseCount('contacts', 3);
    }

    public function test_recaptcha_token_is_required_when_configured(): void
    {
        config(['ghg_landing.recaptcha_secret_key' => 'test-secret']);
        Http::fake();
        $this->postJson(route('ghg-service.store'), $this->payload())
            ->assertUnprocessable()->assertJsonValidationErrors('g-recaptcha-response');
        Http::assertNothingSent();
        $this->assertDatabaseCount('contacts', 0);
        $this->get(route('ghg-service.index'))->assertSee('recaptcha/api.js')->assertDontSee('test-secret');
    }

    public function test_recaptcha_verifies_token_score_action_and_hostname(): void
    {
        config(['ghg_landing.recaptcha_secret_key' => 'test-secret']);
        Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true, 'score' => 0.9, 'action' => 'ghg_consultation',
            'hostname' => parse_url(route('ghg-service.index'), PHP_URL_HOST),
        ])]);
        $this->postJson(route('ghg-service.store'), $this->payload(['g-recaptcha-response' => 'token']))->assertCreated();
        Http::assertSent(fn ($request): bool => $request['secret'] === 'test-secret' && $request['response'] === 'token');
        $this->assertDatabaseCount('contacts', 1);
    }

    public function test_recaptcha_rejects_failed_low_score_wrong_action_or_hostname(): void
    {
        config(['ghg_landing.recaptcha_secret_key' => 'test-secret']);
        $baseline = [
            'success' => true, 'score' => 0.9, 'action' => 'ghg_consultation',
            'hostname' => parse_url(route('ghg-service.index'), PHP_URL_HOST),
        ];
        foreach ([['success' => false], ['score' => 0.1], ['action' => 'login'], ['hostname' => 'spam.example']] as $invalid) {
            Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::response(array_replace($baseline, $invalid))]);
            $this->withoutMiddleware(ThrottleRequests::class)
                ->postJson(route('ghg-service.store'), $this->payload(['g-recaptcha-response' => 'token']))
                ->assertUnprocessable()->assertJsonValidationErrors('g-recaptcha-response');
        }
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_recaptcha_connection_failure_does_not_create_a_contact(): void
    {
        config(['ghg_landing.recaptcha_secret_key' => 'test-secret']);
        Http::fake(['www.google.com/recaptcha/api/siteverify' => Http::failedConnection()]);
        $this->postJson(route('ghg-service.store'), $this->payload(['g-recaptcha-response' => 'token']))
            ->assertUnprocessable()->assertJsonValidationErrors('g-recaptcha-response');
        $this->assertDatabaseCount('contacts', 0);
    }

    public function test_sitemap_includes_landing_route(): void
    {
        $this->get(route('sitemap'))->assertOk()->assertSee(route('ghg-service.index'));
    }
}
