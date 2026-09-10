<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class UpdateServiceContentSeeder extends Seeder
{
    /**
     * Cập nhật nội dung chi tiết cho 8 dịch vụ môi trường theo văn bản pháp luật mới nhất (đến 09/2026).
     */
    public function run(): void
    {
        $services = $this->getServiceContentData();

        foreach ($services as $slug => $content) {
            Service::query()->where('slug', $slug)->update(['content' => $content]);
            $this->command->info("✅ Đã cập nhật: {$slug}");
        }

        $this->command->info('🎉 Hoàn tất cập nhật nội dung 8 dịch vụ môi trường.');
    }

    /**
     * @return array<string, string>
     */
    private function getServiceContentData(): array
    {
        return [
            'bao-cao-danh-gia-tac-dong-moi-truong' => $this->contentDTM(),
            'giay-phep-moi-truong' => $this->contentGPMT(),
            'kiem-ke-khi-nha-kinh' => $this->contentKNK(),
            'tu-van-cbam-esg-lca' => $this->contentCBAM(),
            'quan-trac-moi-truong-dinh-ky' => $this->contentQuanTracDinhKy(),
            'quan-trac-moi-truong-lao-dong' => $this->contentQuanTracLaoDong(),
            'xu-ly-nuoc-thai' => $this->contentXuLyNuocThai(),
            'xu-ly-khi-thai-cong-nghiep' => $this->contentXuLyKhiThai(),
        ];
    }

    // ─── 1. BÁO CÁO ĐÁNH GIÁ TÁC ĐỘNG MÔI TRƯỜNG (ĐTM) ──────────────────

    private function contentDTM(): string
    {
        return <<<'HTML'
<h2><span id="dtm-la-gi">Báo cáo đánh giá tác động môi trường (ĐTM) là gì?</span></h2>
<p>Theo <strong>Khoản 7 Điều 3 Luật Bảo vệ Môi trường 2020</strong>: Đánh giá tác động môi trường là quá trình phân tích, dự báo các tác động đến môi trường của dự án đầu tư cụ thể để đưa ra biện pháp bảo vệ môi trường khi triển khai dự án đó.</p>
<p>ĐTM là thủ tục pháp lý <strong>bắt buộc trước khi phê duyệt dự án</strong>, giúp cơ quan nhà nước đánh giá mức độ ảnh hưởng của dự án lên môi trường tự nhiên, xã hội và đề ra các biện pháp giảm thiểu, xử lý phù hợp.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Báo cáo đánh giá tác động môi trường ĐTM" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hồ sơ báo cáo ĐTM theo Nghị định 08/2022/NĐ-CP (sửa đổi bởi NĐ 48/2026/NĐ-CP)</figcaption>
</figure>

<h2><span id="doi-tuong-lap-dtm">Đối tượng phải lập báo cáo ĐTM</span></h2>
<p>Căn cứ <strong>Điều 30 Luật BVMT 2020</strong> và <strong>Nghị định 48/2026/NĐ-CP</strong>, các đối tượng sau bắt buộc phải lập báo cáo ĐTM:</p>
<div class="space-y-3 my-4 text-black">
    <p><strong>1. Dự án đầu tư Nhóm I:</strong> Dự án có nguy cơ tác động xấu đến môi trường ở mức độ cao, bao gồm dự án thuộc loại hình sản xuất, kinh doanh có nguy cơ gây ô nhiễm môi trường; dự án thực hiện dịch vụ xử lý chất thải nguy hại; dự án có nhập khẩu phế liệu làm nguyên liệu sản xuất.</p>
    <p><strong>2. Dự án đầu tư Nhóm II:</strong> Có yếu tố nhạy cảm về môi trường (nằm trong hoặc liền kề khu bảo tồn, rừng phòng hộ, di sản thiên nhiên) hoặc sử dụng đất, đất có mặt nước từ 10 ha trở lên; sử dụng khu vực biển trên 100 ha.</p>
</div>

<h2><span id="diem-moi-2026">Điểm mới quan trọng từ Nghị định 48/2026/NĐ-CP</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>ĐTM theo giai đoạn:</strong> Chủ dự án được phép lựa chọn lập ĐTM cho từng giai đoạn hoặc lập ĐTM tổng thể cho toàn bộ dự án. Nếu lập theo từng giai đoạn, báo cáo giai đoạn sau phải kế thừa và cập nhật nội dung từ các giai đoạn trước.</li>
    <li><strong>Phân cấp mạnh cho địa phương:</strong> UBND cấp tỉnh được trao thêm thẩm quyền thẩm định ĐTM, giảm tải cho cấp Bộ và rút ngắn thời gian xử lý.</li>
    <li><strong>Chuyển từ "tiền kiểm" sang "hậu kiểm":</strong> Tập trung đánh giá mức độ phát sinh chất thải và nguy cơ tác động thực tế thay vì chỉ nhìn vào quy mô dự án.</li>
    <li><strong>Rút ngắn thời gian thẩm định:</strong> Dự án Nhóm I giảm từ 45 ngày xuống còn tối đa <strong>30 ngày làm việc</strong> (theo Thông tư 09/2026/TT-BNNMT).</li>
</ul>

<h2><span id="tham-quyen-tham-dinh-dtm">Thẩm quyền thẩm định báo cáo ĐTM</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Cơ Quan Thẩm Định</th>
                <th class="p-3 border border-gray-200">Nhóm Dự Án</th>
                <th class="p-3 border border-gray-200">Thời Gian (NĐ 48/2026)</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Bộ TN&amp;MT / Bộ NN&amp;MT</td>
                <td class="p-3 border border-gray-200 text-black">Dự án Nhóm I nguy cơ cao, dự án liên tỉnh, dự án cấp Bộ phê duyệt</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">30 ngày làm việc</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">UBND Cấp Tỉnh / Sở TN&amp;MT</td>
                <td class="p-3 border border-gray-200 text-black">Dự án Nhóm I, Nhóm II được phân cấp theo NĐ 48/2026</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">20–25 ngày làm việc</td>
            </tr>
        </tbody>
    </table>
</div>

<h2><span id="quy-trinh-dtm">Quy trình tư vấn lập ĐTM trọn gói tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="dtm-b1" class="font-bold text-base text-black">1. Khảo sát thực địa &amp; Thu thập dữ liệu</h3>
    <p class="text-sm text-black">Đội ngũ kỹ sư khảo sát hiện trạng nhà máy/dự án, thu thập hồ sơ pháp lý, lấy mẫu phân tích các thông số môi trường nền (nước mặt, nước ngầm, không khí, đất, tiếng ồn).</p>

    <h3 id="dtm-b2" class="font-bold text-base text-black">2. Lập báo cáo ĐTM theo biểu mẫu NĐ 48/2026</h3>
    <p class="text-sm text-black">Xây dựng thuyết minh kỹ thuật chi tiết: mô tả dự án, dự báo nguồn thải, đánh giá tác động, đề xuất công trình BVMT và chương trình quản lý, giám sát môi trường theo đúng Phụ lục Nghị định 08/2022 (sửa đổi bởi NĐ 48/2026).</p>

    <h3 id="dtm-b3" class="font-bold text-base text-black">3. Tham vấn cộng đồng &amp; Nộp hồ sơ</h3>
    <p class="text-sm text-black">Tổ chức tham vấn cộng đồng dân cư, UBND cấp xã và các tổ chức liên quan. Đăng tải trên cổng thông tin điện tử và nộp hồ sơ tại bộ phận một cửa cơ quan có thẩm quyền.</p>

    <h3 id="dtm-b4" class="font-bold text-base text-black">4. Bảo vệ trước Hội đồng thẩm định</h3>
    <p class="text-sm text-black">Đại diện chủ đầu tư thuyết minh kỹ thuật trước Hội đồng, đoàn kiểm tra thực tế tại dự án, giải trình bổ sung theo biên bản kết luận.</p>

    <h3 id="dtm-b5" class="font-bold text-base text-black">5. Nhận Quyết định phê duyệt &amp; Bàn giao</h3>
    <p class="text-sm text-black">Nhận Quyết định phê duyệt báo cáo ĐTM chính thức, bàn giao tận tay khách hàng cùng toàn bộ hồ sơ kỹ thuật và hướng dẫn thực hiện cam kết BVMT trong giai đoạn thi công, vận hành.</p>
</div>

<h2><span id="loi-ich-dtm">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Cam kết <strong>100% hồ sơ ĐTM được phê duyệt</strong> đúng tiến độ cam kết.</li>
    <li>Đội ngũ Thạc sĩ, Kỹ sư môi trường <strong>hơn 10 năm kinh nghiệm</strong> trực tiếp bảo vệ trước Hội đồng thẩm định cấp Bộ và cấp Tỉnh.</li>
    <li>Luôn cập nhật văn bản mới nhất: NĐ 48/2026/NĐ-CP, NĐ 05/2025/NĐ-CP, Luật 146/2025/QH15.</li>
    <li>Hỗ trợ pháp lý dài hạn: tư vấn chuyển tiếp sang thủ tục cấp Giấy phép môi trường sau khi phê duyệt ĐTM.</li>
</ul>
HTML;
    }

    // ─── 2. GIẤY PHÉP MÔI TRƯỜNG (GPMT) ────────────────────────────────────

    private function contentGPMT(): string
    {
        return <<<'HTML'
<h2><span id="gpmt-la-gi">Giấy phép môi trường là gì?</span></h2>
<p>Theo quy định tại <strong>Khoản 8 Điều 3 Luật Bảo vệ Môi trường 2020</strong>: Giấy phép môi trường là văn bản do cơ quan quản lý nhà nước có thẩm quyền cấp cho tổ chức, cá nhân có hoạt động sản xuất, kinh doanh, dịch vụ được phép xả chất thải ra môi trường, quản lý chất thải, nhập khẩu phế liệu từ nước ngoài làm nguyên liệu sản xuất kèm theo yêu cầu, điều kiện về bảo vệ môi trường theo quy định của pháp luật.</p>
<p>Điểm mới đột phá của <strong>Luật BVMT 2020</strong> là tích hợp <strong>7 loại giấy phép môi trường thành phần</strong> trước đây (như Giấy phép xả nước thải, Giấy xác nhận hoàn thành công trình BVMT, Sổ chủ nguồn thải CTNH, Giấy phép xả khí thải,...) thành <strong>01 Giấy phép môi trường duy nhất</strong>.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Giấy phép môi trường theo Luật BVMT 2020" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hồ sơ đề nghị cấp Giấy phép môi trường theo NĐ 08/2022/NĐ-CP (sửa đổi bởi NĐ 48/2026/NĐ-CP)</figcaption>
</figure>

<h2><span id="vi-sao-can-gpmt">Vì sao doanh nghiệp cần hoàn thiện Giấy phép môi trường?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Hợp thức hóa hồ sơ pháp lý để nghiệm thu xây dựng và đưa dự án vào vận hành chính thức.</li>
    <li>Tránh bị xử phạt vi phạm hành chính: mức phạt từ <strong>30–220 triệu đồng</strong> (cá nhân), <strong>gấp đôi đối với tổ chức</strong>, kèm đình chỉ hoạt động 3–6 tháng theo <strong>Nghị định 45/2022/NĐ-CP</strong>.</li>
    <li>Đáp ứng tiêu chuẩn đánh giá nhà máy từ các đối tác FDI và khách hàng quốc tế.</li>
    <li>Được chuyên gia tư vấn tối ưu hóa quy trình xử lý chất thải, tiết kiệm chi phí vận hành.</li>
</ul>

<h2><span id="doi-tuong-gpmt">Đối tượng bắt buộc phải có Giấy phép môi trường</span></h2>
<p>Căn cứ <strong>Điều 39 Luật BVMT 2020</strong>, các đối tượng sau bắt buộc phải có Giấy phép môi trường:</p>
<div class="space-y-3 my-4 text-black">
    <p><strong>1. Dự án đầu tư Nhóm I, Nhóm II và Nhóm III:</strong> Có phát sinh nước thải, bụi, khí thải xả ra môi trường phải được xử lý hoặc có phát sinh chất thải nguy hại phải được quản lý.</p>
    <p><strong>2. Cơ sở sản xuất, kinh doanh, dịch vụ đang hoạt động:</strong> Có tiêu chí về môi trường tương đương dự án Nhóm I, Nhóm II và Nhóm III.</p>
</div>

<h2><span id="diem-moi-gpmt-2026">Điểm mới quan trọng 2025–2026</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>Bãi bỏ thủ tục "cấp đổi" GPMT</strong> theo <strong>Luật số 146/2025/QH15</strong> để đồng bộ hóa hệ thống pháp luật.</li>
    <li><strong>Tích hợp/Chia tách GPMT:</strong> Cho phép tích hợp GPMT cho các dự án cùng địa điểm, cùng chủ đầu tư hoặc dự án liền kề sử dụng chung hệ thống xử lý chất thải. Quy trình chia tách cũng được quy định cụ thể tại <strong>NĐ 48/2026/NĐ-CP</strong>.</li>
    <li><strong>Điều chỉnh GPMT:</strong> Bổ sung quy định yêu cầu điều chỉnh GPMT khi bổ sung phương án chuyển giao/tiếp nhận nước thải hoặc phương án tái sử dụng nước thải.</li>
    <li><strong>Rút ngắn thời gian thẩm định:</strong> Dự án Nhóm I giảm từ 45 ngày xuống tối đa <strong>30 ngày</strong> (theo TT 09/2026/TT-BNNMT).</li>
    <li><strong>Đẩy mạnh phân cấp:</strong> UBND cấp tỉnh được trao thêm nhiều thẩm quyền theo NĐ 48/2026.</li>
</ul>

<h2><span id="tham-quyen-gpmt">Thẩm quyền thẩm định &amp; cấp Giấy phép môi trường</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Cơ Quan Cấp Phép</th>
                <th class="p-3 border border-gray-200">Nhóm Dự Án Phụ Trách</th>
                <th class="p-3 border border-gray-200">Thời Gian (NĐ 48/2026)</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Bộ TN&amp;MT / Bộ NN&amp;MT</td>
                <td class="p-3 border border-gray-200 text-black">Dự án Nhóm I nguy cơ cao, dự án liên tỉnh, dự án cấp Bộ phê duyệt ĐTM</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">30 ngày làm việc</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">UBND Cấp Tỉnh / Sở TN&amp;MT</td>
                <td class="p-3 border border-gray-200 text-black">Dự án Nhóm II và Nhóm III nằm trên địa bàn 2 huyện trở lên</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">20 ngày làm việc</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">UBND Cấp Huyện</td>
                <td class="p-3 border border-gray-200 text-black">Dự án Nhóm III còn lại nằm trên địa bàn 1 huyện</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">15 ngày làm việc</td>
            </tr>
        </tbody>
    </table>
</div>

<h2><span id="quy-trinh-gpmt">Quy trình tư vấn trọn gói tại Môi Trường Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="gpmt-b1" class="font-bold text-base text-black">1. Khảo sát &amp; Đo đạc hiện trạng</h3>
    <p class="text-sm text-black">Đội ngũ kỹ sư khảo sát thực tế, lấy mẫu phân tích các nguồn thải nước thải, khí thải và kiểm tra hiện trạng công trình BVMT.</p>

    <h3 id="gpmt-b2" class="font-bold text-base text-black">2. Lập báo cáo đề xuất cấp phép</h3>
    <p class="text-sm text-black">Tính toán tải lượng phát thải, hoàn thiện thuyết minh báo cáo theo đúng mẫu chuẩn Phụ lục Nghị định 08/2022/NĐ-CP (sửa đổi bởi NĐ 48/2026/NĐ-CP).</p>

    <h3 id="gpmt-b3" class="font-bold text-base text-black">3. Tham vấn cộng đồng &amp; Nộp hồ sơ</h3>
    <p class="text-sm text-black">Đăng tải tham vấn trên cổng thông tin điện tử, nộp hồ sơ tại bộ phận một cửa của Cơ quan có thẩm quyền.</p>

    <h3 id="gpmt-b4" class="font-bold text-base text-black">4. Bảo vệ trước Hội đồng thẩm định</h3>
    <p class="text-sm text-black">Đại diện chủ đầu tư thuyết minh kỹ thuật, cùng đoàn kiểm tra thực tế nhà máy và giải trình bổ sung theo biên bản họp.</p>

    <h3 id="gpmt-b5" class="font-bold text-base text-black">5. Bàn giao Giấy phép &amp; Hướng dẫn vận hành</h3>
    <p class="text-sm text-black">Nhận Giấy phép môi trường gốc đóng dấu chính thức và bàn giao tận tay khách hàng. Hướng dẫn thực hiện các cam kết trong GPMT.</p>
</div>

<h2><span id="loi-ich-gpmt">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Cam kết <strong>100% hồ sơ được phê duyệt</strong> đúng tiến độ.</li>
    <li>Đội ngũ Thạc sĩ, Kỹ sư môi trường hơn 10 năm kinh nghiệm trực tiếp bảo vệ trước cơ quan chức năng.</li>
    <li>Luôn cập nhật NĐ 48/2026/NĐ-CP, NĐ 05/2025/NĐ-CP, Luật 146/2025/QH15.</li>
    <li>Hỗ trợ pháp lý dài hạn và cập nhật các quy định luật mới nhất cho doanh nghiệp.</li>
</ul>
HTML;
    }

    // ─── 3. KIỂM KÊ KHÍ NHÀ KÍNH ──────────────────────────────────────────

    private function contentKNK(): string
    {
        return <<<'HTML'
<h2><span id="knk-la-gi">Kiểm kê khí nhà kính là gì?</span></h2>
<p>Kiểm kê khí nhà kính (KNK) là quá trình <strong>thu thập dữ liệu, đo đạc, tính toán và báo cáo</strong> tổng lượng phát thải 7 loại khí nhà kính chính (CO₂, CH₄, N₂O, HFCs, PFCs, SF₆, NF₃) từ các hoạt động sản xuất, kinh doanh của cơ sở. Đây là nghĩa vụ pháp lý bắt buộc theo <strong>Luật BVMT 2020</strong> và <strong>Nghị định 06/2022/NĐ-CP</strong> (sửa đổi bởi NĐ 119/2025/NĐ-CP).</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Kiểm kê khí nhà kính doanh nghiệp" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Quy trình kiểm kê KNK theo NĐ 06/2022 (sửa đổi bởi NĐ 119/2025) và QĐ 42/2026/QĐ-TTg</figcaption>
</figure>

<h2><span id="doi-tuong-knk">Đối tượng phải thực hiện kiểm kê KNK</span></h2>
<p>Theo <strong>Quyết định 42/2026/QĐ-TTg</strong> (có hiệu lực từ 25/09/2026, thay thế QĐ 13/2024), danh mục cơ sở phải kiểm kê KNK đã tăng lên <strong>2.441 cơ sở</strong> thuộc 6 lĩnh vực:</p>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>Năng lượng:</strong> Nhà máy điện, lọc dầu, khai thác than, dầu khí</li>
    <li><strong>Giao thông vận tải:</strong> Đường bộ, đường sắt, hàng hải, hàng không</li>
    <li><strong>Xây dựng:</strong> Sản xuất xi măng, kính, gạch, vật liệu xây dựng</li>
    <li><strong>Các quá trình công nghiệp:</strong> Hóa chất, kim loại, điện tử</li>
    <li><strong>Nông nghiệp, lâm nghiệp và sử dụng đất</strong></li>
    <li><strong>Chất thải:</strong> Bãi chôn lấp, xử lý nước thải</li>
</ul>

<h2><span id="diem-moi-knk-2026">Điểm mới quan trọng 2025–2026</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>NĐ 119/2025/NĐ-CP</strong> (hiệu lực 01/08/2025): Sửa đổi NĐ 06/2022, hoàn thiện cơ chế phân bổ hạn ngạch phát thải và phát triển thị trường carbon.</li>
    <li><strong>QĐ 42/2026/QĐ-TTg</strong> (hiệu lực 25/09/2026): Cập nhật danh mục 2.441 cơ sở phải kiểm kê KNK.</li>
    <li><strong>Thị trường carbon thí điểm:</strong> Giai đoạn 2025–2028 triển khai thí điểm sàn giao dịch tín chỉ carbon và phân bổ hạn ngạch cho nhóm phát thải trọng điểm, tiến tới vận hành chính thức từ năm 2029.</li>
    <li><strong>Phương pháp kiểm kê:</strong> Áp dụng theo tiêu chuẩn GHG Protocol, ISO 14064-1 cho phạm vi phát thải Scope 1 (trực tiếp), Scope 2 (năng lượng mua), Scope 3 (chuỗi giá trị).</li>
</ul>

<h2><span id="quy-trinh-knk">Quy trình kiểm kê KNK tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="knk-b1" class="font-bold text-base text-black">1. Rà soát &amp; Xác định ranh giới kiểm kê</h3>
    <p class="text-sm text-black">Xác định phạm vi, ranh giới tổ chức và hoạt động cần kiểm kê theo tiêu chuẩn GHG Protocol/ISO 14064-1.</p>

    <h3 id="knk-b2" class="font-bold text-base text-black">2. Thu thập dữ liệu &amp; Tính toán phát thải</h3>
    <p class="text-sm text-black">Thu thập số liệu tiêu thụ nhiên liệu, điện năng, nguyên vật liệu. Áp dụng hệ số phát thải quốc gia/IPCC để tính toán tổng lượng phát thải CO₂e.</p>

    <h3 id="knk-b3" class="font-bold text-base text-black">3. Lập báo cáo kiểm kê KNK</h3>
    <p class="text-sm text-black">Xây dựng báo cáo theo mẫu chuẩn tại Phụ lục NĐ 06/2022 (sửa đổi bởi NĐ 119/2025), bao gồm kết quả phát thải, phân tích xu hướng và đề xuất lộ trình giảm phát thải.</p>

    <h3 id="knk-b4" class="font-bold text-base text-black">4. Thẩm định &amp; Nộp báo cáo</h3>
    <p class="text-sm text-black">Hỗ trợ thẩm định bởi đơn vị độc lập (nếu bắt buộc) và nộp báo cáo về Bộ TN&amp;MT qua hệ thống đăng ký quốc gia.</p>

    <h3 id="knk-b5" class="font-bold text-base text-black">5. Tư vấn lộ trình giảm phát thải &amp; Tín chỉ carbon</h3>
    <p class="text-sm text-black">Xây dựng chiến lược Net Zero, tư vấn đăng ký tín chỉ carbon theo cơ chế thị trường trong nước và quốc tế.</p>
</div>

<h2><span id="loi-ich-knk">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Kinh nghiệm kiểm kê KNK cho <strong>hàng trăm doanh nghiệp</strong> thuộc mọi lĩnh vực sản xuất.</li>
    <li>Đội ngũ chuyên gia được đào tạo theo chuẩn <strong>ISO 14064-1, GHG Protocol</strong>.</li>
    <li>Cập nhật kịp thời QĐ 42/2026/QĐ-TTg, NĐ 119/2025/NĐ-CP.</li>
    <li>Tư vấn trọn gói từ kiểm kê → lộ trình giảm phát thải → đăng ký tín chỉ carbon.</li>
</ul>
HTML;
    }

    // ─── 4. TƯ VẤN CBAM, ESG VÀ LCA ────────────────────────────────────────

    private function contentCBAM(): string
    {
        return <<<'HTML'
<h2><span id="cbam-la-gi">CBAM, ESG và LCA – Giải mã bộ ba tiêu chuẩn xanh toàn cầu</span></h2>
<p><strong>CBAM (Carbon Border Adjustment Mechanism)</strong> – Cơ chế Điều chỉnh Biên giới Carbon của EU – chính thức bước vào giai đoạn thực thi đầy đủ từ <strong>01/01/2026</strong>. Đây là hàng rào thương mại xanh yêu cầu nhà nhập khẩu hàng hóa vào EU phải mua chứng chỉ CBAM tương ứng với lượng phát thải tích hợp trong sản phẩm.</p>
<p><strong>ESG (Environmental, Social, Governance)</strong> là bộ tiêu chí đánh giá mức độ bền vững của doanh nghiệp về Môi trường, Xã hội và Quản trị. <strong>LCA (Life Cycle Assessment)</strong> là phương pháp đánh giá tác động môi trường trong toàn bộ vòng đời sản phẩm từ khai thác nguyên liệu đến thải bỏ.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Tư vấn CBAM ESG LCA doanh nghiệp Việt Nam" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">CBAM chính thức thực thi từ 01/01/2026 – Doanh nghiệp Việt Nam cần chuẩn bị ngay</figcaption>
</figure>

<h2><span id="cbam-anh-huong">CBAM ảnh hưởng thế nào đến doanh nghiệp Việt Nam?</span></h2>
<p>Từ ngày <strong>01/01/2026</strong>, CBAM áp dụng cho 6 ngành hàng nhập khẩu vào EU:</p>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>Thép &amp; Sắt</strong> – Bao gồm sắt thép thô, ống thép, dây thép</li>
    <li><strong>Nhôm</strong> – Nhôm thỏi, thanh nhôm, nhôm tấm</li>
    <li><strong>Xi măng</strong> – Xi măng Portland, clinker</li>
    <li><strong>Phân bón</strong> – Urê, amoni nitrat, phân hỗn hợp NPK</li>
    <li><strong>Điện</strong></li>
    <li><strong>Hydro</strong></li>
</ul>
<p>Nếu doanh nghiệp không cung cấp số liệu phát thải thực tế đã được xác minh, EU sẽ áp dụng <strong>"giá trị mặc định" rất cao</strong>, gây tăng chi phí thuế carbon đáng kể và giảm khả năng cạnh tranh.</p>

<h2><span id="esg-quan-trong">Tại sao ESG ngày càng quan trọng?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Các thị trường quốc tế (EU, Mỹ, Nhật, Hàn Quốc) ngày càng yêu cầu báo cáo ESG theo khung chuẩn <strong>GRI, CDP, ISSB (IFRS S1/S2)</strong>.</li>
    <li>Ngân hàng và quỹ đầu tư ưu tiên cấp vốn cho doanh nghiệp có điểm ESG cao.</li>
    <li>Khách hàng FDI kiểm tra ESG trước khi ký hợp đồng dài hạn.</li>
    <li>Thông tư 96/2020/TT-BTC yêu cầu doanh nghiệp niêm yết công bố thông tin phát triển bền vững.</li>
</ul>

<h2><span id="dich-vu-cbam-esg">Dịch vụ tư vấn CBAM, ESG &amp; LCA tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="cbam-b1" class="font-bold text-base text-black">1. Kiểm kê &amp; Xác minh dấu chân carbon sản phẩm (PCF)</h3>
    <p class="text-sm text-black">Đo đạc, tính toán dấu chân carbon phạm vi Scope 1, 2, 3 theo ISO 14064-1, ISO 14067. Lập báo cáo phát thải tích hợp sản phẩm phục vụ khai báo CBAM.</p>

    <h3 id="cbam-b2" class="font-bold text-base text-black">2. Đánh giá vòng đời sản phẩm (LCA) theo ISO 14040/14044</h3>
    <p class="text-sm text-black">Phân tích tác động môi trường từ giai đoạn khai thác nguyên liệu → sản xuất → phân phối → sử dụng → thải bỏ. Tối ưu hóa quy trình sản xuất giảm tác động.</p>

    <h3 id="cbam-b3" class="font-bold text-base text-black">3. Xây dựng báo cáo ESG theo khung quốc tế</h3>
    <p class="text-sm text-black">Lập báo cáo phát triển bền vững theo chuẩn GRI Standards, CDP, ISSB (IFRS S1/S2). Tư vấn chiến lược ESG tích hợp với mục tiêu kinh doanh.</p>

    <h3 id="cbam-b4" class="font-bold text-base text-black">4. Hỗ trợ khai báo CBAM trên cổng EU</h3>
    <p class="text-sm text-black">Hướng dẫn doanh nghiệp khai báo số liệu phát thải tích hợp sản phẩm trên hệ thống CBAM Registry của EU, đảm bảo tuân thủ đúng quy định.</p>

    <h3 id="cbam-b5" class="font-bold text-base text-black">5. Tư vấn lộ trình giảm phát thải &amp; Chứng nhận quốc tế</h3>
    <p class="text-sm text-black">Xây dựng lộ trình Net Zero, hỗ trợ doanh nghiệp đạt chứng nhận ISO 14001, ISO 50001, đăng ký tín chỉ carbon Verra/Gold Standard.</p>
</div>

<h2><span id="loi-ich-cbam">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Đội ngũ chuyên gia am hiểu cả pháp luật Việt Nam lẫn quy định EU về CBAM.</li>
    <li>Phương pháp luận theo chuẩn quốc tế: <strong>ISO 14064, ISO 14067, GHG Protocol, GRI, ISSB</strong>.</li>
    <li>Đã tư vấn thành công cho nhiều doanh nghiệp xuất khẩu sang thị trường EU.</li>
    <li>Tư vấn trọn gói: kiểm kê KNK → LCA → ESG → CBAM → lộ trình Net Zero.</li>
</ul>
HTML;
    }

    // ─── 5. QUAN TRẮC MÔI TRƯỜNG ĐỊNH KỲ ───────────────────────────────────

    private function contentQuanTracDinhKy(): string
    {
        return <<<'HTML'
<h2><span id="quan-trac-la-gi">Quan trắc môi trường định kỳ là gì?</span></h2>
<p>Quan trắc môi trường định kỳ là hoạt động <strong>đo đạc, lấy mẫu, phân tích</strong> các thông số chất lượng môi trường (nước thải, khí thải, nước mặt, nước ngầm, không khí xung quanh, đất, chất thải rắn) tại cơ sở sản xuất theo tần suất quy định trong <strong>Giấy phép môi trường</strong> hoặc <strong>Quyết định phê duyệt ĐTM</strong>.</p>
<p>Đây là nghĩa vụ pháp lý bắt buộc theo <strong>Luật BVMT 2020</strong>, <strong>NĐ 08/2022/NĐ-CP</strong> (sửa đổi bởi NĐ 48/2026/NĐ-CP) và <strong>Thông tư 10/2021/TT-BTNMT</strong>.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Quan trắc môi trường định kỳ" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Dịch vụ quan trắc môi trường định kỳ theo NĐ 08/2022 (sửa đổi bởi NĐ 48/2026)</figcaption>
</figure>

<h2><span id="tan-suat-quan-trac">Tần suất quan trắc theo quy định hiện hành</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Loại Cơ Sở</th>
                <th class="p-3 border border-gray-200">Tần Suất Quan Trắc</th>
                <th class="p-3 border border-gray-200">Ghi Chú</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Cơ sở phải lập ĐTM (hoạt động liên tục)</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">03 tháng/lần</td>
                <td class="p-3 border border-gray-200 text-black">Theo NĐ 08/2022 (sửa đổi NĐ 48/2026)</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Cơ sở khác (hoạt động liên tục)</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">06 tháng/lần</td>
                <td class="p-3 border border-gray-200 text-black">Theo GPMT hoặc Đăng ký MT</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Cơ sở hoạt động thời vụ</td>
                <td class="p-3 font-semibold border border-gray-200 text-black">01 lần/đợt hoạt động</td>
                <td class="p-3 border border-gray-200 text-black">Nếu thuộc đối tượng phải lập ĐTM</td>
            </tr>
        </tbody>
    </table>
</div>
<p class="text-sm text-black"><em><strong>Lưu ý:</strong> Các thông số đã có hệ thống quan trắc tự động, liên tục thì không bắt buộc quan trắc định kỳ đối với thông số đó.</em></p>

<h2><span id="quan-trac-tu-dong">Quan trắc tự động, liên tục</span></h2>
<p>Theo <strong>Phụ lục XXVIII NĐ 08/2022</strong> (cập nhật bởi NĐ 48/2026), các cơ sở sau phải lắp đặt hệ thống quan trắc tự động:</p>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Khu sản xuất, kinh doanh, dịch vụ tập trung, cụm công nghiệp</li>
    <li>Dự án, cơ sở có nguy cơ gây ô nhiễm MT với lưu lượng xả thải lớn</li>
    <li>Yêu cầu: thiết bị đo, Datalogger truyền dữ liệu thời gian thực, camera giám sát, thiết bị lấy mẫu tự động (đối với nước thải)</li>
    <li>Dữ liệu truyền trực tiếp về <strong>Sở TN&amp;MT địa phương</strong></li>
</ul>

<h2><span id="dich-vu-quan-trac">Dịch vụ quan trắc tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="qt-b1" class="font-bold text-base text-black">1. Lập kế hoạch quan trắc</h3>
    <p class="text-sm text-black">Rà soát GPMT/ĐTM, xác định các thông số, vị trí và tần suất quan trắc phù hợp. Lập lịch quan trắc theo năm đảm bảo tuân thủ.</p>

    <h3 id="qt-b2" class="font-bold text-base text-black">2. Lấy mẫu &amp; Phân tích tại phòng thí nghiệm</h3>
    <p class="text-sm text-black">Đội ngũ kỹ thuật viên lấy mẫu hiện trường theo đúng quy trình kỹ thuật. Phân tích tại phòng thí nghiệm đạt chuẩn VILAS/ISO 17025.</p>

    <h3 id="qt-b3" class="font-bold text-base text-black">3. Lập báo cáo kết quả quan trắc</h3>
    <p class="text-sm text-black">Tổng hợp kết quả, so sánh với QCVN hiện hành (QCVN 40:2025/BTNMT, QCVN 19:2009/BTNMT,...), đánh giá mức độ tuân thủ.</p>

    <h3 id="qt-b4" class="font-bold text-base text-black">4. Tổng hợp Báo cáo BVMT hằng năm</h3>
    <p class="text-sm text-black">Lập Báo cáo công tác bảo vệ môi trường hằng năm để nộp cho cơ quan quản lý nhà nước theo quy định.</p>
</div>

<h2><span id="loi-ich-quan-trac">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Phòng thí nghiệm đạt chuẩn <strong>VILAS / ISO 17025</strong> (liên kết đối tác).</li>
    <li>Đội ngũ kỹ thuật lấy mẫu được đào tạo chuyên sâu, trang thiết bị hiện đại.</li>
    <li>Lập lịch nhắc quan trắc tự động, đảm bảo doanh nghiệp không bỏ sót kỳ quan trắc.</li>
    <li>Tư vấn giải pháp khắc phục khi kết quả vượt QCVN.</li>
</ul>
HTML;
    }

    // ─── 6. QUAN TRẮC MÔI TRƯỜNG LAO ĐỘNG ──────────────────────────────────

    private function contentQuanTracLaoDong(): string
    {
        return <<<'HTML'
<h2><span id="qtld-la-gi">Quan trắc môi trường lao động là gì?</span></h2>
<p>Quan trắc môi trường lao động là hoạt động <strong>đo lường, phân tích các yếu tố có hại</strong> tại nơi làm việc bao gồm: yếu tố vật lý (nhiệt độ, độ ẩm, tiếng ồn, rung, ánh sáng, bức xạ), yếu tố hóa học (bụi, hơi khí độc), yếu tố sinh học (vi khuẩn, nấm mốc) và yếu tố tâm – sinh lý (cường độ lao động, tư thế làm việc).</p>
<p>Đây là nghĩa vụ pháp lý bắt buộc theo <strong>Luật An toàn, vệ sinh lao động 2015</strong>, <strong>Nghị định 44/2016/NĐ-CP</strong> (sửa đổi bởi NĐ 140/2018/NĐ-CP) và <strong>Thông tư 19/2016/TT-BYT</strong>.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Quan trắc môi trường lao động" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Đo đạc quan trắc môi trường lao động theo Luật ATVSLĐ 2015 và TT 19/2016/TT-BYT</figcaption>
</figure>

<h2><span id="doi-tuong-qtld">Đối tượng &amp; Tần suất thực hiện</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>Đối tượng:</strong> Tất cả cơ sở sản xuất, kinh doanh, dịch vụ có sử dụng lao động.</li>
    <li><strong>Tần suất:</strong> Tối thiểu <strong>01 lần/năm</strong> theo Luật ATVSLĐ 2015.</li>
    <li><strong>Xử phạt:</strong> Không thực hiện quan trắc MTLĐ có thể bị phạt từ <strong>20–40 triệu đồng</strong> theo nghị định xử phạt VPHC trong lĩnh vực lao động.</li>
</ul>

<h2><span id="cac-yeu-to-quan-trac-ld">Các yếu tố cần quan trắc</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Nhóm Yếu Tố</th>
                <th class="p-3 border border-gray-200">Chỉ Tiêu Đo Đạc</th>
                <th class="p-3 border border-gray-200">Quy Chuẩn Áp Dụng</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Vi khí hậu</td>
                <td class="p-3 border border-gray-200 text-black">Nhiệt độ, độ ẩm, tốc độ gió, bức xạ nhiệt</td>
                <td class="p-3 border border-gray-200 text-black">QCVN 26:2016/BYT</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Vật lý</td>
                <td class="p-3 border border-gray-200 text-black">Tiếng ồn, rung, ánh sáng, điện từ trường</td>
                <td class="p-3 border border-gray-200 text-black">QCVN 24:2016/BYT, QCVN 27:2016/BYT</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Hóa học</td>
                <td class="p-3 border border-gray-200 text-black">Bụi toàn phần, bụi hô hấp, hơi khí độc (SO₂, NO₂, CO, VOC...)</td>
                <td class="p-3 border border-gray-200 text-black">QCVN 02:2019/BYT, QCVN 03:2019/BYT</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Sinh học</td>
                <td class="p-3 border border-gray-200 text-black">Vi khuẩn, nấm mốc, ký sinh trùng</td>
                <td class="p-3 border border-gray-200 text-black">Theo hướng dẫn TT 19/2016/TT-BYT</td>
            </tr>
        </tbody>
    </table>
</div>

<h2><span id="quy-trinh-qtld">Quy trình quan trắc MTLĐ tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="qtld-b1" class="font-bold text-base text-black">1. Khảo sát sơ bộ &amp; Lập kế hoạch</h3>
    <p class="text-sm text-black">Rà soát hồ sơ vệ sinh lao động, xác định các vị trí đo, yếu tố có hại cần quan trắc, lập phương án lấy mẫu.</p>

    <h3 id="qtld-b2" class="font-bold text-base text-black">2. Đo đạc hiện trường</h3>
    <p class="text-sm text-black">Đội ngũ kỹ thuật viên sử dụng thiết bị chuyên dụng đo đạc trực tiếp tại các vị trí làm việc theo đúng TCVN, QCVN.</p>

    <h3 id="qtld-b3" class="font-bold text-base text-black">3. Phân tích &amp; Lập báo cáo</h3>
    <p class="text-sm text-black">Phân tích mẫu tại phòng thí nghiệm, so sánh kết quả với QCVN/BYT hiện hành. Lập báo cáo quan trắc MTLĐ theo mẫu TT 19/2016/TT-BYT.</p>

    <h3 id="qtld-b4" class="font-bold text-base text-black">4. Tư vấn cải thiện &amp; Lưu hồ sơ</h3>
    <p class="text-sm text-black">Đề xuất biện pháp cải thiện điều kiện lao động, trang bị BHCN phù hợp. Lưu hồ sơ phục vụ khám sức khỏe định kỳ và quản lý bệnh nghề nghiệp.</p>
</div>

<h2><span id="loi-ich-qtld">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Đơn vị quan trắc đủ điều kiện năng lực theo quy định pháp luật.</li>
    <li>Thiết bị đo đạc hiện đại, hiệu chuẩn định kỳ đúng chuẩn.</li>
    <li>Kết quả chính xác, đúng hạn – phục vụ nộp hồ sơ thanh tra lao động.</li>
    <li>Tư vấn trọn gói: quan trắc → đề xuất khắc phục → hỗ trợ khám sức khỏe nghề nghiệp.</li>
</ul>
HTML;
    }

    // ─── 7. THIẾT KẾ & VẬN HÀNH HỆ THỐNG XỬ LÝ NƯỚC THẢI ─────────────────

    private function contentXuLyNuocThai(): string
    {
        return <<<'HTML'
<h2><span id="xlnt-tong-quan">Thiết kế &amp; Thi công hệ thống xử lý nước thải</span></h2>
<p>Môi Trường Bảo Châu cung cấp giải pháp <strong>tổng thầu EPC (Engineering – Procurement – Construction)</strong> trọn gói từ tư vấn thiết kế, cung cấp thiết bị đến thi công xây dựng và vận hành hệ thống xử lý nước thải công nghiệp, nước thải y tế, nước thải sinh hoạt đạt chuẩn xả thải theo quy định.</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Hệ thống xử lý nước thải công nghiệp" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hệ thống xử lý nước thải đạt QCVN 40:2025/BTNMT (thay thế QCVN 40:2011)</figcaption>
</figure>

<h2><span id="qcvn-40-2025">Điểm mới QCVN 40:2025/BTNMT – Thay thế QCVN 40:2011</span></h2>
<p>Ngày <strong>01/09/2025</strong>, <strong>QCVN 40:2025/BTNMT</strong> (ban hành theo Thông tư 06/2025/TT-BTNMT) chính thức có hiệu lực, thay thế QCVN 40:2011/BTNMT và 10 quy chuẩn nước thải ngành khác:</p>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Thay thế QCVN 40:2011 (nước thải CN), QCVN 28:2010 (y tế), QCVN 25:2009 (bãi chôn lấp CTR), QCVN 29:2010 (xăng dầu)...</li>
    <li>Thay thế QCVN 01-MT:2015 (cao su), QCVN 11-MT:2015 (thủy sản), QCVN 12-MT:2015 (giấy), QCVN 13-MT:2015 (dệt nhuộm)...</li>
    <li><strong>Lộ trình chuyển tiếp:</strong> Cơ sở đã vận hành hoặc đã có GPMT trước 01/09/2025 được áp dụng quy chuẩn cũ đến hết <strong>31/12/2031</strong>.</li>
    <li><strong>Dự án mới:</strong> Từ 01/09/2025, bắt buộc áp dụng QCVN 40:2025.</li>
</ul>

<h2><span id="cong-nghe-xlnt">Công nghệ xử lý nước thải phổ biến</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Công Nghệ</th>
                <th class="p-3 border border-gray-200">Ứng Dụng</th>
                <th class="p-3 border border-gray-200">Ưu Điểm</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">AAO (Anaerobic-Anoxic-Oxic)</td>
                <td class="p-3 border border-gray-200 text-black">NT sinh hoạt, KCN, chế biến thực phẩm</td>
                <td class="p-3 border border-gray-200 text-black">Xử lý N, P hiệu quả, chi phí vận hành thấp</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">MBR (Membrane Bioreactor)</td>
                <td class="p-3 border border-gray-200 text-black">NT công nghiệp, tái sử dụng nước</td>
                <td class="p-3 border border-gray-200 text-black">Nước sau xử lý chất lượng cao, diện tích nhỏ</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">SBR (Sequencing Batch Reactor)</td>
                <td class="p-3 border border-gray-200 text-black">Nhà máy quy mô nhỏ–vừa</td>
                <td class="p-3 border border-gray-200 text-black">Linh hoạt, dễ vận hành tự động</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">UASB + Aerotank</td>
                <td class="p-3 border border-gray-200 text-black">Chế biến, giết mổ, cao su, tinh bột</td>
                <td class="p-3 border border-gray-200 text-black">Thu hồi biogas, giảm BOD/COD cao</td>
            </tr>
        </tbody>
    </table>
</div>

<h2><span id="quy-trinh-xlnt">Quy trình triển khai EPC tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="xlnt-b1" class="font-bold text-base text-black">1. Khảo sát &amp; Đánh giá đặc tính nước thải</h3>
    <p class="text-sm text-black">Lấy mẫu, phân tích thành phần, lưu lượng, tải lượng ô nhiễm. Xác định quy chuẩn đầu ra áp dụng (QCVN 40:2025 hoặc quy chuẩn cũ theo lộ trình chuyển tiếp).</p>

    <h3 id="xlnt-b2" class="font-bold text-base text-black">2. Thiết kế hệ thống xử lý</h3>
    <p class="text-sm text-black">Đề xuất công nghệ phù hợp, thiết kế bản vẽ kỹ thuật thi công, dự toán chi phí đầu tư và vận hành.</p>

    <h3 id="xlnt-b3" class="font-bold text-base text-black">3. Thi công &amp; Lắp đặt thiết bị</h3>
    <p class="text-sm text-black">Tổng thầu thi công xây dựng, cung cấp và lắp đặt toàn bộ hệ thống thiết bị cơ khí, điện, tự động hóa.</p>

    <h3 id="xlnt-b4" class="font-bold text-base text-black">4. Vận hành thử &amp; Nghiệm thu</h3>
    <p class="text-sm text-black">Chạy thử hệ thống, nuôi cấy vi sinh, điều chỉnh thông số vận hành. Lấy mẫu đầu ra so sánh QCVN, nghiệm thu bàn giao.</p>

    <h3 id="xlnt-b5" class="font-bold text-base text-black">5. Bảo trì &amp; Hỗ trợ vận hành dài hạn</h3>
    <p class="text-sm text-black">Đào tạo nhân sự vận hành, bảo trì định kỳ, hỗ trợ kỹ thuật 24/7 trong suốt vòng đời hệ thống.</p>
</div>

<h2><span id="loi-ich-xlnt">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Cam kết <strong>100% nước thải đầu ra đạt QCVN</strong> hiện hành.</li>
    <li>Cập nhật QCVN 40:2025/BTNMT và lộ trình chuyển tiếp đến 31/12/2031.</li>
    <li>Tổng thầu EPC trọn gói: thiết kế → thi công → vận hành → bảo trì.</li>
    <li>Đã triển khai hàng trăm trạm XLNT công suất từ 5 m³/ngày đến 10.000 m³/ngày.</li>
</ul>
HTML;
    }

    // ─── 8. GIẢI PHÁP XỬ LÝ KHÍ THẢI CÔNG NGHIỆP ─────────────────────────

    private function contentXuLyKhiThai(): string
    {
        return <<<'HTML'
<h2><span id="xlkt-tong-quan">Giải pháp xử lý khí thải công nghiệp</span></h2>
<p>Khí thải công nghiệp chứa các chất ô nhiễm như bụi, SO₂, NO₂, CO, VOC (hợp chất hữu cơ bay hơi), H₂S, HCl, kim loại nặng... Nếu không được xử lý đạt chuẩn trước khi xả ra môi trường sẽ gây ô nhiễm không khí nghiêm trọng và vi phạm pháp luật.</p>
<p>Môi Trường Bảo Châu cung cấp giải pháp <strong>thiết kế, chế tạo, lắp đặt và vận hành</strong> hệ thống xử lý khí thải công nghiệp đạt chuẩn <strong>QCVN 19:2009/BTNMT</strong> (khí thải công nghiệp đối với bụi và chất vô cơ) và <strong>QCVN 20:2009/BTNMT</strong> (chất hữu cơ).</p>

<figure class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5">
    <img decoding="async" class="w-full h-auto object-cover" src="/assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png" alt="Hệ thống xử lý khí thải công nghiệp" width="1024" height="576" />
    <figcaption class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium">Hệ thống xử lý khí thải đạt QCVN 19:2009/BTNMT, QCVN 20:2009/BTNMT</figcaption>
</figure>

<h2><span id="can-cu-phap-ly-kt">Căn cứ pháp lý</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li><strong>Luật BVMT 2020</strong> – Quy định nghĩa vụ xử lý khí thải trước khi xả ra môi trường.</li>
    <li><strong>QCVN 19:2009/BTNMT</strong> – Quy chuẩn khí thải công nghiệp đối với bụi và các chất vô cơ.</li>
    <li><strong>QCVN 20:2009/BTNMT</strong> – Quy chuẩn khí thải công nghiệp đối với các chất hữu cơ.</li>
    <li><strong>NĐ 08/2022/NĐ-CP</strong> (sửa đổi bởi NĐ 48/2026/NĐ-CP) – Quy định trong Giấy phép môi trường về giới hạn phát thải khí thải.</li>
    <li><strong>NĐ 45/2022/NĐ-CP</strong> – Xử phạt vi phạm hành chính: vượt QCVN khí thải phạt từ <strong>50–500 triệu đồng</strong>, đình chỉ 3–12 tháng.</li>
</ul>

<h2><span id="cong-nghe-xlkt">Công nghệ xử lý khí thải phổ biến</span></h2>
<div class="overflow-x-auto my-4 rounded-xl border border-gray-200">
    <table class="w-full text-left text-xs sm:text-sm border-collapse text-black">
        <thead class="bg-gray-100 text-black font-bold">
            <tr>
                <th class="p-3 border border-gray-200">Công Nghệ</th>
                <th class="p-3 border border-gray-200">Xử Lý Chất Ô Nhiễm</th>
                <th class="p-3 border border-gray-200">Ứng Dụng</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Tháp hấp thụ (Scrubber)</td>
                <td class="p-3 border border-gray-200 text-black">SO₂, HCl, H₂S, NH₃, khí axit/kiềm</td>
                <td class="p-3 border border-gray-200 text-black">Hóa chất, xi mạ, dệt nhuộm, cao su</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Lọc bụi túi vải (Baghouse)</td>
                <td class="p-3 border border-gray-200 text-black">Bụi mịn, bụi PM2.5, PM10</td>
                <td class="p-3 border border-gray-200 text-black">Xi măng, gỗ, thực phẩm, vật liệu xây dựng</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Hấp phụ than hoạt tính</td>
                <td class="p-3 border border-gray-200 text-black">VOC, dung môi hữu cơ, mùi</td>
                <td class="p-3 border border-gray-200 text-black">Sơn, in ấn, nhựa, điện tử</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">Cyclon + Venturi</td>
                <td class="p-3 border border-gray-200 text-black">Bụi thô, bụi ẩm, khói</td>
                <td class="p-3 border border-gray-200 text-black">Luyện kim, đúc, gia công kim loại</td>
            </tr>
            <tr>
                <td class="p-3 font-bold text-primary border border-gray-200">RTO/RCO (Oxy hóa nhiệt)</td>
                <td class="p-3 border border-gray-200 text-black">VOC nồng độ cao, mùi hôi</td>
                <td class="p-3 border border-gray-200 text-black">Sản xuất sơn, keo, hóa mỹ phẩm</td>
            </tr>
        </tbody>
    </table>
</div>

<h2><span id="quy-trinh-xlkt">Quy trình triển khai tại Bảo Châu</span></h2>
<div class="space-y-4 my-4 text-black">
    <h3 id="xlkt-b1" class="font-bold text-base text-black">1. Khảo sát &amp; Đánh giá nguồn phát thải</h3>
    <p class="text-sm text-black">Xác định thành phần, nồng độ, lưu lượng, nhiệt độ khí thải. Rà soát yêu cầu trong GPMT/ĐTM và QCVN áp dụng.</p>

    <h3 id="xlkt-b2" class="font-bold text-base text-black">2. Thiết kế giải pháp xử lý</h3>
    <p class="text-sm text-black">Đề xuất công nghệ phù hợp với đặc thù khí thải, lập bản vẽ thiết kế kỹ thuật và dự toán chi phí.</p>

    <h3 id="xlkt-b3" class="font-bold text-base text-black">3. Chế tạo, lắp đặt &amp; Đấu nối</h3>
    <p class="text-sm text-black">Chế tạo thiết bị tại xưởng, vận chuyển và lắp đặt tại nhà máy. Đấu nối hệ thống thu gom khí thải từ các nguồn phát sinh.</p>

    <h3 id="xlkt-b4" class="font-bold text-base text-black">4. Vận hành thử &amp; Đo kiểm</h3>
    <p class="text-sm text-black">Chạy thử hệ thống, điều chỉnh thông số tối ưu. Lấy mẫu khí thải đầu ra so sánh QCVN 19:2009, QCVN 20:2009.</p>

    <h3 id="xlkt-b5" class="font-bold text-base text-black">5. Bàn giao &amp; Bảo trì định kỳ</h3>
    <p class="text-sm text-black">Đào tạo vận hành, bàn giao tài liệu kỹ thuật. Bảo trì, thay thế vật tư tiêu hao (túi lọc, than hoạt tính, hóa chất) theo định kỳ.</p>
</div>

<h2><span id="loi-ich-xlkt">Vì sao chọn Môi Trường Bảo Châu?</span></h2>
<ul class="space-y-2 list-disc pl-5 text-black">
    <li>Cam kết <strong>khí thải đầu ra đạt 100% QCVN</strong> hiện hành.</li>
    <li>Xưởng chế tạo thiết bị riêng, kiểm soát chất lượng từ A-Z.</li>
    <li>Cập nhật NĐ 48/2026/NĐ-CP về chuyển đổi mô hình "hậu kiểm" và yêu cầu phát thải thực tế.</li>
    <li>Đội ngũ kỹ sư cơ khí, hóa, môi trường giàu kinh nghiệm triển khai thực tế.</li>
</ul>
HTML;
    }
}
