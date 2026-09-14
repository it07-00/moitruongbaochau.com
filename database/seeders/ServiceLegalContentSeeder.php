<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Support\RichContentNormalizer;
use Illuminate\Database\Seeder;
use LogicException;

class ServiceLegalContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->services() as $slug => $data) {
            $service = Service::query()->where('slug', $slug)->first();

            if (! $service) {
                throw new LogicException("Cannot update legal content because service [{$slug}] does not exist.");
            }

            $service->update([
                'short_description' => $data['summary'],
                'content' => RichContentNormalizer::normalize($this->buildContent($data)),
                'tags' => array_values(array_unique($data['tags'])),
                'meta_title' => $service->name.' - Môi Trường Bảo Châu',
                'meta_description' => $data['summary'],
            ]);
        }
    }

    /**
     * @return array<string, array{summary: string, audience: array<int, string>, work: array<int, string>, deliverables: array<int, string>, laws: array<int, string>, note: string, tags: array<int, string>}>
     */
    private function services(): array
    {
        return [
            'lap-bao-cao-phat-trien-ben-vung-esg' => $this->service(
                'Xây dựng báo cáo phát triển bền vững có dữ liệu kiểm chứng, phản ánh các chủ đề môi trường, xã hội và quản trị trọng yếu, phục vụ công bố thông tin, gọi vốn và quản trị rủi ro.',
                ['Doanh nghiệp niêm yết, công ty đại chúng hoặc tổ chức có nghĩa vụ công bố thông tin.', 'Doanh nghiệp trong chuỗi cung ứng cần đáp ứng yêu cầu ESG của khách hàng, ngân hàng hoặc nhà đầu tư.', 'Tổ chức muốn thiết lập mục tiêu, chỉ số và lộ trình phát triển bền vững.'],
                ['Đánh giá khoảng cách, các bên liên quan và chủ đề ESG trọng yếu.', 'Thiết lập ranh giới, bộ chỉ số, chủ sở hữu dữ liệu và cơ chế lưu bằng chứng.', 'Thu thập, kiểm tra dữ liệu; biên soạn báo cáo và kế hoạch cải thiện kỳ tiếp theo.'],
                ['Ma trận trọng yếu và bản đồ bên liên quan.', 'Bộ chỉ số, biểu mẫu dữ liệu và danh mục bằng chứng.', 'Báo cáo phát triển bền vững cùng lộ trình ESG có mục tiêu và thời hạn.'],
                ['environment-law', 'environment-amendment', 'disclosure', 'green-growth'],
                'Thông tư 96/2020/TT-BTC đặt yêu cầu công bố tác động liên quan đến môi trường và xã hội cho đối tượng thuộc phạm vi thị trường chứng khoán. GRI, ISSB hoặc yêu cầu chuỗi cung ứng là chuẩn tham chiếu được chọn theo mục tiêu dự án, không thay thế pháp luật Việt Nam.',
                ['BaoCaoESG', 'PhatTrienBenVung', 'QuanTriESG', 'CongBoThongTin', 'GRI', 'ISSB', 'SDGs', 'TangTruongXanh', 'DuLieuESG', 'MoiTruongBaoChau'],
            ),
            'tu-van-tieu-chi-cang-xanh' => $this->service(
                'Đánh giá hiện trạng và xây dựng chương trình cảng xanh theo TCCS 02:2022/CHHVN, gắn quản lý môi trường với sử dụng năng lượng, số hóa vận hành và giảm phát thải.',
                ['Doanh nghiệp khai thác cảng biển, bến cảng và đơn vị quản lý hạ tầng logistics.', 'Cảng cần tự đánh giá, công bố hoặc duy trì kết quả áp dụng tiêu chí cảng xanh.', 'Nhà đầu tư muốn tích hợp yêu cầu môi trường vào dự án nâng cấp cảng.'],
                ['Đánh giá khoảng cách theo từng tiêu chí và kiểm tra hồ sơ chứng minh.', 'Lập đường cơ sở về năng lượng, phát thải, chất thải, nước, không khí và tiếng ồn.', 'Xây dựng chương trình hành động, hỗ trợ hồ sơ tự đánh giá và cơ chế theo dõi hằng năm.'],
                ['Báo cáo đánh giá khoảng cách và bảng điểm hiện trạng.', 'Bộ hồ sơ minh chứng theo tiêu chí.', 'Chương trình hành động cảng xanh có ưu tiên đầu tư và bộ chỉ số duy trì.'],
                ['environment-law', 'environment-amendment', 'environment-decree', 'green-growth'],
                'Bộ tiêu chí kỹ thuật trực tiếp là TCCS 02:2022/CHHVN của Cục Hàng hải Việt Nam. Phạm vi pháp lý của từng cảng vẫn phải đối chiếu giấy phép, quy mô nguồn thải và quy định địa phương.',
                ['CangXanh', 'TCCS022022CHHVN', 'GreenPort', 'LogisticsXanh', 'KiemKePhatThai', 'TietKiemNangLuong', 'QuanLyChatThai', 'ESGCangBien', 'TangTruongXanh', 'MoiTruongBaoChau'],
            ),
            'kiem-ke-khi-nha-kinh' => $this->service(
                'Kiểm kê phát thải khí nhà kính cấp cơ sở và xây dựng kế hoạch giảm nhẹ theo khung pháp lý Việt Nam cập nhật trong năm 2026.',
                ['Cơ sở có tên trong danh mục bắt buộc cập nhật tại Quyết định 42/2026/QĐ-TTg.', 'Doanh nghiệp cần dữ liệu để tham gia thị trường các-bon, đáp ứng chuỗi cung ứng hoặc mục tiêu giảm phát thải.', 'Tổ chức muốn xây dựng đường cơ sở carbon và danh mục dự án giảm nhẹ.'],
                ['Xác định ranh giới tổ chức, hoạt động, nguồn phát thải và bể hấp thụ.', 'Thu thập dữ liệu, lựa chọn hệ số, tính toán và đánh giá độ không chắc chắn.', 'Kiểm soát chất lượng, lập báo cáo kiểm kê, kế hoạch giảm nhẹ và hệ thống MRV.'],
                ['Danh mục nguồn phát thải và kế hoạch dữ liệu.', 'Bảng tính kiểm kê, hồ sơ hệ số và bằng chứng đầu vào.', 'Báo cáo kiểm kê cùng đường cong chi phí và kế hoạch giảm phát thải.'],
                ['environment-law', 'ghg-decree', 'ghg-amendment', 'ghg-amendment-2026', 'ghg-list-2026', 'climate-circular', 'carbon-market'],
                'Quyết định 42/2026/QĐ-TTg ban hành ngày 10/08/2026, cập nhật 2.441 cơ sở và có hiệu lực từ 25/09/2026. Trước ngày này cần quản lý giai đoạn chuyển tiếp; từ ngày hiệu lực phải kiểm tra trực tiếp tên và thông tin cơ sở trong phụ lục mới.',
                ['KiemKeKhiNhaKinh', 'BaoCaoKNK', 'GiamPhatThai', 'NghiDinh832026', 'QuyetDinh422026', 'ThiTruongCarbon', 'MRV', 'CarbonManagement', 'NetZero', 'MoiTruongBaoChau'],
            ),
            'tu-van-cbam-esg-lca' => $this->service(
                'Tính phát thải hàm chứa và chuẩn bị bộ dữ liệu CBAM cho hàng hóa xuất khẩu sang EU theo cơ chế chính thức áp dụng từ ngày 01/01/2026.',
                ['Nhà sản xuất hàng hóa thuộc các ngành và mã CN trong phạm vi CBAM.', 'Doanh nghiệp Việt Nam cung cấp dữ liệu cho nhà nhập khẩu hoặc đại diện hải quan EU.', 'Chuỗi cung ứng cần chuyển từ giá trị mặc định sang dữ liệu thực tế có thể xác minh.'],
                ['Xác định mã hàng, công đoạn sản xuất, cơ sở và ranh giới phát thải.', 'Lập dòng nguyên liệu, tiền chất, nhiên liệu, điện và dữ liệu sản lượng.', 'Tính phát thải hàm chứa, chuẩn hóa communication template và hồ sơ xác minh.'],
                ['Bảng xác định hàng hóa và mã CN thuộc phạm vi.', 'Mô hình tính phát thải hàm chứa theo sản phẩm.', 'Bộ hồ sơ dữ liệu cho nhà nhập khẩu và lộ trình giảm rủi ro chi phí CBAM.'],
                ['cbam-regulation', 'cbam-definitive', 'ghg-decree', 'ghg-amendment-2026'],
                'CBAM là pháp luật EU, không phải thủ tục cấp phép của Việt Nam. Nghĩa vụ khai báo và chứng chỉ thuộc nhà nhập khẩu hoặc đại diện tại EU; nhà sản xuất ngoài EU cần cung cấp dữ liệu phát thải đáng tin cậy và có thể xác minh.',
                ['CBAM2026', 'BaoCaoCBAM', 'PhatThaiHamChua', 'CarbonBienGioi', 'EUCBAM', 'MaCN', 'XacMinhCBAM', 'HangHoaXuatKhau', 'DuLieuPhatThai', 'MoiTruongBaoChau'],
            ),
            'danh-gia-vong-doi-san-pham-iso-14067' => $this->service(
                'Đánh giá vòng đời và tính dấu chân carbon sản phẩm để nhận diện điểm nóng phát thải, đáp ứng yêu cầu khách hàng và xây dựng phương án giảm carbon có thể đo lường.',
                ['Nhà sản xuất cần công bố hoặc cung cấp dấu chân carbon sản phẩm.', 'Doanh nghiệp xuất khẩu cần dữ liệu vòng đời, EPD, CBAM hoặc thiết kế sinh thái.', 'Tổ chức muốn so sánh nguyên liệu, năng lượng, vận chuyển và cuối vòng đời.'],
                ['Xác định mục tiêu, đơn vị chức năng, ranh giới hệ thống và quy tắc phân bổ.', 'Lập kiểm kê vòng đời, tính phát thải và đánh giá chất lượng dữ liệu.', 'Phân tích điểm nóng, độ nhạy, giải pháp giảm phát thải và hồ sơ đánh giá độc lập.'],
                ['Báo cáo mục tiêu, phạm vi và giả định nghiên cứu.', 'Bộ dữ liệu kiểm kê vòng đời và bảng tính dấu chân carbon.', 'Báo cáo kết quả, giới hạn, độ nhạy và danh mục giải pháp giảm carbon.'],
                ['environment-law', 'ghg-decree', 'ghg-amendment-2026', 'green-growth'],
                'Phương pháp chuyên môn áp dụng ISO 14040, ISO 14044 và ISO 14067:2018 hoặc phiên bản tiêu chuẩn được hợp đồng lựa chọn. Kết quả chỉ được gọi là chứng nhận khi có tổ chức đánh giá đủ năng lực thực hiện theo chương trình tương ứng.',
                ['ISO14067', 'DauChanCarbon', 'CarbonFootprint', 'DanhGiaVongDoi', 'LCA', 'KiemKeVongDoi', 'SanPhamXanh', 'GiamCarbonSanPham', 'DuLieuVongDoi', 'MoiTruongBaoChau'],
            ),
            'kiem-toan-nang-luong-va-giai-phap-tiet-kiem' => $this->service(
                'Khảo sát, đo lường và phân tích hệ thống sử dụng năng lượng để xác định nghĩa vụ kiểm toán, cơ hội tiết kiệm, chi phí đầu tư và thời gian hoàn vốn.',
                ['Cơ sở sử dụng năng lượng trọng điểm và đơn vị có nghĩa vụ kiểm toán định kỳ.', 'Nhà máy, tòa nhà hoặc cơ sở dịch vụ có chi phí điện, nhiên liệu, hơi hoặc nhiệt lớn.', 'Doanh nghiệp cần giảm phát thải thông qua hiệu quả năng lượng.'],
                ['Rà soát dữ liệu tiêu thụ, đường cơ sở và sơ đồ phân phối năng lượng.', 'Đo kiểm phụ tải chính, lập cân bằng năng lượng và nhận diện tổn thất.', 'Phân tích kỹ thuật - tài chính, ưu tiên giải pháp và xây dựng kế hoạch theo dõi.'],
                ['Báo cáo kiểm toán và đường cơ sở năng lượng.', 'Bảng cân bằng, hồ sơ đo kiểm và danh mục tổn thất.', 'Danh mục giải pháp kèm mức tiết kiệm, vốn đầu tư, hoàn vốn và KPI.'],
                ['energy-efficiency', 'environment-law', 'green-growth', 'ghg-amendment-2026'],
                'Tần suất và nội dung bắt buộc phải xác định theo tình trạng cơ sở sử dụng năng lượng trọng điểm và văn bản hướng dẫn còn hiệu lực. Số liệu tiết kiệm dự kiến cần được xác nhận sau triển khai bằng đo lường và xác minh.',
                ['KiemToanNangLuong', 'TietKiemNangLuong', 'HieuQuaNangLuong', 'QuanLyNangLuong', 'DuongCoSoNangLuong', 'GiamChiPhiDien', 'GiamPhatThai', 'LoHoi', 'KhiNen', 'MoiTruongBaoChau'],
            ),
            'giay-phep-moi-truong' => $this->service(
                'Rà soát dự án và cơ sở để xác định đúng thủ tục ĐTM, giấy phép môi trường, đăng ký môi trường và hồ sơ vận hành theo quy định cập nhật đến năm 2026.',
                ['Chủ dự án đầu tư mới, mở rộng, thay đổi công suất, công nghệ hoặc vị trí.', 'Cơ sở cần cấp mới, cấp đổi, cấp lại hoặc điều chỉnh giấy phép môi trường.', 'Doanh nghiệp cần kiểm tra hồ sơ trước thanh tra, giao dịch hoặc vận hành.'],
                ['Phân loại dự án theo nhóm, yếu tố nhạy cảm, quy mô và loại hình.', 'Xác định thủ tục, thẩm quyền, thời điểm và tài liệu đầu vào.', 'Khảo sát, lập, nộp, giải trình hồ sơ và thiết lập nghĩa vụ sau phê duyệt.'],
                ['Báo cáo rà soát pháp lý và lộ trình thủ tục.', 'Hồ sơ ĐTM, đề xuất cấp phép hoặc đăng ký theo phạm vi.', 'Bộ giải trình và danh mục nghĩa vụ vận hành sau phê duyệt.'],
                ['environment-law', 'environment-amendment', 'environment-decree', 'environment-decree-amendment', 'environment-circular-2026', 'authority-circular'],
                'Luật 146/2025/QH15 và Thông tư 09/2026/TT-BNNMT đã cập nhật hệ thống văn bản môi trường. Loại hồ sơ và thẩm quyền phải rà soát đồng thời công suất, địa điểm, yếu tố nhạy cảm và nguồn thải thực tế.',
                ['HoSoMoiTruong', 'GiayPhepMoiTruong', 'DanhGiaTacDongMoiTruong', 'DangKyMoiTruong', 'LuatBaoVeMoiTruong', 'NghiDinh052025', 'ThongTu092026', 'TuVanPhapLy', 'TuanThuMoiTruong', 'MoiTruongBaoChau'],
            ),
            'bao-cao-danh-gia-tac-dong-moi-truong' => $this->service(
                'Lập báo cáo đánh giá tác động môi trường cho dự án thuộc đối tượng phải thực hiện ĐTM, từ sàng lọc pháp lý, khảo sát nền đến tham vấn và giải trình thẩm định.',
                ['Dự án nhóm I và dự án nhóm II có yêu cầu thực hiện ĐTM theo tiêu chí môi trường.', 'Dự án thay đổi nội dung có khả năng làm gia tăng tác động xấu.', 'Chủ đầu tư cần hoàn thành ĐTM trước mốc quyết định hoặc cấp phép theo luật định.'],
                ['Sàng lọc đối tượng, thẩm quyền và phạm vi đánh giá.', 'Khảo sát nền; nhận diện nguồn thải, mô hình hóa tác động và biện pháp giảm thiểu.', 'Tổ chức tham vấn, hoàn thiện báo cáo và giải trình thẩm định.'],
                ['Báo cáo khảo sát và dữ liệu môi trường nền.', 'Báo cáo ĐTM cùng phụ lục bản vẽ, phân tích và hồ sơ tham vấn.', 'Bộ giải trình và bảng theo dõi yêu cầu sau quyết định phê duyệt.'],
                ['environment-law', 'environment-amendment', 'environment-decree', 'environment-decree-amendment', 'environment-circular-2026', 'authority-circular'],
                'ĐTM không thay thế giấy phép môi trường hoặc giấy phép chuyên ngành khác. Chủ dự án phải đối chiếu mọi thay đổi với nội dung đã được phê duyệt trước khi triển khai.',
                ['BaoCaoDTM', 'DanhGiaTacDongMoiTruong', 'ThamVanCongDong', 'ThamDinhDTM', 'LuatBaoVeMoiTruong', 'NghiDinh052025', 'ThongTu092026', 'DuAnDauTu', 'PhapLyMoiTruong', 'MoiTruongBaoChau'],
            ),
            'quan-trac-moi-truong-dinh-ky' => $this->service(
                'Thiết kế và thực hiện chương trình quan trắc đúng nguồn, vị trí, thông số, tần suất và phương pháp; đánh giá kết quả theo quy chuẩn áp dụng của dự án hoặc cơ sở.',
                ['Cơ sở có yêu cầu quan trắc trong giấy phép môi trường hoặc quyết định phê duyệt ĐTM.', 'Dự án cần quan trắc nền, thi công, vận hành thử nghiệm hoặc vận hành chính thức.', 'Doanh nghiệp cần kiểm chứng hiệu quả xử lý và rủi ro vượt quy chuẩn.'],
                ['Rà soát hồ sơ pháp lý và thiết kế chương trình quan trắc.', 'Lập kế hoạch lấy mẫu, bảo quản, phân tích và QA/QC.', 'Thực hiện, đối chiếu quy chuẩn, cảnh báo bất thường và lập báo cáo.'],
                ['Chương trình và kế hoạch quan trắc.', 'Biên bản hiện trường, phiếu kết quả và hồ sơ QA/QC.', 'Báo cáo tuân thủ cùng khuyến nghị khi có xu hướng bất thường.'],
                ['environment-law', 'environment-amendment', 'environment-decree-amendment', 'environment-circular-2026', 'monitoring-circular'],
                'Quy chuẩn so sánh phải chọn theo loại nguồn thải, thời điểm áp dụng và giấy phép. Năm 2026 cần đặc biệt kiểm tra các QCVN mới về nước thải, tiếng ồn và khí thải; không dùng một quy chuẩn mặc định cho mọi cơ sở.',
                ['QuanTracMoiTruong', 'QuanTracDinhKy', 'LayMauMoiTruong', 'PhanTichMoiTruong', 'QCVN', 'QAQC', 'BaoCaoQuanTrac', 'KiemSoatNguonThai', 'ThongTu102021', 'MoiTruongBaoChau'],
            ),
            'quan-trac-moi-truong-lao-dong' => $this->service(
                'Quan trắc yếu tố có hại tại nơi làm việc và hỗ trợ đánh giá điều kiện lao động trên cơ sở hồ sơ vệ sinh lao động, vị trí việc làm và thời gian tiếp xúc thực tế.',
                ['Doanh nghiệp, cơ sở sản xuất, bệnh viện, trường học và tổ chức có sử dụng lao động.', 'Nơi làm việc có yếu tố vi khí hậu, vật lý, bụi, hóa chất, hơi khí độc hoặc sinh học.', 'Đơn vị cần dữ liệu quản lý sức khỏe, bệnh nghề nghiệp và phân loại lao động.'],
                ['Rà soát hồ sơ vệ sinh lao động, quy trình sản xuất và nhóm tiếp xúc.', 'Lập kế hoạch, đo kiểm, lấy mẫu và phân tích theo quy chuẩn vệ sinh lao động.', 'Đánh giá kết quả, lập báo cáo và kiến nghị biện pháp kiểm soát.'],
                ['Kế hoạch và sơ đồ vị trí quan trắc.', 'Kết quả đo kiểm, phân tích và đánh giá tiếp xúc.', 'Báo cáo cùng khuyến nghị kỹ thuật, tổ chức và bảo vệ cá nhân.'],
                ['occupational-law', 'occupational-decree', 'occupational-circular'],
                'Hoạt động phải do tổ chức đủ điều kiện thực hiện. Danh mục yếu tố đo và số mẫu được xác định từ hồ sơ vệ sinh lao động và khảo sát thực tế, không chỉ từ yêu cầu báo giá.',
                ['QuanTracMoiTruongLaoDong', 'VeSinhLaoDong', 'AnToanLaoDong', 'YeuToCoHai', 'BenhNgheNghiep', 'PhanLoaiLaoDong', 'NghiDinh442016', 'ThongTu192016', 'SucKhoeNguoiLaoDong', 'MoiTruongBaoChau'],
            ),
            'thu-gom-xu-ly-chat-thai' => $this->service(
                'Tư vấn phân định, phân loại, lưu giữ và tổ chức chuyển giao chất thải đến đơn vị có chức năng, bảo đảm hồ sơ truy xuất từ chủ nguồn thải đến xử lý.',
                ['Cơ sở phát sinh chất thải sinh hoạt, công nghiệp thông thường hoặc nguy hại.', 'Doanh nghiệp cần rà soát kho, mã chất thải, chứng từ và hợp đồng chuyển giao.', 'Dự án cần phương án thu gom, vận chuyển, tái sử dụng, tái chế hoặc xử lý.'],
                ['Khảo sát nguồn, phân định dòng chất thải và dự báo khối lượng.', 'Thiết kế phân loại, bao bì, nhãn, khu vực và thời hạn lưu giữ.', 'Kiểm tra năng lực đơn vị tiếp nhận; theo dõi chứng từ, báo cáo và cơ hội tuần hoàn.'],
                ['Danh mục, mã và sơ đồ quản lý dòng chất thải.', 'Quy trình phân loại, lưu giữ và ứng phó sự cố tại kho.', 'Hồ sơ chuyển giao, chứng từ, sổ theo dõi và kế hoạch giảm phát sinh.'],
                ['environment-law', 'environment-amendment', 'environment-decree', 'environment-decree-amendment', 'environment-circular-2026'],
                'Mỗi bên chỉ được thực hiện trong phạm vi chức năng, giấy phép và phương tiện phù hợp. Chất thải phải được phân định theo tính chất và nguồn phát sinh trước khi chọn mã hoặc phương án xử lý.',
                ['ThuGomChatThai', 'VanChuyenChatThai', 'XuLyChatThai', 'ChatThaiNguyHai', 'ChatThaiCongNghiep', 'PhanLoaiTaiNguon', 'ChungTuChatThai', 'KinhTeTuanHoan', 'ThongTu092026', 'MoiTruongBaoChau'],
            ),
            'xay-dung-ban-do-tieng-on' => $this->service(
                'Đo đạc và mô hình hóa phân bố tiếng ồn theo không gian, thời gian để nhận diện nguồn chi phối, khu vực nhạy cảm và hiệu quả phương án giảm ồn.',
                ['Nhà máy, khu công nghiệp, cảng, công trường, tuyến giao thông và khu dịch vụ.', 'Dự án cần đánh giá tiếng ồn trong ĐTM hoặc kiểm chứng khi vận hành.', 'Cơ sở có phản ánh cộng đồng, điểm vượt giới hạn hoặc cần tối ưu cách âm.'],
                ['Khảo sát nguồn, chế độ vận hành, địa hình, công trình và đối tượng nhạy cảm.', 'Thiết kế mạng điểm đo; dựng và hiệu chỉnh mô hình bằng số liệu thực đo.', 'Lập bản đồ hiện trạng, mô phỏng giải pháp và khoanh vùng ưu tiên.'],
                ['Cơ sở dữ liệu nguồn ồn và điểm đo.', 'Bản đồ tiếng ồn hiện trạng và kịch bản sau giảm thiểu.', 'Báo cáo kỹ thuật, vùng ưu tiên và giải pháp kiểm soát.'],
                ['environment-law', 'environment-amendment', 'monitoring-circular'],
                'Kết quả năm 2026 phải đối chiếu QCVN 26:2025/BNNMT và yêu cầu riêng trong hồ sơ môi trường. Mô hình phải được hiệu chỉnh bằng đo đạc thực tế; hình ảnh mô phỏng đơn thuần không thay thế quan trắc.',
                ['BanDoTiengOn', 'NoiseMap', 'QCVN262025', 'DoTiengOn', 'MoHinhTiengOn', 'KiemSoatTiengOn', 'AmHocMoiTruong', 'IoTMoiTruong', 'NhaMayXanh', 'MoiTruongBaoChau'],
            ),
            'xu-ly-nuoc-thai' => $this->service(
                'Tư vấn, thiết kế, thi công và tối ưu hệ thống xử lý nước thải, khí thải trên cơ sở tải lượng thực tế, điều kiện vận hành và quy chuẩn áp dụng năm 2026.',
                ['Nhà máy, khu công nghiệp hoặc cơ sở dịch vụ cần đầu tư mới hay nâng công suất.', 'Cơ sở có đầu ra không ổn định, chi phí vận hành cao hoặc thường xuyên gặp sự cố.', 'Dự án cần đồng bộ công nghệ xử lý với ĐTM, giấy phép và quan trắc tự động.'],
                ['Khảo sát, đo lưu lượng, lấy mẫu và xác định tải lượng thiết kế.', 'So sánh công nghệ, lập cân bằng vật chất, thiết kế và dự toán.', 'Lắp đặt, chạy thử, hiệu chỉnh, đào tạo vận hành và thiết lập bảo trì.'],
                ['Báo cáo khảo sát và cơ sở thiết kế.', 'Thuyết minh công nghệ, bản vẽ, danh mục thiết bị và dự toán.', 'Hồ sơ hoàn công, kết quả chạy thử, hướng dẫn vận hành và bảo trì.'],
                ['environment-law', 'environment-amendment', 'environment-decree-amendment', 'environment-circular-2026', 'industrial-emission'],
                'Nước thải công nghiệp cần đối chiếu QCVN 40:2025/BTNMT; nước thải sinh hoạt, đô thị đối chiếu QCVN 14:2025/BTNMT khi thuộc phạm vi; khí thải áp dụng QCVN 19:2024/BTNMT theo lộ trình. Cột và giới hạn phải xác định cho từng nguồn, lưu lượng và thời điểm.',
                ['XuLyNuocThai', 'XuLyKhiThai', 'QCVN402025', 'QCVN142025', 'QCVN192024', 'ThietKeHeThongXuLy', 'ThiCongMoiTruong', 'VanHanhThuNghiem', 'ToiUuHeThong', 'MoiTruongBaoChau'],
            ),
            'xu-ly-khi-thai-cong-nghiep' => $this->service(
                'Khảo sát nguồn và thiết kế giải pháp xử lý bụi, hơi, khí vô cơ, hữu cơ và mùi để đáp ứng QCVN 19:2024/BTNMT cùng yêu cầu trong giấy phép môi trường.',
                ['Lò hơi, lò nung, dây chuyền sơn, hóa chất, luyện kim, gia công và nguồn khí thải công nghiệp.', 'Cơ sở cần cải tạo lọc bụi, hấp thụ, hấp phụ, đốt hoặc xử lý mùi.', 'Nguồn thải phải kết nối quan trắc tự động hoặc có kết quả vượt giới hạn.'],
                ['Khảo sát chụp hút, đường ống, lưu lượng, nhiệt độ, độ ẩm và chất ô nhiễm.', 'Lấy mẫu, xác định tải lượng, chọn công nghệ và tính toán thiết bị.', 'Thi công, chạy thử, cân chỉnh, đo nghiệm thu và hướng dẫn vận hành.'],
                ['Báo cáo khảo sát và dữ liệu thiết kế.', 'Thuyết minh công nghệ, bản vẽ và danh mục thiết bị.', 'Hồ sơ hoàn công, quy trình vận hành và kết quả chạy thử.'],
                ['environment-law', 'environment-decree-amendment', 'environment-circular-2026', 'industrial-emission', 'monitoring-circular'],
                'QCVN 19:2024/BTNMT có hiệu lực từ 01/07/2025 nhưng quy định chuyển tiếp phải kiểm tra cho từng cơ sở. Thiết kế phải xét tải lượng, dao động sản xuất, an toàn cháy nổ và chất thải thứ cấp.',
                ['XuLyKhiThaiCongNghiep', 'QCVN192024', 'KiemSoatKhiThai', 'LocBui', 'XuLyMui', 'HeThongHapThu', 'CEMS', 'OngKhoiCongNghiep', 'VanHanhHeThong', 'MoiTruongBaoChau'],
            ),
            'ung-pho-su-co-moi-truong' => $this->service(
                'Nhận diện nguy cơ và xây dựng phương án phòng ngừa, ứng phó sự cố chất thải, hóa chất hoặc tràn dầu có kịch bản, lực lượng, phương tiện và cơ chế phối hợp rõ ràng.',
                ['Cơ sở có nguy cơ sự cố chất thải, hệ thống xử lý, kho hóa chất hoặc tràn dầu.', 'Dự án cần nội dung ứng phó trong hồ sơ môi trường hoặc kế hoạch chuyên ngành.', 'Doanh nghiệp cần diễn tập và kiểm tra mức sẵn sàng.'],
                ['Khảo sát nguồn nguy cơ, chất nguy hại, tuyến lan truyền và đối tượng ảnh hưởng.', 'Xây dựng kịch bản, sơ đồ chỉ huy, cảnh báo và huy động nguồn lực.', 'Lập danh mục vật tư; đào tạo, diễn tập và cập nhật phương án.'],
                ['Báo cáo nhận diện và đánh giá rủi ro.', 'Phương án ứng phó kèm sơ đồ, quy trình, danh bạ và thiết bị.', 'Kịch bản diễn tập, biên bản đánh giá và kế hoạch khắc phục.'],
                ['environment-law', 'environment-amendment', 'environment-decree-amendment', 'environment-circular-2026'],
                'Phải đối chiếu thêm pháp luật chuyên ngành về hóa chất, dầu khí, phòng cháy chữa cháy và phòng thủ dân sự tùy loại sự cố. Hồ sơ chỉ hiệu quả khi nguồn lực và quy trình được kiểm tra, diễn tập thực tế.',
                ['UngPhoSuCoMoiTruong', 'SuCoChatThai', 'SuCoHoaChat', 'TranDau', 'KeHoachUngPho', 'DienTapSuCo', 'QuanLyRuiRo', 'AnToanHoaChat', 'PhongNguaSuCo', 'MoiTruongBaoChau'],
            ),
            'nghien-cuu-khoa-hoc-moi-truong' => $this->service(
                'Thiết kế và thực hiện nhiệm vụ nghiên cứu môi trường từ câu hỏi khoa học, phương pháp, dữ liệu đến sản phẩm ứng dụng và chuyển giao kết quả.',
                ['Cơ quan quản lý, viện, trường, doanh nghiệp và tổ chức đặt hàng nhiệm vụ khoa học.', 'Đơn vị cần điều tra ô nhiễm, biến đổi khí hậu, đa dạng sinh học hoặc tài nguyên.', 'Doanh nghiệp muốn thử nghiệm công nghệ, vật liệu hoặc mô hình quản lý mới.'],
                ['Xác định vấn đề, tổng quan, giả thuyết, mục tiêu và sản phẩm.', 'Thiết kế khảo sát, thí nghiệm, lấy mẫu, phân tích và quản trị dữ liệu.', 'Thực hiện, QA/QC, phân tích kết quả và xây dựng phương án ứng dụng.'],
                ['Thuyết minh nhiệm vụ và kế hoạch nghiên cứu.', 'Bộ dữ liệu, nhật ký, quy trình và hồ sơ QA/QC.', 'Báo cáo khoa học, sản phẩm và phương án ứng dụng hoặc chuyển giao.'],
                ['science-law', 'science-decree', 'environment-law', 'green-growth'],
                'Luật Khoa học, công nghệ và đổi mới sáng tạo 93/2025/QH15 có hiệu lực từ 01/10/2025. Nhiệm vụ sử dụng ngân sách, dữ liệu hạn chế tiếp cận hoặc hoạt động thử nghiệm phải rà soát thêm cơ chế quản lý chuyên biệt.',
                ['NghienCuuMoiTruong', 'KhoaHocMoiTruong', 'DoiMoiSangTao', 'DuLieuMoiTruong', 'BienDoiKhiHau', 'DaDangSinhHoc', 'QuanLyTaiNguyen', 'NhiemVuKhoaHoc', 'NghiDinh2672025', 'MoiTruongBaoChau'],
            ),
            'giai-phap-chuyen-doi-cong-nghe' => $this->service(
                'Đánh giá, lựa chọn và chuyển giao công nghệ sạch hoặc công nghệ số nhằm giảm tiêu hao, phát thải và rủi ro vận hành, có tiêu chí nghiệm thu và quản trị sở hữu trí tuệ rõ ràng.',
                ['Doanh nghiệp cần thay thế công nghệ lạc hậu hoặc nâng hiệu suất dây chuyền.', 'Cơ sở muốn tự động hóa quản lý môi trường, năng lượng, chất thải và ESG.', 'Tổ chức tiếp nhận công nghệ trong nước hoặc xuyên biên giới.'],
                ['Đánh giá hiện trạng, điểm nghẽn, nhu cầu và chỉ tiêu đầu ra.', 'Sàng lọc nhà cung cấp, mức sẵn sàng, rủi ro và tổng chi phí sở hữu.', 'Thử nghiệm, chuyển giao, đào tạo và nghiệm thu theo KPI.'],
                ['Báo cáo hiện trạng và yêu cầu công nghệ.', 'Ma trận giải pháp, hồ sơ thẩm định và kế hoạch thử nghiệm.', 'Hồ sơ chuyển giao, đào tạo và bộ tiêu chí nghiệm thu.'],
                ['technology-transfer', 'technology-transfer-amendment', 'science-law', 'science-decree', 'environment-law'],
                'Luật 115/2025/QH15 sửa đổi Luật Chuyển giao công nghệ có hiệu lực từ 01/04/2026. Cần kiểm tra công nghệ thuộc diện khuyến khích, hạn chế hoặc cấm và yêu cầu đăng ký, thẩm định trước giao dịch.',
                ['ChuyenDoiCongNghe', 'ChuyenGiaoCongNghe', 'CongNgheSach', 'DoiMoiSangTao', 'TuDongHoaMoiTruong', 'ChuyenDoiSo', 'Luat1152025', 'HieuQuaSanXuat', 'CongNgheXanh', 'MoiTruongBaoChau'],
            ),
            'he-thong-dien-mat-troi' => $this->service(
                'Khảo sát, thiết kế và thi công hệ thống điện mặt trời theo phụ tải, kết cấu mái, an toàn điện - cháy và cơ chế tự sản xuất, tự tiêu thụ đang áp dụng năm 2026.',
                ['Nhà máy, kho, tòa nhà, cơ sở dịch vụ và hộ sử dụng điện muốn giảm chi phí.', 'Khách hàng cần đánh giá đấu nối, bán điện dư hoặc lưu trữ năng lượng.', 'Chủ đầu tư cần rà soát hệ thống hiện hữu theo Luật Điện lực mới.'],
                ['Phân tích phụ tải, bức xạ, che bóng và khả năng chịu lực.', 'Tính công suất, sản lượng, tỷ lệ tự dùng, tổn thất và hiệu quả tài chính.', 'Thiết kế, thực hiện thủ tục, thi công, thử nghiệm và bàn giao.'],
                ['Báo cáo khảo sát và mô phỏng sản lượng.', 'Thiết kế kỹ thuật, bản vẽ, danh mục thiết bị và phân tích tài chính.', 'Hồ sơ nghiệm thu, hướng dẫn vận hành và kế hoạch bảo trì.'],
                ['electricity-law', 'renewable-decree', 'renewable-amendment', 'environment-law', 'green-growth'],
                'Nghị định 243/2026/NĐ-CP sửa đổi cơ chế liên quan từ 26/06/2026. Phương án bán điện dư hoặc mua bán điện trực tiếp phải được kiểm tra theo mô hình, công suất và điểm đấu nối cụ thể.',
                ['DienMatTroi', 'DienMatTroiMaiNha', 'NangLuongTaiTao', 'TuSanXuatTuTieuThu', 'LuatDienLuc2024', 'NghiDinh2432026', 'GiamChiPhiDien', 'GiamPhatThai', 'SolarRooftop', 'MoiTruongBaoChau'],
            ),
            'he-thong-quan-trac-tu-dong' => $this->service(
                'Thiết kế, lắp đặt và vận hành hệ thống quan trắc nước thải hoặc khí thải tự động, liên tục, bảo đảm đo đúng, lưu dữ liệu, camera và truyền nhận ổn định.',
                ['Cơ sở thuộc đối tượng phải quan trắc tự động, liên tục theo quy mô nguồn thải.', 'Doanh nghiệp có yêu cầu lắp đặt trong giấy phép môi trường.', 'Hệ thống hiện hữu cần nâng cấp thiết bị, trạm, phần mềm hoặc đường truyền.'],
                ['Rà soát đối tượng, thông số, vị trí và giao thức dữ liệu.', 'Thiết kế nhà trạm, lấy mẫu, tiền xử lý, thiết bị đo, camera và lưu điện.', 'Lắp đặt, hiệu chuẩn, kết nối; xây dựng QA/QC và bảo trì.'],
                ['Báo cáo khảo sát và thiết kế hệ thống.', 'Hồ sơ thiết bị, hiệu chuẩn, cấu hình và biên bản kết nối.', 'Quy trình vận hành, QA/QC, bảo trì và ứng phó sự cố.'],
                ['environment-law', 'environment-decree-amendment', 'environment-circular-2026', 'monitoring-circular', 'industrial-emission'],
                'Đối tượng và thông số bắt buộc xác định theo Nghị định 08/2022/NĐ-CP đã sửa đổi, giấy phép và quy chuẩn nguồn thải. Lắp thiết bị chưa hoàn tất nghĩa vụ nếu thiếu QA/QC, hiệu chuẩn, dữ liệu hợp lệ hoặc truyền nhận liên tục.',
                ['QuanTracTuDong', 'QuanTracLienTuc', 'CEMS', 'WQMS', 'TruyenDuLieuQuanTrac', 'HieuChuanThietBi', 'QAMoiTruong', 'CameraQuanTrac', 'TramQuanTrac', 'MoiTruongBaoChau'],
            ),
            'tu-van-epr' => $this->service(
                'Xác định trách nhiệm tái chế hoặc xử lý sản phẩm, bao bì; tính khối lượng, lựa chọn phương án và chuẩn bị hồ sơ EPR cho nhà sản xuất, nhập khẩu.',
                ['Nhà sản xuất, nhập khẩu sản phẩm và bao bì thuộc trách nhiệm tái chế.', 'Doanh nghiệp thuộc trách nhiệm đóng góp tài chính hỗ trợ xử lý chất thải.', 'Tập đoàn cần hợp nhất dữ liệu EPR giữa nhiều pháp nhân và nhãn hàng.'],
                ['Rà soát sản phẩm, bao bì, khối lượng và trường hợp miễn trừ.', 'Chuẩn hóa dữ liệu theo pháp nhân, chủng loại, vật liệu và kỳ báo cáo.', 'So sánh phương án tái chế, ủy quyền hoặc đóng góp và chuẩn bị hồ sơ.'],
                ['Ma trận sản phẩm, bao bì và trách nhiệm EPR.', 'Bộ dữ liệu khối lượng, tài liệu nguồn và phép tính nghĩa vụ.', 'Phương án tuân thủ, hồ sơ đăng ký/báo cáo và lịch kiểm soát.'],
                ['environment-law', 'environment-amendment', 'environment-decree', 'environment-decree-amendment', 'environment-circular-2026'],
                'Trách nhiệm phải xác định theo đúng pháp nhân, loại sản phẩm hoặc bao bì, ngưỡng và miễn trừ. Không dùng doanh số ước tính thay cho dữ liệu truy xuất khi lập hồ sơ chính thức.',
                ['TuVanEPR', 'TrachNhiemTaiChe', 'NhaSanXuatNhapKhau', 'BaoBi', 'TaiCheBatBuoc', 'DongGopTaiChinh', 'KinhTeTuanHoan', 'DuLieuEPR', 'ThongTu092026', 'MoiTruongBaoChau'],
            ),
        ];
    }

    /**
     * @param  array<int, string>  $audience
     * @param  array<int, string>  $work
     * @param  array<int, string>  $deliverables
     * @param  array<int, string>  $laws
     * @param  array<int, string>  $tags
     * @return array{summary: string, audience: array<int, string>, work: array<int, string>, deliverables: array<int, string>, laws: array<int, string>, note: string, tags: array<int, string>}
     */
    private function service(string $summary, array $audience, array $work, array $deliverables, array $laws, string $note, array $tags): array
    {
        return compact('summary', 'audience', 'work', 'deliverables', 'laws', 'note', 'tags');
    }

    /**
     * @param  array{summary: string, audience: array<int, string>, work: array<int, string>, deliverables: array<int, string>, laws: array<int, string>, note: string, tags: array<int, string>}  $service
     */
    private function buildContent(array $service): string
    {
        $audience = $this->list($service['audience']);
        $work = $this->list($service['work']);
        $deliverables = $this->list($service['deliverables']);
        $laws = collect($service['laws'])->map(function (string $key): string {
            $source = $this->legalSources()[$key];

            return '<li><a href="'.e($source['url']).'" target="_blank" rel="noopener noreferrer"><strong>'.e($source['label']).'</strong></a>: '.e($source['description']).'</li>';
        })->implode('');

        return <<<HTML
<p><strong>Cập nhật pháp lý đến tháng 09/2026.</strong> Nội dung dưới đây giúp doanh nghiệp nhận diện phạm vi công việc; nghĩa vụ cuối cùng được xác định theo hồ sơ, quy mô, địa điểm và hoạt động thực tế của từng dự án.</p>
<h2><span id="tong-quan-dich-vu">Tổng quan dịch vụ</span></h2>
<p>{$service['summary']}</p>
<h2><span id="doi-tuong-ap-dung">Đối tượng và thời điểm cần thực hiện</span></h2>
<ul>{$audience}</ul>
<h2><span id="can-cu-phap-ly">Căn cứ pháp lý và tiêu chuẩn áp dụng</span></h2>
<ul>{$laws}</ul>
<p><strong>Lưu ý áp dụng:</strong> {$service['note']}</p>
<h2><span id="pham-vi-trien-khai">Phạm vi triển khai</span></h2>
<ul>{$work}</ul>
<h2><span id="ho-so-ban-giao">Hồ sơ và kết quả bàn giao</span></h2>
<ul>{$deliverables}</ul>
<h2><span id="quy-trinh-dong-hanh">Quy trình đồng hành</span></h2>
<ol>
<li><strong>Sàng lọc và khảo sát:</strong> Xác định mục tiêu, đối tượng áp dụng, hiện trạng, dữ liệu đầu vào và khoảng trống cần xử lý.</li>
<li><strong>Thống nhất phương án:</strong> Chốt ranh giới công việc, phương pháp, kế hoạch, trách nhiệm cung cấp dữ liệu và tiêu chí nghiệm thu.</li>
<li><strong>Triển khai và kiểm soát chất lượng:</strong> Thực hiện chuyên môn, kiểm tra dữ liệu, lưu bằng chứng và phối hợp xử lý nội dung phát sinh.</li>
<li><strong>Bàn giao và hỗ trợ tuân thủ:</strong> Hoàn thiện hồ sơ hoặc hệ thống, hướng dẫn áp dụng, theo dõi kiến nghị và cập nhật khi phạm vi thay đổi.</li>
</ol>
<h2><span id="cam-ket-chat-luong">Nguyên tắc chất lượng</span></h2>
<p>Môi Trường Bảo Châu xây dựng giải pháp trên dữ liệu có nguồn, kiểm soát phiên bản hồ sơ và đối chiếu văn bản có hiệu lực tại thời điểm thực hiện. Nội dung website mang tính thông tin dịch vụ, không thay thế kết luận của cơ quan có thẩm quyền hoặc ý kiến pháp lý cho một hồ sơ cụ thể.</p>
HTML;
    }

    /** @param array<int, string> $items */
    private function list(array $items): string
    {
        return collect($items)->map(fn (string $item): string => '<li>'.e($item).'</li>')->implode('');
    }

    /** @return array<string, array{label: string, url: string, description: string}> */
    private function legalSources(): array
    {
        return [
            'environment-law' => ['label' => 'Luật Bảo vệ môi trường 72/2020/QH14', 'url' => 'https://vanban.chinhphu.vn/?docid=202613&pageid=27160', 'description' => 'khung nghĩa vụ bảo vệ môi trường, quản lý chất thải, ĐTM, giấy phép, EPR và ứng phó sự cố.'],
            'environment-amendment' => ['label' => 'Luật 146/2025/QH15', 'url' => 'https://vanban.chinhphu.vn/?docid=216543&orggroupid=1&pageid=27160', 'description' => 'sửa đổi một số luật trong lĩnh vực nông nghiệp và môi trường, có hiệu lực từ 01/01/2026.'],
            'environment-decree' => ['label' => 'Nghị định 08/2022/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=205092&pageid=27160&typegroupid=4', 'description' => 'quy định chi tiết thi hành một số điều của Luật Bảo vệ môi trường.'],
            'environment-decree-amendment' => ['label' => 'Nghị định 05/2025/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=212284&orggroupid=2&pageid=27160', 'description' => 'sửa đổi, bổ sung Nghị định 08/2022/NĐ-CP.'],
            'environment-circular-2026' => ['label' => 'Thông tư 09/2026/TT-BNNMT', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=216920&pageid=27160', 'description' => 'cập nhật Thông tư 02/2022/TT-BTNMT từ ngày 29/01/2026.'],
            'authority-circular' => ['label' => 'Thông tư 07/2025/TT-BNNMT', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=214172&orggroupid=4&pageid=27160', 'description' => 'quy định phân cấp, phân định thẩm quyền quản lý nhà nước về môi trường và biến đổi khí hậu.'],
            'monitoring-circular' => ['label' => 'Thông tư 10/2021/TT-BTNMT', 'url' => 'https://vanban.chinhphu.vn/?docid=203741&pageid=27160', 'description' => 'quy định kỹ thuật quan trắc và quản lý dữ liệu quan trắc môi trường.'],
            'ghg-decree' => ['label' => 'Nghị định 06/2022/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=205077&pageid=27160', 'description' => 'quy định giảm nhẹ phát thải khí nhà kính và bảo vệ tầng ô-dôn.'],
            'ghg-amendment' => ['label' => 'Nghị định 119/2025/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=213875&orggroupid=2&pageid=27160', 'description' => 'sửa đổi Nghị định 06/2022/NĐ-CP từ ngày 01/08/2025.'],
            'ghg-amendment-2026' => ['label' => 'Nghị định 83/2026/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=0&docid=217277&pageid=27160', 'description' => 'tiếp tục sửa đổi khung giảm nhẹ phát thải khí nhà kính từ ngày 23/03/2026.'],
            'ghg-list-2026' => ['label' => 'Quyết định 42/2026/QĐ-TTg', 'url' => 'https://vanban.chinhphu.vn/?docid=219154&pageid=27160', 'description' => 'cập nhật danh mục 2.441 cơ sở phải kiểm kê khí nhà kính, có hiệu lực từ ngày 25/09/2026.'],
            'climate-circular' => ['label' => 'Thông tư 08/2025/TT-BNNMT', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=214084&pageid=27160', 'description' => 'sửa đổi hướng dẫn về ứng phó với biến đổi khí hậu.'],
            'carbon-market' => ['label' => 'Quyết định 232/QĐ-TTg năm 2025', 'url' => 'https://vanban.chinhphu.vn/?classid=0&docid=212592&pageid=27160', 'description' => 'phê duyệt Đề án thành lập và phát triển thị trường các-bon tại Việt Nam.'],
            'green-growth' => ['label' => 'Quyết định 1658/QĐ-TTg năm 2021', 'url' => 'https://vanban.chinhphu.vn/?docid=204226&pageid=27160', 'description' => 'phê duyệt Chiến lược quốc gia về tăng trưởng xanh giai đoạn 2021-2030, tầm nhìn 2050.'],
            'disclosure' => ['label' => 'Thông tư 96/2020/TT-BTC', 'url' => 'https://vanban.chinhphu.vn/?docid=201902&pageid=27160', 'description' => 'hướng dẫn công bố thông tin trên thị trường chứng khoán.'],
            'cbam-regulation' => ['label' => 'Quy định (EU) 2023/956 về CBAM', 'url' => 'https://eur-lex.europa.eu/eli/reg/2023/956/oj', 'description' => 'thiết lập Cơ chế điều chỉnh biên giới carbon của Liên minh châu Âu.'],
            'cbam-definitive' => ['label' => 'Hướng dẫn CBAM giai đoạn chính thức từ 2026', 'url' => 'https://taxation-customs.ec.europa.eu/carbon-border-adjustment-mechanism/cbam-definitive-regime_en', 'description' => 'hướng dẫn hiện hành của Ủy ban châu Âu về đối tượng, khai báo và chứng chỉ CBAM.'],
            'energy-efficiency' => ['label' => 'Luật Sử dụng năng lượng tiết kiệm và hiệu quả 50/2010/QH12', 'url' => 'https://vanban.chinhphu.vn/?docid=96051&pageid=27160', 'description' => 'quy định kiểm toán và quản lý năng lượng.'],
            'electricity-law' => ['label' => 'Luật Điện lực 61/2024/QH15', 'url' => 'https://vanban.chinhphu.vn/?docid=212489&pageid=27160', 'description' => 'khung pháp lý hiện hành cho hoạt động điện lực.'],
            'renewable-decree' => ['label' => 'Nghị định 58/2025/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=213011&orggroupid=2&pageid=27160', 'description' => 'quy định phát triển điện năng lượng tái tạo và điện năng lượng mới.'],
            'renewable-amendment' => ['label' => 'Nghị định 243/2026/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=0&docid=218605&pageid=27160', 'description' => 'sửa đổi cơ chế mua bán điện trực tiếp và điện năng lượng tái tạo từ ngày 26/06/2026.'],
            'occupational-law' => ['label' => 'Luật An toàn, vệ sinh lao động 84/2015/QH13', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=180606&pageid=27160&typegroupid=3', 'description' => 'quy định trách nhiệm kiểm soát yếu tố có hại tại nơi làm việc.'],
            'occupational-decree' => ['label' => 'Nghị định 44/2016/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?docid=185117&pageid=27160', 'description' => 'quy định điều kiện và hoạt động quan trắc môi trường lao động.'],
            'occupational-circular' => ['label' => 'Thông tư 19/2016/TT-BYT', 'url' => 'https://vanban.chinhphu.vn/default.aspx?docid=186904&pageid=27160', 'description' => 'hướng dẫn quản lý vệ sinh lao động và sức khỏe người lao động.'],
            'industrial-emission' => ['label' => 'Thông tư 45/2024/TT-BTNMT và QCVN 19:2024/BTNMT', 'url' => 'https://vanban.chinhphu.vn/?docid=212369&pageid=27160', 'description' => 'quy chuẩn kỹ thuật quốc gia về khí thải công nghiệp, hiệu lực từ ngày 01/07/2025.'],
            'science-law' => ['label' => 'Luật Khoa học, công nghệ và đổi mới sáng tạo 93/2025/QH15', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=214603&pageid=27160&typegroupid=3', 'description' => 'khung pháp lý mới cho nghiên cứu và đổi mới sáng tạo.'],
            'science-decree' => ['label' => 'Nghị định 267/2025/NĐ-CP', 'url' => 'https://vanban.chinhphu.vn/?classid=0&docid=215664&pageid=27160', 'description' => 'hướng dẫn chương trình, nhiệm vụ khoa học, công nghệ và đổi mới sáng tạo.'],
            'technology-transfer' => ['label' => 'Luật Chuyển giao công nghệ 07/2017/QH14', 'url' => 'https://vanban.chinhphu.vn/default.aspx?docid=190284&pageid=27160', 'description' => 'quy định hoạt động chuyển giao và quản lý công nghệ.'],
            'technology-transfer-amendment' => ['label' => 'Luật 115/2025/QH15', 'url' => 'https://vanban.chinhphu.vn/?classid=1&docid=216532&pageid=27160&typegroupid=3', 'description' => 'sửa đổi Luật Chuyển giao công nghệ từ ngày 01/04/2026.'],
        ];
    }
}
