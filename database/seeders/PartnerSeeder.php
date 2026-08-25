<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            // Đối tác
            ['name' => 'CBAS English', 'logo' => '1-1-768x427.png', 'link' => null, 'type' => 'partner', 'sort_order' => 1],
            ['name' => 'Em Biết Đọc', 'logo' => 'logo-em-biet-doc-1-768x344.webp', 'link' => null, 'type' => 'partner', 'sort_order' => 2],
            ['name' => 'Kami Nail Academy', 'logo' => 'kaminail.png', 'link' => null, 'type' => 'partner', 'sort_order' => 3],
            ['name' => 'Tribeco', 'logo' => '10-1-768x427.png', 'link' => null, 'type' => 'partner', 'sort_order' => 4],
            ['name' => 'Nước Giải Khát Bidrico', 'logo' => 'bidrico.png', 'link' => null, 'type' => 'partner', 'sort_order' => 5],
            ['name' => 'BreadTalk Vietnam', 'logo' => 'breadtalkvietnam.png', 'link' => null, 'type' => 'partner', 'sort_order' => 6],
            ['name' => 'Foods For You', 'logo' => '12-1-768x427.png', 'link' => null, 'type' => 'partner', 'sort_order' => 7],
            ['name' => 'Nha Khoa Anna', 'logo' => 'nhakhoaanna.png', 'link' => null, 'type' => 'partner', 'sort_order' => 8],
            ['name' => 'Topland', 'logo' => '5-1-768x427.png', 'link' => null, 'type' => 'partner', 'sort_order' => 9],
            ['name' => 'Dochi Home', 'logo' => 'dochihome.png', 'link' => null, 'type' => 'partner', 'sort_order' => 10],
            ['name' => 'Kế Toán Sao Kim', 'logo' => 'ketoansaokim.webp', 'link' => null, 'type' => 'partner', 'sort_order' => 11],
            ['name' => 'Thời Trang TQQ', 'logo' => '8-1-768x427.png', 'link' => null, 'type' => 'partner', 'sort_order' => 12],
            ['name' => 'The R\'art School', 'logo' => 'logo-Rart-768x344.webp', 'link' => null, 'type' => 'partner', 'sort_order' => 13],
            ['name' => 'Gocons Construction', 'logo' => 'logo-gocons-768x344.png', 'link' => null, 'type' => 'partner', 'sort_order' => 14],

            // Báo chí
            ['name' => 'Báo Kinh Tế Môi Trường (Kinh Tế Xanh)', 'logo' => 'bao-kinh-te-xanh.png', 'link' => 'https://baokinhtexanh.com.vn', 'type' => 'press', 'sort_order' => 1],
            ['name' => 'Báo Mới', 'logo' => 'bao-moi.png', 'link' => 'https://baomoi.com', 'type' => 'press', 'sort_order' => 2],
            ['name' => 'Báo Gia Lai Online', 'logo' => 'bao-gia-lai.png', 'link' => 'https://baogialai.com.vn', 'type' => 'press', 'sort_order' => 3],
        ];

        Partner::truncate();
        foreach ($partners as $p) {
            Partner::create($p);
        }
    }
}
