<?php

namespace Tests\Feature;

use App\Filament\Resources\GhgDeclarations\GhgDeclarationResource;
use App\Filament\Resources\GhgDeclarations\Pages\ViewGhgDeclaration;
use App\Models\GhgDeclaration;
use App\Models\User;
use App\Support\GhgSurveyDefinition;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class GhgDeclarationFormTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_public_form_loads_without_creating_a_draft(): void
    {
        $this->get(route('ghg-form.index'))
            ->assertOk()
            ->assertSee('Thông tin chung')
            ->assertSee('Nhiên liệu cố định')
            ->assertSee('name="data[company_name]"', false)
            ->assertSee('VD: 0317615845')
            ->assertSee('Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu')
            ->assertSee('noindex,nofollow');
        $this->assertSame(0, GhgDeclaration::query()->count());
    }

    public function test_invalid_information_preserves_input(): void
    {
        $data = $this->generalData();
        $data['total_staff'] = 0;
        $data['working_days'] = 367;
        $data['contact_email'] = 'invalid';
        $this->from(route('ghg-form.step', 1))->post(route('ghg-form.save', 1), ['action' => 'next', 'data' => $data])
            ->assertSessionHasErrors(['data.total_staff', 'data.working_days', 'data.contact_email'])->assertSessionHasInput('data.company_name', 'Công ty Bảo Châu thử nghiệm');
        $this->get(route('ghg-form.step', 1))->assertOk()->assertSee('Công ty Bảo Châu thử nghiệm');
        $this->assertSame(0, GhgDeclaration::query()->count());
    }

    public function test_all_steps_persist_and_submitted_survey_is_immutable(): void
    {
        $this->completeSteps();
        $record = GhgDeclaration::query()->sole();
        $this->get(route('ghg-form.index'))->assertOk()->assertSee('Kiểm tra dữ liệu trước khi nộp');
        $this->post(route('ghg-form.save', 7), ['action' => 'submit'])->assertSessionHasErrors('confirmation');
        $this->assertSame('draft', $record->refresh()->status);
        $this->post(route('ghg-form.save', 7), ['action' => 'submit', 'confirmation' => 1])->assertRedirect(route('ghg-form.step', 7));
        $record->refresh();
        $this->assertSame('submitted', $record->status);
        $this->assertNotNull($record->submitted_at);
        $this->assertSame(100, (int) $record->data[2]['stationary_fuels'][0]['quantity']);
        $this->assertSame(120, (int) $record->data[6]['electricity'][0]['consumption_kwh']);
        $this->get(route('ghg-form.index'))->assertOk()->assertSee('Đã nhận phiếu khai báo của bạn')->assertSee($record->reference);
        $this->post(route('ghg-form.save', 7), ['action' => 'submit', 'confirmation' => 1])->assertStatus(409);
        $this->post(route('ghg-form.save', 1), ['action' => 'save', 'data' => $this->generalData()])->assertStatus(409);
        $this->assertSame(1, GhgDeclaration::query()->count());
    }

    public function test_draft_resumes_and_other_references_are_ignored(): void
    {
        $foreign = GhgDeclaration::factory()->create(['company_name' => 'Doanh nghiệp bí mật']);
        $this->get(route('ghg-form.index', ['reference' => $foreign->reference]))->assertOk()->assertDontSee('Doanh nghiệp bí mật');
        $this->post(route('ghg-form.save', 1), ['action' => 'save', 'data' => $this->generalData(), 'reference' => $foreign->reference])->assertRedirect(route('ghg-form.step', 1));
        $this->get(route('ghg-form.index'))->assertOk()->assertSee('Công ty Bảo Châu thử nghiệm');
        $this->assertSame('Doanh nghiệp bí mật', $foreign->refresh()->company_name);
        $this->assertSame(2, GhgDeclaration::query()->count());
    }

    public function test_steps_cannot_be_skipped_and_data_cannot_be_injected(): void
    {
        $this->get(route('ghg-form.step', 7))->assertForbidden();
        $this->post(route('ghg-form.save', 7), ['action' => 'submit', 'confirmation' => 1])->assertForbidden();
        $this->get(route('ghg-form.step', 8))->assertNotFound();
        $this->post(route('ghg-form.save', 1), ['action' => 'next', 'data' => $this->generalData() + ['status' => 'submitted']])->assertSessionHasErrors('data');
        $this->assertSame(0, GhgDeclaration::query()->count());
    }

    public function test_fuel_requires_valid_choices_and_nonnegative_numbers(): void
    {
        $this->saveGeneral();
        $this->post(route('ghg-form.save', 2), ['action' => 'next', 'data' => ['stationary_fuels' => [[
            'month' => 13, 'fuel_type' => 'invalid', 'quantity' => -1, 'unit' => 'kg', 'purpose' => 'dan_dung',
        ]]]])->assertSessionHasErrors(['data.stationary_fuels.0.month', 'data.stationary_fuels.0.fuel_type', 'data.stationary_fuels.0.quantity']);
        $this->assertArrayNotHasKey(2, GhgDeclaration::query()->sole()->data);
    }

    public function test_duplicate_fuel_rows_must_be_combined(): void
    {
        $this->saveGeneral();
        $row = ['month' => 1, 'fuel_type' => 'do', 'quantity' => 100, 'unit' => 'lit', 'purpose' => 'cong_nghiep_sx_xd'];
        $this->post(route('ghg-form.save', 2), ['action' => 'next', 'data' => ['stationary_fuels' => [$row, $row]]])
            ->assertSessionHasErrors('data.stationary_fuels.1.month');
        $this->assertArrayNotHasKey(2, GhgDeclaration::query()->sole()->data);
        $row['month'] = 2;
        $this->post(route('ghg-form.save', 2), ['action' => 'next', 'data' => ['stationary_fuels' => [$row]]])
            ->assertSessionHasNoErrors()->assertRedirect(route('ghg-form.step', 3));
    }

    public function test_water_requires_unique_months_and_treatment_when_flow_is_positive(): void
    {
        $this->saveGeneral();
        foreach ([2, 3] as $step) {
            $this->post(route('ghg-form.save', $step), ['action' => 'next', 'data' => GhgSurveyDefinition::defaults($step)])->assertSessionHasNoErrors();
        }
        $data = GhgSurveyDefinition::defaults(4);
        $data['domestic_wastewater'][0]['flow_volume_m3'] = 10;
        $data['industrial_wastewater'][1]['month'] = 1;
        $this->post(route('ghg-form.save', 4), ['action' => 'next', 'data' => $data])->assertSessionHasErrors(['data.domestic_wastewater.0.treatment_type', 'data.industrial_wastewater.1.month']);
        $data = GhgSurveyDefinition::defaults(4);
        array_pop($data['domestic_wastewater']);
        $this->post(route('ghg-form.save', 4), ['action' => 'next', 'data' => $data])->assertSessionHasErrors('data.domestic_wastewater');
    }

    public function test_private_evidence_can_only_be_downloaded_by_admin(): void
    {
        Storage::fake('local');
        $this->completeSteps();
        $file = UploadedFile::fake()->createWithContent('hoa-don.pdf', "%PDF-1.4\nChung tu");
        $this->post(route('ghg-form.save', 7), ['action' => 'save', 'evidence' => [$file], 'evidence_category' => 'Điện', 'evidence_note' => 'Hóa đơn tháng 1'])->assertSessionHasNoErrors();
        $record = GhgDeclaration::query()->sole();
        Storage::disk('local')->assertExists($record->evidence[0]['path']);
        $url = route('ghg-form.evidence', ['declaration' => $record, 'evidence' => 0]);
        $this->get($url)->assertRedirect(route('filament.admin.auth.login'));
        $this->actingAs(User::factory()->create(['is_admin' => false]))->get($url)->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true]))->get($url)->assertOk()->assertDownload('hoa-don.pdf');
        $this->get(route('ghg-form.evidence', ['declaration' => $record, 'evidence' => 99]))->assertNotFound();
    }

    public function test_invalid_and_oversized_uploads_cannot_be_saved(): void
    {
        Storage::fake('local');
        $this->completeSteps();
        $this->post(route('ghg-form.save', 7), ['action' => 'save', 'evidence' => [UploadedFile::fake()->createWithContent('script.php', '<?php echo 1;')]])->assertSessionHasErrors('evidence.0');
        $this->post(route('ghg-form.save', 7), ['action' => 'save', 'evidence' => [UploadedFile::fake()->create('large.pdf', 10241, 'application/pdf')]])->assertSessionHasErrors('evidence.0');
        $this->assertEmpty(Storage::disk('local')->allFiles());
        $this->assertEmpty(GhgDeclaration::query()->sole()->evidence);
    }

    public function test_admin_can_view_all_steps_and_nonadmin_cannot_access_resource(): void
    {
        $this->completeSteps();
        $record = GhgDeclaration::query()->sole();
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->assertFalse(GhgDeclarationResource::canViewAny());
        $this->get(GhgDeclarationResource::getUrl('view', ['record' => $record]))->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(ViewGhgDeclaration::class, ['record' => $record->id])->assertOk()->assertSee('Công ty Bảo Châu thử nghiệm')->assertSee('Nhiên liệu cố định')->assertSee('120');
        $this->assertFalse(GhgDeclarationResource::canEdit($record));
    }

    private function saveGeneral(): void
    {
        $this->post(route('ghg-form.save', 1), ['action' => 'next', 'data' => $this->generalData()])->assertSessionHasNoErrors()->assertRedirect(route('ghg-form.step', 2));
    }

    private function completeSteps(): void
    {
        $this->saveGeneral();
        foreach (range(2, 6) as $step) {
            $data = GhgSurveyDefinition::defaults($step);
            if ($step === 2) {
                $data['stationary_fuels'][] = ['month' => 1, 'fuel_type' => 'do', 'quantity' => 100, 'unit' => 'lit', 'purpose' => 'cong_nghiep_sx_xd', 'notes' => 'Máy phát điện'];
            }
            if ($step === 6) {
                $data['electricity'][0]['consumption_kwh'] = 120;
            }
            $this->post(route('ghg-form.save', $step), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors()->assertRedirect(route('ghg-form.step', $step + 1));
            $this->get(route('ghg-form.step', $step + 1))->assertOk();
        }
    }

    /** @return array<string, mixed> */
    private function generalData(): array
    {
        return ['company_name' => 'Công ty Bảo Châu thử nghiệm', 'tax_code' => '0312345678', 'address' => 'TP. Hồ Chí Minh',
            'contact_name' => 'Nguyễn Văn A', 'contact_phone' => '0915549148', 'contact_email' => 'survey@example.com',
            'inventory_year' => 2026, 'total_staff' => 100, 'working_days' => 312, 'purpose' => 'Kiểm kê khí nhà kính'];
    }
}
