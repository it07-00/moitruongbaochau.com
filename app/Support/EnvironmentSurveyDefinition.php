<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class EnvironmentSurveyDefinition
{
    /** @return array<int, string> */
    public static function steps(): array
    {
        return [1 => 'Thông tin doanh nghiệp', 2 => 'Sản phẩm & sản lượng', 3 => 'Nhiên liệu', 4 => 'Nước thải & khí thải', 5 => 'Chất thải rắn', 6 => 'Hồ sơ pháp lý', 7 => 'Xác nhận & gửi'];
    }

    /** @return array<int, string> */
    public static function guides(): array
    {
        return [
            1 => 'Điền thông tin doanh nghiệp và người phụ trách. Nếu có báo cáo BVMT năm 2025, hãy đính kèm để không cần nhập lại số liệu năm 2025.',
            2 => 'Khai báo từng sản phẩm, đơn vị tính và sản lượng thực tế. Dùng cùng đơn vị khi so sánh số liệu hai năm.',
            3 => 'Khai báo điện và từng loại nhiên liệu sử dụng theo hóa đơn hoặc sổ theo dõi. Ghi rõ đơn vị; số lượng cho phép số thập phân.',
            4 => 'Ghi lưu lượng nước thải, nguồn phát sinh khí thải theo giấy phép và thực tế. Nếu có công trình xử lý, mô tả công suất, công nghệ và đính kèm hồ sơ.',
            5 => 'Tách riêng rác sinh hoạt, chất thải công nghiệp và chất thải nguy hại. Đối chiếu khối lượng với chứng từ thu gom; ghi mã CTNH nếu có.',
            6 => 'Chọn trạng thái cho từng nhóm hồ sơ. Chọn Có cần đính kèm ít nhất một tệp; mỗi tệp tối đa 20 MB và mỗi nhóm tối đa 10 tệp.',
            7 => 'Rà soát toàn bộ dữ liệu và hồ sơ. Bấm Chỉnh sửa để quay lại từng bước, xác nhận thông tin rồi gửi phiếu; phiếu đã gửi sẽ được khóa chỉnh sửa.',
        ];
    }

    /** @return array<string, string> */
    public static function statuses(): array
    {
        return ['draft' => 'Bản nháp', 'submitted' => 'Đã gửi', 'revision_required' => 'Cần bổ sung', 'completed' => 'Đã hoàn tất'];
    }

    /** @return array<string, string> */
    public static function documents(): array
    {
        return [
            'business_registration' => 'Giấy đăng ký kinh doanh / chứng nhận đầu tư',
            'land_use_certificate' => 'Giấy chứng nhận quyền sử dụng đất',
            'factory_or_land_lease' => 'Hợp đồng thuê xưởng / thuê đất',
            'environmental_license' => 'Giấy phép môi trường / đăng ký môi trường',
            'electricity_water_invoices' => 'Hóa đơn điện, nước năm 2025 và 2026',
            'domestic_waste_contract_invoice' => 'Hợp đồng và hóa đơn thu gom rác sinh hoạt năm 2025 và 2026',
            'industrial_waste_contract_invoice' => 'Hợp đồng và hóa đơn thu gom rác công nghiệp năm 2025 và 2026',
            'hazardous_waste_contract_manifest' => 'Hợp đồng và chứng từ CTNH (liên số 4) năm 2025 và 2026',
            'iso_certificate' => 'Giấy chứng nhận ISO (nếu có)',
            'inspection_minutes' => 'Biên bản thanh tra, kiểm tra (nếu có)',
            'environment_report_2025' => 'Báo cáo công tác BVMT năm 2025',
            'other_legal_documents' => 'Hồ sơ pháp lý khác / thông tin có thay đổi',
        ];
    }

    /** @return array<string, array<string, mixed>> */
    public static function fields(int $step): array
    {
        $yesNo = ['1' => 'Có', '0' => 'Không'];

        return match ($step) {
            1 => [
                'company_name' => self::field('Tên doanh nghiệp', placeholder: 'VD: CÔNG TY TNHH SẢN XUẤT ABC'),
                'tax_code' => self::field('Mã số thuế', required: false, placeholder: 'VD: 0312345678'),
                'address' => self::field('Địa chỉ', 'textarea', max: 1000, placeholder: 'VD: Lô A1, Khu công nghiệp, phường/xã, tỉnh/thành phố'),
                'contact_name' => self::field('Người phụ trách cung cấp thông tin', placeholder: 'VD: Nguyễn Văn An'),
                'contact_position' => self::field('Chức vụ', required: false, placeholder: 'VD: Nhân viên phụ trách môi trường'),
                'contact_phone' => self::field('Số điện thoại', 'tel', max: 30, placeholder: 'VD: 0912345678'),
                'contact_email' => self::field('Email', 'email', placeholder: 'VD: moitruong@congty.vn'),
                'employee_count_2026' => self::field('Số lượng lao động năm 2026', 'integer', placeholder: 'VD: 150'),
                'business_type' => self::field('Loại hình sản xuất, kinh doanh, dịch vụ', max: 500, placeholder: 'VD: Sản xuất hàng may mặc, chế biến thực phẩm'),
                'operation_frequency' => self::field('Tần suất hoạt động', 'select', options: ['regular' => 'Thường xuyên', 'seasonal' => 'Theo mùa vụ']),
                'seasonal_start_month' => self::field('Từ tháng', 'month', condition: 'seasonal'),
                'seasonal_end_month' => self::field('Đến tháng', 'month', condition: 'seasonal'),
                'has_environment_report_2025' => self::field('Có Báo cáo công tác BVMT năm 2025?', 'boolean', options: $yesNo),
                'other_information' => self::field('Thông tin khác', 'textarea', false, max: 5000, placeholder: 'VD: Thay đổi công suất, địa điểm hoặc thời gian hoạt động trong năm 2026'),
            ],
            4 => [
                'has_wastewater_treatment' => self::field('Có công trình xử lý nước thải?', 'boolean', options: $yesNo),
                'wastewater_treatment_description' => self::field('Công trình nước thải: tên, công suất, thuyết minh', 'textarea', max: 10000, condition: 'wastewater', placeholder: 'VD: Hệ thống xử lý nước thải công suất 50 m³/ngày, công nghệ sinh học hiếu khí, vận hành từ năm 2020'),
                'has_air_treatment' => self::field('Có công trình xử lý khí thải?', 'boolean', options: $yesNo),
                'air_treatment_description' => self::field('Công trình khí thải: tên, công suất, thuyết minh', 'textarea', max: 10000, condition: 'air', placeholder: 'VD: Hệ thống lọc bụi túi vải cho lò hơi, công suất 10.000 m³/giờ'),
            ],
            7 => [
                'confirm_information' => self::field('Tôi xác nhận các thông tin cung cấp là đúng theo hồ sơ hiện có của doanh nghiệp', 'checkbox'),
                'submit_note' => self::field('Ghi chú khi gửi', 'textarea', false, max: 5000, placeholder: 'VD: Doanh nghiệp sẽ bổ sung chứng từ thu gom chất thải sau khi nhận từ nhà cung cấp'),
            ],
            default => [],
        };
    }

    /** @return array<string, array{label: string, fields: array<string, array<string, mixed>>, fixed: bool}> */
    public static function tables(int $step): array
    {
        $quantities = [
            'name' => self::field('Tên / chủng loại', placeholder: 'VD: Giấy, bìa carton, thức ăn thừa'), 'unit' => self::field('Đơn vị', max: 50, placeholder: 'VD: kg, tấn, m³, lít, kWh'),
            'quantity_2025' => self::field('Năm 2025', 'decimal', condition: 'year2025', placeholder: 'VD: 1250.5'),
            'quantity_2026' => self::field('Năm 2026', 'decimal', placeholder: 'VD: 1500.75'),
        ];
        $type = self::field('Loại nước thải', 'select', options: ['domestic' => 'Nước thải sinh hoạt', 'production' => 'Nước thải sản xuất', 'cooling' => 'Nước làm mát']);

        return match ($step) {
            2 => ['products' => ['label' => 'Sản phẩm và sản lượng', 'fields' => array_replace($quantities, ['name' => self::field('Tên sản phẩm', placeholder: 'VD: Áo thun, bao bì giấy, thực phẩm đóng hộp')]), 'fixed' => false]],
            3 => ['fuels' => ['label' => 'Nhiên liệu sử dụng', 'fields' => array_replace($quantities, ['name' => self::field('Tên nhiên liệu', placeholder: 'VD: Điện, Dầu DO, LPG, Than')]), 'fixed' => false]],
            4 => [
                'approved_wastewater_flows' => ['label' => 'Lưu lượng nước thải được phê duyệt', 'fixed' => true, 'fields' => [
                    'type' => $type, 'flow' => self::field('Lưu lượng phê duyệt', 'decimal', false, placeholder: 'VD: 50'),
                    'unit' => self::field('Đơn vị', max: 50, placeholder: 'VD: m³/ngày'), 'source_document' => self::field('Nguồn: ĐTM / GPMT / hồ sơ cũ', required: false, placeholder: 'VD: GPMT số 123/GPMT, cấp ngày 15/03/2024'),
                ]],
                'actual_wastewater_flows' => ['label' => 'Lưu lượng nước thải phát sinh', 'fixed' => true, 'fields' => [
                    'type' => $type, 'flow_2025' => self::field('Năm 2025', 'decimal', false, condition: 'year2025', placeholder: 'VD: 35.5'),
                    'flow_2026' => self::field('Năm 2026', 'decimal', false, placeholder: 'VD: 40.25'), 'unit' => self::field('Đơn vị', max: 50, placeholder: 'VD: m³/ngày'),
                ]],
            ],
            5 => [
                'domestic_wastes' => ['label' => 'Rác sinh hoạt', 'fields' => $quantities, 'fixed' => false],
                'industrial_wastes' => ['label' => 'Rác công nghiệp thông thường', 'fixed' => false, 'fields' => $quantities + [
                    'is_reused_as_material' => self::field('Tái sử dụng làm nguyên liệu?', 'boolean', options: ['1' => 'Có', '0' => 'Không']),
                    'reuse_note' => self::field('Ghi chú tái sử dụng', required: false, max: 1000, placeholder: 'VD: Thu hồi phế liệu để tái sử dụng trong sản xuất'),
                ]],
                'hazardous_wastes' => ['label' => 'Chất thải nguy hại', 'fixed' => false, 'fields' => ['code' => self::field('Mã CTNH', required: false, max: 50, placeholder: 'Nhập mã theo chứng từ CTNH')] + array_replace($quantities, ['name' => self::field('Tên chất thải nguy hại', placeholder: 'VD: Dầu nhớt thải, giẻ lau dính dầu, bóng đèn thải')])],
            ],
            default => [],
        };
    }

    /** @return array<string, mixed> */
    public static function defaults(int $step): array
    {
        $data = [];
        foreach (self::tables($step) as $key => $table) {
            $data[$key] = $table['fixed'] ? array_map(fn (string $type): array => ['type' => $type, 'unit' => 'm³/ngày'], ['domestic', 'production', 'cooling']) : [];
        }
        if ($step === 6) {
            $data['documents'] = [];
            foreach (self::documents() as $key => $label) {
                $data['documents'][$key] = ['status' => '', 'note' => ''];
            }
        }

        return $data;
    }

    /** @return list<string> */
    public static function keys(int $step): array
    {
        return array_merge(array_keys(self::fields($step)), array_keys(self::tables($step)), $step === 6 ? ['documents'] : []);
    }

    /** @param array<string, mixed> $data @return array<string, array<mixed>> */
    public static function rules(int $step, array $data, bool $strict): array
    {
        $rules = ['data' => ['present', 'array:'.implode(',', self::keys($step))]];
        foreach (self::fields($step) as $key => $field) {
            $rules['data.'.$key] = self::fieldRules($field, $data, $strict);
        }
        foreach (self::tables($step) as $key => $table) {
            $rules['data.'.$key] = ['present', 'array', $table['fixed'] ? 'size:3' : 'max:200'];
            $rules['data.'.$key.'.*'] = ['array:'.implode(',', array_keys($table['fields']))];
            foreach ($table['fields'] as $name => $field) {
                $rules['data.'.$key.'.*.'.$name] = self::fieldRules($field, $data, $strict);
            }
            if ($table['fixed']) {
                $rules['data.'.$key.'.*.type'] = ['required', Rule::in(['domestic', 'production', 'cooling']), 'distinct'];
            }
        }
        if ($step === 6) {
            $rules['data.documents'] = ['present', 'array:'.implode(',', array_keys(self::documents()))];
            foreach (self::documents() as $key => $label) {
                $rules['data.documents.'.$key] = [$strict ? 'required' : 'nullable', 'array:status,note'];
                $rules['data.documents.'.$key.'.status'] = [$strict ? 'required' : 'nullable', Rule::in(['available', 'not_available', 'pending'])];
                $rules['data.documents.'.$key.'.note'] = ['nullable', 'string', 'max:2000'];
            }
        }

        return $rules;
    }

    /** @param array<string, mixed> $field @param array<string, mixed> $data @return array<mixed> */
    private static function fieldRules(array $field, array $data, bool $strict): array
    {
        if (! self::visible($field, $data)) {
            return ['exclude'];
        }
        $presence = $strict && $field['required'] ? 'required' : 'nullable';

        return [$presence, ...match ($field['type']) {
            'integer' => ['integer', 'min:0', 'max:1000000000'],
            'decimal' => ['numeric', 'min:0', 'max:1000000000000'],
            'month' => ['integer', 'between:1,12'],
            'boolean' => ['boolean'],
            'checkbox' => $strict ? ['accepted'] : ['boolean'],
            'select' => [Rule::in(array_keys($field['options']))],
            'email' => ['email:rfc', 'max:255'],
            default => ['string', 'max:'.$field['max']],
        }];
    }

    /** @param array<string, mixed> $field @param array<string, mixed> $data */
    public static function visible(array $field, array $data): bool
    {
        return match ($field['condition']) {
            'year2025' => ! (bool) ($data['has_environment_report_2025'] ?? false),
            'seasonal' => ($data['operation_frequency'] ?? '') === 'seasonal',
            'wastewater' => (bool) ($data['has_wastewater_treatment'] ?? false),
            'air' => (bool) ($data['has_air_treatment'] ?? false),
            default => true,
        };
    }

    /** @return array<string, string> */
    public static function attributes(): array
    {
        $attributes = [];
        foreach (range(1, 7) as $step) {
            foreach (self::fields($step) as $key => $field) {
                $attributes['data.'.$key] = $field['label'];
            }
            foreach (self::tables($step) as $key => $table) {
                foreach ($table['fields'] as $name => $field) {
                    $attributes['data.'.$key.'.*.'.$name] = $table['label'].' — '.$field['label'];
                }
            }
        }

        return $attributes;
    }

    /** @return array<string, string> */
    public static function messages(): array
    {
        return ['required' => 'Vui lòng nhập hoặc chọn :attribute.', 'numeric' => ':attribute phải là số.', 'integer' => ':attribute phải là số nguyên.', 'min' => ':attribute không được âm.', 'max' => ':attribute vượt quá giới hạn :max.', 'email' => 'Email không hợp lệ.', 'in' => 'Vui lòng chọn giá trị hợp lệ cho :attribute.', 'boolean' => 'Vui lòng chọn Có hoặc Không.', 'accepted' => 'Vui lòng xác nhận thông tin trước khi gửi.', 'size' => 'Cần đủ ba loại nước thải.', 'distinct' => 'Không được trùng loại nước thải.'];
    }

    /** @return array{label: string, type: string, required: bool, options: array<mixed>, max: int, condition: string, placeholder: string} */
    private static function field(string $label, string $type = 'text', bool $required = true, array $options = [], int $max = 255, string $condition = '', string $placeholder = ''): array
    {
        return compact('label', 'type', 'required', 'options', 'max', 'condition', 'placeholder');
    }
}
