<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        foreach (Service::with('category')->get() as $service) {
            if (filled($service->tags)) {
                continue;
            }

            $tags = $serviceTagMap[$service->slug] ?? [
                $this->tagFrom($service->name, 'DichVuMoiTruong'),
                $this->tagFrom($service->category?->name, 'DichVuMoiTruong'),
                'TuVanMoiTruong',
                'MoiTruongBaoChau',
            ];

            $service->update([
                'tags' => array_values(array_unique($tags)),
            ]);
        }

        // 2. Seed Posts
        foreach (Post::with('category')->get() as $post) {
            if (filled($post->tags)) {
                continue;
            }

            $tags = [
                'TinTucMoiTruong',
                'LuatBVMT2020',
                'PhapLuatMoiTruong',
                'MoiTruongBaoChau',
            ];
            if ($post->category) {
                $tags[] = $this->tagFrom($post->category->name, 'TinTucMoiTruong');
            }

            $post->update([
                'tags' => array_values(array_unique($tags)),
            ]);
        }

        // 3. Seed Projects
        foreach (Project::all() as $project) {
            if (filled($project->tags)) {
                continue;
            }

            $tags = [
                'DuAnTieuBieu',
                'NangLucThucHien',
                $this->tagFrom($project->category, 'DuAnMoiTruong'),
                'MoiTruongBaoChau',
            ];

            $project->update([
                'tags' => array_values(array_unique($tags)),
            ]);
        }

        // 4. Seed Job Postings
        foreach (JobPosting::all() as $job) {
            if (filled($job->tags)) {
                continue;
            }

            $tags = [
                'TuyenDungBaoChau',
                'ViecLamMoiTruong',
                'KySuMoiTruong',
                'CoHoiNgheNghiep',
            ];

            $job->update([
                'tags' => array_values(array_unique($tags)),
            ]);
        }
    }

    private function tagFrom(?string $value, string $fallback): string
    {
        if (blank($value)) {
            return $fallback;
        }

        $tag = Str::studly(preg_replace('/[^a-zA-Z0-9]+/', ' ', Str::ascii($value)) ?? '');

        return filled($tag) ? $tag : $fallback;
    }
}
