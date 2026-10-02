<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class GhgSurveyDefinition
{
    /** @return array<int, string> */
    public static function steps(): array
    {
        return [1 => 'Thông tin chung', 2 => 'Nhiên liệu cố định', 3 => 'Nhiên liệu di động', 4 => 'Nước thải', 5 => 'PCCC & Làm lạnh', 6 => 'Điện & Năng lượng', 7 => 'Xác nhận'];
    }

    /** @return array<string, array<string, mixed>> */
    public static function generalFields(): array
    {
        return [
            'company_name' => self::field('Tên doanh nghiệp'),
            'tax_code' => self::field('Mã số thuế'),
            'address' => self::field('Địa chỉ cơ sở'),
            'contact_name' => self::field('Người liên hệ'),
            'contact_phone' => self::field('Số điện thoại', 'tel'),
            'contact_email' => self::field('Email liên hệ', 'email'),
            'inventory_year' => self::field('Năm kiểm kê', 'number', min: 2000, max: 2100),
            'total_staff' => self::field('Tổng nhân sự', 'number', min: 1, max: 10000000),
            'working_days' => self::field('Số ngày làm việc / năm', 'number', min: 1, max: 366),
            'purpose' => self::field('Mục đích kiểm kê', required: false),
            'energy_consumption_toe' => self::field('Năng lượng tiêu thụ (TOE)', 'decimal', required: false),
        ];
    }

    /** @return array<string, array{label: string, monthly: bool, fields: array<string, array<string, mixed>>}> */
    public static function sections(int $step): array
    {
        $month = self::field('Tháng', 'select', options: array_combine(range(1, 12), array_map(fn (int $month): string => 'Tháng '.$month, range(1, 12))));
        $fuel = [
            'do' => 'Dầu DO', 'lpg' => 'LPG', 'xang' => 'Xăng', 'cng' => 'CNG / Khí tự nhiên', 'dau_nhien_lieu' => 'Dầu FO',
        ];
        $stationary = $fuel + [
            'cui_ep' => 'Củi ép / Gỗ', 'dau_ho' => 'Dầu hỏa', 'dau_tho' => 'Dầu thô', 'mo_cong_nghiep' => 'Mỡ công nghiệp',
            'mo_thuc_vat' => 'Mỡ thực vật', 'nhot' => 'Nhớt', 'than_antraxit' => 'Than antraxit', 'than_cui' => 'Than củi', 'than_sub_bitum' => 'Than sub-bitum', 'trau' => 'Trấu',
        ];
        $units = self::field('Đơn vị', 'select', options: ['kg' => 'Kg', 'lit' => 'Lít', 'mmbtu' => 'MMBTU']);
        $notes = self::field('Ghi chú', required: false);
        $flow = self::field('Lưu lượng nước thải (m³)', 'decimal');

        return match ($step) {
            2 => ['stationary_fuels' => ['label' => 'Nhiên liệu cố định', 'monthly' => false, 'fields' => [
                'month' => $month, 'fuel_type' => self::field('Loại nhiên liệu', 'select', options: $stationary),
                'quantity' => self::field('Lượng sử dụng', 'decimal'), 'unit' => $units,
                'purpose' => self::field('Mục đích sử dụng', 'select', options: ['cong_nghiep_nang_luong' => 'Công nghiệp năng lượng', 'cong_nghiep_sx_xd' => 'Công nghiệp sản xuất & xây dựng', 'thuong_mai_dich_vu' => 'Thương mại & dịch vụ', 'nong_lam_ngu_nghiep' => 'Nông, lâm, ngư nghiệp', 'dan_dung' => 'Dân dụng']), 'notes' => $notes,
            ]]],
            3 => ['mobile_fuels' => ['label' => 'Nhiên liệu di động', 'monthly' => false, 'fields' => [
                'month' => $month, 'fuel_type' => self::field('Loại nhiên liệu', 'select', options: $fuel + ['jet_kerosene' => 'Nhiên liệu hàng không', 'xang_hang_khong' => 'Xăng hàng không']),
                'equipment_type' => self::field('Loại phương tiện', 'select', options: ['duong_bo' => 'Đường bộ', 'hang_khong' => 'Hàng không nội địa', 'duong_sat' => 'Đường sắt', 'duong_thuy' => 'Đường thủy & hàng hải', 'nong_nghiep' => 'Nông, lâm, ngư nghiệp']),
                'quantity' => self::field('Lượng sử dụng', 'decimal'), 'unit' => $units, 'notes' => $notes,
            ]]],
            4 => [
                'domestic_wastewater' => ['label' => 'Nước thải sinh hoạt', 'monthly' => true, 'fields' => [
                    'month' => $month, 'treatment_type' => self::field('Hệ thống xử lý', 'select', required: false, options: ['tu_hoai' => 'Bể tự hoại', 'tap_trung_hieu_khi' => 'Tập trung, hiếu khí', 'ho_ky_khi_sh' => 'Hồ kỵ khí', 'khong_xu_ly' => 'Không xử lý']),
                    'flow_volume_m3' => $flow, 'n_concentration_mg_l' => self::field('Tổng N sau xử lý (mg/L)', 'decimal'), 'bod_concentration_mg_l' => self::field('BOD sau xử lý (mg/L)', 'decimal'),
                ]],
                'industrial_wastewater' => ['label' => 'Nước thải công nghiệp', 'monthly' => true, 'fields' => [
                    'month' => $month, 'treatment_type' => self::field('Hệ thống xử lý', 'select', required: false, options: ['ban_hieu_khi' => 'Kỵ khí nông / Bán hiếu khí', 'hieu_khi_cn' => 'Hiếu khí', 'hieu_khi_ky_khi' => 'Hiếu khí + Kỵ khí', 'ho_on_dinh' => 'Hồ ổn định', 'ky_khi_sau' => 'Kỵ khí sâu', 'uasb' => 'UASB', 'khong_xu_ly_cn' => 'Không xử lý']),
                    'flow_volume_m3' => $flow, 'cod_before_mg_l' => self::field('COD trước xử lý (mg/L)', 'decimal'), 'cod_after_mg_l' => self::field('COD sau xử lý (mg/L)', 'decimal'),
                ]],
            ],
            5 => [
                'fire_extinguishers' => ['label' => 'Bình chữa cháy', 'monthly' => false, 'fields' => [
                    'extinguisher_type' => self::field('Loại bình', 'select', options: ['MFZ35' => 'MFZ35 – Bột ABC 35kg', 'MFZ4' => 'MFZ4 – Bột ABC 4kg', 'MFZ8' => 'MFZ8 – Bột ABC 8kg', 'MT24' => 'MT24 – CO₂ 24kg', 'MT3' => 'MT3 – CO₂ 3kg', 'MT5' => 'MT5 – CO₂ 5kg']),
                    'new_count' => self::field('Số lượng mới', 'number'), 'new_weight_kg' => self::field('Khối lượng tịnh mới (kg)', 'decimal'),
                    'in_use_count' => self::field('Số lượng đang dùng', 'number'), 'recharge_kg' => self::field('Lượng nạp lại (kg)', 'decimal'), 'disposed_count' => self::field('Số lượng thải bỏ', 'number'),
                ]],
                'refrigeration' => ['label' => 'Thiết bị làm lạnh', 'monthly' => false, 'fields' => [
                    'equipment_name' => self::field('Tên thiết bị'), 'model_code' => self::field('Model thiết bị', required: false),
                    'refrigerant_type' => self::field('Môi chất lạnh', 'select', options: array_combine(['R-410A', 'R134', 'R134a', 'R143a', 'R22', 'R290', 'R32', 'R404A', 'R407c', 'R410a', 'R507A', 'R600a', 'R744'], ['R-410A', 'HFC-134', 'HFC-134a', 'HFC-143a', 'HCFC-22', 'Propane R290', 'HFC-32', 'R404A', 'R407C', 'R410a', 'R507A', 'Isobutane R600a', 'CO₂ R744'])),
                    'annual_refill_kg' => self::field('Lượng nạp thêm trong năm (kg)', 'decimal'), 'equipment_count' => self::field('Số lượng thiết bị', 'number'), 'notes' => $notes,
                ]],
            ],
            6 => [
                'electricity' => ['label' => 'Điện tiêu thụ', 'monthly' => true, 'fields' => ['month' => $month, 'consumption_kwh' => self::field('Điện tiêu thụ (kWh)', 'decimal')]],
                'steam' => ['label' => 'Nhiệt hơi mua vào', 'monthly' => true, 'fields' => ['month' => $month, 'consumption' => self::field('Nhiệt hơi tiêu thụ', 'decimal'), 'unit' => self::field('Đơn vị', 'select', options: ['kWh' => 'kWh', 'MWh' => 'MWh', 'GJ' => 'GJ', 'TJ' => 'TJ'])]],
            ],
            default => [],
        };
    }

    /** @return array<string, mixed> */
    private static function field(string $label, string $type = 'text', bool $required = true, array $options = [], int $min = 0, int $max = 1000000000): array
    {
        return compact('label', 'type', 'required', 'options', 'min', 'max');
    }

    /** @return array<string, array<mixed>> */
    public static function rules(int $step): array
    {
        $fields = $step === 1 ? self::generalFields() : [];
        $sections = self::sections($step);
        $rules = ['data' => ['present', 'array:'.implode(',', array_keys($fields ?: $sections))]];
        foreach ($fields as $key => $field) {
            $rules['data.'.$key] = self::fieldRules($field);
        }
        foreach ($sections as $key => $section) {
            $rules['data.'.$key] = $section['monthly'] ? ['required', 'array', 'size:12'] : ['present', 'array', 'max:200'];
            $rules['data.'.$key.'.*'] = ['array:'.implode(',', array_keys($section['fields']))];
            foreach ($section['fields'] as $name => $field) {
                $rules['data.'.$key.'.*.'.$name] = self::fieldRules($field);
            }
            if ($section['monthly']) {
                $rules['data.'.$key.'.*.month'][] = 'distinct';
            }
        }

        return $rules;
    }

    /** @return array<mixed> */
    private static function fieldRules(array $field): array
    {
        $rules = [$field['required'] ? 'required' : 'nullable'];

        return [...$rules, ...match ($field['type']) {
            'number' => ['integer', 'min:'.$field['min'], 'max:'.$field['max']],
            'decimal' => ['numeric', 'min:0', 'max:1000000000000'],
            'select' => [Rule::in(array_keys($field['options']))],
            'email' => ['email:rfc', 'max:255'],
            'tel' => ['string', 'regex:/^(?:\+?84|0)[0-9\s.\-]{8,14}$/'],
            default => ['string', 'max:255'],
        }];
    }

    /** @return array<string, mixed> */
    public static function defaults(int $step): array
    {
        if ($step === 1) {
            return ['inventory_year' => 2026];
        }
        $data = [];
        foreach (self::sections($step) as $key => $section) {
            $data[$key] = [];
            if ($section['monthly']) {
                foreach (range(1, 12) as $month) {
                    $row = ['month' => $month];
                    foreach ($section['fields'] as $name => $field) {
                        if ($name !== 'month') {
                            $row[$name] = in_array($field['type'], ['number', 'decimal']) ? 0 : ($name === 'unit' ? 'kWh' : '');
                        }
                    }
                    $data[$key][] = $row;
                }
            }
        }

        return $data;
    }

    /** @return array<string, string> */
    public static function attributes(int $step): array
    {
        $attributes = [];
        foreach (self::generalFields() as $key => $field) {
            $attributes['data.'.$key] = $field['label'];
        }
        foreach (self::sections($step) as $key => $section) {
            foreach ($section['fields'] as $name => $field) {
                $attributes['data.'.$key.'.*.'.$name] = $field['label'];
            }
        }

        return $attributes;
    }
}
