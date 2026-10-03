<?php

namespace Database\Seeders;

use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GhgDeclarationDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([1 => 'submitted', 2 => 'submitted', 3 => 'draft'] as $number => $status) {
            $reference = '01M3X7VMW8TTWKR06WRJNA9K0'.$number;
            if (GhgDeclaration::query()->where('reference', $reference)->exists()) {
                continue;
            }
            $data = $this->sampleData($number);
            foreach (range(1, 6) as $step) {
                Validator::make(['data' => $data[$step]], GhgSurveyDefinition::rules($step))->validate();
            }
            $path = 'ghg-declarations/'.$reference.'/chung-tu-mau.pdf';
            $pdf = $this->samplePdf();
            Storage::disk('local')->put($path, $pdf);
            GhgDeclaration::query()->create([
                'reference' => $reference,
                'company_name' => $data[1]['company_name'],
                'contact_email' => $data[1]['contact_email'],
                'status' => $status,
                'current_step' => 7,
                'data' => $data,
                'evidence' => [[
                    'path' => $path, 'name' => 'chung-tu-mau.pdf', 'size' => strlen($pdf),
                    'category' => 'Điện & Năng lượng', 'note' => 'Tài liệu minh họa do seeder tạo, không phải hóa đơn thực tế.',
                ]],
                'submitted_at' => $status === 'submitted' ? now()->subDays($number) : null,
            ]);
        }
    }

    /** @return array<int, array<string, mixed>> */
    private function sampleData(int $number): array
    {
        $data = [1 => [
            'company_name' => '[DỮ LIỆU MẪU] Công ty Sản xuất Minh họa '.$number,
            'tax_code' => '000000000'.$number,
            'address' => 'Cơ sở minh họa '.$number.', TP. Hồ Chí Minh (địa chỉ mẫu)',
            'contact_name' => 'Người liên hệ mẫu '.$number,
            'contact_phone' => '090000000'.$number,
            'contact_email' => 'ghg-demo-'.$number.'@example.com',
            'inventory_year' => 2026, 'total_staff' => 80 * $number, 'working_days' => 300,
            'purpose' => 'Dữ liệu minh họa để kiểm tra quản lý và xuất Excel, không dùng làm báo cáo thực tế.',
            'energy_consumption_toe' => 420.5 * $number,
        ]];
        foreach (range(2, 6) as $step) {
            $data[$step] = GhgSurveyDefinition::defaults($step);
        }
        foreach (range(1, 12) as $month) {
            $data[2]['stationary_fuels'][] = ['month' => $month, 'fuel_type' => 'do', 'quantity' => (1200 + $month * 25) * $number, 'unit' => 'lit', 'purpose' => 'cong_nghiep_sx_xd', 'notes' => 'Nồi hơi phân xưởng mẫu'];
            $data[2]['stationary_fuels'][] = ['month' => $month, 'fuel_type' => 'lpg', 'quantity' => (300 + $month * 5) * $number, 'unit' => 'kg', 'purpose' => 'cong_nghiep_sx_xd', 'notes' => 'Gia nhiệt khu vực mẫu'];
            $data[3]['mobile_fuels'][] = ['month' => $month, 'fuel_type' => 'do', 'equipment_type' => 'duong_bo', 'quantity' => (450 + $month * 10) * $number, 'unit' => 'lit', 'notes' => 'Đội xe tải mẫu'];
            $data[4]['domestic_wastewater'][$month - 1] = ['month' => $month, 'treatment_type' => 'tu_hoai', 'flow_volume_m3' => (100 + $month) * $number, 'n_concentration_mg_l' => 12.5, 'bod_concentration_mg_l' => 30];
            $data[4]['industrial_wastewater'][$month - 1] = ['month' => $month, 'treatment_type' => 'hieu_khi_cn', 'flow_volume_m3' => (320 + $month * 2) * $number, 'cod_before_mg_l' => 450, 'cod_after_mg_l' => 65];
            $data[6]['electricity'][$month - 1] = ['month' => $month, 'consumption_kwh' => (18500 + $month * 150) * $number];
            $data[6]['steam'][$month - 1] = ['month' => $month, 'consumption' => (25.5 + $month) * $number, 'unit' => 'GJ'];
        }
        $data[6]['trees'] = [
            ['name' => 'Sao đen (dữ liệu mẫu)', 'tree_type' => 'hardwood', 'growth_rate' => 'medium', 'age_years' => 5, 'quantity' => 20 * $number],
        ];
        $data[6]['other_activities'] = [
            ['name' => 'Chất thải rắn (dữ liệu mẫu)', 'description' => 'Chuyển giao xử lý trong năm', 'quantity' => 12.5 * $number, 'unit' => 'tấn', 'notes' => 'Số liệu minh họa, không dùng làm báo cáo thực tế'],
        ];
        $data[5]['equipment'] = [
            ['name' => 'Máy lạnh văn phòng (dữ liệu mẫu)', 'manufacture_year' => 2020, 'brand' => 'Reetech', 'origin' => 'Việt Nam', 'capacity' => '5 kW', 'energy_source' => 'Điện', 'purpose' => 'Làm mát', 'area' => 'Văn phòng'],
        ];
        $data[5]['fire_extinguishers'] = [
            ['extinguisher_type' => 'MT5', 'new_count' => 5, 'new_weight_kg' => 25, 'in_use_count' => 20, 'recharge_kg' => 10, 'disposed_count' => 2],
            ['extinguisher_type' => 'MFZ4', 'new_count' => 4, 'new_weight_kg' => 16, 'in_use_count' => 30, 'recharge_kg' => 8, 'disposed_count' => 1],
        ];
        $data[5]['refrigeration'] = [
            ['equipment_name' => 'Điều hòa văn phòng mẫu', 'model_code' => 'DEMO-AC-01', 'refrigerant_type' => 'R32', 'annual_refill_kg' => 3.5, 'equipment_count' => 8, 'notes' => 'Bảo dưỡng tháng 7 (dữ liệu mẫu)'],
            ['equipment_name' => 'Kho lạnh mẫu', 'model_code' => 'DEMO-COLD-01', 'refrigerant_type' => 'R404A', 'annual_refill_kg' => 12, 'equipment_count' => 2, 'notes' => 'Nhật ký thiết bị minh họa'],
        ];

        return $data;
    }

    private function samplePdf(): string
    {
        $text = 'BT /F1 18 Tf 50 780 Td (DEMO DOCUMENT - NOT A REAL INVOICE) Tj ET';
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>',
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            '<< /Length '.strlen($text).">>\nstream\n".$text."\nendstream",
        ];
        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n".$object."\nendobj\n";
        }
        $start = strlen($pdf);
        $pdf .= "xref\n0 6\n0000000000 65535 f \n";
        foreach (array_slice($offsets, 1) as $offset) {
            $pdf .= sprintf("%010d 00000 n \n", $offset);
        }

        return $pdf."trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n".$start."\n%%EOF\n";
    }
}
