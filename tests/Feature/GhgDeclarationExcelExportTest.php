<?php

namespace Tests\Feature;

use App\Filament\Resources\GhgDeclarations\Pages\ListGhgDeclarations;
use App\Filament\Resources\GhgDeclarations\Pages\ViewGhgDeclaration;
use App\Models\GhgDeclaration;
use App\Models\User;
use App\Services\GhgDeclarationExcelExport;
use App\Support\GhgSurveyDefinition;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use ZipArchive;

class GhgDeclarationExcelExportTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_workbook_preserves_sections_numbers_and_safe_text(): void
    {
        $data = [];
        foreach (range(1, 6) as $step) {
            $data[$step] = GhgSurveyDefinition::defaults($step);
        }
        $data[1]['company_name'] = '=HYPERLINK("https://example.com")';
        $data[1]['tax_code'] = '0317615845';
        $data[1]['contact_phone'] = '0915549148';
        $data[5]['equipment'] = [
            ['name' => '=Máy lạnh', 'manufacture_year' => 2020, 'brand' => 'Reetech', 'origin' => 'Việt Nam', 'capacity' => '5 kW', 'energy_source' => 'Điện', 'purpose' => 'Làm mát', 'area' => 'Kho'],
        ];
        $data[6]['trees'] = [
            ['name' => '=Sao đen', 'tree_type' => 'hardwood', 'growth_rate' => 'fast', 'age_years' => 5, 'quantity' => 20],
            ['name' => 'Thông', 'tree_type' => 'conifer', 'growth_rate' => 'slow', 'age_years' => 10, 'quantity' => 3],
        ];
        $data[2]['stationary_fuels'] = [['month' => 1, 'fuel_type' => 'do', 'quantity' => 125.5, 'unit' => 'lit', 'purpose' => 'cong_nghiep_sx_xd']];
        foreach (['domestic_wastewater' => ['tu_hoai', 'tap_trung_hieu_khi'], 'industrial_wastewater' => ['hieu_khi_cn', 'uasb']] as $section => $systems) {
            $months = $data[4][$section];
            $data[4][$section] = [];
            foreach ($systems as $system) {
                foreach ($months as $row) {
                    $data[4][$section][] = array_replace($row, ['treatment_type' => $system, 'flow_volume_m3' => 123.5]);
                }
            }
        }
        $record = GhgDeclaration::factory()->create(['data' => $data, 'evidence' => [['name' => 'hoa-don.pdf', 'category' => 'Điện', 'note' => 'Tháng 1', 'size' => 123, 'path' => 'private/secret.pdf']]]);
        $path = tempnam(sys_get_temp_dir(), 'ghg-test-');
        try {
            app(GhgDeclarationExcelExport::class)->writeDeclaration($record, $path);
            $sheets = $this->readWorkbook($path);
            $this->assertCount(7, $sheets);
            $this->assertSame($data[1]['company_name'], $sheets['Thông tin chung'][4][1]);
            $this->assertContains('0317615845', array_column($sheets['Thông tin chung'], 1));
            $this->assertContains('0915549148', array_column($sheets['Thông tin chung'], 1));
            $this->assertSame(125.5, $sheets['Nhiên liệu cố định'][2][2]);
            $this->assertNotSame('do', $sheets['Nhiên liệu cố định'][2][1]);
            $this->assertSame('hoa-don.pdf', $sheets['Chứng từ'][1][0]);
            $equipmentRows = array_values(array_filter($sheets[GhgSurveyDefinition::steps()[5]], fn (array $row): bool => ($row[0] ?? null) === '=Máy lạnh'));
            $this->assertSame([['=Máy lạnh', 2020, 'Reetech', 'Việt Nam', '5 kW', 'Điện', 'Làm mát', 'Kho']], $equipmentRows);
            $treeRows = array_values(array_filter($sheets[GhgSurveyDefinition::steps()[6]], fn (array $row): bool => in_array($row[0] ?? null, ['=Sao đen', 'Thông'], true)));
            $this->assertSame([['=Sao đen', 'Gỗ cứng', 'Nhanh', 5, 20], ['Thông', 'Lá kim', 'Chậm', 10, 3]], $treeRows);
            $waterRows = array_values(array_filter($sheets['Nước thải'], fn (array $row): bool => preg_match('/^Tháng \d+$/u', (string) ($row[0] ?? '')) === 1));
            $this->assertCount(48, $waterRows);
            $this->assertSame(12, count(array_filter($waterRows, fn (array $row): bool => $row[1] === 'UASB')));
            $this->assertSame(12, count(array_filter($waterRows, fn (array $row): bool => $row[1] === 'Bể tự hoại')));
            $this->assertSame(123.5, $waterRows[47][2]);
            $zip = new ZipArchive;
            $zip->open($path);
            foreach (range(1, 7) as $number) {
                $xml = $zip->getFromName('xl/worksheets/sheet'.$number.'.xml');
                $this->assertStringNotContainsString('<f', $xml);
                $this->assertStringNotContainsString('private/secret.pdf', $xml);
            }
            $zip->close();
        } finally {
            unlink($path);
        }
    }

    public function test_admin_downloads_from_view_list_and_record(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $record = GhgDeclaration::factory()->create();
        Livewire::test(ViewGhgDeclaration::class, ['record' => $record->id])->callAction('exportExcel')->assertFileDownloaded('khai-bao-khi-nha-kinh-'.$record->reference.'.xlsx');
        Livewire::test(ListGhgDeclarations::class)->callTableAction('exportExcel', $record)->assertFileDownloaded('khai-bao-khi-nha-kinh-'.$record->reference.'.xlsx');
        Livewire::test(ListGhgDeclarations::class)->callAction('exportExcel')->assertFileDownloaded();
    }

    public function test_list_export_matches_filters_and_search(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $included = GhgDeclaration::factory()->create(['company_name' => 'Bảo Châu', 'status' => 'submitted']);
        GhgDeclaration::factory()->create(['company_name' => 'Bảo Châu', 'status' => 'draft']);
        GhgDeclaration::factory()->create(['company_name' => 'Doanh nghiệp khác', 'status' => 'submitted']);
        $component = Livewire::test(ListGhgDeclarations::class)->filterTable('status', 'submitted')->searchTable('Bảo Châu');
        $path = tempnam(sys_get_temp_dir(), 'ghg-test-');
        try {
            app(GhgDeclarationExcelExport::class)->writeList($component->instance()->getFilteredSortedTableQuery()->lazy(), $path);
            $rows = $this->readWorkbook($path)['Danh sách phiếu'];
            $this->assertCount(2, $rows);
            $this->assertSame($included->reference, $rows[1][0]);
            $this->assertSame('Đã nộp', $rows[1][1]);
        } finally {
            unlink($path);
        }
    }

    public function test_nonadmin_cannot_export(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => false]));
        $this->expectException(HttpException::class);
        app(GhgDeclarationExcelExport::class)->downloadList([]);
    }

    public function test_empty_list_has_headers(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'ghg-test-');
        try {
            app(GhgDeclarationExcelExport::class)->writeList([], $path);
            $rows = $this->readWorkbook($path)['Danh sách phiếu'];
            $this->assertCount(1, $rows);
            $this->assertSame('Mã phiếu', $rows[0][0]);
        } finally {
            unlink($path);
        }
    }

    /** @return array<string, list<array<int, mixed>>> */
    private function readWorkbook(string $path): array
    {
        $reader = new Reader;
        $reader->open($path);
        $result = [];
        try {
            foreach ($reader->getSheetIterator() as $sheet) {
                $rows = [];
                foreach ($sheet->getRowIterator() as $row) {
                    $rows[] = $row->toArray();
                }
                $result[$sheet->getName()] = $rows;
            }
        } finally {
            $reader->close();
        }

        return $result;
    }
}
