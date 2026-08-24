<?php

namespace Tests\Feature;

use App\ContactStatus;
use App\Models\Contact;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_contact_form_validates_and_persists_a_lead(): void
    {
        $response = $this->from(route('contact.index'))->post(route('contact.store'), [
            'name' => 'Nguyễn Văn An',
            'email' => 'an@example.com',
            'phone' => '0915549148',
            'topic' => 'Tư vấn giấy phép môi trường',
            'message' => 'Tôi cần tư vấn hồ sơ cho nhà máy mới.',
            'website' => '',
        ]);

        $response->assertRedirect(route('contact.index'))->assertSessionHas('success');

        $contact = Contact::query()->sole();
        $this->assertSame('Nguyễn Văn An', $contact->name);
        $this->assertSame(ContactStatus::New, $contact->status);
    }

    public function test_contact_form_rejects_invalid_and_honeypot_input(): void
    {
        $this->from(route('contact.index'))->post(route('contact.store'), [
            'name' => '',
            'phone' => 'abc',
            'message' => 'ngắn',
            'website' => 'spam.example',
        ])->assertRedirect(route('contact.index'))
            ->assertSessionHasErrors(['name', 'phone', 'message', 'website']);

        $this->assertSame(0, Contact::query()->count());
    }
}
