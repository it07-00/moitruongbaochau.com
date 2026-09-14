<?php

namespace Database\Seeders;

use App\ContentStatus;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Support\RichContentNormalizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapabilityProfileSeeder extends Seeder
{
    /**
     * Synchronize public company and service content with the 2026 capability profile.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->updateAboutPage();
            $this->updateServicesPage();
            $this->updateServices();
        });

        $this->call(ServiceLegalContentSeeder::class);
        $this->call(HeaderNavigationSeeder::class);
    }

    private function updateAboutPage(): void
    {
        $page = Page::query()->firstOrNew(['slug' => 'gioi-thieu']);

        $page->fill([
            'title' => 'MÔI TRƯỜNG BẢO CHÂU - Dịch vụ chất lượng, giải pháp hiệu quả',
            'template' => 'about',
            'excerpt' => 'Đơn vị tư vấn các quy định pháp luật về bảo vệ môi trường, đồng hành cùng doanh nghiệp trên hành trình phát triển bền vững.',
            'content' => RichContentNormalizer::normalize(<<<'HTML'
<p>Môi Trường Bảo Châu được định hướng phát triển là đơn vị tư vấn các quy định pháp luật về bảo vệ môi trường. Trước yêu cầu ngày càng chặt chẽ về tiêu chuẩn môi trường trong sản xuất, xuất nhập khẩu và nhu cầu đối với sản phẩm xanh, việc tuân thủ pháp luật về bảo vệ môi trường không chỉ là nghĩa vụ mà còn là động lực tạo ra lợi nhuận bền vững cho doanh nghiệp.</p>
<p>Với phương châm <strong>“Dịch vụ chất lượng - Giải pháp hiệu quả”</strong>, chúng tôi luôn đồng hành và mang đến trải nghiệm tốt nhất cho khách hàng. Đội ngũ kỹ sư, chuyên viên có trình độ chuyên môn và kinh nghiệm trong ngành môi trường, an toàn vệ sinh lao động, cùng mạng lưới cơ quan, đối tác và nhà thầu, giúp Bảo Châu triển khai giải pháp đồng bộ và hiệu quả.</p>
<p>Hệ thống văn phòng tại <strong>TP. Hồ Chí Minh, Hải Phòng, Khánh Hòa và Gia Lai</strong> tạo năng lực hỗ trợ khách hàng trên phạm vi toàn quốc, nhanh chóng và kịp thời ở cả ba miền Bắc - Trung - Nam.</p>
<p>Bảo Châu không ngừng cải tiến, đổi mới và nỗ lực để đáp lại sự tín nhiệm của khách hàng; lấy <strong>Chất lượng - Uy tín - Hiệu quả</strong> làm phương châm hoạt động, cùng các giá trị cốt lõi <strong>Chất lượng, Uy tín, Trách nhiệm, Sáng tạo và Hợp tác</strong>.</p>
HTML),
            'status' => ContentStatus::Published,
            'published_at' => $page->published_at ?? now()->startOfDay(),
            'meta_title' => 'Về Môi Trường Bảo Châu - Năng lực tư vấn môi trường toàn quốc',
            'meta_description' => 'Môi Trường Bảo Châu cung cấp giải pháp môi trường, năng lượng và phát triển bền vững với mạng lưới hỗ trợ trên toàn quốc.',
        ]);

        $page->metadata = array_replace($page->metadata ?? [], [
            'about_badge' => 'VỀ CHÚNG TÔI',
            'vision_badge' => 'TẦM NHÌN & SỨ MỆNH',
            'vision_title' => '<span class="text-primary block">TẦM NHÌN</span> Chung tay vì môi trường xanh',
            'vision_desc_1' => 'Trở thành <strong>đơn vị tư vấn hàng đầu được doanh nghiệp lựa chọn</strong> trong lĩnh vực môi trường và tiết kiệm năng lượng.',
            'vision_desc_2' => 'Tất cả chúng ta cùng chung tay vì một môi trường xanh - sạch - đẹp và một nền kinh tế phát triển bền vững.',
            'mission_1_title' => 'Giải pháp quản lý tối ưu',
            'mission_1_desc' => 'Mang đến các giải pháp tối ưu về quản lý môi trường, giúp doanh nghiệp nâng cao hiệu quả kinh doanh song hành với bảo vệ môi trường.',
            'mission_2_title' => 'Giảm thiểu tác động',
            'mission_2_desc' => 'Đóng góp tích cực vào việc giảm thiểu tác động tiêu cực đến môi trường thông qua các giải pháp công nghệ tiên tiến.',
            'mission_3_title' => 'Nâng cao nhận thức',
            'mission_3_desc' => 'Xây dựng cộng đồng doanh nghiệp và xã hội có ý thức hơn về bảo vệ môi trường, hướng đến sự phát triển bền vững.',
            'mission_4_title' => 'Chung tay vì môi trường xanh',
            'mission_4_desc' => 'Kết nối khách hàng, đối tác, đội ngũ chuyên gia và cộng đồng trong hành động vì môi trường xanh - sạch - đẹp.',
            'timeline_desc' => 'Từ nền tảng tư vấn pháp luật bảo vệ môi trường, Bảo Châu từng bước mở rộng thành hệ sinh thái 18 nhóm dịch vụ về môi trường, năng lượng và phát triển bền vững.',
            'timeline_4_year' => '2024 - 2026',
            'timeline_4_title' => 'Mở rộng hệ sinh thái chuyển đổi xanh',
            'timeline_4_desc' => 'Hoàn thiện năng lực ESG, cảng xanh, kiểm kê khí nhà kính, CBAM, ISO 14067, kiểm toán năng lượng, EPR, năng lượng mặt trời và quan trắc tự động.',
        ]);

        $page->save();
    }

    private function updateServicesPage(): void
    {
        $page = Page::query()->firstOrNew(['slug' => 'dich-vu']);

        $page->fill([
            'title' => '18 lĩnh vực dịch vụ môi trường & phát triển bền vững',
            'template' => 'services',
            'excerpt' => 'Giải pháp toàn diện từ ESG, cảng xanh, khí nhà kính, CBAM, năng lượng đến hồ sơ pháp lý, quan trắc, xử lý chất thải và chuyển đổi công nghệ.',
            'status' => ContentStatus::Published,
            'published_at' => $page->published_at ?? now()->startOfDay(),
            'meta_title' => '18 dịch vụ môi trường và phát triển bền vững - Bảo Châu',
            'meta_description' => 'Danh mục 18 dịch vụ môi trường, ESG, khí nhà kính, năng lượng, quan trắc, xử lý chất thải và công nghệ của Môi Trường Bảo Châu.',
        ]);

        $page->metadata = array_replace($page->metadata ?? [], [
            'services_badge' => 'LĨNH VỰC HOẠT ĐỘNG',
            'cta_title' => 'Cần một lộ trình môi trường phù hợp cho doanh nghiệp?',
            'cta_desc' => 'Bảo Châu sẵn sàng khảo sát, rà soát yêu cầu tuân thủ và đề xuất giải pháp đồng bộ theo nhu cầu thực tế.',
        ]);

        $page->save();
    }

    private function updateServices(): void
    {
        $categories = collect($this->categories())->mapWithKeys(function (array $category): array {
            $model = ServiceCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [...$category, 'is_active' => true],
            );

            return [$category['slug'] => $model];
        });

        foreach ($this->services() as $index => $serviceData) {
            $service = Service::query()->firstOrNew(['slug' => $serviceData['slug']]);
            $service->fill([
                'service_category_id' => $categories[$serviceData['category']]->getKey(),
                'name' => $serviceData['name'],
                'short_description' => $serviceData['description'],
                'content' => RichContentNormalizer::normalize($this->buildServiceContent($serviceData)),
                'thumbnail' => $serviceData['image'],
                'status' => ContentStatus::Published,
                'is_featured' => $index < 8,
                'sort_order' => $index + 1,
                'published_at' => $service->published_at ?? now()->startOfDay(),
                'meta_title' => $serviceData['name'].' - Môi Trường Bảo Châu',
                'meta_description' => $serviceData['description'],
            ]);
            $service->save();
        }

        Service::query()
            ->whereIn('slug', ['bao-cao-danh-gia-tac-dong-moi-truong', 'xu-ly-khi-thai-cong-nghiep'])
            ->update(['is_featured' => false, 'sort_order' => 90]);
    }

    /**
     * @return array<int, array{name: string, slug: string, image: string, description: string, sort_order: int}>
     */
    private function categories(): array
    {
        return [
            ['name' => 'Phát triển bền vững & ESG', 'slug' => 'khi-nha-kinh-esg', 'image' => 'uploads/service-categories/Bai-Dang-Bao-Chau-1024x572.png', 'description' => 'Báo cáo ESG, tiêu chí cảng xanh và trách nhiệm mở rộng của nhà sản xuất.', 'sort_order' => 1],
            ['name' => 'Khí nhà kính & Carbon', 'slug' => 'khi-nha-kinh-carbon', 'image' => 'uploads/service-categories/Bai-Dang-Bao-Chau-1024x572.png', 'description' => 'Kiểm kê khí nhà kính, CBAM và đánh giá dấu chân carbon sản phẩm.', 'sort_order' => 2],
            ['name' => 'Năng lượng & Công nghệ xanh', 'slug' => 'nang-luong-cong-nghe-xanh', 'image' => 'uploads/service-categories/CTY-TAN-TIEN-1024x640.png', 'description' => 'Kiểm toán năng lượng, điện mặt trời và chuyển đổi công nghệ xanh.', 'sort_order' => 3],
            ['name' => 'Pháp lý & Ứng phó môi trường', 'slug' => 'phap-ly-moi-truong', 'image' => 'uploads/service-categories/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png', 'description' => 'Hồ sơ pháp lý và kế hoạch ứng phó sự cố môi trường cho doanh nghiệp.', 'sort_order' => 4],
            ['name' => 'Quan trắc & An toàn lao động', 'slug' => 'quan-trac-moi-truong', 'image' => 'uploads/service-categories/Hinh-1-1024x683.jpg', 'description' => 'Quan trắc môi trường, điều kiện lao động, tiếng ồn và hệ thống quan trắc tự động.', 'sort_order' => 5],
            ['name' => 'Kỹ thuật xử lý & Nghiên cứu', 'slug' => 'ky-thuat-xu-ly', 'image' => 'uploads/service-categories/CTY-TAN-TIEN-1024x640.png', 'description' => 'Quản lý chất thải, hệ thống xử lý và nghiên cứu khoa học môi trường.', 'sort_order' => 6],
        ];
    }

    /**
     * @return array<int, array{category: string, name: string, slug: string, image: string, description: string, scope: array<int, string>}>
     */
    private function services(): array
    {
        return [
            $this->service(
                'khi-nha-kinh-esg',
                'Tư vấn, lập báo cáo phát triển bền vững (ESG)',
                'lap-bao-cao-phat-trien-ben-vung-esg',
                'slide-4.png',
                'Xây dựng báo cáo tích hợp các yếu tố kinh tế, xã hội và môi trường, đáp ứng chuẩn mực ESG và thúc đẩy các Mục tiêu Phát triển Bền vững (SDGs).',
                ['Rà soát hiện trạng quản trị và các chủ đề ESG trọng yếu.', 'Xây dựng hệ thống chỉ tiêu, dữ liệu và bằng chứng phục vụ báo cáo.', 'Hoàn thiện báo cáo và lộ trình cải thiện hiệu quả bền vững.'],
            ),
            $this->service(
                'khi-nha-kinh-esg',
                'Tư vấn tiêu chí về cảng xanh',
                'tu-van-tieu-chi-cang-xanh',
                'Bai-Dang-Bao-Chau-768x429.png',
                'Tư vấn công bố và áp dụng TCCS 02:2022/CHHVN về tiêu chí cảng xanh, góp phần thúc đẩy phát triển bền vững ngành hàng hải.',
                ['Đánh giá khoảng cách giữa hiện trạng cảng và bộ tiêu chí.', 'Thiết lập hồ sơ, dữ liệu và chương trình hành động cảng xanh.', 'Hỗ trợ hoàn thiện công bố và duy trì kết quả áp dụng.'],
            ),
            $this->service(
                'khi-nha-kinh-carbon',
                'Kiểm kê khí nhà kính và tư vấn kế hoạch giảm phát thải',
                'kiem-ke-khi-nha-kinh',
                'slide-3.png',
                'Lập báo cáo kiểm kê khí nhà kính, xây dựng kế hoạch giảm nhẹ phát thải và đề xuất các giải pháp tiết kiệm năng lượng cho doanh nghiệp.',
                ['Xác định ranh giới kiểm kê và thu thập dữ liệu phát thải.', 'Tính toán, kiểm soát chất lượng dữ liệu và lập báo cáo.', 'Xây dựng mục tiêu, danh mục giải pháp và lộ trình giảm phát thải.'],
            ),
            $this->service(
                'khi-nha-kinh-carbon',
                'Lập báo cáo CBAM',
                'tu-van-cbam-esg-lca',
                'slide-4.png',
                'Tổng hợp thông tin về phát thải trực tiếp, gián tiếp và hỗ trợ doanh nghiệp tuân thủ yêu cầu CBAM để quản trị rủi ro chi phí carbon.',
                ['Xác định sản phẩm, cơ sở và dữ liệu thuộc phạm vi CBAM.', 'Tính toán phát thải gắn với hàng hóa theo nguồn dữ liệu phù hợp.', 'Lập báo cáo, hồ sơ giải trình và hỗ trợ cập nhật định kỳ.'],
            ),
            $this->service(
                'khi-nha-kinh-carbon',
                'Đánh giá vòng đời và dấu chân carbon sản phẩm theo ISO 14067:2018',
                'danh-gia-vong-doi-san-pham-iso-14067',
                'slide-3.png',
                'Đánh giá vòng đời sản phẩm, tính toán dấu chân carbon và hỗ trợ đo lường, báo cáo, giảm thiểu tác động môi trường theo ISO 14067:2018.',
                ['Xác lập đơn vị chức năng, ranh giới và kịch bản vòng đời.', 'Thu thập dữ liệu nguyên liệu, năng lượng, vận chuyển và xử lý cuối vòng đời.', 'Tính dấu chân carbon, phân tích điểm nóng và đề xuất cải tiến.'],
            ),
            $this->service(
                'nang-luong-cong-nghe-xanh',
                'Kiểm toán năng lượng & giải pháp tiết kiệm năng lượng',
                'kiem-toan-nang-luong-va-giai-phap-tiet-kiem',
                '118-1-768x429.png',
                'Đo lường, phân tích và tính toán mức tiêu thụ năng lượng; đề xuất giải pháp sử dụng năng lượng hiệu quả, bao gồm cải tạo và thay thế bẫy hơi phù hợp.',
                ['Khảo sát hệ thống sử dụng năng lượng và thu thập số liệu vận hành.', 'Phân tích cân bằng năng lượng, tổn thất và cơ hội tiết kiệm.', 'Đề xuất giải pháp kỹ thuật, chi phí đầu tư và hiệu quả hoàn vốn.'],
            ),
            $this->service(
                'phap-ly-moi-truong',
                'Tư vấn hồ sơ môi trường',
                'giay-phep-moi-truong',
                'slide-2.jpg',
                'Tư vấn và thực hiện ĐTM, giấy phép môi trường, đăng ký môi trường và các hồ sơ liên quan, bảo đảm tuân thủ pháp luật và giảm thiểu tác động môi trường.',
                ['Rà soát quy mô, ngành nghề và hiện trạng pháp lý của dự án hoặc cơ sở.', 'Xác định loại hồ sơ, thẩm quyền và tài liệu cần chuẩn bị.', 'Lập, nộp, giải trình và hoàn thiện hồ sơ theo yêu cầu thẩm định.'],
            ),
            $this->service(
                'quan-trac-moi-truong',
                'Quan trắc môi trường',
                'quan-trac-moi-truong-dinh-ky',
                '19-768x432.png',
                'Thực hiện quan trắc không khí, khí thải, nước thải, bùn thải và hướng dẫn doanh nghiệp thực hiện đúng các yêu cầu về quan trắc môi trường.',
                ['Thiết kế chương trình, vị trí, tần suất và thông số quan trắc.', 'Tổ chức lấy mẫu, đo đạc, phân tích và kiểm soát chất lượng.', 'Tổng hợp kết quả, đánh giá tuân thủ và lập báo cáo.'],
            ),
            $this->service(
                'quan-trac-moi-truong',
                'Quan trắc môi trường lao động và phân loại lao động',
                'quan-trac-moi-truong-lao-dong',
                '6-768x429.png',
                'Quan trắc, đo kiểm môi trường lao động tại cơ sở, nhà máy, xí nghiệp và hỗ trợ đánh giá, phân loại theo điều kiện lao động.',
                ['Khảo sát vị trí việc làm, yếu tố tiếp xúc và điều kiện lao động.', 'Đo kiểm các yếu tố vật lý, hóa học và vi khí hậu liên quan.', 'Lập hồ sơ kết quả và hỗ trợ phân loại điều kiện lao động.'],
            ),
            $this->service(
                'ky-thuat-xu-ly',
                'Thu gom, vận chuyển và xử lý chất thải',
                'thu-gom-xu-ly-chat-thai',
                'Thiet-ke-chua-co-ten-2-768x429.png',
                'Tổ chức thu gom, vận chuyển, xử lý chất thải nguy hại đúng quy định và tư vấn quản lý chất thải an toàn cho doanh nghiệp.',
                ['Phân loại dòng chất thải, khối lượng và yêu cầu lưu giữ.', 'Lập phương án thu gom, vận chuyển và lựa chọn giải pháp xử lý.', 'Hỗ trợ hồ sơ bàn giao, theo dõi và quản lý chất thải.'],
            ),
            $this->service(
                'quan-trac-moi-truong',
                'Xây dựng bản đồ tiếng ồn (Noise Map)',
                'xay-dung-ban-do-tieng-on',
                'Hinh-1-768x512.jpg',
                'Xác định nguồn gây ô nhiễm tiếng ồn và xây dựng bản đồ tiếng ồn để đề xuất giải pháp kiểm soát tại cơ sở, nhà máy, xí nghiệp bằng công nghệ IoT và AI.',
                ['Khảo sát nguồn ồn, không gian truyền âm và đối tượng chịu tác động.', 'Đo đạc, mô hình hóa và trực quan hóa phân bố mức ồn.', 'Khoanh vùng ưu tiên và đề xuất giải pháp kiểm soát tiếng ồn.'],
            ),
            $this->service(
                'ky-thuat-xu-ly',
                'Tư vấn, thiết kế và thi công hệ thống xử lý khí thải & nước thải',
                'xu-ly-nuoc-thai',
                '118-1-768x429.png',
                'Tư vấn, thiết kế và thi công hệ thống nhằm xử lý triệt để nước thải, khí thải, hạn chế tối đa tác động xấu đến môi trường.',
                ['Khảo sát nguồn thải, lưu lượng, tải lượng và yêu cầu đầu ra.', 'Lựa chọn công nghệ, thiết kế kỹ thuật và lập phương án đầu tư.', 'Thi công, chạy thử, chuyển giao vận hành và tối ưu hệ thống.'],
            ),
            $this->service(
                'phap-ly-moi-truong',
                'Ứng phó sự cố môi trường',
                'ung-pho-su-co-moi-truong',
                'slide-1.png',
                'Lập kế hoạch, biện pháp, kịch bản và tổ chức diễn tập ứng phó sự cố hóa chất, sự cố tràn dầu và sự cố chất thải.',
                ['Nhận diện kịch bản sự cố, nguồn nguy cơ và phạm vi ảnh hưởng.', 'Xây dựng lực lượng, phương tiện, quy trình thông tin và phối hợp.', 'Tổ chức huấn luyện, diễn tập, đánh giá và cập nhật phương án.'],
            ),
            $this->service(
                'ky-thuat-xu-ly',
                'Nghiên cứu khoa học môi trường',
                'nghien-cuu-khoa-hoc-moi-truong',
                'slide-3.png',
                'Nghiên cứu các yếu tố tự nhiên và nhân tạo tác động đến môi trường như ô nhiễm, biến đổi khí hậu, đa dạng sinh học và tài nguyên thiên nhiên.',
                ['Xây dựng câu hỏi nghiên cứu, phương pháp và kế hoạch thu thập dữ liệu.', 'Tổ chức khảo sát, phân tích và đánh giá kết quả khoa học.', 'Đề xuất giải pháp ứng dụng và chuyển giao kết quả nghiên cứu.'],
            ),
            $this->service(
                'nang-luong-cong-nghe-xanh',
                'Cung cấp giải pháp chuyển đổi công nghệ',
                'giai-phap-chuyen-doi-cong-nghe',
                'Bai-Dang-Bao-Chau-768x429.png',
                'Ứng dụng công nghệ mới để giải quyết vấn đề và nâng cao hiệu quả trong sản xuất, quản lý, môi trường và dịch vụ.',
                ['Đánh giá quy trình hiện tại, điểm nghẽn và nhu cầu chuyển đổi.', 'Lựa chọn giải pháp công nghệ phù hợp với mục tiêu và nguồn lực.', 'Triển khai thử nghiệm, chuyển giao và đo lường hiệu quả.'],
            ),
            $this->service(
                'nang-luong-cong-nghe-xanh',
                'Tư vấn, thiết kế và thi công hệ thống điện mặt trời',
                'he-thong-dien-mat-troi',
                'slide-4.png',
                'Khảo sát, tính toán công suất, thiết kế, lắp đặt và bảo trì hệ thống điện mặt trời, tối ưu hiệu quả năng lượng cho hộ gia đình và doanh nghiệp.',
                ['Khảo sát mặt bằng, phụ tải, bức xạ và điều kiện đấu nối.', 'Tính toán công suất, sản lượng, thiết kế và hiệu quả đầu tư.', 'Thi công, nghiệm thu, giám sát vận hành và bảo trì hệ thống.'],
            ),
            $this->service(
                'quan-trac-moi-truong',
                'Tư vấn, thiết kế và thi công hệ thống quan trắc tự động',
                'he-thong-quan-trac-tu-dong',
                '19-768x432.png',
                'Triển khai hệ thống quan trắc khí thải tự động, liên tục (CEMS) và truyền dữ liệu quan trắc về cơ quan quản lý phục vụ công tác bảo vệ môi trường.',
                ['Khảo sát điểm đo, thông số bắt buộc và hạ tầng truyền dữ liệu.', 'Thiết kế, lựa chọn thiết bị, lắp đặt và tích hợp hệ thống.', 'Hiệu chuẩn, truyền dữ liệu, hướng dẫn vận hành và bảo trì.'],
            ),
            $this->service(
                'khi-nha-kinh-esg',
                'Tư vấn EPR cho doanh nghiệp',
                'tu-van-epr',
                'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png',
                'Hỗ trợ xác định sản phẩm thuộc diện EPR, tính chi phí tái chế hoặc đóng góp tài chính, chuẩn bị báo cáo và xây dựng lộ trình tuân thủ hiệu quả.',
                ['Rà soát danh mục sản phẩm, bao bì và trách nhiệm áp dụng.', 'Tính toán khối lượng, phương án tái chế hoặc đóng góp tài chính.', 'Chuẩn bị hồ sơ báo cáo, lộ trình tuân thủ và truyền thông trách nhiệm môi trường.'],
            ),
        ];
    }

    /**
     * @param  array<int, string>  $scope
     * @return array{category: string, name: string, slug: string, image: string, description: string, scope: array<int, string>}
     */
    private function service(string $category, string $name, string $slug, string $image, string $description, array $scope): array
    {
        return compact('category', 'name', 'slug', 'image', 'description', 'scope');
    }

    /**
     * @param  array{category: string, name: string, slug: string, image: string, description: string, scope: array<int, string>}  $service
     */
    private function buildServiceContent(array $service): string
    {
        $scopeItems = collect($service['scope'])
            ->map(fn (string $item): string => '<li>'.e($item).'</li>')
            ->implode('');

        return <<<HTML
<h2><span id="tong-quan-dich-vu">Tổng quan dịch vụ</span></h2>
<p>{$service['description']}</p>
<p>Môi Trường Bảo Châu đồng hành cùng doanh nghiệp từ bước rà soát nhu cầu, xây dựng phương án đến triển khai, bàn giao và hỗ trợ duy trì kết quả.</p>
<h2><span id="pham-vi-trien-khai">Phạm vi triển khai</span></h2>
<ul>{$scopeItems}</ul>
<h2><span id="quy-trinh-dong-hanh">Quy trình đồng hành</span></h2>
<ol>
<li><strong>Tiếp nhận và khảo sát:</strong> Làm rõ mục tiêu, phạm vi, dữ liệu đầu vào và yêu cầu thực tế tại doanh nghiệp.</li>
<li><strong>Xây dựng giải pháp:</strong> Phân tích dữ liệu, lựa chọn phương pháp và thống nhất kế hoạch triển khai.</li>
<li><strong>Thực hiện và kiểm soát:</strong> Triển khai công việc, kiểm tra chất lượng và phối hợp xử lý các vấn đề phát sinh.</li>
<li><strong>Bàn giao và hỗ trợ:</strong> Hoàn thiện hồ sơ hoặc hệ thống, hướng dẫn áp dụng và hỗ trợ cập nhật khi cần thiết.</li>
</ol>
<h2><span id="gia-tri-mang-lai">Giá trị mang lại</span></h2>
<p>Giải pháp được xây dựng theo hiện trạng và mục tiêu của từng khách hàng, hướng đến hiệu quả vận hành, khả năng tuân thủ và giá trị phát triển bền vững lâu dài.</p>
HTML;
    }
}
