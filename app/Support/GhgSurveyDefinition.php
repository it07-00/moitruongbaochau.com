<?php

namespace App\Support;

use Illuminate\Validation\Rule;

class GhgSurveyDefinition
{
    /** @return array<int, string> */
    public static function steps(): array
    {
        return [1 => 'Thông tin chung', 2 => 'Nhiên liệu cố định', 3 => 'Nhiên liệu di động', 4 => 'Nước thải', 5 => 'Thiết bị, PCCC & Làm lạnh', 6 => 'Điện, năng lượng & cây xanh', 7 => 'Xác nhận'];
    }

    /** @return array<string, array<string, mixed>> */
    public static function generalFields(): array
    {
        return [
            'company_name' => self::field('Tên doanh nghiệp', placeholder: 'VD: Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu', hint: 'Tên đầy đủ pháp nhân theo Giấy phép ĐKKD'),
            'tax_code' => self::field('Mã số thuế', placeholder: 'VD: 0317615845', hint: 'Mã số thuế doanh nghiệp (10 hoặc 13 số)'),
            'address' => self::field('Địa chỉ cơ sở', placeholder: 'VD: 180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh', hint: 'Địa chỉ trụ sở hoặc vị trí nhà máy / cơ sở thực hiện kiểm kê'),
            'contact_name' => self::field('Người liên hệ', placeholder: 'VD: Nguyễn Văn Thành', hint: 'Họ tên cán bộ phụ trách hồ sơ môi trường hoặc ESG'),
            'contact_phone' => self::field('Số điện thoại', 'tel', placeholder: 'VD: 0915 549 148', hint: 'Số điện thoại di động hoặc hotline liên hệ trực tiếp'),
            'contact_email' => self::field('Email liên hệ', 'email', placeholder: 'VD: info@baochauenvir.com', hint: 'Email tiếp nhận trao đổi và nhận bản dự thảo báo cáo kiểm kê'),
            'inventory_year' => self::field('Năm kiểm kê', 'number', min: 2000, max: 2100, placeholder: '2026', hint: 'Năm thu thập số liệu phát thải khí nhà kính (mặc định 2026)'),
            'total_staff' => self::field('Tổng nhân sự', 'number', min: 1, max: 10000000, placeholder: 'VD: 50', hint: 'Tổng số cán bộ, công nhân viên làm việc tại cơ sở'),
            'working_days' => self::field('Số ngày làm việc / năm', 'number', min: 1, max: 366, placeholder: 'VD: 300', hint: 'Số ngày làm việc thực tế trong năm (thường 260 - 312 ngày)'),
            'purpose' => self::field('Mục đích kiểm kê', required: false, placeholder: 'VD: Báo cáo ESG, tuân thủ Nghị định 06/2022/NĐ-CP, đáp ứng yêu cầu chuỗi cung ứng...', hint: 'Không bắt buộc. Ghi rõ mục đích hoặc yêu cầu riêng của cơ sở'),
            'energy_consumption_toe' => self::field('Năng lượng tiêu thụ (TOE)', 'decimal', required: false, placeholder: 'VD: 1000', hint: 'Không bắt buộc. Tổng năng lượng tiêu thụ quy đổi TOE (nếu có)'),
        ];
    }

