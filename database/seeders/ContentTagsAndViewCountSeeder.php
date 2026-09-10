<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ContentTagsAndViewCountSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Services
        $serviceTagMap = [
            'giay-phep-moi-truong' => ['GiayPhepMoiTruong', 'TuVanMoiTruong', 'HoSoMoiTruongTronGoi', 'LuatBVMT2020', 'MoiTruongBaoChau'],
            'bao-cao-danh-gia-tac-dong-moi-truong-dtm' => ['BaoCaoDTM', 'DanhGiaTacDongMoiTruong', 'TuVanMoiTruong', 'LuatBVMT2020', 'MoiTruongBaoChau'],
            'dang-ky-moi-truong' => ['DangKyMoiTruong', 'KeHoachBVMT', 'ThuTucMoiTruong', 'MoiTruongBaoChau'],
            'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky' => ['BaoCaoBVMTDinhKy', 'QuanTracMoiTruong', 'HoSoMoiTruong', 'MoiTruongBaoChau'],
            'giay-phep-khai-thac-su-dung-nuoc-duoi-dat' => ['KhaiThacNuocNgam', 'TaiNguyenNuoc', 'GiayPhepMoiTruong', 'MoiTruongBaoChau'],
            'kiem-ke-khi-nha-kinh-esg' => ['KiemKeKhiNhaKinh', 'BaoCaoESG', 'DauChanCarbon', 'ISO14064', 'MoiTruongBaoChau'],
            'thiet-ke-thi-cong-he-thong-xu-ly-nuoc-thai' => ['XuLyNuocThai', 'ThietKeHeThong', 'EPCMoiTruong', 'QCVN40', 'MoiTruongBaoChau'],
            'thiet-ke-thi-cong-he-thong-xu-ly-khi-thai' => ['XuLyKhiThai', 'ThapHapThu', 'KiemSoatMui', 'MoiTruongBaoChau'],
            'quan-trac-moi-truong-lao-dong' => ['QuanTracMoiTruongLaoDong', 'AnToanVeSinhLaoDong', 'HoSoVeSinhLaoDong', 'MoiTruongBaoChau'],
            'tu-van-lap-ho-so-ve-sinh-lao-dong' => ['HoSoVeSinhLaoDong', 'YTeCoSo', 'QuanLyMoiTruong', 'MoiTruongBaoChau'],
        ];

        foreach (Service::all() as $service) {
            $tags = $serviceTagMap[$service->slug] ?? [
                str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9]/', ' ', $service->name))),
                $service->category ? str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9]/', ' ', $service->category->name))) : 'DichVuMoiTruong',
                'TuVanMoiTruong',
                'MoiTruongBaoChau',
            ];

            $service->update([
                'tags' => $tags,
                'view_count' => $service->view_count > 0 ? $service->view_count : rand(1500, 3800),
            ]);
        }

        // 2. Seed Posts
        foreach (Post::all() as $post) {
            $tags = [
                'TinTucMoiTruong',
                'LuatBVMT2020',
                'PhapLuatMoiTruong',
                'MoiTruongBaoChau',
            ];
            if ($post->category) {
                $tags[] = str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9]/', ' ', $post->category->name)));
            }

            $post->update([
                'tags' => array_unique($tags),
                'view_count' => $post->view_count > 0 ? $post->view_count : rand(1200, 4500),
            ]);
        }

        // 3. Seed Projects
        foreach (Project::all() as $project) {
            $tags = [
                'DuAnTieuBieu',
                'NangLucThucHien',
                $project->category ? str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9]/', ' ', $project->category))) : 'DuAnMoiTruong',
                'MoiTruongBaoChau',
            ];

            $project->update([
                'tags' => array_unique($tags),
                'view_count' => $project->view_count > 0 ? $project->view_count : rand(900, 2600),
            ]);
        }

        // 4. Seed Job Postings
        foreach (JobPosting::all() as $job) {
            $tags = [
                'TuyenDungBaoChau',
                'ViecLamMoiTruong',
                'KySuMoiTruong',
                'CoHoiNgheNghiep',
            ];

            $job->update([
                'tags' => array_unique($tags),
                'view_count' => $job->view_count > 0 ? $job->view_count : rand(600, 1800),
            ]);
        }
    }
}
