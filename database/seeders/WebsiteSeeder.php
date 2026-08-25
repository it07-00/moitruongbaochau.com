<?php

namespace Database\Seeders;

use App\ContentStatus;
use App\Models\JobPosting;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Redirect;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use Carbon\CarbonInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $publishedAt = now()->startOfDay();

            $this->seedPage($publishedAt);
            $this->seedServices($publishedAt);
            $this->seedPosts($publishedAt);
            $this->seedProjects($publishedAt);
            $this->seedJobs($publishedAt);
            $this->seedSettings();
            $this->seedRedirects();
            $this->seedMenu();
        });
    }

    private function seedPage(CarbonInterface $publishedAt): void
    {
        // 1. TRANG CHỦ (Home Page)
        Page::query()->updateOrCreate(['slug' => 'trang-chu'], [
            'title' => 'MÔI TRƯỜNG BẢO CHÂU với sứ mệnh',
            'template' => 'home',
            'excerpt' => 'Đơn vị tư vấn và kỹ thuật môi trường đồng hành cùng doanh nghiệp.',
            'content' => '<p>Giải quyết bài toán tồn tại, phát triển và <strong>tăng trưởng doanh nghiệp bền vững</strong> cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.</p><p>Luôn lấy chữ <strong>Tâm</strong> để nâng chữ <strong>Tầm</strong>. Chúng tôi không ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng không ngại đưa ra phương án giải quyết tối ưu nhất cho khách hàng.</p><p>Đồng hành cùng <span class="text-primary font-medium">MÔI TRƯỜNG BẢO CHÂU</span> chắc chắn bạn sẽ nhận được sự phục vụ <strong>nhiệt tình và tận tâm</strong> của toàn đội ngũ chuyên gia giàu kinh nghiệm.</p>',
            'thumbnail' => 'assets/images/logo-leave-png-min.png',
            'metadata' => [
                'about_badge' => 'Về chúng tôi',
                'about_link' => '/gioi-thieu',
                'about_desc_1' => 'Giải quyết bài toán tồn tại, phát triển và <span class="font-medium">tăng trưởng doanh nghiệp bền vững</span> cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.',
                'about_desc_2' => 'Luôn lấy chữ <span class="font-medium">Tâm</span> để nâng chữ <span class="font-medium">Tầm</span>. Chúng tôi không ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng không ngại đưa ra phương án giải quyết phù hợp cho khách hàng.',
                'about_desc_3' => 'Đồng hành cùng <span class="text-primary font-medium">MÔI TRƯỜNG BẢO CHÂU</span> chắc chắn bạn sẽ nhận được sự phục vụ <span class="font-medium">nhiệt tình và tận tâm</span> của toàn đội ngũ được đào tạo trong một môi trường phù hợp văn hóa doanh nghiệp của chúng tôi.',
                'stat_1_number' => '7',
                'stat_1_suffix' => '+',
                'stat_1_title' => 'Năm kinh nghiệm',
                'stat_1_desc' => 'Chúng tôi luôn tự tin để tư vấn và đưa ra giải pháp phù hợp nhằm giải quyết tất cả các vấn đề khó khăn của doanh nghiệp về Giấy phép Môi trường, Báo cáo ĐTM, Khí nhà kính ESG và Xử lý Nước thải.',
                'stat_2_number' => '500',
                'stat_2_suffix' => '+',
                'stat_2_title' => 'Dự án đã hoàn thành',
                'stat_2_desc' => 'Hơn 500+ hồ sơ pháp lý, đề án và công trình xử lý môi trường được nghiệm thu đúng hạn, đảm bảo 100% tuân thủ quy định pháp luật BVMT hiện hành.',
                'stat_3_number' => '30',
                'stat_3_suffix' => '+',
                'stat_3_title' => 'Chuyên gia & Kỹ sư',
                'stat_3_desc' => 'Đội ngũ chuyên gia, kỹ sư công nghệ môi trường giàu kinh nghiệm, tận tâm, nhiệt huyết và luôn đặt uy tín, trách nhiệm lên hàng đầu.',
                'services_badge' => 'DỊCH VỤ MÔI TRƯỜNG',
                'services_title' => 'Dịch vụ môi trường tiêu biểu',
                'projects_badge' => 'DỰ ÁN TIÊU BIỂU',
                'projects_title' => 'Dự án đã thực hiện',
                'testimonials_badge' => 'ĐÁNH GIÁ KHÁCH HÀNG',
                'testimonials_title' => 'Khách hàng nói gì về Bảo Châu',
                'posts_badge' => 'TIN TỨC MỚI NHẤT',
                'posts_title' => 'Tin tức & Kiến thức môi trường',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Môi Trường Bảo Châu - Dịch vụ & Kỹ thuật môi trường chuyên nghiệp',
            'meta_description' => 'Tư vấn môi trường, giấy phép môi trường, quan trắc, kiểm kê khí nhà kính và giải pháp xử lý môi trường cho doanh nghiệp.',
        ]);

        // 2. TRANG GIỚI THIỆU (About Us)
        Page::query()->updateOrCreate(['slug' => 'gioi-thieu'], [
            'title' => 'MÔI TRƯỜNG BẢO CHÂU với sứ mệnh',
            'template' => 'about',
            'excerpt' => 'Giải quyết bài toán tồn tại, phát triển và tăng trưởng doanh nghiệp bền vững cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.',
            'content' => '<p>Giải quyết bài toán tồn tại, phát triển và <strong>tăng trưởng doanh nghiệp bền vững</strong> cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.</p><p>Luôn lấy chữ <strong>Tâm</strong> để nâng chữ <strong>Tầm</strong>. Chúng tôi không ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng không ngại đưa ra phương án giải quyết phù hợp cho khách hàng.</p><p>Đồng hành cùng <span class="text-primary font-medium">MÔI TRƯỜNG BẢO CHÂU</span> chắc chắn bạn sẽ nhận được sự phục vụ <strong>nhiệt tình và tận tâm</strong> của toàn đội ngũ được đào tạo trong một môi trường phù hợp văn hóa doanh nghiệp của chúng tôi.</p>',
            'thumbnail' => 'assets/images/logo-leave-png-min.png',
            'metadata' => [
                'about_badge' => 'Về chúng tôi',
                'vision_badge' => 'TẦM NHÌN & SỨ MỆNH',
                'vision_title' => '<span class="text-primary block">MÔI TRƯỜNG BẢO CHÂU</span> Kiến tạo biểu tượng phát triển bền vững',
                'vision_desc_1' => 'Với tầm nhìn trở thành <strong>đơn vị tiên phong trong lĩnh vực môi trường tại Việt Nam</strong>, được khách hàng tin tưởng lựa chọn hàng đầu và là biểu tượng của sự phát triển bền vững, Môi trường Bảo Châu luôn nhận được sự tín nhiệm của khách hàng.',
                'vision_desc_2' => 'Để có thể phát triển song hành cùng với khách hàng, Môi trường Bảo Châu luôn đặt sứ mệnh của bản thân lên đầu tiên:',
                'mission_1_title' => 'Đối với khách hàng',
                'mission_1_desc' => 'Cung cấp các giải pháp môi trường tối ưu, giúp doanh nghiệp nâng cao hiệu quả sản xuất, giảm thiểu tác động đến môi trường và đảm bảo tuân thủ các quy định pháp luật.',
                'mission_2_title' => 'Đối với đối tác',
                'mission_2_desc' => 'Xây dựng mối quan hệ hợp tác bền vững, cùng nhau phát triển và chia sẻ thành công trên chặng đường chuyển đổi xanh.',
                'mission_3_title' => 'Đối với nhân viên',
                'mission_3_desc' => 'Tạo môi trường làm việc chuyên nghiệp, năng động, khuyến khích sáng tạo và tạo mọi điều kiện để phát triển bản thân toàn diện.',
                'mission_4_title' => 'Đối với cộng đồng',
                'mission_4_desc' => 'Góp phần xây dựng một cộng đồng sống xanh, sạch, đẹp, bảo vệ tài nguyên thiên nhiên và nâng cao chất lượng cuộc sống cho thế hệ tương lai.',
                'org_badge' => 'SƠ ĐỒ BỘ MÁY',
                'org_title' => 'CƠ CẤU <span class="text-primary">TỔ CHỨC</span>',
                'org_director' => 'GIÁM ĐỐC',
                'org_dept_1' => 'PHÒNG KỸ THUẬT',
                'org_dept_1_sub1' => 'Bộ phận Quan trắc',
                'org_dept_1_sub2' => 'Bộ phận Tư vấn',
                'org_dept_2' => 'PHÒNG KINH DOANH',
                'org_dept_2_sub1' => 'Bộ phận Kinh doanh',
                'org_dept_3' => 'PHÒNG TỔNG HỢP',
                'org_dept_3_sub1' => 'BP HC – Nhân sự',
                'org_dept_3_sub2' => 'BP TC – Kế toán',
                'timeline_badge' => 'HÀNH TRÌNH PHÁT TRIỂN',
                'timeline_title' => 'Lịch sử <span class="text-primary">hình thành & phát triển</span>',
                'timeline_desc' => 'Hành trình hơn 8 năm xây dựng uy tín và khẳng định vị thế đơn vị tư vấn môi trường đáng tin cậy của Môi Trường Bảo Châu.',
                'timeline_1_year' => '2018',
                'timeline_1_title' => 'Thành lập công ty',
                'timeline_1_desc' => 'Môi Trường Bảo Châu chính thức thành lập, quy tụ các kỹ sư môi trường tâm huyết với định hướng cung cấp dịch vụ hồ sơ pháp lý chuẩn mực.',
                'timeline_2_year' => '2020',
                'timeline_2_title' => 'Chuẩn hóa Luật BVMT 2020',
                'timeline_2_desc' => 'Tiên phong nghiên cứu và chuẩn hóa quy trình cấp Giấy phép môi trường (GPMT) và Báo cáo ĐTM theo khung quy định mới của Luật BVMT 2020.',
                'timeline_3_year' => '2022',
                'timeline_3_title' => 'Mở rộng Kỹ thuật & Xử lý nước',
                'timeline_3_desc' => 'Mở rộng quy mô thiết kế, thi công và vận hành trạm xử lý nước thải - khí thải công nghiệp cho các nhà máy quy mô lớn tại các KCN trọng điểm.',
                'timeline_4_year' => '2024 – 2026',
                'timeline_4_title' => 'Khí nhà kính & Chiến lược ESG',
                'timeline_4_desc' => 'Triển khai tư vấn Kiểm kê Khí nhà kính (ISO 14064), báo cáo CBAM, LCA và chiến lược ESG, khẳng định vị thế đối tác môi trường toàn diện.',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Về Môi Trường Bảo Châu - Năng lực tư vấn môi trường',
            'meta_description' => 'Giới thiệu năng lực, đội ngũ và định hướng phục vụ doanh nghiệp của Môi Trường Bảo Châu.',
        ]);

        // 3. TRANG DỊCH VỤ (Services Index)
        Page::query()->updateOrCreate(['slug' => 'dich-vu'], [
            'title' => 'Dịch vụ Môi trường Doanh nghiệp',
            'template' => 'services',
            'excerpt' => 'Giải pháp tư vấn hồ sơ pháp lý môi trường, quan trắc định kỳ, kiểm kê khí nhà kính ESG và xử lý nước thải - khí thải công nghiệp trọn gói.',
            'thumbnail' => 'uploads/service-categories/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png',
            'metadata' => [
                'services_badge' => 'DỊCH VỤ CỦA CHÚNG TÔI',
                'cta_title' => 'Cần tư vấn giải pháp môi trường tối ưu cho doanh nghiệp?',
                'cta_desc' => 'Đội ngũ kỹ sư và chuyên gia pháp lý của Môi Trường Bảo Châu luôn sẵn sàng đồng hành, khảo sát và đưa ra phương án phù hợp nhất.',
                'cta_button_text' => 'Liên hệ tư vấn ngay',
                'cta_phone' => '0915 549 148',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Dịch vụ môi trường doanh nghiệp - Môi Trường Bảo Châu',
            'meta_description' => 'Dịch vụ tư vấn giấy phép, quan trắc, kiểm kê khí nhà kính và xử lý môi trường trọn gói.',
        ]);

        // 4. TRANG DỰ ÁN (Projects Index)
        Page::query()->updateOrCreate(['slug' => 'du-an'], [
            'title' => 'Dự án Môi trường Tiêu biểu',
            'template' => 'projects',
            'excerpt' => 'Tổng hợp các dự án tư vấn hồ sơ pháp lý, cấp Giấy phép Môi trường, Báo cáo ĐTM, quan trắc và công trình xử lý môi trường đã nghiệm thu thành công.',
            'thumbnail' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
            'metadata' => [
                'projects_badge' => 'NĂNG LỰC DỰ ÁN',
                'projects_subtitle' => 'Hơn 500+ dự án đã hoàn thành trên toàn quốc',
                'cta_title' => 'Khởi tạo dự án môi trường chuẩn mực cùng Bảo Châu',
                'cta_desc' => 'Cam kết 100% hồ sơ được phê duyệt đúng tiến độ và tối ưu chi phí vận hành cho doanh nghiệp.',
                'cta_button_text' => 'Nhận báo giá dự án',
                'cta_phone' => '0915 549 148',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Dự án môi trường tiêu biểu - Môi Trường Bảo Châu',
            'meta_description' => 'Năng lực triển khai giấy phép môi trường, ĐTM, quan trắc và kiểm kê khí nhà kính của Môi Trường Bảo Châu.',
        ]);

        // 5. TRANG TIN TỨC (News / Posts Index)
        Page::query()->updateOrCreate(['slug' => 'tin-tuc'], [
            'title' => 'Tin tức & Kiến thức Môi trường',
            'template' => 'posts',
            'excerpt' => 'Cập nhật quy định pháp luật BVMT mới nhất, hướng dẫn thủ tục Giấy phép môi trường, kiểm kê Khí nhà kính ISO 14064 và báo cáo phát triển bền vững ESG.',
            'thumbnail' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
            'metadata' => [
                'posts_badge' => 'TIN TỨC & SỰ KIỆN',
                'posts_subtitle' => 'Thông tin pháp lý và kiến thức chuyên ngành mới nhất',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Tin tức môi trường, pháp luật và ESG - Môi Trường Bảo Châu',
            'meta_description' => 'Cập nhật pháp luật bảo vệ môi trường, giấy phép môi trường, kiểm kê khí nhà kính và ESG.',
        ]);

        // 6. TRANG TUYỂN DỤNG (Recruitment Index)
        Page::query()->updateOrCreate(['slug' => 'tuyen-dung'], [
            'title' => 'Cơ hội Nghề nghiệp tại Môi Trường Bảo Châu',
            'template' => 'recruitment',
            'excerpt' => 'Gia nhập đội ngũ kỹ sư, chuyên gia môi trường năng động, phát triển bản thân toàn diện cùng chế độ đãi ngộ hấp dẫn.',
            'thumbnail' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
            'metadata' => [
                'recruitment_badge' => 'CƠ HỘI NGHỀ NGHIỆP',
                'benefits_title' => 'Vì sao nên gia nhập Môi Trường Bảo Châu?',
                'benefits_desc' => 'Chúng tôi tạo dựng môi trường làm việc chuyên nghiệp, minh bạch, coi trọng giá trị con người và thúc đẩy sự tiến bộ vượt bậc của từng cá nhân.',
                'benefit_1_title' => 'Thu nhập & Thưởng hấp dẫn',
                'benefit_1_desc' => 'Lương cạnh tranh theo năng lực, thưởng dự án, thưởng KPIs và thưởng các dịp lễ tết xứng đáng với đóng góp.',
                'benefit_2_title' => 'Đào tạo & Thăng tiến rõ ràng',
                'benefit_2_desc' => 'Được hướng dẫn trực tiếp bởi chuyên gia giàu kinh nghiệm, tham gia các khóa đào tạo nâng cao chuyên môn.',
                'benefit_3_title' => 'Môi trường năng động & Trẻ trung',
                'benefit_3_desc' => 'Văn hóa làm việc đoàn kết, cởi mở, khuyến khích sáng tạo và tôn trọng sự khác biệt của mỗi thành viên.',
                'benefit_4_title' => 'Chế độ phúc lợi toàn diện',
                'benefit_4_desc' => 'Đầy đủ BHXH, BHYT, BHTN, khám sức khỏe định kỳ, du lịch thường niên và các hoạt động team building sôi nổi.',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Tuyển dụng Môi Trường Bảo Châu - Cơ hội việc làm',
            'meta_description' => 'Cơ hội nghề nghiệp trong lĩnh vực tư vấn, quan trắc và kỹ thuật môi trường.',
        ]);

        // 7. TRANG LIÊN HỆ (Contact Us)
        Page::query()->updateOrCreate(['slug' => 'lien-he'], [
            'title' => 'Liên hệ Tư vấn Môi trường',
            'template' => 'contact',
            'excerpt' => 'Môi Trường Bảo Châu sẵn sàng lắng nghe, khảo sát tận nơi và tư vấn giải pháp môi trường phù hợp nhất cho doanh nghiệp của bạn.',
            'thumbnail' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
            'metadata' => [
                'contact_badge' => 'BẠN ĐANG CẦN GIẢI PHÁP PHÙ HỢP?',
                'card_1_title' => 'Tư vấn hồ sơ & Giấy phép MT',
                'card_1_desc_1' => 'Bạn cần lập hồ sơ môi trường chuẩn Luật BVMT 2020: Báo cáo ĐTM, Giấy phép môi trường (GPMT), Đăng ký môi trường và tối ưu hồ sơ pháp lý?',
                'card_1_desc_2' => 'Môi Trường Bảo Châu tư vấn giải pháp phù hợp với từng quy mô dự án, giúp doanh nghiệp hoàn thiện pháp lý nhanh chóng, an tâm vận hành dài lâu.',
                'card_2_title' => 'Kiểm kê Khí nhà kính – ESG – CBAM',
                'card_2_desc_1' => 'Doanh nghiệp xuất khẩu cần đáp ứng cơ chế CBAM của EU, tính toán phát thải carbon theo ISO 14064 và xây dựng báo cáo phát triển bền vững ESG?',
                'card_2_desc_2' => 'Đội ngũ chuyên gia Bảo Châu hướng dẫn phương pháp kiểm kê chính xác, tối ưu hóa chuỗi cung ứng và định hướng lộ trình giảm phát thải hiệu quả.',
                'card_3_title' => 'Xử lý Nước thải & Khí thải',
                'card_3_desc_1' => 'Cần thiết kế, thi công mới hoặc cải tạo nâng công suất hệ thống xử lý nước thải, khí thải đạt quy chuẩn xả thải QCVN hiện hành?',
                'card_3_desc_2' => 'Cung cấp giải pháp công nghệ sinh học và hóa lý tối ưu, tiết kiệm chi phí đầu tư và hóa chất vận hành hàng tháng cho nhà máy.',
            ],
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Liên hệ tư vấn môi trường - Môi Trường Bảo Châu',
            'meta_description' => 'Liên hệ Môi Trường Bảo Châu để được tư vấn hồ sơ, quan trắc và giải pháp môi trường cho doanh nghiệp.',
        ]);
    }

    private function seedServices(CarbonInterface $publishedAt): void
    {
        /** @var Collection<string, ServiceCategory> $serviceCategories */
        $serviceCategories = collect([
            [
                'name' => 'Pháp lý môi trường',
                'slug' => 'phap-ly-moi-truong',
                'image' => 'uploads/service-categories/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png',
                'description' => 'Tư vấn trọn gói Giấy phép môi trường (GPMT), Báo cáo đánh giá tác động môi trường (ĐTM), Đăng ký môi trường theo Luật BVMT 2020.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Khí nhà kính & ESG',
                'slug' => 'khi-nha-kinh-esg',
                'image' => 'uploads/service-categories/Bai-Dang-Bao-Chau-1024x572.png',
                'description' => 'Kiểm kê khí nhà kính toàn diện (Scope 1, 2, 3), tính toán dấu chân carbon LCA, lập hồ sơ CBAM và báo cáo phát triển bền vững ESG.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Quan trắc môi trường',
                'slug' => 'quan-trac-moi-truong',
                'image' => 'uploads/service-categories/Hinh-1-1024x683.jpg',
                'description' => 'Đo đạc môi trường lao động, vi khí hậu, tiếng ồn, ánh sáng, bụi; Lập báo cáo quan trắc môi trường định kỳ hàng năm.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Kỹ thuật xử lý',
                'slug' => 'ky-thuat-xu-ly',
                'image' => 'uploads/service-categories/CTY-TAN-TIEN-1024x640.png',
                'description' => 'Thiết kế, thi công, cải tạo và chuyển giao công nghệ xử lý nước thải sinh hoạt, công nghiệp và xử lý bụi, khí thải công nghiệp.',
                'sort_order' => 4,
            ],
        ])->mapWithKeys(function (array $category): array {
            $model = ServiceCategory::query()->updateOrCreate(['slug' => $category['slug']], [...$category, 'is_active' => true]);

            return [$category['slug'] => $model];
        });

        $services = [
            ['category' => 'phap-ly-moi-truong', 'name' => 'Lập báo cáo đánh giá tác động môi trường (ĐTM)', 'slug' => 'bao-cao-danh-gia-tac-dong-moi-truong', 'image' => 'slide-1.png'],
            ['category' => 'phap-ly-moi-truong', 'name' => 'Tư vấn cấp giấy phép môi trường', 'slug' => 'giay-phep-moi-truong', 'image' => 'slide-2.jpg'],
            ['category' => 'khi-nha-kinh-esg', 'name' => 'Kiểm kê khí nhà kính và xây dựng lộ trình giảm phát thải', 'slug' => 'kiem-ke-khi-nha-kinh', 'image' => 'slide-3.png'],
            ['category' => 'khi-nha-kinh-esg', 'name' => 'Tư vấn CBAM, ESG và vòng đời sản phẩm LCA', 'slug' => 'tu-van-cbam-esg-lca', 'image' => 'slide-4.png'],
            ['category' => 'quan-trac-moi-truong', 'name' => 'Quan trắc môi trường định kỳ', 'slug' => 'quan-trac-moi-truong-dinh-ky', 'image' => '19-768x432.png'],
            ['category' => 'quan-trac-moi-truong', 'name' => 'Quan trắc môi trường lao động', 'slug' => 'quan-trac-moi-truong-lao-dong', 'image' => '6-768x429.png'],
            ['category' => 'ky-thuat-xu-ly', 'name' => 'Thiết kế và vận hành hệ thống xử lý nước thải', 'slug' => 'xu-ly-nuoc-thai', 'image' => '118-1-768x429.png'],
            ['category' => 'ky-thuat-xu-ly', 'name' => 'Giải pháp xử lý khí thải công nghiệp', 'slug' => 'xu-ly-khi-thai-cong-nghiep', 'image' => 'Thiet-ke-chua-co-ten-2-768x429.png'],
        ];

        $serviceContent = <<<'HTML'
<h2><span id="dich-vu-tu-van-moi-truong-la-gi">Tổng quan về dịch vụ</span></h2>
<p>Môi Trường Bảo Châu là đơn vị tư vấn hàng đầu trong lĩnh vực lập hồ sơ môi trường, quan trắc phân tích và chuyển giao công nghệ xử lý chất thải đạt chuẩn theo quy định của Luật Bảo vệ Môi trường 2020.</p>
<p>Chúng tôi đồng hành cùng chủ đầu tư từ giai đoạn chuẩn bị dự án, hoàn thiện thủ tục cấp phép đến giám sát vận hành thực tế tại nhà máy.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
  <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Dịch vụ Môi Trường Bảo Châu" width="1024" height="576" />
  <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hồ sơ tư vấn kỹ thuật chuyên sâu tại Môi Trường Bảo Châu</figcaption>
</figure>

<h2><span id="loi-ich-khi-su-dung-dich-vu">Lợi ích khi doanh nghiệp lựa chọn Bảo Châu</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
  <li>Cam kết 100% hồ sơ được Hội đồng thẩm định phê duyệt đúng hạn.</li>
  <li>Đội ngũ Thạc sĩ, Kỹ sư môi trường hơn 10 năm kinh nghiệm trực tiếp bảo vệ trước cơ quan chức năng.</li>
  <li>Tiết kiệm chi phí đầu tư và tối ưu hóa chi phí vận hành công trình BVMT.</li>
  <li>Hỗ trợ pháp lý dài hạn và cập nhật các quy định luật mới nhất cho doanh nghiệp.</li>
</ul>

<h2><span id="quy-trinh-trien-khai-dich-vu">Quy trình triển khai trọn gói</span></h2>
<div class="space-y-4 my-4 text-black">
  <h3 class="font-bold text-base text-black">1. Khảo sát hiện trạng &amp; Thu thập dữ liệu</h3>
  <p class="text-sm text-black">Đo đạc, lấy mẫu phân tích và rà soát hồ sơ pháp lý hiện có tại cơ sở sản xuất.</p>

  <h3 class="font-bold text-base text-black">2. Xây dựng thuyết minh kỹ thuật</h3>
  <p class="text-sm text-black">Lập báo cáo chuyên môn chi tiết theo đúng quy chuẩn và biểu mẫu hiện hành của Bộ TN&MT.</p>

  <h3 class="font-bold text-base text-black">3. Nộp hồ sơ &amp; Bảo vệ thẩm định</h3>
  <p class="text-sm text-black">Đại diện chủ dự án giải trình kỹ thuật trước Hội đồng thẩm định và chỉnh sửa hoàn thiện theo kết luận cuộc họp.</p>

  <h3 class="font-bold text-base text-black">4. Bàn giao kết quả gốc &amp; Hướng dẫn vận hành</h3>
  <p class="text-sm text-black">Bàn giao giấy phép/kết quả thẩm định chính thức và hướng dẫn doanh nghiệp thực hiện các cam kết bảo vệ môi trường.</p>
</div>
HTML;

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], [
                'service_category_id' => $serviceCategories[$service['category']]->getKey(),
                'name' => $service['name'],
                'short_description' => 'Khảo sát đúng nhu cầu, xây dựng hồ sơ và đồng hành giải trình theo quy định hiện hành.',
                'content' => $serviceContent,
                'thumbnail' => $service['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'sort_order' => $index + 1,
                'published_at' => $publishedAt,
                'meta_title' => $service['name'].' - Môi Trường Bảo Châu',
                'meta_description' => 'Dịch vụ '.$service['name'].' đúng quy định, tiến độ rõ ràng và hỗ trợ doanh nghiệp xuyên suốt.',
            ]);
        }
    }

    private function seedPosts(CarbonInterface $publishedAt): void
    {
        /** @var Collection<string, PostCategory> $postCategories */
        $postCategories = collect([
            ['name' => 'Tin quốc tế', 'slug' => 'tin-quoc-te', 'sort_order' => 1],
            ['name' => 'Tin trong nước', 'slug' => 'tin-trong-nuoc', 'sort_order' => 2],
            ['name' => 'Tin nội bộ', 'slug' => 'tin-noi-bo', 'sort_order' => 3],
        ])->mapWithKeys(function (array $category): array {
            $model = PostCategory::query()->updateOrCreate(['slug' => $category['slug']], [...$category, 'is_active' => true]);

            return [$category['slug'] => $model];
        });

        // Xóa các danh mục cũ nếu có
        PostCategory::query()->whereNotIn('slug', ['tin-quoc-te', 'tin-trong-nuoc', 'tin-noi-bo'])->delete();

        $gpmtContent = <<<'HTML'
<h2><span id="giay-phep-moi-truong-la-gi">Giấy phép môi trường là gì?</span></h2>
<p>Theo quy định tại <strong>Khoản 8 Điều 3 Luật Bảo vệ Môi trường 2020</strong>: Giấy phép môi trường là văn bản do cơ quan quản lý nhà nước có thẩm quyền cấp cho tổ chức, cá nhân có hoạt động sản xuất, kinh doanh, dịch vụ được phép xả chất thải ra môi trường, quản lý chất thải, nhập khẩu phế liệu từ nước ngoài làm nguyên liệu sản xuất kèm theo yêu cầu, điều kiện về bảo vệ môi trường theo quy định của pháp luật.</p>
<p>Điểm mới đột phá của <strong>Luật BVMT 2020</strong> là tích hợp <strong>7 loại giấy phép môi trường thành phần</strong> trước đây (như Giấy phép xả nước thải, Giấy xác nhận hoàn thành công trình BVMT, Sổ chủ nguồn thải CTNH, Giấy phép xả khí thải,...) thành <strong>01 Giấy phép môi trường duy nhất</strong>.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
  <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Giấy phép môi trường Luật 2020" width="1024" height="576" />
  <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hồ sơ đề nghị cấp Giấy phép môi trường theo Nghị định 08/2022/NĐ-CP</figcaption>
</figure>

<h2><span id="vi-sao-doanh-nghiep-can-giay-phep-moi-truong">Vì sao doanh nghiệp cần hoàn thiện Giấy phép môi trường?</span></h2>
<p>Giấy phép môi trường giúp doanh nghiệp xây dựng nền tảng pháp lý vững chắc, an tâm sản xuất kinh doanh và đáp ứng các tiêu chuẩn khắt khe từ chuỗi cung ứng toàn cầu.</p>
<ul class="space-y-2 list-disc pl-5 text-black">
  <li>Hợp thức hóa hồ sơ pháp lý để nghiệm thu xây dựng và đưa dự án vào vận hành chính thức.</li>
  <li>Tránh bị xử phạt vi phạm hành chính (mức phạt có thể lên đến 1.000.000.000 VNĐ theo Nghị định 45/2022/NĐ-CP).</li>
  <li>Đáp ứng tiêu chuẩn đánh giá nhà máy từ các đối tác FDI và khách hàng quốc tế.</li>
  <li>Được chuyên gia tư vấn tối ưu hóa quy trình xử lý chất thải, tiết kiệm chi phí năng lượng và bảo vệ môi trường.</li>
</ul>

<h2><span id="doi-tuong-bat-buoc-phai-co-giay-phep-moi-truong">Đối tượng bắt buộc phải có Giấy phép môi trường</span></h2>
<p>Căn cứ <strong>Điều 39 Luật BVMT 2020</strong>, các đối tượng sau bắt buộc phải có Giấy phép môi trường:</p>
<div class="space-y-3 my-4 text-black">
  <p><strong>1. Dự án đầu tư Nhóm I, Nhóm II và Nhóm III:</strong> Có phát sinh nước thải, bụi, khí thải xả ra môi trường phải được xử lý hoặc có phát sinh chất thải nguy hại phải được quản lý.</p>
  <p><strong>2. Cơ sở sản xuất, kinh doanh, dịch vụ đang hoạt động:</strong> Có tiêu chí về môi trường tương đương dự án Nhóm I, Nhóm II và Nhóm III.</p>
</div>

<h2><span id="tham-quyen-tham-dinh-cap-giay-phep-moi-truong">Thẩm quyền thẩm định &amp; cấp Giấy phép môi trường</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
  <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
    <thead class="bg-gray-100 text-black font-bold">
      <tr>
        <th class="p-3 border border-gray-200">Cơ Quan Cấp Phép</th>
        <th class="p-3 border border-gray-200">Nhóm Dự Án Phụ Trách</th>
        <th class="p-3 border border-gray-200">Thời Gian Thẩm Định</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
      <tr>
        <td class="p-3 font-bold text-primary border border-gray-200">Bộ TN&amp;MT</td>
        <td class="p-3 border border-gray-200 text-black">Dự án Nhóm I nguy cơ cao, dự án liên tỉnh, dự án cấp Bộ phê duyệt ĐTM</td>
        <td class="p-3 font-semibold border border-gray-200 text-black">45 ngày làm việc</td>
      </tr>
      <tr>
        <td class="p-3 font-bold text-primary border border-gray-200">UBND Cấp Tỉnh / Sở TN&amp;MT</td>
        <td class="p-3 border border-gray-200 text-black">Dự án Nhóm II và Nhóm III nằm trên địa bàn 2 huyện trở lên</td>
        <td class="p-3 font-semibold border border-gray-200 text-black">30 ngày làm việc</td>
      </tr>
      <tr>
        <td class="p-3 font-bold text-primary border border-gray-200">UBND Cấp Huyện</td>
        <td class="p-3 border border-gray-200 text-black">Dự án Nhóm III còn lại nằm trên địa bàn 1 huyện</td>
        <td class="p-3 font-semibold border border-gray-200 text-black">20 ngày làm việc</td>
      </tr>
    </tbody>
  </table>
</div>

<h2><span id="quy-trinh-tu-van-tron-goi-tai-bao-chau">Quy trình tư vấn trọn gói tại Môi Trường Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
  <h3 id="khao-sat-muc-tieu-va-yeu-cau" class="font-bold text-base text-black">1. Khảo sát mục tiêu &amp; Đo đạc hiện trạng</h3>
  <p class="text-sm text-black">Đội ngũ kỹ sư khảo sát thực tế, lấy mẫu phân tích các nguồn thải nước thải, khí thải và kiểm tra hiện trạng công trình BVMT.</p>

  <h3 id="xay-dung-bao-cao-ky-thuat" class="font-bold text-base text-black">2. Lập báo cáo kỹ thuật đề xuất cấp phép</h3>
  <p class="text-sm text-black">Tính toán tải lượng phát thải, hoàn thiện thuyết minh báo cáo theo đúng mẫu chuẩn Phụ lục Nghị định 08/2022/NĐ-CP.</p>

  <h3 id="tham-van-cong-dong-nop-ho-so" class="font-bold text-base text-black">3. Tham vấn cộng đồng &amp; Nộp hồ sơ</h3>
  <p class="text-sm text-black">Đăng tải tham vấn trên cổng thông tin điện tử, nộp hồ sơ tại bộ phận một cửa của Cơ quan có thẩm quyền.</p>

  <h3 id="bao-ve-hoi-dong-tham-dinh" class="font-bold text-base text-black">4. Bảo vệ trước Hội đồng thẩm định</h3>
  <p class="text-sm text-black">Đại diện chủ đầu tư thuyết minh kỹ thuật, cùng đoàn kiểm tra thực tế nhà máy và giải trình bổ sung theo biên bản họp.</p>

  <h3 id="ban-giao-giay-phep-huong-dan" class="font-bold text-base text-black">5. Bàn giao Giấy phép &amp; Hướng dẫn vận hành</h3>
  <p class="text-sm text-black">Nhận Giấy phép môi trường gốc đóng dấu chính thức và bàn giao tận tay khách hàng.</p>
</div>
HTML;

        $posts = [
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Hướng Dẫn Thủ Tục Cấp Giấy Phép Môi Trường Mới Nhất Theo Luật BVMT 2020 & Nghị Định 08/2022/NĐ-CP',
                'slug' => 'huong-dan-thu-tuc-cap-giay-phep-moi-truong',
                'image' => 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png',
                'excerpt' => 'Doanh nghiệp có thể tiếp cận nhiều kênh thông tin pháp lý môi trường, nhưng Giấy phép môi trường (GPMT) là văn bản pháp lý tối quan trọng bắt buộc phải hoàn thành trước khi cơ sở đi vào hoạt động chính thức.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Doanh nghiệp nào phải thực hiện kiểm kê khí nhà kính theo Quyết định 13/2024/QĐ-TTg?',
                'slug' => 'doanh-nghiep-phai-kiem-ke-khi-nha-kinh',
                'image' => 'Lich-thang-8-768x432.png',
                'excerpt' => 'Danh mục cơ sở phát thải khí nhà kính phải thực hiện kiểm kê định kỳ cập nhật mới nhất theo Quyết định 13/2024/QĐ-TTg của Thủ tướng Chính phủ.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-quoc-te',
                'title' => 'Cơ Chế Điều Chỉnh Biên Giới Carbon (CBAM) Của EU & Lời Khuyên Cho Doanh Nghiệp Xuất Khẩu',
                'slug' => 'cbam-du-lieu-doanh-nghiep-can-chuan-bi',
                'image' => '6-768x429.png',
                'excerpt' => 'Cơ chế điều chỉnh biên giới carbon (CBAM) của EU bắt đầu áp dụng giai đoạn chuyển tiếp, đặt ra yêu cầu báo cáo phát thải nghiêm ngặt cho hàng xuất khẩu.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Quy Trình Quan Trắc & Đo Kiểm Môi Trường Lao Động Định Kỳ Tại Nhà Máy Sản Xuất',
                'slug' => 'quy-trinh-quan-trac-moi-truong-lao-dong',
                'image' => 'Hinh-1-768x512.jpg',
                'excerpt' => 'Quan trắc môi trường định kỳ giúp kiểm soát chất lượng không khí, nước thải và tuân thủ các quy chuẩn kỹ thuật quốc gia QCVN.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Các Công Nghệ Xử Lý Nước Thải Tiên Tiến Giúp Tiết Kiệm Chi Phí Vận Hành',
                'slug' => 'cac-cong-nghe-xu-ly-nuoc-thai-tien-tien',
                'image' => 'Thiet-ke-chua-co-ten-2-768x429.png',
                'excerpt' => 'Ứng dụng các công nghệ xử lý sinh học kết hợp màng lọc MBR giúp tối ưu hóa diện tích xây dựng và giảm chi phí điện năng vận hành.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Tổng Hợp Các Mức Phạt Vi Phạm Hành Chính Về Bảo Vệ Môi Trường Mới Nhất',
                'slug' => 'tong-hop-muc-phat-vi-pham-moi-truong',
                'image' => '118-1-768x429.png',
                'excerpt' => 'Cập nhật mức xử phạt hành chính mới nhất trong lĩnh vực bảo vệ môi trường theo Nghị định 45/2022/NĐ-CP của Chính phủ.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-quoc-te',
                'title' => 'Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho Doanh Nghiệp Xuất Khẩu',
                'slug' => 'kiem-ke-khi-nha-kinh-iso-14064-1',
                'image' => 'Bai-Dang-Bao-Chau-1024x572.png',
                'excerpt' => 'Báo cáo kiểm kê khí nhà kính đáp ứng tiêu chuẩn quốc tế ISO 14064-1 và yêu cầu khắt khe từ chuỗi cung ứng xanh toàn cầu.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Quy Trình Lập Báo Cáo ĐTM Dự Án Nhóm I & II Theo Luật BVMT 2020',
                'slug' => 'quy-trinh-lap-bao-cao-dtm',
                'image' => '1-768x427.png',
                'excerpt' => 'Hướng dẫn chi tiết quy trình thẩm định, tham vấn và phê duyệt báo cáo đánh giá tác động môi trường ĐTM cấp Bộ và cấp Tỉnh.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-quoc-te',
                'title' => 'Đánh Giá Vòng Đời Sản Phẩm (LCA): Chìa Khóa Đạt Chứng Chỉ Xanh Xuất Khẩu EU & Mỹ',
                'slug' => 'danh-gia-vong-doi-san-pham-lca',
                'image' => '5.-ceragem-1024x683.jpg',
                'excerpt' => 'Phương pháp Life Cycle Assessment giúp định lượng phát thải carbon trên từng đơn vị sản phẩm và mở rộng thị trường quốc tế.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-quoc-te',
                'title' => 'Lộ Trình Chuyển Đổi Năng Lượng & Kiểm Toán Năng Lượng Cho Nhà Máy Net Zero 2050',
                'slug' => 'lo-trinh-chuyen-doi-nang-luong-net-zero',
                'image' => 'moi-truong-bao-chau-1024x603.jpg',
                'excerpt' => 'Xây dựng giải pháp tiết kiệm năng lượng, điện mặt trời mái nhà và giảm phát thải khí nhà kính cho khu công nghiệp.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-quoc-te',
                'title' => 'Tư Vấn Tín Chỉ Carbon & Chiến Lược Trung Hòa Carbon (Carbon Neutral) Cho Doanh Nghiệp',
                'slug' => 'tu-van-tin-chi-carbon-trung-hoa-carbon',
                'image' => 'Lich-thang-8-768x432.png',
                'excerpt' => 'Cơ chế mua bán và chuyển nhượng tín chỉ carbon theo tiêu chuẩn quốc tế Verra (VCS), Gold Standard (GS) đón đầu sàn giao dịch carbon.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Báo Cáo Công Tác Bảo Vệ Môi Trường Định Kỳ Hằng Năm: Thời Hạn & Biểu Mẫu Chuẩn',
                'slug' => 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky',
                'image' => 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png',
                'excerpt' => 'Hướng dẫn lập và gửi báo cáo công tác bảo vệ môi trường trước ngày 05/01 hằng năm theo Thông tư 02/2022/TT-BTNMT tránh bị phạt nặng.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-trong-nuoc',
                'title' => 'Đăng Ký Môi Trường Là Gì? Đối Tượng Phải Thực Hiện & Cơ Quan Tiếp Nhận Hồ Sơ',
                'slug' => 'dang-ky-moi-truong-doi-tuong-thu-tuc',
                'image' => '118-1-768x429.png',
                'excerpt' => 'Chi tiết quy định đăng ký môi trường tại UBND cấp xã, các trường hợp được miễn và thời hạn nộp hồ sơ chuẩn quy định pháp luật.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Ứng Dụng Công Nghệ Màng MBR Trong Xử Lý Nước Thải Dệt Nhuộm Và Thu Hồi Nước',
                'slug' => 'ung-dung-mang-mbr-xu-ly-nuoc-thai',
                'image' => 'CTY-TAN-TIEN-1024x640.png',
                'excerpt' => 'Giải pháp xử lý nước thải dệt nhuộm độ màu cao, thu hồi nước tái sử dụng cho sản xuất giúp tiết kiệm tài nguyên nước sạch.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Bảo Châu Nghiệm Thu Hệ Thống Xử Lý Nước Thải 1.200 m³/ngày Cho Nhà Máy Thực Phẩm',
                'slug' => 'nghiem-thu-he-thong-xu-ly-nuoc-thai-1200m3',
                'image' => '4-768x427.png',
                'excerpt' => 'Bàn giao và vận hành ổn định hệ thống xử lý nước thải chế biến thực phẩm đạt cột A QCVN 40:2011/BTNMT.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Công Nghệ Xử Lý Khí Thải Lò Hơi & Bụi Công Nghiệp Đạt Chuẩn QCVN 19:2009/BTNMT',
                'slug' => 'cong-nghe-xu-ly-khi-thai-lo-hoi',
                'image' => 'moi-truong-bao-chau-1024x603.jpg',
                'excerpt' => 'Thiết kế tháp hấp thụ, lọc bụi túi vải và cyclone xử lý triệt để SO2, NOx, CO, bụi khói lò hơi bảo vệ môi trường không khí xung quanh.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Xử Lý Nước Cấp Công Nghiệp & Hệ Thống Lọc Nước Tinh Khiết RO Cho Ngành Dược Phẩm',
                'slug' => 'xu-ly-nuoc-cap-cong-nghiep-ro',
                'image' => 'Thiet-ke-chua-co-ten-2-768x429.png',
                'excerpt' => 'Cung cấp và lắp đặt dây chuyền lọc nước RO khử khoáng EDI đạt tiêu chuẩn Dược điển Việt Nam V và GMP-WHO.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'tin-noi-bo',
                'title' => 'Quy Trình Vận Hành & Bảo Trì Trạm Xử Lý Nước Thải Tập Trung Khu Công Nghiệp',
                'slug' => 'van-hanh-bao-tri-tram-xu-ly-nuoc-thai',
                'image' => 'Hinh-1-768x512.jpg',
                'excerpt' => 'Dịch vụ trọn gói vận hành, kiểm soát vi sinh bùn hoạt tính, tối ưu hóa hóa chất keo tụ PAC và polymer tại các trạm xử lý nước thải KCN.',
                'content' => $gpmtContent,
            ],
        ];

        foreach ($posts as $index => $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], [
                'post_category_id' => $postCategories[$post['category']]->getKey(),
                'title' => $post['title'],
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'thumbnail' => $post['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'published_at' => $publishedAt->copy()->subHours($index),
                'meta_title' => $post['title'],
                'meta_description' => $post['excerpt'],
            ]);
        }
    }

    private function seedProjects(CarbonInterface $publishedAt): void
    {
        $projectDetailContent = <<<'HTML'
<h2><span id="tong-quan-du-an">Tổng quan dự án &amp; Phạm vi thực hiện</span></h2>
<p>Dự án được triển khai nhằm đảm bảo tính tuân thủ pháp luật môi trường theo Luật BVMT 2020 và các quy chuẩn kỹ thuật quốc gia. Môi Trường Bảo Châu đã trực tiếp khảo sát thực địa, lập báo cáo chuyên sâu và bảo vệ thành công trước Hội đồng thẩm định.</p>
<p>Công trình đi vào vận hành giúp doanh nghiệp kiểm soát 100% rủi ro phát tán ô nhiễm và tối ưu chi phí vận hành bảo dưỡng.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
  <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Bai-Dang-Bao-Chau-1024x572.png" alt="Quy trình thực hiện dự án môi trường Bảo Châu" width="1024" height="572" />
  <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hồ sơ và quy trình kỹ thuật nghiệm thu dự án</figcaption>
</figure>

<h2><span id="giai-phap-ky-thuat">Giải pháp kỹ thuật &amp; Điểm nổi bật</span></h2>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4 text-black">
  <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
    <p class="font-bold text-primary text-sm mb-1">1. Tối ưu xử lý phát thải</p>
    <p class="text-xs text-gray-600">Ứng dụng công nghệ xử lý tuần hoàn, giảm tải lượng xả thải và tiết kiệm chi phí hóa chất.</p>
  </div>
  <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
    <p class="font-bold text-primary text-sm mb-1">2. Kiểm soát khí thải &amp; Mùi</p>
    <p class="text-xs text-gray-600">Hệ thống chụp hút cục bộ kết hợp lọc than hoạt tính khử mùi và bụi triệt để.</p>
  </div>
  <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
    <p class="font-bold text-primary text-sm mb-1">3. Quản lý chất thải nguy hại</p>
    <p class="text-xs text-gray-600">Quy hoạch kho lưu giữ CTNH đạt chuẩn Thông tư 02/2022/TT-BTNMT.</p>
  </div>
  <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
    <p class="font-bold text-primary text-sm mb-1">4. Giám sát tự động</p>
    <p class="text-xs text-gray-600">Thiết lập hệ thống quan trắc và cảnh báo tự động khi có biến động thông số.</p>
  </div>
</div>

<h2><span id="ket-qua-dat-duoc">Kết quả đạt được &amp; Cam kết</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
  <li>100% Hồ sơ được phê duyệt và nghiệm thu đúng tiến độ cam kết.</li>
  <li>Đồng hành hỗ trợ kỹ thuật và giải trình thanh tra môi trường trọn đời dự án.</li>
  <li>Cung cấp đầy đủ báo cáo giám sát định kỳ theo quy định pháp luật.</li>
</ul>
HTML;

        $projects = [
            [
                'title' => 'Dự Án Giấy Phép Môi Trường Nhà Máy BERICAP Việt Nam',
                'slug' => 'giay-phep-moi-truong-bericap-viet-nam',
                'category' => 'giay-phep',
                'client' => 'Tập đoàn BERICAP (Đức)',
                'location' => 'KCN Long Thành, Đồng Nai',
                'image' => 'BERICAP.jpg',
                'summary' => 'Tư vấn lập hồ sơ đề nghị cấp Giấy phép môi trường cấp Bộ Tài nguyên và Môi trường cho nhà máy sản xuất bao bì nhựa chính xác quy mô 25.000 m².',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho PepsiCo',
                'slug' => 'tu-van-moi-truong-pepsico',
                'category' => 'khi-nha-kinh',
                'client' => 'Suntory PepsiCo Việt Nam',
                'location' => 'KCN VSIP 1, Bình Dương',
                'image' => 'PEPSICO.jpg',
                'summary' => 'Xác định phạm vi phát thải Scope 1, 2, 3, xây dựng báo cáo kiểm kê khí nhà kính và lộ trình giảm phát thải Net Zero theo chuẩn quốc tế ISO 14064-1:2018.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Báo Cáo Đánh Giá Tác Động Môi Trường ĐTM Nhựa Tân Tiến',
                'slug' => 'ho-so-moi-truong-tan-tien',
                'category' => 'dtm',
                'client' => 'Bao Bì Nhựa Tân Tiến',
                'location' => 'KCN Tân Bình, TP. Hồ Chí Minh',
                'image' => 'CTY-TAN-TIEN.png',
                'summary' => 'Lập báo cáo ĐTM dự án mở rộng nhà xưởng sản xuất màng ghép phức hợp công suất 50.000 tấn/năm, bảo vệ thành công trước Hội đồng thẩm định Sở TN&MT TP.HCM.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Hệ Thống Xử Lý Khí Thải & Bụi Nhà Máy Ceragem',
                'slug' => 'giai-phap-moi-truong-ceragem',
                'category' => 'xu-ly-nuoc',
                'client' => 'Tập Đoàn Ceragem Hàn Quốc',
                'location' => 'KCN Tân Phú Trung, TP.HCM',
                'image' => '5.-ceragem-1024x683.jpg',
                'summary' => 'Thiết kế, thi công và lắp đặt tháp hấp thụ than hoạt tính kết hợp cyclone lọc bụi cho dây chuyền sản xuất thiết bị y tế đạt chuẩn QCVN 19:2009/BTNMT.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Quan Trắc Môi Trường Lao Động & Khí Thải Định Kỳ Mitsubishi',
                'slug' => 'quan-trac-moi-truong-mitsubishi',
                'category' => 'quan-trac',
                'client' => 'Mitsubishi Motors Việt Nam',
                'location' => 'Bình Dương - TP.HCM',
                'image' => 'Hinh-1-1024x683.jpg',
                'summary' => 'Thực hiện đo đạc hơn 120 vị trí yếu tố vi khí hậu, tiếng ồn, ánh sáng, bụi và phân tích mẫu nước thải định kỳ 4 đợt/năm cho hệ thống chuỗi nhà máy.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Giấy Phép Môi Trường Nhà Máy Nước Giải Khát Bidrico',
                'slug' => 'kiem-ke-khi-nha-kinh-bidrico',
                'category' => 'giay-phep',
                'client' => 'Tân Quang Minh (Bidrico)',
                'location' => 'KCN Vĩnh Lộc, TP. Hồ Chí Minh',
                'image' => 'Bai-Dang-Bao-Chau-1024x572.png',
                'summary' => 'Tư vấn tích hợp toàn diện các giấy phép xả thải, sổ chủ nguồn thải và đăng ký môi trường thành Giấy phép môi trường cấp Tỉnh đạt chuẩn 100%.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Giấy Phép Môi Trường Tổ Hợp Chế Biến Thực Phẩm CJ Foods',
                'slug' => 'giay-phep-moi-truong-cj-foods',
                'category' => 'giay-phep',
                'client' => 'Tập Đoàn CJ Foods (Hàn Quốc)',
                'location' => 'KCN Hiệp Phước, TP.HCM',
                'image' => 'moi-truong-bao-chau-1024x603.jpg',
                'summary' => 'Hoàn thiện hồ sơ cấp phép xả nước thải và khí thải chế biến thực phẩm đông lạnh xuất khẩu công suất 15.000 tấn/năm cho tập đoàn CJ Foods.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Báo Cáo ĐTM Mở Rộng Nhà Máy Sản Xuất Gia Dụng Lock&Lock',
                'slug' => 'bao-cao-dtm-lock-and-lock',
                'category' => 'dtm',
                'client' => 'Lock&Lock Vina',
                'location' => 'KCN Mỹ Xuân A2, BR-VT',
                'image' => 'Thiet-ke-chua-co-ten-2-768x429.png',
                'summary' => 'Đánh giá tác động môi trường giai đoạn 3 mở rộng dây chuyền ép nhựa và thủy tinh chịu nhiệt công suất 30.000 tấn/năm đạt chuẩn phê duyệt cấp Bộ.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Tư Vấn Khí Nhà Kính & Lộ Trình ESG Cho Chuỗi Vinamilk',
                'slug' => 'tu-van-khi-nha-kinh-vinamilk',
                'category' => 'khi-nha-kinh',
                'client' => 'Vinamilk Việt Nam',
                'location' => 'Bình Dương & Cần Thơ',
                'image' => 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png',
                'summary' => 'Kiểm kê phát thải KNK chuỗi nhà máy chế biến sữa, xây dựng chỉ số carbon footprint trên từng đơn vị sản phẩm và lộ trình Net Zero theo tiêu chuẩn ISO 14064.',
                'content' => $projectDetailContent,
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], [
                'title' => $project['title'],
                'category' => $project['category'],
                'client' => $project['client'],
                'location' => $project['location'] ?? 'Toàn Quốc',
                'summary' => $project['summary'],
                'content' => $project['content'],
                'thumbnail' => $project['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'published_at' => $publishedAt,
                'completed_at' => today(),
                'meta_title' => $project['title'].' - Môi Trường Bảo Châu',
                'meta_description' => $project['summary'],
            ]);
        }
    }

    private function seedJobs(CarbonInterface $publishedAt): void
    {
        $jobs = [
            [
                'title' => 'Kỹ Sư Lập Báo Cáo ĐTM & Giấy Phép Môi Trường',
                'slug' => 'ky-su-dtm-giay-phep-moi-truong',
                'location' => 'TP. Hồ Chí Minh',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Chủ trì lập báo cáo ĐTM, Giấy phép môi trường và bảo vệ phương án kỹ thuật trước Hội đồng thẩm định Sở/Bộ TN&MT.',
                'content' => '<p><strong>Trách nhiệm chính:</strong></p><ul><li>Khảo sát hiện trạng nhà máy, thu thập số liệu quy trình sản xuất và lấy mẫu quan trắc phân tích.</li><li>Biên soạn Báo cáo ĐTM, Báo cáo đề xuất cấp Giấy phép môi trường theo Luật BVMT 2020.</li><li>Đại diện chủ dự án giải trình và bảo vệ phương án kỹ thuật trước Hội đồng thẩm định Sở TN&MT, Bộ TN&MT.</li><li>Chỉnh sửa hoàn thiện hồ sơ và bàn giao Giấy phép môi trường chính thức cho khách hàng.</li></ul>',
                'requirements' => '<ul><li>Tốt nghiệp Đại học chuyên ngành Quản lý Môi trường, Kỹ thuật Môi trường hoặc Khoa học Môi trường.</li><li>Tối thiểu 1 - 3 năm kinh nghiệm lập báo cáo ĐTM hoặc Giấy phép môi trường.</li><li>Nắm vững Luật Bảo vệ Môi trường 2020, Nghị định 08/2022/NĐ-CP và Thông tư 02/2022/TT-BTNMT.</li><li>Kỹ năng giao tiếp, thuyết trình và bảo vệ phương án trước hội đồng tốt.</li></ul>',
                'benefits' => '<ul><li>Thu nhập 15 - 25 Triệu + Thưởng % hoa hồng dự án theo KPI.</li><li>Lương tháng 13, 14 và thưởng nóng dự án hoàn thành xuất sắc.</li><li>Đài thọ 100% chi phí các khóa đào tạo nâng cao chứng chỉ kiểm kê KNK, CBAM, ESG quốc tế.</li><li>Đầy đủ chế độ BHXH, BHYT, du lịch nghỉ dưỡng 1-2 lần/năm.</li></ul>',
            ],
            [
                'title' => 'Chuyên Viên Tư Vấn Kiểm Kê Khí Nhà Kính & Báo Cáo ESG',
                'slug' => 'chuyen-vien-kiem-ke-khi-nha-kinh',
                'location' => 'TP. Hồ Chí Minh',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Tư vấn kiểm kê phát thải khí nhà kính theo ISO 14064, cơ chế CBAM EU, đánh giá vòng đời LCA và lập báo cáo phát triển bền vững ESG.',
                'content' => '<p><strong>Trách nhiệm chính:</strong></p><ul><li>Thu thập số liệu tiêu thụ năng lượng, nhiên liệu, nguyên vật liệu tại cơ sở sản xuất của khách hàng.</li><li>Áp dụng hệ số phát thải theo IPCC/GHG Protocol để tính toán lượng phát thải Phạm vi 1, 2, 3.</li><li>Xây dựng báo cáo kiểm kê KNK cấp cơ sở (ISO 14064-1) và kế hoạch giảm nhẹ phát thải.</li><li>Hỗ trợ doanh nghiệp xuất khẩu lập tờ khai phát thải theo cơ chế điều chỉnh biên giới carbon CBAM của EU.</li></ul>',
                'requirements' => '<ul><li>Tốt nghiệp Đại học ngành Môi trường, Biến đổi khí hậu, Năng lượng hoặc Kỹ thuật Hóa học.</li><li>Am hiểu tiêu chuẩn ISO 14064-1, GHG Protocol, IPCC Guidelines và quy định CBAM EU.</li><li>Tiếng Anh đọc hiểu tài liệu chuyên ngành tốt (tương đương TOEIC 650+ / IELTS 6.0+).</li><li>Kỹ năng phân tích số liệu Excel / công cụ mô hình hóa tốt.</li></ul>',
                'benefits' => '<ul><li>Thu nhập 18 - 30 Triệu + Thưởng dự án ESG cao cấp.</li><li>Cơ hội làm việc trực tiếp với các tập đoàn FDI đa quốc gia và tổ chức quốc tế.</li><li>Được cử đi học và cấp chứng chỉ Lead Auditor ISO 14064 quốc tế.</li><li>Môi trường năng động, lộ trình thăng tiến lên Trưởng nhóm/Chuyên gia tư vấn cấp cao.</li></ul>',
            ],
            [
                'title' => 'Kỹ Sư Thiết Kế & Vận Hành Hệ Thống Xử Lý Nước Thải',
                'slug' => 'ky-su-thiet-ke-xu-ly-nuoc-thai',
                'location' => 'TP. Hồ Chí Minh & Công trình',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Thiết kế công nghệ, lập bản vẽ thi công và chỉ đạo vận hành chạy thử hệ thống xử lý nước thải công nghiệp & sinh hoạt.',
                'content' => '<p><strong>Trách nhiệm chính:</strong></p><ul><li>Tính toán công nghệ, lập sơ đồ dây chuyền xử lý và bảng cân bằng vật chất cho trạm xử lý nước thải.</li><li>Triển khai bản vẽ thiết kế cơ sở, bản vẽ thi công (AutoCAD/Revit) chi tiết bể xử lý, thiết bị và đường ống.</li><li>Giám sát lắp đặt thiết bị công nghệ, nuôi cấy vi sinh và vận hành chạy thử đạt chuẩn xả thải.</li><li>Lập quy trình vận hành chuẩn (SOP) và hướng dẫn bàn giao kỹ thuật cho chủ đầu tư.</li></ul>',
                'requirements' => '<ul><li>Tốt nghiệp Đại học chuyên ngành Kỹ thuật Môi trường, Công nghệ Môi trường hoặc Cấp thoát nước.</li><li>Kinh nghiệm 2+ năm thiết kế hoặc thi công trạm xử lý nước thải công nghiệp.</li><li>Thành thạo phần mềm AutoCAD, MS Office; biết Revit MEP là lợi thế lớn.</li><li>Sẵn sàng đi công tác giám sát tại công trình nhà máy khi cần thiết.</li></ul>',
                'benefits' => '<ul><li>Thu nhập 16 - 26 Triệu + Phụ cấp công tác + Thưởng tiến độ công trình.</li><li>Đầy đủ bảo hộ lao động cao cấp, bảo hiểm tai nạn 24/7 và chế độ đãi ngộ vượt trội.</li><li>Được làm chủ công nghệ xử lý tiên tiến: MBR, MBBR, AO/AAO, Fenton...</li></ul>',
            ],
            [
                'title' => 'Chuyên Viên Kinh Doanh Dịch Vụ Môi Trường (B2B Sales)',
                'slug' => 'nhan-vien-kinh-doanh-dich-vu-moi-truong',
                'location' => 'TP. Hồ Chí Minh',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Tìm kiếm, kết nối và tư vấn giải pháp môi trường cho các doanh nghiệp, nhà máy FDI trong các khu công nghiệp.',
                'content' => '<p><strong>Trách nhiệm chính:</strong></p><ul><li>Tìm kiếm và tiếp cận khách hàng doanh nghiệp sản xuất tại các KCN TP.HCM, Bình Dương, Đồng Nai, Long An.</li><li>Phối hợp bộ phận kỹ thuật tư vấn gói dịch vụ phù hợp (ĐTM, Giấy phép MT, Khí nhà kính, Xử lý nước thải).</li><li>Soạn thảo báo giá, thương thảo điều khoản và ký kết hợp đồng dịch vụ.</li><li>Chăm sóc khách hàng hiện hữu và mở rộng mạng lưới đối tác chiến lược.</li></ul>',
                'requirements' => '<ul><li>Tốt nghiệp Cao đẳng/Đại học các ngành Kinh tế, Quản trị, Môi trường hoặc liên quan.</li><li>Có kỹ năng giao tiếp tốt, tác phong chuyên nghiệp, đam mê kinh doanh B2B.</li><li>Có kinh nghiệm sales dịch vụ B2B hoặc am hiểu ngành môi trường là lợi thế lớn.</li><li>Chủ động, có tinh thần cầu tiến và chịu được áp lực doanh số.</li></ul>',
                'benefits' => '<ul><li>Lương cứng 10 - 15 Triệu + Hoa hồng % hợp đồng lũy tiến (Tổng thu nhập 25 - 40+ Triệu/tháng).</li><li>Nguồn khách hàng tiềm năng được công ty hỗ trợ liên tục qua Marketing.</li><li>Thưởng nóng xuất sắc theo từng hợp đồng ký mới.</li></ul>',
            ],
            [
                'title' => 'Tuyển Dụng Kế Toán Nội Bộ & Quản Lý Dự Án',
                'slug' => 'ke-toan-noi-bo',
                'location' => 'TP. Hồ Chí Minh',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Quản lý thu chi nội bộ, theo dõi tiến độ thanh toán hợp đồng dự án môi trường và phối hợp kế toán thuế.',
                'content' => '<p><strong>Trách nhiệm chính:</strong></p><ul><li>Kiểm tra, đối chiếu chứng từ thu chi, tạm ứng công tác phí và thanh toán nhà cung cấp.</li><li>Theo dõi các mốc nghiệm thu và thanh toán hợp đồng tư vấn, thi công công trình.</li><li>Lập báo cáo dòng tiền nội bộ định kỳ hàng tuần, hàng tháng cho Ban Giám Đốc.</li><li>Lưu trữ hồ sơ hợp đồng, hóa đơn chứng từ gọn gàng, khoa học.</li></ul>',
                'requirements' => '<ul><li>Tốt nghiệp Cao đẳng/Đại học chuyên ngành Kế toán, Kiểm toán, Tài chính.</li><li>Tối thiểu 1 năm kinh nghiệm kế toán nội bộ hoặc kế toán tổng hợp.</li><li>Cẩn thận, trung thực, tỉ mỉ và có tinh thần trách nhiệm cao.</li><li>Sử dụng thành thạo phần mềm MISA và Excel văn phòng.</li></ul>',
                'benefits' => '<ul><li>Thu nhập 10 - 14 Triệu + Lương tháng 13, 14.</li><li>Môi trường văn phòng thân thiện, giờ làm việc hành chính chuẩn mực.</li><li>Đầy đủ chế độ BHXH, BHYT, nghỉ mát hàng năm cùng công ty.</li></ul>',
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::query()->updateOrCreate(['slug' => $job['slug']], [
                'title' => $job['title'],
                'location' => $job['location'],
                'employment_type' => $job['employment_type'],
                'summary' => $job['summary'],
                'content' => $job['content'],
                'requirements' => $job['requirements'],
                'benefits' => $job['benefits'],
                'status' => ContentStatus::Published,
                'published_at' => $publishedAt,
                'expires_at' => now()->addMonths(6),
                'meta_title' => $job['title'].' - Môi Trường Bảo Châu',
                'meta_description' => $job['summary'],
            ]);
        }
    }

    private function seedSettings(): void
    {
        foreach ([
            // 1. Thông tin doanh nghiệp (General)
            'company_name' => 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu',
            'company_short_name' => 'Môi Trường Bảo Châu',
            'tax_id' => '0317615845',
            'logo' => 'assets/images/optimized/logo-bao-chau.webp',
            'favicon' => 'assets/images/cropped-chuan-192x192.png',

            // 2. Liên hệ & Trụ sở (Contact)
            'hotline' => '0915 549 148',
            'phone' => '028 6686 2886',
            'email' => 'info@baochauenvir.com',
            'address' => '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh',
            'working_hours' => 'Thứ 2 - Thứ 6: 08:00 - 17:30 | Thứ 7: 08:00 - 12:00',
            'google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.267864834827!2d106.71457177573615!3d10.790786958925828!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528a49c669145%3A0xe54d24f4699aeecb!2zMTgwLzQwIE5ndXnhu4VuIEjhu691IEPhuqNuaCwgUGjGsOG7nW5nIDIyLCBCw6xuaCBUaOG6oW5oLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1716362831822!5m2!1svi!2s',

            // 3. Mạng xã hội (Social)
            'facebook' => 'https://www.facebook.com/moitruongbaochau',
            'youtube' => 'https://www.youtube.com/@moitruongbaochau',
            'zalo' => 'https://zalo.me/0915549148',

            // 4. SEO Mặc định (SEO)
            'seo_default_title' => 'Môi Trường Bảo Châu - Dịch vụ & Kỹ thuật môi trường chuyên nghiệp',
            'seo_default_description' => 'Tư vấn Giấy phép Môi trường, Báo cáo ĐTM, Kiểm kê Khí nhà kính ESG và Xử lý Nước thải trọn gói uy tín.',
            'seo_default_image' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
        ] as $key => $value) {
            $group = 'general';
            if (str_starts_with($key, 'seo_')) {
                $group = 'seo';
            } elseif (in_array($key, ['hotline', 'phone', 'email', 'address', 'working_hours', 'google_maps_embed'], true)) {
                $group = 'contact';
            } elseif (in_array($key, ['facebook', 'youtube', 'zalo'], true)) {
                $group = 'social';
            }

            Setting::query()->updateOrCreate(['key' => $key], [
                'value' => $value,
                'type' => 'string',
                'group' => $group,
            ]);
        }
    }

    private function seedRedirects(): void
    {
        foreach ([
            '/index.html' => '/', '/about.html' => '/gioi-thieu', '/contact.html' => '/lien-he',
            '/news.html' => '/tin-tuc', '/news-detail.html' => '/tin-tuc/huong-dan-thu-tuc-cap-giay-phep-moi-truong',
            '/project.html' => '/du-an', '/project-detail.html' => '/du-an/giay-phep-moi-truong-bericap-viet-nam',
            '/recruitment.html' => '/tuyen-dung', '/recruitment-detail.html' => '/tuyen-dung/ky-su-dtm-giay-phep-moi-truong',
            '/service-detail.html' => '/dich-vu/giay-phep-moi-truong', '/service.html' => '/dich-vu',
        ] as $oldPath => $newPath) {
            Redirect::query()->updateOrCreate(['old_path' => $oldPath], [
                'new_path' => $newPath,
                'status_code' => 301,
                'is_active' => true,
            ]);
        }
    }

    private function seedMenu(): void
    {
        $menu = Menu::query()->updateOrCreate(['location' => 'primary'], ['name' => 'Menu chính', 'is_active' => true]);

        foreach ([
            ['label' => 'Trang chủ', 'route_name' => 'home'],
            ['label' => 'Giới thiệu', 'route_name' => 'about'],
            ['label' => 'Dịch vụ', 'route_name' => 'services.index'],
            ['label' => 'Dự án', 'route_name' => 'projects.index'],
            ['label' => 'Tin tức', 'route_name' => 'posts.index'],
            ['label' => 'Tuyển dụng', 'route_name' => 'recruitment.index'],
            ['label' => 'Liên hệ', 'route_name' => 'contact.index'],
        ] as $sortOrder => $item) {
            $menu->items()->updateOrCreate(['label' => $item['label']], [
                ...$item,
                'sort_order' => $sortOrder,
                'is_active' => true,
            ]);
        }
    }
}
