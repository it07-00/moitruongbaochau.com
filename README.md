# Môi Trường Bảo Châu

Website doanh nghiệp và CMS nội bộ cho `moitruongbaochau.com`, xây dựng bằng Laravel 13, PHP 8.3 và theme Tailwind CSS v4 đã compile. Source quản lý trang, dịch vụ, bài viết, dự án, tuyển dụng, media, menu, thông tin website, liên hệ khách hàng và redirect SEO.

## Yêu cầu

- PHP 8.3+ với các extension: Ctype, cURL, DOM, Fileinfo, GD, Intl, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML và Zip.
- Composer 2.8+.
- Node.js 24+ và npm 11+ nếu cần build asset Vite mặc định của Laravel.
- SQLite cho local hoặc MySQL/MariaDB cho production.

## Cài đặt local

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

Mặc định website chạy tại `http://localhost:8000`. Không commit file `.env`, mật khẩu hoặc credential production.

## Cấu hình môi trường

Các biến quan trọng:

```env
APP_NAME="Môi Trường Bảo Châu"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Ho_Chi_Minh
APP_LOCALE=vi
APP_FALLBACK_LOCALE=vi

DB_CONNECTION=sqlite
ADMIN_EMAIL=
```

Production phải dùng `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://moitruongbaochau.com`, HTTPS và thông tin database riêng.

## Tạo tài khoản quản trị

Không có mật khẩu mặc định trong repository. Tạo hoặc nâng quyền tài khoản bằng command tương tác:

```powershell
php artisan admin:create
```

Sau đó đăng nhập tại `/admin/login`. Command yêu cầu mật khẩu tối thiểu 12 ký tự gồm chữ hoa, chữ thường, số và ký hiệu.

## Dữ liệu và storage

```powershell
php artisan migrate
php artisan db:seed --class=WebsiteSeeder
php artisan storage:link
```

Seeder có thể chạy lại an toàn bằng `updateOrCreate`. Upload được lưu trên disk `public` dưới `storage/app/public/media`; chỉ JPG, JPEG, PNG và WebP tối đa 5 MB được chấp nhận.

## Chạy và build frontend

Asset theme production nằm trong `public/assets`. Vite vẫn được giữ cho phần frontend có nhu cầu build thêm:

```powershell
npm run dev
npm run build
```

Nếu thay đổi CSS/JS qua Vite mà giao diện chưa cập nhật, chạy lại một trong hai command trên.

## Kiểm thử và chất lượng code

```powershell
php artisan test --compact
vendor\bin\pint --format agent
composer audit
npm run build
```

Feature Test bao phủ homepage, trang chi tiết, trạng thái xuất bản, form liên hệ, admin authentication/authorization, CMS vận hành, upload an toàn, SEO meta/schema, sitemap và redirect.

## Cấu trúc chính

```text
app/
├── Console/Commands/       # Command tạo admin
├── Http/Controllers/
│   ├── Frontend/           # Website công khai
│   └── Admin/              # CMS bảo vệ bởi auth + admin
├── Http/Requests/          # Validation và upload policy
├── Models/                 # Nội dung và dữ liệu vận hành
├── Services/               # Cache menu/settings
└── Support/                # Dữ liệu SEO

resources/views/
├── components/             # SEO, breadcrumb, header/footer, card
├── frontend/               # Trang công khai
├── admin/                  # CMS
└── errors/                 # 403/404/419/429/500/503

routes/
├── web.php                 # Frontend, sitemap, robots, fallback redirect
└── admin.php               # Admin authentication và CMS
```

## Checklist triển khai production

1. Cấu hình DNS trỏ domain và `www` về server; chọn một host canonical.
2. Cài SSL, ép HTTPS tại web server/proxy và kiểm tra mixed content.
3. Chọn PHP 8.3+ và bật đủ extension.
4. Deploy source, sau đó chạy:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize
   ```

5. Cấu hình `.env` production, database, mail, session/cache/queue và backup; không đặt secret trong source.
6. Đảm bảo `storage` và `bootstrap/cache` có quyền ghi.
7. Cấu hình cron `* * * * * php artisan schedule:run` và supervisor cho queue nếu chuyển mail/job sang queue.
8. Tạo admin bằng `php artisan admin:create` trong terminal bảo mật.
9. Kiểm tra `/robots.txt`, `/sitemap.xml`, canonical, Open Graph, schema và HTTP status của error page.
10. Khai báo Google Search Console, Analytics/Tag Manager theo chính sách cookie thực tế.
11. Thiết lập backup database + upload và kiểm thử khôi phục định kỳ.

Shared hosting không có SSH có thể build `vendor` và frontend ở máy local cùng phiên bản PHP, upload source đã build, rồi chạy migration bằng terminal của hosting. Không upload `.env` qua kho Git công khai.

## Migration SEO từ website cũ

Trước khi đổi DNS hoặc source production:

1. Crawl toàn bộ URL hiện hữu và xuất dữ liệu từ Search Console/Analytics.
2. Phân loại URL đang có index, traffic, backlink hoặc nội dung có giá trị.
3. Map từng URL cũ sang URL mới trong module `/admin/redirects`; không redirect hàng loạt về homepage.
4. Giữ nội dung/title quan trọng hoặc chuyển nội dung tương đương trước khi bật redirect 301.
5. Crawl lại staging để phát hiện 404, redirect chain/loop, canonical sai và asset lỗi.
6. Sau deploy, theo dõi Coverage, Page indexing, Core Web Vitals và lỗi 404 trong Search Console.

Seeder đã tạo redirect cho 10 URL `.html` của theme mới. Danh sách website cũ ngoài theme vẫn phải được crawl và map trước khi go-live.