    /** @return array<string, array{label: string, monthly: bool, fields: array<string, array<string, mixed>>}> */
    public static function sections(int $step): array
    {
        $month = self::field('Tháng', 'select', options: array_combine(range(1, 12), array_map(fn (int $month): string => 'Tháng '.$month, range(1, 12))));
        $fuel = [
            'do' => 'Dầu DO',
            'lpg' => 'LPG',
            'xang' => 'Xăng',
            'cng' => 'CNG / Khí tự nhiên',
            'dau_nhien_lieu' => 'Dầu FO',
        ];
        $stationary = $fuel + [
            'cui_ep' => 'Củi ép / Gỗ',
            'dau_ho' => 'Dầu hỏa',
            'dau_tho' => 'Dầu thô',
            'mo_cong_nghiep' => 'Mỡ công nghiệp',
            'mo_thuc_vat' => 'Mỡ thực vật',
            'nhot' => 'Nhớt',
            'than_antraxit' => 'Than antraxit',
            'than_cui' => 'Than củi',
            'than_sub_bitum' => 'Than sub-bitum',
            'trau' => 'Trấu',
        ];
        $units = self::field('Đơn vị', 'select', options: ['kg' => 'Kg', 'lit' => 'Lít', 'mmbtu' => 'MMBTU']);
        $notes = self::field('Ghi chú', required: false, placeholder: 'VD: Nồi hơi phân xưởng 1 hoặc máy phát điện dự phòng', hint: 'Thông tin phân xưởng, thiết bị hoặc số hóa đơn (nếu có)');
        $flow = self::field('Lưu lượng nước thải (m³)', 'decimal', placeholder: 'VD: 120.5', hint: 'Lưu lượng xả thải trong tháng theo đồng hồ hoặc hóa đơn nước sạch');

        return match ($step) {
            2 => [
                'stationary_fuels' => [
                    'label' => 'Nhiên liệu cố định',
                    'monthly' => false,
                    'fields' => [
                        'month' => $month,
                        'fuel_type' => self::field('Loại nhiên liệu', 'select', options: $stationary, hint: 'Chọn loại nhiên liệu đốt cho thiết bị cố định'),
                        'quantity' => self::field('Lượng sử dụng', 'decimal', placeholder: 'VD: 1200', hint: 'Khối lượng hoặc thể tích nhiên liệu tiêu thụ trong tháng'),
                        'unit' => $units,
                        'purpose' => self::field('Mục đích sử dụng', 'select', options: ['cong_nghiep_nang_luong' => 'Công nghiệp năng lượng', 'cong_nghiep_sx_xd' => 'Công nghiệp sản xuất & xây dựng', 'thuong_mai_dich_vu' => 'Thương mại & dịch vụ', 'nong_lam_ngu_nghiep' => 'Nông, lâm, ngư nghiệp', 'dan_dung' => 'Dân dụng'], hint: 'Lĩnh vực hoặc mục đích tiêu thụ năng lượng'),
                        'notes' => $notes,
                    ],
                ],
            ],
            3 => [
                'mobile_fuels' => [
                    'label' => 'Nhiên liệu di động',
                    'monthly' => false,
                    'fields' => [
                        'month' => $month,
                        'fuel_type' => self::field('Loại nhiên liệu', 'select', options: $fuel + ['jet_kerosene' => 'Nhiên liệu hàng không', 'xang_hang_khong' => 'Xăng hàng không'], hint: 'Chọn loại nhiên liệu cấp cho phương tiện'),
                        'equipment_type' => self::field('Loại phương tiện', 'select', options: ['duong_bo' => 'Đường bộ', 'hang_khong' => 'Hàng không nội địa', 'duong_sat' => 'Đường sắt', 'duong_thuy' => 'Đường thủy & hàng hải', 'nong_nghiep' => 'Nông, lâm, ngư nghiệp'], hint: 'Hình thức / loại phương tiện giao thông vận tải'),
                        'quantity' => self::field('Lượng sử dụng', 'decimal', placeholder: 'VD: 450', hint: 'Lượng nhiên liệu sử dụng theo hóa đơn xăng dầu'),
                        'unit' => $units,
                        'notes' => self::field('Ghi chú', required: false, placeholder: 'VD: Xe tải chở hàng 51D-12345, xe công tác công ty', hint: 'Biển số xe, bộ phận sử dụng hoặc mục đích vận chuyển'),
                    ],
                ],
            ],
            4 => [
                'domestic_wastewater' => [
                    'label' => 'Nước thải sinh hoạt',
                    'monthly' => true,
                    'fields' => [
                        'month' => $month,
                        'treatment_type' => self::field('Hệ thống xử lý', 'select', required: false, options: ['tu_hoai' => 'Bể tự hoại', 'tap_trung_hieu_khi' => 'Tập trung, hiếu khí', 'ho_ky_khi_sh' => 'Hồ kỵ khí', 'khong_xu_ly' => 'Không xử lý'], hint: 'Công nghệ hoặc hệ thống xử lý nước thải sinh hoạt'),
                        'flow_volume_m3' => $flow,
                        'n_concentration_mg_l' => self::field('Tổng N sau xử lý (mg/L)', 'decimal', placeholder: 'VD: 15.2', hint: 'Hàm lượng Nitơ tổng (mg/L) theo kết quả quan trắc định kỳ'),
                        'bod_concentration_mg_l' => self::field('BOD sau xử lý (mg/L)', 'decimal', placeholder: 'VD: 25.0', hint: 'Hàm lượng BOD₅ (mg/L) theo phiếu kết quả thử nghiệm'),
                    ],
                ],
                'industrial_wastewater' => [
                    'label' => 'Nước thải công nghiệp',
                    'monthly' => true,
                    'fields' => [
                        'month' => $month,
                        'treatment_type' => self::field('Hệ thống xử lý', 'select', required: false, options: ['ban_hieu_khi' => 'Kỵ khí nông / Bán hiếu khí', 'hieu_khi_cn' => 'Hiếu khí', 'hieu_khi_ky_khi' => 'Hiếu khí + Kỵ khí', 'ho_on_dinh' => 'Hồ ổn định', 'ky_khi_sau' => 'Kỵ khí sâu', 'uasb' => 'UASB', 'khong_xu_ly_cn' => 'Không xử lý'], hint: 'Quy trình / công nghệ trạm xử lý nước thải sản xuất'),
                        'flow_volume_m3' => self::field('Lưu lượng nước thải (m³)', 'decimal', placeholder: 'VD: 320.0', hint: 'Lưu lượng nước thải sản xuất phát sinh trong tháng'),
                        'cod_before_mg_l' => self::field('COD trước xử lý (mg/L)', 'decimal', placeholder: 'VD: 450.0', hint: 'Nồng độ COD nước thải đầu vào trạm xử lý (mg/L)'),
                        'cod_after_mg_l' => self::field('COD sau xử lý (mg/L)', 'decimal', placeholder: 'VD: 65.0', hint: 'Nồng độ COD nước thải đầu ra sau xử lý (mg/L)'),
                    ],
                ],
            ],
            5 => [
                'equipment' => [
                    'label' => 'Danh sách thiết bị',
                    'monthly' => false,
                    'fields' => [
                        'name' => self::field('Tên thiết bị', placeholder: 'VD: Máy lạnh'),
                        'manufacture_year' => self::field('Năm sản xuất', 'number', min: 1900, max: 2100, placeholder: 'VD: 2020'),
                        'brand' => self::field('Thương hiệu', placeholder: 'VD: Reetech'),
                        'origin' => self::field('Xuất xứ', placeholder: 'VD: Việt Nam'),
                        'capacity' => self::field('Công suất', placeholder: 'VD: 5 kW', hint: 'Ghi công suất và đơn vị theo thông số thiết bị, ví dụ kW, HP hoặc tấn/giờ'),
                        'energy_source' => self::field('Năng lượng sử dụng', placeholder: 'VD: Điện, dầu DO, LPG'),
                        'purpose' => self::field('Mục đích sử dụng', placeholder: 'VD: Làm mát'),
                        'area' => self::field('Khu vực', placeholder: 'VD: Kho'),
                    ],
                ],
                'fire_extinguishers' => [
                    'label' => 'Bình chữa cháy',
                    'monthly' => false,
                    'fields' => [
                        'extinguisher_type' => self::field('Loại bình', 'select', options: ['MFZ35' => 'MFZ35 – Bột ABC 35kg', 'MFZ4' => 'MFZ4 – Bột ABC 4kg', 'MFZ8' => 'MFZ8 – Bột ABC 8kg', 'MT24' => 'MT24 – CO₂ 24kg', 'MT3' => 'MT3 – CO₂ 3kg', 'MT5' => 'MT5 – CO₂ 5kg'], hint: 'Chủng loại bình chữa cháy bột hoặc khí CO₂'),
                        'new_count' => self::field('Số lượng mới', 'number', placeholder: 'VD: 5', hint: 'Số bình mua sắm mới bổ sung trong năm (nhập 0 nếu không có)'),
                        'new_weight_kg' => self::field('Khối lượng tịnh mới (kg)', 'decimal', placeholder: 'VD: 20', hint: 'Tổng khối lượng chất chữa cháy nạp trong bình mới (kg)'),
                        'in_use_count' => self::field('Số lượng đang dùng', 'number', placeholder: 'VD: 20', hint: 'Tổng số lượng bình đang trang bị tại cơ sở'),
                        'recharge_kg' => self::field('Lượng nạp lại (kg)', 'decimal', placeholder: 'VD: 8', hint: 'Khối lượng khí/bột nạp sạc lại trong đợt bảo dưỡng định kỳ (kg)'),
                        'disposed_count' => self::field('Số lượng thải bỏ', 'number', placeholder: 'VD: 2', hint: 'Số bình hư hại hoặc hết hạn đã thanh lý trong năm'),
                    ],
                ],
                'refrigeration' => [
                    'label' => 'Thiết bị làm lạnh',
                    'monthly' => false,
                    'fields' => [
                        'equipment_name' => self::field('Tên thiết bị', placeholder: 'VD: Hệ thống điều hòa trung tâm VRV Daikin, Chiller xưởng 1...', hint: 'Tên hệ thống điều hòa, tủ cấp đông, kho lạnh hoặc chiller'),
                        'model_code' => self::field('Model thiết bị', required: false, placeholder: 'VD: RXQ10TATVJU', hint: 'Mã model ghi trên tem máy (không bắt buộc)'),
                        'refrigerant_type' => self::field('Môi chất lạnh', 'select', options: array_combine(['R-410A', 'R134', 'R134a', 'R143a', 'R22', 'R290', 'R32', 'R404A', 'R407c', 'R410a', 'R507A', 'R600a', 'R744'], ['R-410A', 'HFC-134', 'HFC-134a', 'HFC-143a', 'HCFC-22', 'Propane R290', 'HFC-32', 'R404A', 'R407C', 'R410a', 'R507A', 'Isobutane R600a', 'CO₂ R744']), hint: 'Loại gas làm lạnh được nạp trong thiết bị'),
                        'annual_refill_kg' => self::field('Lượng nạp thêm trong năm (kg)', 'decimal', placeholder: 'VD: 3.5', hint: 'Lượng gas nạp bổ sung do rò rỉ hoặc bảo dưỡng trong năm (kg)'),
                        'equipment_count' => self::field('Số lượng thiết bị', 'number', placeholder: 'VD: 2', hint: 'Số lượng tổ máy/thiết bị cùng model'),
                        'notes' => self::field('Ghi chú', required: false, placeholder: 'VD: Lắp đặt tại khu vực văn phòng, bảo dưỡng định kỳ tháng 7', hint: 'Vị trí lắp đặt hoặc thông tin nhật ký bảo dưỡng máy'),
                    ],
                ],
            ],
            6 => [
                'electricity' => [
                    'label' => 'Điện tiêu thụ',
                    'monthly' => true,
                    'fields' => [
                        'month' => $month,
                        'consumption_kwh' => self::field('Điện tiêu thụ (kWh)', 'decimal', placeholder: 'VD: 18500', hint: 'Sản lượng điện tiêu thụ trong tháng (kWh) theo hóa đơn tiền điện EVN'),
                    ],
                ],
                'steam' => [
                    'label' => 'Nhiệt hơi mua vào',
                    'monthly' => true,
                    'fields' => [
                        'month' => $month,
                        'consumption' => self::field('Nhiệt hơi tiêu thụ', 'decimal', placeholder: 'VD: 25.5', hint: 'Sản lượng hơi / nhiệt mua từ đơn vị cung cấp ngoài (nhập 0 nếu không dùng)'),
                        'unit' => self::field('Đơn vị', 'select', options: ['kWh' => 'kWh', 'MWh' => 'MWh', 'GJ' => 'GJ', 'TJ' => 'TJ'], hint: 'Đơn vị tính trên hóa đơn cung cấp nhiệt hơi'),
                    ],
                ],
                'trees' => [
                    'label' => 'Thống kê cây xanh',
                    'monthly' => false,
                    'fields' => [
                        'name' => self::field('Tên cây', placeholder: 'VD: Sao đen', hint: 'Tên loài cây trồng tại cơ sở'),
                        'tree_type' => self::field('Loại cây', 'select', options: ['hardwood' => 'Gỗ cứng', 'conifer' => 'Lá kim']),
                        'growth_rate' => self::field('Tỷ lệ tăng trưởng', 'select', options: ['fast' => 'Nhanh', 'medium' => 'Trung bình', 'slow' => 'Chậm']),
                        'age_years' => self::field('Số tuổi cây', 'number', max: 10000, placeholder: 'VD: 5', hint: 'Tuổi cây tính theo năm tại năm kiểm kê'),
                        'quantity' => self::field('Số lượng', 'number', min: 1, placeholder: 'VD: 20', hint: 'Số cây cùng loài, loại, tỷ lệ tăng trưởng và tuổi'),
                    ],
                ],
                'other_activities' => [
                    'label' => 'Thông tin kiểm kê khác',
                    'monthly' => false,
                    'fields' => [
                        'name' => self::field('Tên nguồn phát thải / hoạt động khác', placeholder: 'VD: Xử lý chất thải rắn', hint: 'Khai báo nội dung chưa có trong các mục phía trên'),
                        'description' => self::field('Mô tả', required: false, placeholder: 'VD: Loại chất thải, quy trình xử lý, thời gian phát sinh'),
                        'quantity' => self::field('Lượng phát sinh / sử dụng', 'decimal', required: false, placeholder: 'VD: 120.5', hint: 'Số liệu trong năm kiểm kê, nếu có'),
                        'unit' => self::field('Đơn vị', required: false, placeholder: 'VD: kg, tấn, m³, lít'),
                        'notes' => self::field('Ghi chú', required: false, placeholder: 'VD: Nguồn số liệu hoặc thông tin cần tư vấn thêm'),
                    ],
                ],
            ],
            default => [],
        };
    }

