<?php

namespace Tests\Feature;

use App\ContactStatus;
use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Contacts\Pages\ListContacts;
use App\Filament\Resources\GhgConsultations\GhgConsultationResource;
use App\Filament\Resources\GhgConsultations\Pages\EditGhgConsultation;
use App\Filament\Resources\GhgConsultations\Pages\ListGhgConsultations;
use App\Models\Contact;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GhgConsultationAdminTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_lists_and_badges_separate_existing_and_new_consultations_from_contacts(): void
    {
        $general = Contact::factory()->create(['source' => route('contact.index')]);
        $legacyGeneral = Contact::factory()->create(['source' => null]);
        $consultation = Contact::factory()->create(['source' => route('ghg-service.index')]);
        $legacyConsultation = Contact::factory()->create(['source' => 'https://old.example'.route('ghg-service.index', [], false)]);

        Livewire::test(ListContacts::class)
            ->assertCanSeeTableRecords([$general, $legacyGeneral])
            ->assertCanNotSeeTableRecords([$consultation, $legacyConsultation]);
        Livewire::test(ListGhgConsultations::class)
            ->assertCanSeeTableRecords([$consultation, $legacyConsultation])
            ->assertCanNotSeeTableRecords([$general, $legacyGeneral]);
        $this->assertSame('2', ContactResource::getNavigationBadge());
        $this->assertSame('2', GhgConsultationResource::getNavigationBadge());
        $this->assertNull(ContactResource::resolveRecordRouteBinding($consultation->id));
        $this->assertNull(GhgConsultationResource::resolveRecordRouteBinding($general->id));
    }

    public function test_consultation_status_can_be_updated_without_changing_general_contacts(): void
    {
        $general = Contact::factory()->create();
        $consultation = Contact::factory()->create(['source' => route('ghg-service.index')]);

        Livewire::test(EditGhgConsultation::class, ['record' => $consultation->id])
            ->fillForm(['status' => ContactStatus::InProgress->value])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(ContactStatus::InProgress, $consultation->fresh()->status);
        $this->assertSame(ContactStatus::New, $general->fresh()->status);
    }

    public function test_only_admins_can_access_consultation_management(): void
    {
        $this->get(route('filament.admin.resources.ghg-consultations.index'))->assertOk();
        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->get(route('filament.admin.resources.ghg-consultations.index'))->assertForbidden();
        auth()->logout();
        $this->get(route('filament.admin.resources.ghg-consultations.index'))
            ->assertRedirect(route('filament.admin.auth.login'));
    }
}
