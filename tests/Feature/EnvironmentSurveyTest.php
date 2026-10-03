<?php

namespace Tests\Feature;

use App\Filament\Resources\EnvironmentSurveys\EnvironmentSurveyResource;
use App\Filament\Resources\EnvironmentSurveys\Pages\ListEnvironmentSurveys;
use App\Filament\Resources\EnvironmentSurveys\Pages\ViewEnvironmentSurvey;
use App\Models\EnvironmentSurvey;
use App\Models\Service;
use App\Models\SurveyFile;
use App\Models\User;
use App\Services\EnvironmentSurveyExport;
use App\Services\EnvironmentSurveyService;
use App\Support\EnvironmentSurveyDefinition as Definition;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader;
use Tests\TestCase;
use ZipArchive;

class EnvironmentSurveyTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_environment_report_service_links_to_the_survey(): void
    {
        $service = Service::factory()->make(['slug' => 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky']);
        $this->assertSame(route('bvmt.index'), $service->getDeclarationFormUrl());
    }

    public function test_public_form_and_unknown_token(): void
    {
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Báo cáo công tác')->assertSee('name="data[company_name]"', false)->assertSee('noindex,nofollow')->assertHeader('Referrer-Policy', 'no-referrer');
        $this->assertSame(0, EnvironmentSurvey::query()->count());
        $this->get('/khao-sat/not-a-token')->assertNotFound();
    }

    public function test_fixed_link_resumes_the_same_draft_without_exposing_a_token(): void
    {
        $this->post(route('bvmt.save', ['step' => 1]), ['action' => 'save', 'data' => ['company_name' => 'Công ty dùng link cố định']])
            ->assertRedirect(route('bvmt.step', ['step' => 1]));
        $survey = EnvironmentSurvey::query()->sole();
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Công ty dùng link cố định')->assertDontSee($survey->token)
            ->assertSee('ghg-guide-card')->assertSee('ghg-survey.css')->assertSee('bvmt-survey.css');
        $this->post(route('bvmt.save', ['step' => 1]), ['action' => 'goto', 'target_step' => 2, 'data' => ['company_name' => 'Công ty đã cập nhật']])
            ->assertRedirect(route('bvmt.step', ['step' => 2]));
        $this->assertSame(1, EnvironmentSurvey::query()->count());
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Bước 2 / 7');
        $this->assertSame('Công ty đã cập nhật', $survey->refresh()->company_name);
    }

    public function test_fixed_links_do_not_select_another_survey_from_query_parameters(): void
    {
        Storage::fake('local');
        $survey = EnvironmentSurvey::factory()->create(['data' => ['company_name' => 'Doanh nghiệp riêng']]);
        $file = SurveyFile::factory()->create(['environment_survey_id' => $survey->id]);
        $this->get(route('bvmt.index', ['survey' => $survey->token]))->assertOk()->assertDontSee('Doanh nghiệp riêng');
        $this->get(route('bvmt.file', ['file' => $file, 'survey' => $survey->token]))->assertNotFound();
        $this->delete(route('bvmt.file.delete', ['file' => $file]))->assertNotFound();
        $this->post(route('bvmt.start', ['survey' => $survey->token]), ['action' => 'save', 'data' => ['company_name' => 'Doanh nghiệp mới']])->assertSessionHasNoErrors();
        $this->assertSame(2, EnvironmentSurvey::query()->count());
        $this->assertSame('Doanh nghiệp riêng', $survey->refresh()->data['company_name']);
    }

    public function test_all_steps_render_saved_rows_and_information(): void
    {
        $row = ['name' => 'Dữ liệu đã lưu', 'unit' => 'kg', 'quantity_2025' => 0, 'quantity_2026' => 12.5];
        $data = $this->companyData() + Definition::defaults(4) + $this->documentsData();
        $data += ['has_wastewater_treatment' => false, 'has_air_treatment' => false, 'products' => [$row], 'fuels' => [$row], 'domestic_wastes' => [$row], 'industrial_wastes' => [$row + ['is_reused_as_material' => false]], 'hazardous_wastes' => [$row + ['code' => '18 01 01']]];
        $survey = EnvironmentSurvey::factory()->create(['data' => $data]);
        $this->withSession(['bvmt_survey.reference' => $survey->reference]);
        foreach (range(1, 7) as $step) {
            $response = $this->get(route('bvmt.step', ['step' => $step]))->assertOk()->assertSee(Definition::steps()[$step]);
            if (in_array($step, [2, 3, 5], true)) {
                $response->assertSee('value="12.5"', false)->assertSee('Dữ liệu đã lưu');
            }
        }
    }

    public function test_incomplete_draft_is_saved_and_can_resume_on_another_device(): void
    {
        $this->post(route('bvmt.start'), ['action' => 'save', 'data' => ['company_name' => 'Doanh nghiệp A']])->assertSessionHasNoErrors();
        $survey = EnvironmentSurvey::query()->sole();
        $this->assertSame(64, strlen($survey->token));
        $this->assertSame('draft', $survey->status);
        $this->flushSession();
        $this->get(route('bvmt.show', ['survey' => $survey->token]))->assertRedirect(route('bvmt.step', ['step' => 1]));
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Doanh nghiệp A')->assertDontSee($survey->token);
        $this->post($this->saveUrl($survey, 1), ['action' => 'next', 'data' => ['company_name' => 'Dữ liệu giữ lại']])->assertSessionHasErrors('data.contact_email')->assertSessionHasInput('data.company_name', 'Dữ liệu giữ lại');
        $this->assertSame('Doanh nghiệp A', $survey->refresh()->company_name);
    }

    public function test_draft_still_rejects_negative_and_unexpected_data(): void
    {
        $this->post(route('bvmt.start'), ['action' => 'save', 'data' => ['employee_count_2026' => -1, 'status' => 'completed']])->assertSessionHasErrors(['data.employee_count_2026', 'data']);
        $this->assertSame(0, EnvironmentSurvey::query()->count());
        $survey = EnvironmentSurvey::factory()->create();
        $this->post($this->saveUrl($survey, 2), ['action' => 'save', 'data' => ['products' => [['name' => 'A', 'quantity_2026' => -1]]]])->assertSessionHasErrors('data.products.0.quantity_2026');
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => ['has_environment_report_2025' => ['bad']]])->assertSessionHasErrors('data.has_environment_report_2025');
    }

    public function test_seasonal_months_and_treatment_descriptions_are_conditional(): void
    {
        $data = $this->companyData();
        $data['operation_frequency'] = 'seasonal';
        $this->post(route('bvmt.start'), ['action' => 'next', 'data' => $data])->assertSessionHasErrors(['data.seasonal_start_month', 'data.seasonal_end_month']);
        $data += ['seasonal_start_month' => 12, 'seasonal_end_month' => 2];
        $this->post(route('bvmt.start'), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors();
        $survey = EnvironmentSurvey::query()->sole();
        $water = Definition::defaults(4) + ['has_wastewater_treatment' => 1, 'has_air_treatment' => 0];
        $this->post($this->saveUrl($survey, 4), ['action' => 'next', 'data' => $water])->assertSessionHasErrors('data.wastewater_treatment_description');
        $water['wastewater_treatment_description'] = 'Hệ thống 20 m³/ngày';
        $this->post($this->saveUrl($survey, 4), ['action' => 'next', 'data' => $water])->assertSessionHasNoErrors();
    }

    public function test_report_2025_is_required_and_shared_with_document_step(): void
    {
        Storage::fake('local');
        $data = array_replace($this->companyData(), ['has_environment_report_2025' => 1]);
        $this->post(route('bvmt.start'), ['action' => 'next', 'data' => $data])->assertSessionHasErrors('uploads.environment_report_2025');
        $this->assertSame(0, EnvironmentSurvey::query()->count());
        $this->post(route('bvmt.start'), ['action' => 'next', 'data' => $data, 'uploads' => ['environment_report_2025' => [UploadedFile::fake()->create('baocao.pdf', 10, 'application/pdf')]]])->assertSessionHasNoErrors();
        $survey = EnvironmentSurvey::query()->sole();
        $this->assertSame('environment_report_2025', $survey->data['source_2025']);
        $this->assertSame('available', $survey->data['documents']['environment_report_2025']['status']);
        $this->post($this->saveUrl($survey, 2), ['action' => 'next', 'data' => ['products' => [['name' => 'Sản phẩm', 'unit' => 'kg', 'quantity_2025' => -999, 'quantity_2026' => 12.5]]]])->assertSessionHasNoErrors();
        $this->assertArrayNotHasKey('quantity_2025', $survey->refresh()->data['products'][0]);
        $this->get(route('bvmt.step', ['step' => 6]))->assertOk()->assertSee('Đã cung cấp ở bước 1');
        $this->assertSame(1, $survey->files()->count());
    }

    public function test_2025_data_required_without_report_and_all_tables_validate(): void
    {
        $survey = EnvironmentSurvey::factory()->create(['data' => $this->companyData()]);
        foreach ([2 => 'products', 3 => 'fuels', 5 => 'domestic_wastes'] as $step => $key) {
            $data = Definition::defaults($step);
            $data[$key] = [['name' => 'Dữ liệu', 'unit' => 'kg', 'quantity_2026' => 0]];
            $this->post($this->saveUrl($survey, $step), ['action' => 'next', 'data' => $data])->assertSessionHasErrors('data.'.$key.'.0.quantity_2025');
        }
        $water = Definition::defaults(4) + ['has_wastewater_treatment' => 0, 'has_air_treatment' => 0];
        $water['actual_wastewater_flows'][1]['type'] = 'domestic';
        $this->post($this->saveUrl($survey, 4), ['action' => 'next', 'data' => $water])->assertSessionHasErrors('data.actual_wastewater_flows.0.type');
        $waste = Definition::defaults(5);
        $waste['industrial_wastes'] = [['name' => 'Vải', 'unit' => 'kg', 'quantity_2025' => 0, 'quantity_2026' => 0, 'is_reused_as_material' => 'invalid']];
        $this->post($this->saveUrl($survey, 5), ['action' => 'next', 'data' => $waste])->assertSessionHasErrors('data.industrial_wastes.0.is_reused_as_material');
    }

    public function test_report_choice_excludes_2025_in_every_quantity_table(): void
    {
        $survey = EnvironmentSurvey::factory()->create(['data' => ['has_environment_report_2025' => true]]);
        foreach ([3 => ['fuels'], 5 => ['domestic_wastes', 'industrial_wastes', 'hazardous_wastes']] as $step => $tables) {
            $data = Definition::defaults($step);
            foreach ($tables as $key) {
                $data[$key] = [['name' => 'Mẫu', 'unit' => 'kg', 'quantity_2025' => -1, 'quantity_2026' => 0]];
                if ($key === 'industrial_wastes') {
                    $data[$key][0]['is_reused_as_material'] = 0;
                }
            }
            $this->post($this->saveUrl($survey, $step), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors();
            foreach ($tables as $key) {
                $this->assertArrayNotHasKey('quantity_2025', $survey->refresh()->data[$key][0]);
            }
        }
        $data = Definition::defaults(4) + ['has_wastewater_treatment' => 0, 'has_air_treatment' => 0];
        $data['actual_wastewater_flows'][0]['flow_2025'] = -1;
        $this->post($this->saveUrl($survey, 4), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors();
        $this->assertArrayNotHasKey('flow_2025', $survey->refresh()->data['actual_wastewater_flows'][0]);
    }

    public function test_failed_document_step_rolls_back_uploaded_files(): void
    {
        Storage::fake('local');
        $survey = EnvironmentSurvey::factory()->create();
        $data = $this->documentsData();
        $data['documents']['land_use_certificate']['status'] = 'available';
        $this->post($this->saveUrl($survey, 6), ['action' => 'next', 'data' => $data, 'uploads' => ['business_registration' => [UploadedFile::fake()->create('dangky.pdf', 1, 'application/pdf')]]])->assertSessionHasErrors('data.documents.land_use_certificate.status');
        $this->assertSame(0, $survey->files()->count());
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_file_validation_counts_and_cross_survey_access(): void
    {
        Storage::fake('local');
        $survey = EnvironmentSurvey::factory()->create();
        $other = EnvironmentSurvey::factory()->create();
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => [], 'uploads' => ['environment_report_2025' => [UploadedFile::fake()->create('bad.exe', 5, 'application/octet-stream')]]])->assertSessionHasErrors('uploads.environment_report_2025.0');
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => [], 'uploads' => ['environment_report_2025' => [UploadedFile::fake()->create('big.pdf', 20481, 'application/pdf')]]])->assertSessionHasErrors('uploads.environment_report_2025.0');
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => [], 'uploads' => ['environment_report_2025' => [UploadedFile::fake()->create('report.pdf', 1, 'application/pdf')]]])->assertSessionHasNoErrors();
        $file = $survey->files()->sole();
        Storage::disk('local')->assertExists($file->path);
        $this->withSession(['bvmt_survey.reference' => $other->reference])->get(route('bvmt.file', ['file' => $file]))->assertNotFound();
        $this->delete(route('bvmt.file.delete', ['file' => $file]))->assertNotFound();
        $this->withSession(['bvmt_survey.reference' => $survey->reference])->get(route('bvmt.file', ['file' => $file]))->assertDownload('report.pdf');
        SurveyFile::factory()->count(9)->create(['environment_survey_id' => $survey->id]);
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => [], 'uploads' => ['environment_report_2025' => [UploadedFile::fake()->create('extra.pdf', 1, 'application/pdf')]]])->assertSessionHasErrors('uploads.environment_report_2025');
        $this->assertSame(10, $survey->files()->count());
        $this->delete(route('bvmt.file.delete', ['file' => $file]))->assertNoContent();
        $this->assertModelMissing($file);
    }

    public function test_available_documents_need_files_and_uploads_set_status(): void
    {
        Storage::fake('local');
        $survey = EnvironmentSurvey::factory()->create();
        $data = $this->documentsData();
        $data['documents']['business_registration']['status'] = 'available';
        $this->post($this->saveUrl($survey, 6), ['action' => 'next', 'data' => $data])->assertSessionHasErrors('data.documents.business_registration.status');
        $data['documents']['business_registration']['status'] = 'pending';
        $this->post($this->saveUrl($survey, 6), ['action' => 'next', 'data' => $data, 'uploads' => ['business_registration' => [UploadedFile::fake()->create('dkdn.pdf', 1, 'application/pdf')]]])->assertSessionHasNoErrors();
        $this->assertSame('available', $survey->refresh()->data['documents']['business_registration']['status']);
        $data['documents']['business_registration']['status'] = 'not_available';
        $this->post($this->saveUrl($survey, 6), ['action' => 'next', 'data' => $data])->assertSessionHasErrors('data.documents.business_registration.status');
    }

    public function test_whole_flow_submit_locks_updates_and_admin_can_reopen(): void
    {
        $survey = $this->completeSurvey();
        $this->get(route('bvmt.step', ['step' => 7]))->assertOk()->assertSee('Chỉnh sửa bước 1');
        $this->post($this->saveUrl($survey, 7), ['action' => 'submit', 'data' => ['confirm_information' => 0]])->assertSessionHasErrors('data.confirm_information');
        $this->post($this->saveUrl($survey, 7), ['action' => 'submit', 'data' => ['confirm_information' => 1, 'submit_note' => 'Đã kiểm tra']])->assertSessionHasNoErrors();
        $this->assertSame('submitted', $survey->refresh()->status);
        $this->assertNotNull($survey->submitted_at);
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Đã nhận phiếu khảo sát của bạn');
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => ['company_name' => 'Thay đổi']])->assertStatus(409);
        $file = SurveyFile::factory()->create(['environment_survey_id' => $survey->id]);
        $this->delete(route('bvmt.file.delete', ['file' => $file]))->assertStatus(409);
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        app(EnvironmentSurveyService::class)->changeStatus($survey, 'revision_required', 'Bổ sung thông tin liên hệ');
        $this->get(route('bvmt.index'))->assertOk()->assertSee('Bổ sung thông tin liên hệ');
        $this->post($this->saveUrl($survey, 1), ['action' => 'save', 'data' => $this->companyData()])->assertSessionHasNoErrors();
        $file->delete();
        $this->post($this->saveUrl($survey, 7), ['action' => 'submit', 'data' => ['confirm_information' => 1]])->assertSessionHasNoErrors();
        app(EnvironmentSurveyService::class)->changeStatus($survey->refresh(), 'completed');
        $this->assertFalse($survey->isEditable());
    }

    public function test_submit_revalidates_earlier_steps_after_report_choice_changes(): void
    {
        $survey = EnvironmentSurvey::factory()->create(['data' => ['confirm_information' => true]]);
        $this->post($this->saveUrl($survey, 7), ['action' => 'submit', 'data' => ['confirm_information' => 1]])->assertSessionHasErrors('data.company_name');
        $this->assertSame('draft', $survey->refresh()->status);
        $survey = $this->completeSurvey();
        $data = $survey->data;
        unset($data['products'][0]['quantity_2025']);
        $survey->update(['data' => $data]);
        $this->post($this->saveUrl($survey, 7), ['action' => 'submit', 'data' => ['confirm_information' => 1]])->assertSessionHasErrors('data.products.0.quantity_2025');
    }

    public function test_admin_resource_actions_and_permissions(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $survey = $this->completeSurvey();
        $survey->update(['status' => 'submitted', 'submitted_at' => now()]);
        $this->get(route('bvmt.admin.export', ['survey' => $survey]))->assertRedirect();
        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->get(route('bvmt.admin.export', ['survey' => $survey]))->assertForbidden();
        $this->get(EnvironmentSurveyResource::getUrl('view', ['record' => $survey]))->assertForbidden();
        $this->assertFalse(EnvironmentSurveyResource::canViewAny());
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(ListEnvironmentSurveys::class)->assertOk()->assertCanSeeTableRecords([$survey]);
        Livewire::test(ViewEnvironmentSurvey::class, ['record' => $survey->id])->assertOk()->assertSee('Hồ sơ chưa đính kèm')->callAction('requestRevision', data: ['note' => 'Cập nhật số liệu'])->assertHasNoActionErrors();
        $this->assertSame('revision_required', $survey->refresh()->status);
        Livewire::test(ListEnvironmentSurveys::class)->callAction('createSurvey', data: ['company_name' => 'Khách mới', 'contact_email' => 'khach@example.com'])->assertHasNoActionErrors();
        $this->assertSame(2, EnvironmentSurvey::query()->count());
        $this->get(route('bvmt.admin.export', ['survey' => $survey]))->assertOk()->assertDownload('BVMT-2026-'.$survey->reference.'.xlsx');
    }

    public function test_excel_export_preserves_numeric_values_and_safe_text(): void
    {
        $survey = $this->completeSurvey();
        $data = $survey->data;
        $data['company_name'] = '=HYPERLINK("https://example.com")';
        $survey->update(['data' => $data]);
        $path = tempnam(sys_get_temp_dir(), 'bvmt-test-');
        try {
            app(EnvironmentSurveyExport::class)->write($survey, $path);
            $reader = new Reader;
            $reader->open($path);
            $sheets = [];
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    $sheets[$sheet->getName()][] = $row->toArray();
                }
            }
            $reader->close();
            $this->assertCount(9, $sheets);
            $this->assertContains($data['company_name'], array_column($sheets['Thông tin doanh nghiệp'], 1));
            $this->assertSame(12.5, $sheets['Sản phẩm & sản lượng'][2][3]);
            $zip = new ZipArchive;
            $zip->open($path);
            $this->assertStringNotContainsString('<f', $zip->getFromName('xl/worksheets/sheet1.xml'));
            $zip->close();
        } finally {
            unlink($path);
        }
    }

    public function test_zip_archive_scopes_files_and_keeps_duplicate_names(): void
    {
        Storage::fake('local');
        $survey = EnvironmentSurvey::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get(route('bvmt.admin.archive', ['survey' => $survey]))->assertNotFound();
        foreach (range(1, 2) as $index) {
            Storage::disk('local')->put('environment-surveys/'.$index.'.pdf', 'PDF '.$index);
            SurveyFile::factory()->create(['environment_survey_id' => $survey->id, 'path' => 'environment-surveys/'.$index.'.pdf', 'original_name' => 'hồ-sơ.pdf']);
        }
        $response = app(EnvironmentSurveyExport::class)->archive($survey);
        $path = $response->getFile()->getPathname();
        $zip = new ZipArchive;
        try {
            $zip->open($path);
            $this->assertSame(2, $zip->numFiles);
            $this->assertSame('PDF 1', $zip->getFromIndex(0));
            $this->assertNotSame($zip->getNameIndex(0), $zip->getNameIndex(1));
            $zip->close();
        } finally {
            unlink($path);
        }
    }

    private function completeSurvey(): EnvironmentSurvey
    {
        $survey = EnvironmentSurvey::factory()->create();
        foreach (range(1, 6) as $step) {
            $data = match ($step) {
                1 => $this->companyData(),
                2 => ['products' => [['name' => 'Sản phẩm mẫu', 'unit' => 'kg', 'quantity_2025' => 10, 'quantity_2026' => 12.5]]],
                4 => Definition::defaults(4) + ['has_wastewater_treatment' => 0, 'has_air_treatment' => 0],
                6 => $this->documentsData(), default => Definition::defaults($step),
            };
            $this->post($this->saveUrl($survey, $step), ['action' => 'next', 'data' => $data])->assertSessionHasNoErrors();
        }
        $this->assertCount(6, app(EnvironmentSurveyService::class)->completedSteps($survey->refresh()));

        return $survey;
    }

    /** @return array<string, mixed> */
    private function companyData(): array
    {
        return ['company_name' => 'Công ty khảo sát', 'tax_code' => '0123456789', 'address' => 'Địa chỉ doanh nghiệp', 'contact_name' => 'Nguyễn A', 'contact_phone' => '0912345678', 'contact_email' => 'dn@example.com', 'employee_count_2026' => 0, 'business_type' => 'Sản xuất', 'operation_frequency' => 'regular', 'has_environment_report_2025' => 0];
    }

    /** @return array<string, mixed> */
    private function documentsData(): array
    {
        $data = Definition::defaults(6);
        foreach ($data['documents'] as &$document) {
            $document['status'] = 'not_available';
        }

        return $data;
    }

    private function saveUrl(EnvironmentSurvey $survey, int $step): string
    {
        $this->withSession(['bvmt_survey.reference' => $survey->reference]);

        return route('bvmt.save', ['step' => $step]);
    }
}