    /** @return array{title: string, summary: string, items: array<string>, example: string}|null */
    public static function stepGuide(int $step): ?array
    {
        return match ($step) {
            1 => [
                'title' => 'Thông tin pháp nhân doanh nghiệp và người đại diện',
                'summary' => 'Nhập thông tin định danh doanh nghiệp theo Giấy phép ĐKKD hoặc tra cứu trên MaSoThue.com để đảm bảo tính pháp lý của hồ sơ kiểm kê khí nhà kính.',
                'items' => [
                    'Mã số thuế & Tên doanh nghiệp: Tra cứu chính xác theo dữ liệu đăng ký với cơ quan Thuế.',
                    'Người liên hệ: Họ tên, số điện thoại và email cán bộ phụ trách hồ sơ môi trường hoặc ESG của cơ sở.',
                    'Năm kiểm kê mặc định là 2026. Số ngày làm việc thông thường từ 260 đến 312 ngày/năm.',
                ],
                'example' => 'Mẫu tham khảo: Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu — MST: 0317615845 — Địa chỉ: 180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh — ĐT: 0915 549 148 — Email: info@baochauenvir.com',
            ],
            2 => [
                'title' => 'Nguồn phát thải từ đốt cháy tĩnh (Scope 1)',
                'summary' => 'Bao gồm nhiên liệu tiêu thụ cho các thiết bị cố định như lò hơi, nồi hơi, máy phát điện dự phòng, lò nung, máy sấy, bếp ăn công nghiệp...',
                'items' => [
                    'Lượng tiêu thụ: Lấy theo hóa đơn GTGT mua dầu FO, DO, gas LPG, than, củi ép... hoặc phiếu xuất kho nhiên liệu theo từng tháng.',
                    'Bấm "+ Thêm dòng dữ liệu" nếu cơ sở dùng nhiều loại nhiên liệu khác nhau hoặc theo từng tháng phát sinh.',
                    'Nếu trong năm không sử dụng nhiên liệu cố định, bạn có thể để trống và bấm "Lưu và tiếp tục".',
                ],
                'example' => 'Ví dụ: Tháng 1 tiêu thụ 1.200 lít dầu DO cấp cho nồi hơi phân xưởng 1; hoặc 300 kg gas LPG cho bếp ăn tập thể.',
            ],
            3 => [
                'title' => 'Nhiên liệu phương tiện giao thông vận tải (Scope 1)',
                'summary' => 'Nhiên liệu tiêu thụ của các phương tiện giao thông thuộc quyền sở hữu hoặc quyền kiểm soát của doanh nghiệp (xe tải, xe công tác, xe nâng chạy xăng dầu...).',
                'items' => [
                    'Tổng hợp số lít xăng, dầu theo hóa đơn VAT mua xăng dầu (Petrolimex, PVOIL...), sao kê thẻ nhiên liệu hoặc nhật trình xe.',
                    'Phân loại đúng theo loại phương tiện: Đường bộ, Đường thủy, Nông nghiệp...',
                    'Không thêm dòng nếu cơ sở không phát sinh sử dụng nhiên liệu cho phương tiện vận tải.',
                ],
                'example' => 'Ví dụ: Tháng 3 sử dụng 450 lít dầu DO cho xe tải chở hàng đường bộ biển số 51D-12345; hoặc 150 lít xăng RON 95 cho xe công tác.',
            ],
            4 => [
                'title' => 'Hệ thống xử lý nước thải sinh hoạt và sản xuất (Scope 1)',
                'summary' => 'Phát thải khí nhà kính (CH₄, N₂O) từ quy trình xử lý nước thải sinh hoạt của cán bộ công nhân viên và nước thải sản xuất công nghiệp.',
                'items' => [
                    'Lưu lượng nước thải (m³): Lấy theo chỉ số đồng hồ đo lưu lượng xả thải hoặc tính theo 80% - 100% hóa đơn nước sạch tiêu thụ hàng tháng.',
                    'Nồng độ BOD, COD, Tổng N: Lấy giá trị từ Phiếu kết quả thử nghiệm trong Báo cáo quan trắc môi trường định kỳ của cơ sở.',
                    'Bảng gồm 12 tháng: Nếu tháng nào cơ sở không hoạt động hoặc không phát sinh xả thải, hãy nhập giá trị 0.',
                ],
                'example' => 'Ví dụ: Tháng 1 nước thải sinh hoạt phát sinh 120 m³, BOD sau xử lý là 25 mg/L, Tổng N là 15 mg/L qua hệ thống bể tự hoại.',
            ],
            5 => [
                'title' => 'Danh sách thiết bị, PCCC và hệ thống làm lạnh',
                'summary' => 'Phát thải rò rỉ các loại khí nhà kính tiềm năng cao (HFCs, CO₂) từ bình chữa cháy và môi chất lạnh (gas điều hòa không khí, kho lạnh, chiller).',
                'items' => [
                    'Danh sách thiết bị: Ghi tên, năm sản xuất, thương hiệu, xuất xứ, công suất kèm đơn vị, năng lượng sử dụng, mục đích và khu vực lắp đặt theo tem máy hoặc hồ sơ thiết bị.',
                    'Thiết bị làm lạnh: Xem tem mác máy để biết loại gas (R-32, R-410A, R-134a, R-22...) và lượng nạp bổ sung trong năm theo biên bản bảo trì / hóa đơn nạp gas.',
                    'Bình chữa cháy: Thống kê số bình đang sử dụng, khối lượng nạp sạc lại trong đợt bảo dưỡng PCCC định kỳ hoặc số bình mua sắm mới/thải bỏ.',
                    'Nếu trong năm không nạp thêm gas hoặc không nạp sạc bình PCCC, nhập số 0 ở các trường khối lượng nạp.',
                ],
                'example' => 'Ví dụ: Hệ thống điều hòa trung tâm VRV Daikin dùng gas R-410A, nạp bù 3,5 kg gas trong đợt bảo dưỡng tháng 6; 20 bình chữa cháy MFZ4 đang sử dụng.',
            ],
            6 => [
                'title' => 'Điện năng, năng lượng mua vào và thống kê cây xanh',
                'summary' => 'Phát thải gián tiếp từ việc tiêu thụ điện lưới quốc gia và nhiệt hơi mua ngoài phục vụ toàn bộ hoạt động của doanh nghiệp.',
                'items' => [
                    'Điện lưới: Tra cứu sản lượng điện tiêu thụ (kWh) trên 12 hóa đơn tiền điện EVN hàng tháng (từ tháng 1 đến tháng 12 của năm kiểm kê).',
                    'Nhiệt hơi / Lạnh: Nếu cơ sở mua hơi nhiệt từ đơn vị cung cấp bên ngoài, nhập sản lượng theo hóa đơn (chọn đơn vị kWh, MWh, GJ, TJ); nếu không dùng thì nhập 0.',
                    'Bảng yêu cầu đủ 12 tháng: Điền đầy đủ chỉ số kWh của từng tháng để hệ thống tổng hợp hệ số phát thải chuẩn xác.',
                    'Cây xanh: Thêm từng nhóm cây theo tên, loại gỗ cứng hoặc lá kim, tỷ lệ tăng trưởng, tuổi cây và số lượng. Nếu không có cây xanh, để bảng trống.',
                    'Thông tin kiểm kê khác: Bấm "+ Thêm nội dung khác" để khai báo nguồn phát thải hoặc hoạt động chưa có trong biểu mẫu. Nếu không có, để trống.',
                ],
                'example' => 'Ví dụ: Tháng 1 chỉ số điện tiêu thụ trên hóa đơn EVN là 18.500 kWh; nhiệt hơi mua ngoài không có thì nhập 0.',
            ],
            7 => [
                'title' => 'Rà soát tổng hợp dữ liệu và Tải lên chứng từ đối soát',
                'summary' => 'Kiểm tra lại toàn bộ dữ liệu 6 bước trước và đính kèm hóa đơn chứng từ liên quan trước khi nộp chính thức.',
                'items' => [
                    'Bấm mở từng mục tóm tắt bên dưới để kiểm tra số liệu. Bạn có thể bấm "← Quay lại" để chỉnh sửa dữ liệu bất kỳ lúc nào trước khi nộp.',
                    'Tải lên file scan hoặc ảnh chụp hóa đơn tiền điện 12 tháng, hóa đơn xăng dầu, kết quả thử nghiệm nước thải, biên bản nạp gas lạnh (PDF, PNG, JPG, XLSX).',
                    'Tích chọn ô cam kết tính xác thực của dữ liệu và bấm "Xác nhận và nộp phiếu" để gửi cho đội ngũ chuyên gia Môi Trường Bảo Châu tiếp nhận.',
                ],
                'example' => 'Chứng từ khuyến nghị: File hóa đơn EVN cả năm, hóa đơn dầu DO/FO, phiếu kết quả quan trắc nước thải.',
            ],
            default => null,
        };
    }

