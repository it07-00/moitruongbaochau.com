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
        $projects = [
            ['title' => 'Giấy phép môi trường Nhà máy BERICAP Việt Nam', 'slug' => 'giay-phep-moi-truong-bericap-viet-nam', 'category' => 'giay-phep', 'client' => 'BERICAP Việt Nam', 'image' => 'BERICAP.jpg'],
            ['title' => 'Tư vấn môi trường cho PEPSICO', 'slug' => 'tu-van-moi-truong-pepsico', 'category' => 'quan-trac', 'client' => 'PEPSICO', 'image' => 'PEPSICO.jpg'],
            ['title' => 'Hồ sơ môi trường Công ty Tân Tiến', 'slug' => 'ho-so-moi-truong-tan-tien', 'category' => 'giay-phep', 'client' => 'Công ty Tân Tiến', 'image' => 'CTY-TAN-TIEN-1024x640.png'],
            ['title' => 'Quan trắc môi trường Công ty Bảo Bì Thành Tiến', 'slug' => 'quan-trac-moi-truong-bao-bi-thanh-tien', 'category' => 'quan-trac', 'client' => 'Bảo Bì Thành Tiến', 'image' => 'baobithanhtien.png'],
            ['title' => 'Kiểm kê khí nhà kính Bidrico', 'slug' => 'kiem-ke-khi-nha-kinh-bidrico', 'category' => 'khi-nha-kinh', 'client' => 'Bidrico', 'image' => 'bidrico.png'],
            ['title' => 'Giải pháp xử lý môi trường BreadTalk Việt Nam', 'slug' => 'giai-phap-moi-truong-breadtalk', 'category' => 'xu-ly-nuoc', 'client' => 'BreadTalk Việt Nam', 'image' => 'breadtalkvietnam.png'],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], [
                'title' => $project['title'],
                'category' => $project['category'],
                'client' => $project['client'],
                'location' => 'Việt Nam',
                'summary' => 'Dự án được triển khai theo phạm vi, tiến độ và yêu cầu tuân thủ đã thống nhất với khách hàng.',
                'content' => "Bảo Châu thực hiện khảo sát, tổng hợp dữ liệu và kiểm soát chất lượng hồ sơ trước khi bàn giao.\n\nKết quả dự án giúp doanh nghiệp chủ động nghĩa vụ pháp lý và duy trì hoạt động ổn định.",
                'thumbnail' => $project['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'published_at' => $publishedAt,
                'completed_at' => today(),
                'meta_title' => $project['title'],
                'meta_description' => 'Dự án '.$project['title'].' do Môi Trường Bảo Châu thực hiện.',
            ]);
        }
    }

    private function seedJobs(CarbonInterface $publishedAt): void
    {
        foreach ([
            ['title' => 'Kỹ sư ĐTM & Giấy phép môi trường', 'slug' => 'ky-su-dtm-giay-phep-moi-truong'],
            ['title' => 'Chuyên viên kiểm kê khí nhà kính', 'slug' => 'chuyen-vien-kiem-ke-khi-nha-kinh'],
            ['title' => 'Nhân viên kinh doanh dịch vụ môi trường', 'slug' => 'nhan-vien-kinh-doanh-dich-vu-moi-truong'],
        ] as $job) {
            JobPosting::query()->updateOrCreate(['slug' => $job['slug']], [
                'title' => $job['title'],
                'location' => 'TP. Hồ Chí Minh',
                'employment_type' => 'Toàn thời gian',
                'summary' => 'Cơ hội làm việc trong môi trường chuyên nghiệp, chú trọng năng lực và sự phát triển lâu dài.',
                'content' => 'Phối hợp với đội ngũ chuyên môn để triển khai công việc đúng phạm vi, tiến độ và tiêu chuẩn chất lượng.',
                'requirements' => 'Tốt nghiệp chuyên ngành phù hợp, giao tiếp rõ ràng, chủ động học hỏi và có tinh thần trách nhiệm.',
                'benefits' => 'Thu nhập theo năng lực, đào tạo chuyên môn, đầy đủ chế độ và lộ trình phát triển rõ ràng.',
                'status' => ContentStatus::Published,
                'published_at' => $publishedAt,
                'expires_at' => now()->addMonths(3),
                'meta_title' => 'Tuyển dụng '.$job['title'].' - Môi Trường Bảo Châu',
                'meta_description' => 'Thông tin tuyển dụng vị trí '.$job['title'].' tại Môi Trường Bảo Châu.',
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
