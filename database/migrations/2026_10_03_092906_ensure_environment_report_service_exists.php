<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $slug = 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky';
        if (DB::table('services')->where('slug', $slug)->exists()) {
            return;
        }

        DB::table('services')->insert([
            'slug' => $slug,
            'name' => 'Báo cáo công tác bảo vệ môi trường năm 2026',
            'service_category_id' => DB::table('service_categories')->where('slug', 'phap-ly-moi-truong')->value('id'),
            'short_description' => 'Thu thập thông tin, số liệu và hồ sơ phục vụ Báo cáo công tác bảo vệ môi trường năm 2026.',
            'content' => <<<'HTML'
<h2>Chuẩn bị thông tin cho báo cáo công tác BVMT 2026</h2>
<p>Doanh nghiệp cung cấp thông tin liên hệ, sản phẩm và sản lượng, nhiên liệu sử dụng, công trình xử lý nước thải và khí thải, lượng chất thải phát sinh và các hồ sơ liên quan.</p>
<h2>Điền phiếu khảo sát theo 7 bước</h2>
<p>Bấm “Điền biểu mẫu ngay” để khai báo. Có thể lưu nháp, quay lại chỉnh sửa và lưu link riêng để tiếp tục trên thiết bị khác.</p>
<h2>Báo cáo và số liệu năm 2025</h2>
<p>Nếu đã có Báo cáo công tác BVMT năm 2025, hãy tải hồ sơ ở bước 1. Khi đó không cần nhập lại số liệu năm 2025 trong các bảng khảo sát.</p>
<h2>Hồ sơ đính kèm và xác nhận</h2>
<p>Chuẩn bị giấy tờ pháp lý, giấy phép môi trường, hóa đơn và chứng từ liên quan. Kiểm tra thông tin ở bước cuối trước khi gửi phiếu cho Bảo Châu.</p>
HTML,
            'status' => 'published',
            'published_at' => now(),
            'meta_title' => 'Báo cáo công tác bảo vệ môi trường năm 2026',
            'meta_description' => 'Phiếu khảo sát 7 bước phục vụ Báo cáo công tác BVMT 2026, hỗ trợ lưu nháp, khai báo số liệu và tải hồ sơ doanh nghiệp.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Preserve CMS content on rollback because it may have been edited after creation.
     */
    public function down(): void {}
};
