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

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(['slug' => $service['slug']], [
                'service_category_id' => $serviceCategories[$service['category']]->getKey(),
                'name' => $service['name'],
                'short_description' => 'Khảo sát đúng nhu cầu, xây dựng hồ sơ và đồng hành giải trình theo quy định hiện hành.',
                'content' => "Bảo Châu tiếp nhận thông tin dự án, rà soát nghĩa vụ pháp lý và đề xuất phạm vi công việc phù hợp.\n\nQuy trình triển khai gồm khảo sát, thu thập dữ liệu, lập hồ sơ, kiểm soát chất lượng và đồng hành với doanh nghiệp trong quá trình thẩm định hoặc vận hành.",
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

        $posts = [
            ['category' => 'phap-luat-moi-truong', 'title' => 'Hướng dẫn thủ tục cấp giấy phép môi trường mới nhất', 'slug' => 'huong-dan-thu-tuc-cap-giay-phep-moi-truong', 'image' => 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png'],
            ['category' => 'phap-luat-moi-truong', 'title' => 'Những nội dung cần chuẩn bị cho báo cáo công tác bảo vệ môi trường', 'slug' => 'bao-cao-cong-tac-bao-ve-moi-truong', 'image' => 'Bai-Dang-Bao-Chau-768x429.png'],
            ['category' => 'khi-nha-kinh-esg', 'title' => 'Doanh nghiệp nào phải thực hiện kiểm kê khí nhà kính?', 'slug' => 'doanh-nghiep-phai-kiem-ke-khi-nha-kinh', 'image' => 'Lich-thang-8-768x432.png'],
            ['category' => 'khi-nha-kinh-esg', 'title' => 'CBAM và những dữ liệu doanh nghiệp xuất khẩu cần chuẩn bị', 'slug' => 'cbam-du-lieu-doanh-nghiep-can-chuan-bi', 'image' => '1-768x427.png'],
            ['category' => 'ky-thuat-moi-truong', 'title' => 'Kiểm soát chất lượng quan trắc môi trường định kỳ', 'slug' => 'kiem-soat-chat-luong-quan-trac-moi-truong', 'image' => '3-768x427.png'],
            ['category' => 'ky-thuat-moi-truong', 'title' => 'Các dấu hiệu hệ thống xử lý nước thải cần được tối ưu', 'slug' => 'toi-uu-he-thong-xu-ly-nuoc-thai', 'image' => '5-768x427.png'],
        ];

        foreach ($posts as $post) {
            Post::query()->updateOrCreate(['slug' => $post['slug']], [
                'post_category_id' => $postCategories[$post['category']]->getKey(),
                'title' => $post['title'],
                'excerpt' => 'Tóm tắt quy định và các bước triển khai thực tế dành cho doanh nghiệp.',
                'content' => "Bài viết tổng hợp các yêu cầu quan trọng và cách chuẩn bị dữ liệu theo hướng dễ kiểm soát.\n\nDoanh nghiệp nên rà soát hồ sơ hiện có, xác định đầu mối phụ trách và xây dựng lịch thực hiện trước thời hạn pháp lý.",
                'thumbnail' => $post['image'],
                'status' => ContentStatus::Published,
                'is_featured' => true,
                'published_at' => $publishedAt,
                'meta_title' => $post['title'],
                'meta_description' => 'Hướng dẫn thực tế về '.$post['title'].'.',
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
