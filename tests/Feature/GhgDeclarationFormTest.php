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

    public function test_tree_inventory_persists_renders_and_can_be_removed(): void
    {
        $this->completeSteps();
        $data = GhgSurveyDefinition::defaults(6);
        $data['trees'] = [
            ['name' => 'Sao đen', 'tree_type' => 'hardwood', 'growth_rate' => 'medium', 'age_years' => 5, 'quantity' => 20],
            ['name' => 'Thông', 'tree_type' => 'conifer', 'growth_rate' => 'slow', 'age_years' => 10, 'quantity' => 3],
        ];
        $this->post(route('ghg-form.save', 6), ['action' => 'save', 'data' => $data])->assertSessionHasNoErrors();
        $record = GhgDeclaration::query()->sole();
        $this->assertEquals($data['trees'], $record->data[6]['trees']);
        $this->get(route('ghg-form.step', 6))->assertOk()->assertSee('Thống kê cây xanh')->assertSee('+ Thêm nhóm cây')
            ->assertSee('value="Sao đen"', false)->assertSee('data[trees][1][quantity]', false);
        $this->get(route('ghg-form.step', 7))->assertOk()->assertSee('Sao đen')->assertSee('Gỗ cứng')->assertSee('Lá kim')->assertSee('Trung bình');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(ViewGhgDeclaration::class, ['record' => $record->id])->assertSee('Sao đen')->assertSee('Thống kê cây xanh');
        unset($data['trees']);
        $this->post(route('ghg-form.save', 6), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors();
        $this->assertSame([], $record->refresh()->data[6]['trees']);
        $this->get(route('ghg-form.step', 7))->assertOk()->assertSee('Không có cây xanh.');
    }

    public function test_tree_inventory_rejects_invalid_rows_and_preserves_input(): void
    {
        $this->completeSteps();
        $data = GhgSurveyDefinition::defaults(6);
        $data['trees'] = [['name' => 'Cây cần sửa', 'tree_type' => 'invalid', 'growth_rate' => 'invalid', 'age_years' => -1, 'quantity' => 1.5]];
        $this->from(route('ghg-form.step', 6))->post(route('ghg-form.save', 6), ['action' => 'save', 'data' => $data])
            ->assertSessionHasErrors(['data.trees.0.tree_type', 'data.trees.0.growth_rate', 'data.trees.0.age_years', 'data.trees.0.quantity'])
            ->assertSessionHasInput('data.trees.0.name', 'Cây cần sửa');
        $this->get(route('ghg-form.step', 6))->assertOk()->assertSee('value="Cây cần sửa"', false);
        $this->assertSame([], GhgDeclaration::query()->sole()->data[6]['trees']);
        $data['trees'] = [['quantity' => 0]];
        $this->post(route('ghg-form.save', 6), ['action' => 'next', 'data' => $data])
            ->assertSessionHasErrors(['data.trees.0.name', 'data.trees.0.tree_type', 'data.trees.0.growth_rate', 'data.trees.0.age_years', 'data.trees.0.quantity']);
    }

    public function test_equipment_inventory_persists_renders_and_can_be_removed(): void
    {
        $this->completeSteps();
        $data = GhgSurveyDefinition::defaults(5);
        $data['equipment'] = [
            ['name' => 'Máy lạnh kho', 'manufacture_year' => 2020, 'brand' => 'Reetech', 'origin' => 'Việt Nam', 'capacity' => '5 kW', 'energy_source' => 'Điện', 'purpose' => 'Làm mát', 'area' => 'Kho'],
            ['name' => 'Máy phát điện', 'manufacture_year' => 2023, 'brand' => 'Cummins', 'origin' => 'Mỹ', 'capacity' => '200 kVA', 'energy_source' => 'Dầu DO', 'purpose' => 'Dự phòng', 'area' => 'Nhà máy'],
        ];
        $this->post(route('ghg-form.save', 5), ['action' => 'save', 'data' => $data])->assertSessionHasNoErrors();
        $record = GhgDeclaration::query()->sole();
        $this->assertEquals($data['equipment'], $record->data[5]['equipment']);
        $this->get(route('ghg-form.step', 5))->assertOk()->assertSee('Danh sách thiết bị')->assertSee('+ Thêm thiết bị')
            ->assertSee('value="Máy lạnh kho"', false)->assertSee('data[equipment][1][area]', false);
        $this->get(route('ghg-form.step', 7))->assertOk()->assertSee('Máy lạnh kho')->assertSee('200 kVA')->assertSee('Reetech');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(ViewGhgDeclaration::class, ['record' => $record->id])->assertSee('Máy lạnh kho')->assertSee('Danh sách thiết bị');
        unset($data['equipment']);
        $this->post(route('ghg-form.save', 5), ['action' => 'save', 'data' => $data])->assertSessionHasNoErrors();
        $this->assertSame([], $record->refresh()->data[5]['equipment']);
        $this->get(route('ghg-form.step', 7))->assertOk()->assertSee('Không có thiết bị.');
    }

    public function test_equipment_inventory_rejects_invalid_rows_and_preserves_input(): void
    {
        $this->completeSteps();
        $data = GhgSurveyDefinition::defaults(5);
        $data['equipment'] = [['name' => 'Thiết bị cần sửa', 'manufacture_year' => 1899, 'unexpected' => 'Không được lưu']];
        $this->from(route('ghg-form.step', 5))->post(route('ghg-form.save', 5), ['action' => 'next', 'data' => $data])
            ->assertSessionHasErrors(['data.equipment.0', 'data.equipment.0.manufacture_year', 'data.equipment.0.brand', 'data.equipment.0.origin', 'data.equipment.0.capacity', 'data.equipment.0.energy_source', 'data.equipment.0.purpose', 'data.equipment.0.area'])
            ->assertSessionHasInput('data.equipment.0.name', 'Thiết bị cần sửa');
        $this->get(route('ghg-form.step', 5))->assertOk()->assertSee('value="Thiết bị cần sửa"', false);
        $this->assertSame([], GhgDeclaration::query()->sole()->data[5]['equipment']);
        $data['equipment'] = [['manufacture_year' => 2020.5]];
        $this->post(route('ghg-form.save', 5), ['action' => 'save', 'data' => $data])->assertSessionHasErrors(['data.equipment.0.name', 'data.equipment.0.manufacture_year']);
    }

    public function test_existing_draft_without_new_inventories_can_still_be_submitted(): void
    {
        $this->completeSteps();
        $record = GhgDeclaration::query()->sole();
        $data = $record->data;
        unset($data[6]['trees']);
        unset($data[5]['equipment']);
        $record->update(['data' => $data]);
        $this->get(route('ghg-form.step', 7))->assertOk()->assertSee('Chưa khai báo cây xanh.')->assertSee('Chưa khai báo danh sách thiết bị.');
        $this->post(route('ghg-form.save', 7), ['action' => 'submit', 'confirmation' => 1])->assertSessionHasNoErrors();
        $this->assertSame('submitted', $record->refresh()->status);
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

    public function test_multiple_water_systems_persist_and_require_twelve_unique_months_each(): void
    {
        $this->saveGeneral();
        foreach ([2, 3] as $step) {
            $this->post(route('ghg-form.save', $step), ['action' => 'next', 'data' => GhgSurveyDefinition::defaults($step)])->assertSessionHasNoErrors();
        }
        $data = GhgSurveyDefinition::defaults(4);
        foreach (['domestic_wastewater' => ['tu_hoai', 'tap_trung_hieu_khi'], 'industrial_wastewater' => ['hieu_khi_cn', 'uasb']] as $section => $systems) {
            $months = $data[$section];
            $data[$section] = [];
            foreach ($systems as $system) {
                foreach ($months as $row) {
                    $data[$section][] = array_replace($row, ['treatment_type' => $system, 'flow_volume_m3' => 123.5]);
                }
            }
        }
        $this->post(route('ghg-form.save', 4), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors()->assertRedirect(route('ghg-form.step', 5));
        $record = GhgDeclaration::query()->sole();
        $this->assertSame($data, $record->data[4]);
        $this->get(route('ghg-form.step', 4))->assertOk()->assertSee('Thêm hệ thống xử lý khác')->assertSee('123.5');
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(ViewGhgDeclaration::class, ['record' => $record->id])->assertSee('Bể tự hoại')->assertSee('Tập trung, hiếu khí')->assertSee('UASB');

        $duplicate = $data;
        $duplicate['domestic_wastewater'][1]['month'] = 1;
        $this->post(route('ghg-form.save', 4), ['action' => 'save', 'data' => $duplicate])->assertSessionHasErrors('data.domestic_wastewater.1.month');
        $missing = $data;
        array_pop($missing['industrial_wastewater']);
        $this->post(route('ghg-form.save', 4), ['action' => 'save', 'data' => $missing])->assertSessionHasErrors('data.industrial_wastewater');
        $this->assertSame($data, $record->refresh()->data[4]);
    }

    public function test_water_can_be_saved_without_any_systems(): void
    {
        $this->saveGeneral();
        foreach ([2, 3] as $step) {
            $this->post(route('ghg-form.save', $step), ['action' => 'next', 'data' => GhgSurveyDefinition::defaults($step)])->assertSessionHasNoErrors();
        }
        $this->post(route('ghg-form.save', 4), ['action' => 'next', 'data' => []])->assertSessionHasNoErrors();
        $this->assertSame(['domestic_wastewater' => [], 'industrial_wastewater' => []], GhgDeclaration::query()->sole()->data[4]);
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
