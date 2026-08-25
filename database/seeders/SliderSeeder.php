<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Công ty TNHH Dịch vụ và Kỹ thuật Môi Trường Bảo Châu',
                'caption' => 'Giải pháp môi trường chuyên nghiệp - Tận tâm - Uy tín',
                'image' => 'uploads/sliders/slide-1.png',
                'link' => null,
                'open_in_new_tab' => false,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Môi Trường Bảo Châu - Tư vấn hồ sơ môi trường',
                'caption' => 'Thủ tục cấp phép nhanh chóng, đúng quy định pháp luật',
                'image' => 'uploads/sliders/slide-2.jpg',
                'link' => '/dich-vu',
                'open_in_new_tab' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Đồng hành phát triển xanh & bền vững',
                'caption' => 'Nâng tầm giá trị doanh nghiệp trong kỷ nguyên mới',
                'image' => 'uploads/sliders/slide-3.png',
                'link' => '/du-an',
                'open_in_new_tab' => false,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Dịch vụ Kiểm kê Khí nhà kính - ESG & CBAM',
                'caption' => 'Chuyên gia tính toán phát thải, báo cáo ESG chuẩn quốc tế',
                'image' => 'uploads/sliders/slide-4.png',
                'link' => '/dich-vu',
                'open_in_new_tab' => false,
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        Slider::truncate();
        foreach ($sliders as $slide) {
            Slider::create($slide);
        }
    }
}
