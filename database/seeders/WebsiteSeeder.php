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
        Page::query()->updateOrCreate(['slug' => 'gioi-thieu'], [
            'title' => 'Về Môi Trường Bảo Châu',
            'template' => 'about',
            'excerpt' => 'Đơn vị tư vấn và kỹ thuật môi trường đồng hành cùng doanh nghiệp.',
            'content' => "Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu cung cấp giải pháp pháp lý và kỹ thuật môi trường cho doanh nghiệp.\n\nChúng tôi tập trung vào tính tuân thủ, tiến độ minh bạch và giải pháp có thể vận hành lâu dài, từ hồ sơ môi trường đến quan trắc, kiểm kê khí nhà kính và xử lý chất thải.",
            'status' => ContentStatus::Published,
            'published_at' => $publishedAt,
            'meta_title' => 'Về Môi Trường Bảo Châu - Năng lực tư vấn môi trường',
            'meta_description' => 'Giới thiệu năng lực, đội ngũ và định hướng phục vụ doanh nghiệp của Môi Trường Bảo Châu.',
        ]);
    }

    private function seedServices(CarbonInterface $publishedAt): void
    {
        $serviceCategories = collect([
            ['name' => 'Pháp lý môi trường', 'slug' => 'phap-ly-moi-truong'],
            ['name' => 'Khí nhà kính & ESG', 'slug' => 'khi-nha-kinh-esg'],
            ['name' => 'Quan trắc môi trường', 'slug' => 'quan-trac-moi-truong'],
            ['name' => 'Kỹ thuật xử lý', 'slug' => 'ky-thuat-xu-ly'],
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
        $postCategories = collect([
            ['name' => 'Pháp luật môi trường', 'slug' => 'phap-luat-moi-truong'],
            ['name' => 'Khí nhà kính & ESG', 'slug' => 'khi-nha-kinh-esg'],
            ['name' => 'Kỹ thuật môi trường', 'slug' => 'ky-thuat-moi-truong'],
        ])->mapWithKeys(function (array $category): array {
            $model = PostCategory::query()->updateOrCreate(['slug' => $category['slug']], [...$category, 'is_active' => true]);

            return [$category['slug'] => $model];
        });

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
                'category' => 'phap-luat-moi-truong',
                'title' => 'Hướng Dẫn Thủ Tục Cấp Giấy Phép Môi Trường Mới Nhất Theo Luật BVMT 2020 & Nghị Định 08/2022/NĐ-CP',
                'slug' => 'huong-dan-thu-tuc-cap-giay-phep-moi-truong',
                'image' => 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png',
                'excerpt' => 'Doanh nghiệp có thể tiếp cận nhiều kênh thông tin pháp lý môi trường, nhưng Giấy phép môi trường (GPMT) là văn bản pháp lý tối quan trọng bắt buộc phải hoàn thành trước khi cơ sở đi vào hoạt động chính thức.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'phap-luat-moi-truong',
                'title' => 'Những nội dung cần chuẩn bị cho báo cáo công tác bảo vệ môi trường định kỳ',
                'slug' => 'bao-cao-cong-tac-bao-ve-moi-truong',
                'image' => 'Bai-Dang-Bao-Chau-768x429.png',
                'excerpt' => 'Báo cáo công tác bảo vệ môi trường là nghĩa vụ hàng năm trước ngày 05/01 của mọi cơ sở sản xuất, kinh doanh dịch vụ theo Thông tư 02/2022/TT-BTNMT.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'khi-nha-kinh-esg',
                'title' => 'Doanh nghiệp nào phải thực hiện kiểm kê khí nhà kính theo Quyết định 13/2024/QĐ-TTg?',
                'slug' => 'doanh-nghiep-phai-kiem-ke-khi-nha-kinh',
                'image' => 'Lich-thang-8-768x432.png',
                'excerpt' => 'Danh mục cơ sở phát thải khí nhà kính phải thực hiện kiểm kê định kỳ cập nhật mới nhất theo Quyết định 13/2024/QĐ-TTg của Thủ tướng Chính phủ.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'khi-nha-kinh-esg',
                'title' => 'CBAM và những dữ liệu doanh nghiệp xuất khẩu sang EU cần chuẩn bị ngay',
                'slug' => 'cbam-du-lieu-doanh-nghiep-can-chuan-bi',
                'image' => '1-768x427.png',
                'excerpt' => 'Cơ chế điều chỉnh biên giới carbon (CBAM) của EU bắt đầu áp dụng giai đoạn chuyển tiếp, đặt ra yêu cầu báo cáo phát thải nghiêm ngặt cho hàng xuất khẩu.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'ky-thuat-moi-truong',
                'title' => 'Kiểm soát chất lượng quan trắc môi trường định kỳ theo Thông tư 10/2021/TT-BTNMT',
                'slug' => 'kiem-soat-chat-luong-quan-trac-moi-truong',
                'image' => '3-768x427.png',
                'excerpt' => 'Quy trình đảm bảo chất lượng QA/QC trong quan trắc môi trường nước thải, khí thải, không khí xung quanh đạt chuẩn VIMCERTS.',
                'content' => $gpmtContent,
            ],
            [
                'category' => 'ky-thuat-moi-truong',
                'title' => 'Các dấu hiệu hệ thống xử lý nước thải công nghiệp cần được bảo dưỡng và tối ưu',
                'slug' => 'toi-uu-he-thong-xu-ly-nuoc-thai',
                'image' => '5-768x427.png',
                'excerpt' => 'Nhận biết sớm các sự cố bùn vi sinh, mùi hôi và quá tải công suất để có biện pháp cải tạo, nâng cấp trạm xử lý nước thải kịp thời.',
                'content' => $gpmtContent,
            ],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], [
                'post_category_id' => $postCategories[$post['category']]->getKey(),
                'title' => $post['title'],
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'thumbnail' => $post['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'published_at' => $publishedAt,
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
                'title' => 'Giấy phép môi trường Nhà máy BERICAP Việt Nam',
                'slug' => 'giay-phep-moi-truong-bericap-viet-nam',
                'category' => 'giay-phep',
                'client' => 'Tập đoàn BERICAP (Đức)',
                'location' => 'KCN Long Thành, Đồng Nai',
                'image' => 'BERICAP.jpg',
                'summary' => 'Tư vấn hoàn thiện hồ sơ đề xuất cấp Giấy phép môi trường cấp Bộ Tài nguyên và Môi trường cho nhà máy sản xuất bao bì nhựa định hình 25.000 m².',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho PepsiCo',
                'slug' => 'tu-van-moi-truong-pepsico',
                'category' => 'quan-trac',
                'client' => 'Suntory PepsiCo Việt Nam',
                'location' => 'KCN VSIP 1, Bình Dương',
                'image' => 'PEPSICO.jpg',
                'summary' => 'Tư vấn thiết lập hệ thống kiểm kê phát thải khí nhà kính phạm vi 1 & 2 theo chuẩn quốc tế ISO 14064-1 cho các nhà máy nước giải khát.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Báo Cáo ĐTM Mở Rộng Nhà Máy Bao Bì Nhựa Tân Tiến',
                'slug' => 'ho-so-moi-truong-tan-tien',
                'category' => 'giay-phep',
                'client' => 'Bao Bì Nhựa Tân Tiến',
                'location' => 'KCN Tân Bình, TP. Hồ Chí Minh',
                'image' => 'CTY-TAN-TIEN.png',
                'summary' => 'Lập báo cáo đánh giá tác động môi trường mở rộng quy mô sản xuất bao bì phức hợp công suất 50.000 tấn/năm, bảo vệ thành công trước Sở TN&MT.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Quan trắc môi trường Nhà máy Bao Bì Thành Tiến',
                'slug' => 'quan-trac-moi-truong-bao-bi-thanh-tien',
                'category' => 'quan-trac',
                'client' => 'Bao Bì Thành Tiến',
                'location' => 'Tân Phú, TP. Hồ Chí Minh',
                'image' => 'baobithanhtien.png',
                'summary' => 'Thực hiện đo kiểm môi trường lao động và quan trắc khí thải, nước thải định kỳ 4 đợt/năm cho chuỗi xưởng in ấn sản xuất bao bì.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Kiểm kê khí nhà kính & Lộ trình giảm phát thải Bidrico',
                'slug' => 'kiem-ke-khi-nha-kinh-bidrico',
                'category' => 'khi-nha-kinh',
                'client' => 'Tân Quang Minh (Bidrico)',
                'location' => 'KCN Vĩnh Lộc, TP. Hồ Chí Minh',
                'image' => 'bidrico.png',
                'summary' => 'Tính toán lượng phát thải Scope 1, 2 và tư vấn lộ trình chuyển đổi năng lượng xanh, thu hồi nhiệt thải cho cụm nhà máy đồ uống.',
                'content' => $projectDetailContent,
            ],
            [
                'title' => 'Hệ thống xử lý nước thải sinh hoạt BreadTalk Việt Nam',
                'slug' => 'giai-phap-moi-truong-breadtalk',
                'category' => 'xu-ly-nuoc',
                'client' => 'BreadTalk Việt Nam',
                'location' => 'Bình Tân, TP. Hồ Chí Minh',
                'image' => 'breadtalkvietnam.png',
                'summary' => 'Thiết kế, thi công và chuyển giao công nghệ module tách dầu mỡ kết hợp xử lý vi sinh nước thải chế biến bánh kẹo đạt chuẩn QCVN.',
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
            'company_name' => 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu',
            'logo' => 'assets/images/optimized/logo-bao-chau.webp',
            'favicon' => 'assets/images/cropped-chuan-192x192.png',
            'phone' => '0915 549 148',
            'email' => 'info@baochauenvir.com',
            'address' => '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh',
            'facebook' => 'https://www.facebook.com/moitruongbaochau',
            'youtube' => 'https://www.youtube.com/@moitruongbaochau',
            'zalo' => 'https://zalo.me/0915549148',
            'seo_default_title' => 'Môi Trường Bảo Châu',
            'seo_default_description' => 'Giải pháp tư vấn và kỹ thuật môi trường cho doanh nghiệp.',
            'seo_default_image' => 'assets/images/optimized/og-moi-truong-bao-chau.webp',
        ] as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], [
                'value' => $value,
                'type' => 'string',
                'group' => str_starts_with($key, 'seo_') ? 'seo' : 'general',
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