    /** @return array<string, mixed> */
    private static function field(
        string $label,
        string $type = 'text',
        bool $required = true,
        array $options = [],
        int $min = 0,
        int $max = 1000000000,
        string $placeholder = '',
        string $hint = ''
    ): array {
        return compact('label', 'type', 'required', 'options', 'min', 'max', 'placeholder', 'hint');
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
            $isWastewater = in_array($key, ['domestic_wastewater', 'industrial_wastewater'], true);
            $rules['data.'.$key] = $section['monthly'] && ! $isWastewater ? ['required', 'array', 'size:12'] : ['present', 'array', 'max:200'];
            if (in_array($key, ['trees', 'equipment', 'other_activities'], true)) {
                $rules['data.'.$key] = ['sometimes', 'array', 'max:200'];
            }
            $rules['data.'.$key.'.*'] = ['array:'.implode(',', array_keys($section['fields']))];
            foreach ($section['fields'] as $name => $field) {
                $rules['data.'.$key.'.*.'.$name] = self::fieldRules($field);
            }
            if ($section['monthly'] && ! $isWastewater) {
                $rules['data.'.$key.'.*.month'][] = 'distinct';
            }
        }

        return $rules;
    }

    /** @return array<mixed> */
    private static function fieldRules(array $field): array
    {
        $rules = [$field['required'] ? 'required' : 'nullable'];

        return [
            ...$rules,
            ...match ($field['type']) {
                'number' => ['integer', 'min:'.$field['min'], 'max:'.$field['max']],
                'decimal' => ['numeric', 'min:0', 'max:1000000000000'],
                'select' => [Rule::in(array_keys($field['options']))],
                'email' => ['email:rfc', 'max:255'],
                'tel' => ['string', 'regex:/^(?:\+?84|0)[0-9\s.\-]{8,14}$/'],
                default => ['string', 'max:255'],
            },
        ];
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
