<?php

namespace Database\Seeders;

use App\Models\GhgDeclaration;
use App\Support\GhgSurveyDefinition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GhgDeclarationSeeder extends Seeder
{
    public function run(): void
    {
        if (GhgDeclaration::query()->where('company_name', 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu')->exists()) {
            return;
        }

        $step1 = [
            'company_name' => 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu',
            'tax_code' => '0317615845',
            'address' => '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh',
            'contact_name' => 'Nguyễn Văn Thành',
            'contact_phone' => '0915549148',
            'contact_email' => 'info@baochauenvir.com',
            'inventory_year' => 2026,
            'total_staff' => 50,
            'working_days' => 300,
            'purpose' => 'Báo cáo ESG và tuân thủ Nghị định 06/2022/NĐ-CP',
            'energy_consumption_toe' => 1000,
        ];

        $step2 = [
            'stationary_fuels' => [
                [
                    'month' => 1,
                    'fuel_type' => 'do',
                    'quantity' => 1200,
                    'unit' => 'lit',
                    'purpose' => 'cong_nghiep_sx_xd',
                    'notes' => 'Lò hơi phân xưởng sản xuất',
                ],
                [
                    'month' => 6,
                    'fuel_type' => 'lpg',
                    'quantity' => 350,
                    'unit' => 'kg',
                    'purpose' => 'dan_dung',
                    'notes' => 'Bếp ăn tập thể cán bộ công nhân viên',
                ],
            ],
        ];

        $step3 = [
            'mobile_fuels' => [
                [
                    'month' => 3,
                    'fuel_type' => 'do',
                    'equipment_type' => 'duong_bo',
                    'quantity' => 450,
                    'unit' => 'lit',
                    'notes' => 'Xe tải giao hàng 51D-12345',
                ],
                [
                    'month' => 5,
                    'fuel_type' => 'xang',
                    'equipment_type' => 'duong_bo',
                    'quantity' => 180,
                    'unit' => 'lit',
                    'notes' => 'Xe ô tô công tác cơ sở',
                ],
            ],
        ];

        $step4 = GhgSurveyDefinition::defaults(4);
        foreach ($step4['domestic_wastewater'] as &$row) {
            $row['treatment_type'] = 'tu_hoai';
            $row['flow_volume_m3'] = 120.5;
            $row['n_concentration_mg_l'] = 15.2;
            $row['bod_concentration_mg_l'] = 25.0;
        }
        foreach ($step4['industrial_wastewater'] as &$row) {
            $row['treatment_type'] = 'hieu_khi_cn';
            $row['flow_volume_m3'] = 320.0;
            $row['cod_before_mg_l'] = 450.0;
            $row['cod_after_mg_l'] = 65.0;
        }

        $step5 = [
            'fire_extinguishers' => [
                [
                    'extinguisher_type' => 'MFZ4',
                    'new_count' => 5,
                    'new_weight_kg' => 20,
                    'in_use_count' => 20,
                    'recharge_kg' => 8,
                    'disposed_count' => 2,
                ],
            ],
            'refrigeration' => [
                [
                    'equipment_name' => 'Hệ thống điều hòa trung tâm VRV Daikin',
                    'model_code' => 'RXQ10TATVJU',
                    'refrigerant_type' => 'R-410A',
                    'annual_refill_kg' => 3.5,
                    'equipment_count' => 2,
                    'notes' => 'Khu văn phòng điều hành',
                ],
            ],
        ];

        $step6 = GhgSurveyDefinition::defaults(6);
        foreach ($step6['electricity'] as &$row) {
            $row['consumption_kwh'] = 18500;
        }

        // Tạo phiếu hoàn chỉnh đã nộp
        GhgDeclaration::query()->create([
            'reference' => (string) Str::ulid(),
            'company_name' => $step1['company_name'],
            'contact_email' => $step1['contact_email'],
            'status' => 'submitted',
            'current_step' => 7,
            'submitted_at' => now(),
            'data' => [
                1 => $step1,
                2 => $step2,
                3 => $step3,
                4 => $step4,
                5 => $step5,
                6 => $step6,
            ],
            'evidence' => [
                [
                    'name' => 'hoa_don_dien_evn_2026.pdf',
                    'path' => 'ghg-evidence/sample_evn.pdf',
                    'category' => 'Điện & Năng lượng',
                    'note' => 'Hóa đơn tiền điện EVN cả năm 2026',
                    'size' => 1024000,
                ],
            ],
        ]);

        // Tạo 1 phiếu bản nháp
        GhgDeclaration::query()->create([
            'reference' => (string) Str::ulid(),
            'company_name' => 'Công ty Cổ phần Công nghệ Môi trường Xanh Á Châu',
            'contact_email' => 'contact@achaugreen.vn',
            'status' => 'draft',
            'current_step' => 3,
            'data' => [
                1 => [
                    'company_name' => 'Công ty Cổ phần Công nghệ Môi trường Xanh Á Châu',
                    'tax_code' => '0318999888',
                    'address' => 'Lô C2 KCN Hiệp Phước, Nhà Bè, TP. Hồ Chí Minh',
                    'contact_name' => 'Trần Minh Quân',
                    'contact_phone' => '0908123456',
                    'contact_email' => 'contact@achaugreen.vn',
                    'inventory_year' => 2026,
                    'total_staff' => 120,
                    'working_days' => 280,
                    'purpose' => 'Kiểm kê định kỳ phát thải nhà máy',
                    'energy_consumption_toe' => 2500,
                ],
                2 => [
                    'stationary_fuels' => [
                        [
                            'month' => 2,
                            'fuel_type' => 'dau_nhien_lieu',
                            'quantity' => 2500,
                            'unit' => 'lit',
                            'purpose' => 'cong_nghiep_sx_xd',
                            'notes' => 'Lò hơi đốt dầu FO phân xưởng đúc',
                        ],
                    ],
                ],
            ],
            'evidence' => [],
        ]);
    }
}
