<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Chị Bella',
                'client_company' => 'Kami Nail Academy',
                'client_role' => 'Giám đốc điều hành',
                'avatar' => 'kaminail.png',
                'content' => 'Đã hợp tác nhiều dự án xử lý nước thải và khí thải với Bảo Châu. Rất hài lòng về chất lượng công trình, tiến độ thi công chuẩn xác và dịch vụ hậu mãi, bảo trì cực kỳ chu đáo.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Anh Long',
                'client_company' => 'Điện Lạnh Quản Long',
                'client_role' => 'Trưởng phòng Kỹ thuật',
                'avatar' => 'daynghekimhoan.jpg',
                'content' => 'Chân thành cảm ơn đội ngũ kỹ sư MÔI TRƯỜNG BẢO CHÂU đã hỗ trợ hết sức nhiệt tình trong đợt thanh kiểm tra môi trường vừa qua. Tác phong làm việc nhanh nhẹn, hồ sơ đầy đủ và chuyên môn cao.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Anh Trần Chí Hiếu',
                'client_company' => 'Thiết Bị Công Nghệ Năng Lực',
                'client_role' => 'Quản lý Dự án',
                'avatar' => 'nangluc.png',
                'content' => 'Khi hợp tác với MÔI TRƯỜNG BẢO CHÂU trong dự án quan trắc môi trường lao động và lập bản đồ tiếng ồn, chúng tôi hoàn toàn yên tâm về sự chính xác, quy trình đo đạc bài bản và nhanh chóng.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'client_name' => 'Chị Bùi Thị Quỳnh Nhi',
                'client_company' => 'Kiến Trúc Xây Dựng AHD',
                'client_role' => 'Giám đốc dự án',
                'avatar' => '2-1-768x427.png',
                'content' => 'Tôi rất hài lòng với dịch vụ tư vấn cơ chế CBAM và đánh giá vòng đời sản phẩm LCA của Môi Trường Bảo Châu. Nhờ đó lô hàng xuất khẩu sang EU của chúng tôi đã thông quan thuận lợi.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'client_name' => 'Anh Nguyễn Nhất Sinh',
                'client_company' => 'Sạch Store',
                'client_role' => 'Chủ sáng lập',
                'avatar' => 'sachstore.png',
                'content' => 'Doanh nghiệp chúng tôi ban đầu rất lo lắng về các quy định mới của Luật Bảo vệ Môi trường 2020. Nhờ Bảo Châu tư vấn tận tình, toàn bộ hồ sơ cấp phép đã được phê duyệt suôn sẻ.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'client_name' => 'Thầy Nguyễn Văn Thuận',
                'client_company' => 'Trung Tâm GDNN Mỹ Nghệ Kim Hoàn',
                'client_role' => 'Hiệu trưởng',
                'avatar' => 'daynghekimhoan.jpg',
                'content' => 'Chúng tôi và Môi Trường Bảo Châu đã hợp tác hơn 5 năm nay trong các đợt quan trắc môi trường định kỳ. Rất tin tưởng năng lực, uy tín và sự nhiệt tình của đội ngũ kỹ sư.',
                'rating' => 5,
                'source' => 'Google Reviews',
                'source_url' => 'https://maps.app.goo.gl/moitruongbaochau',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        Testimonial::truncate();
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
