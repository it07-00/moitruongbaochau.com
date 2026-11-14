<?php

namespace App\Services;

use App\ContactStatus;
use App\ContentStatus;
use App\CtaType;
use App\Models\Contact;
use App\Models\CtaClick;
use App\Models\EnvironmentSurvey;
use App\Models\GhgDeclaration;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ActivityStatisticsService
{
    /**
     * @return list<array{
     *     label: string,
     *     group: string,
     *     url: string,
     *     today: int,
     *     week: int,
     *     month: int,
     *     year: int,
     *     total: int,
     *     highlight_label: string,
     *     highlight_tone: string
     * }>
     */
    public function getSummaryRows(): array
    {
        $now = now();
        $ranges = [
            'today_start' => $now->copy()->startOfDay()->toDateTimeString(),
            'today_end' => $now->copy()->endOfDay()->toDateTimeString(),
            'week_start' => $now->copy()->startOfWeek()->toDateTimeString(),
            'week_end' => $now->copy()->endOfWeek()->toDateTimeString(),
            'month_start' => $now->copy()->startOfMonth()->toDateTimeString(),
            'month_end' => $now->copy()->endOfMonth()->toDateTimeString(),
            'year_start' => $now->copy()->startOfYear()->toDateTimeString(),
            'year_end' => $now->copy()->endOfYear()->toDateTimeString(),
        ];

        $postStats = $this->summarizePeriods(Post::query(), $ranges);
        $publishedPosts = Post::query()->where('status', ContentStatus::Published)->count();

        $serviceStats = $this->summarizePeriods(Service::query(), $ranges);
        $publishedServices = Service::query()->where('status', ContentStatus::Published)->count();

        $projectStats = $this->summarizePeriods(Project::query(), $ranges);
        $publishedProjects = Project::query()->where('status', ContentStatus::Published)->count();

        $jobPostingStats = $this->summarizePeriods(JobPosting::query(), $ranges);
        $openJobPostings = JobPosting::query()->published()->open()->count();

        $jobApplicationStats = $this->summarizePeriods(JobApplication::query(), $ranges);
        $newJobApplications = JobApplication::query()->where('status', 'new')->count();

        $contactStats = $this->summarizePeriods(Contact::generalContacts(), $ranges);
        $newContacts = Contact::generalContacts()->where('status', ContactStatus::New)->count();

        $ghgConsultStats = $this->summarizePeriods(Contact::ghgConsultations(), $ranges);
        $newGhgConsults = Contact::ghgConsultations()->where('status', ContactStatus::New)->count();

        $surveyStats = $this->summarizePeriods(EnvironmentSurvey::query(), $ranges);
        $submittedSurveys = EnvironmentSurvey::query()->whereNotNull('submitted_at')->count();

        $declarationStats = $this->summarizePeriods(GhgDeclaration::query(), $ranges);
        $submittedDeclarations = GhgDeclaration::query()->whereNotNull('submitted_at')->count();

        $pageViewStats = $this->summarizePeriods(PageView::query(), $ranges);
        $ghgLandingViews = PageView::query()->where('page_key', 'landing:ghg-service')->count();

        $ctaStats = $this->summarizePeriods(CtaClick::query(), $ranges);
        $hotlineZaloCtas = CtaClick::query()->whereIn('type', [CtaType::Hotline, CtaType::Zalo])->count();

        return [
            $this->makeRow(
                label: 'Bài đăng mới (Tin tức)',
                group: 'Nội dung',
                url: route('filament.admin.resources.posts.index'),
                stats: $postStats,
                highlightLabel: number_format($publishedPosts).' đã xuất bản',
                highlightTone: 'info',
            ),
            $this->makeRow(
                label: 'Dịch vụ mới',
                group: 'Nội dung',
                url: route('filament.admin.resources.services.index'),
                stats: $serviceStats,
                highlightLabel: number_format($publishedServices).' đang hiển thị',
                highlightTone: 'info',
            ),
            $this->makeRow(
                label: 'Dự án mới',
                group: 'Nội dung',
                url: route('filament.admin.resources.projects.index'),
                stats: $projectStats,
                highlightLabel: number_format($publishedProjects).' đã xuất bản',
                highlightTone: 'info',
            ),
            $this->makeRow(
                label: 'Tin tuyển dụng (Vị trí tuyển)',
                group: 'Tuyển dụng',
                url: route('filament.admin.resources.job-postings.index'),
                stats: $jobPostingStats,
                highlightLabel: number_format($openJobPostings).' đang mở tuyển',
                highlightTone: $openJobPostings > 0 ? 'success' : 'gray',
            ),
            $this->makeRow(
                label: 'Đơn tuyển dụng (Hồ sơ ứng viên)',
                group: 'Tuyển dụng',
                url: route('filament.admin.resources.job-applications.index'),
                stats: $jobApplicationStats,
                highlightLabel: number_format($newJobApplications).' hồ sơ mới',
                highlightTone: $newJobApplications > 0 ? 'warning' : 'success',
            ),
            $this->makeRow(
                label: 'Liên hệ khách hàng',
                group: 'Khách hàng',
                url: route('filament.admin.resources.contacts.index'),
                stats: $contactStats,
                highlightLabel: number_format($newContacts).' chưa xử lý',
                highlightTone: $newContacts > 0 ? 'warning' : 'success',
            ),
            $this->makeRow(
                label: 'Tư vấn Khí nhà kính',
                group: 'Khách hàng',
                url: route('filament.admin.resources.ghg-consultations.index'),
                stats: $ghgConsultStats,
                highlightLabel: number_format($newGhgConsults).' chưa xử lý',
                highlightTone: $newGhgConsults > 0 ? 'warning' : 'success',
            ),
            $this->makeRow(
                label: 'Phiếu khảo sát BVMT',
                group: 'Hồ sơ khai báo',
                url: route('filament.admin.resources.khao-sat-bvmt.index'),
                stats: $surveyStats,
                highlightLabel: number_format($submittedSurveys).' đã nộp hoàn tất',
                highlightTone: 'info',
            ),
            $this->makeRow(
                label: 'Phiếu khai báo Khí nhà kính',
                group: 'Hồ sơ khai báo',
                url: route('filament.admin.resources.ghg-declarations.index'),
                stats: $declarationStats,
                highlightLabel: number_format($submittedDeclarations).' đã nộp hoàn tất',
                highlightTone: 'info',
            ),
            $this->makeRow(
                label: 'Lượt xem trang (Tracking)',
                group: 'Lưu lượng',
                url: route('filament.admin.resources.page-views.index'),
                stats: $pageViewStats,
                highlightLabel: 'Landing KNK: '.number_format($ghgLandingViews),
                highlightTone: 'success',
            ),
            $this->makeRow(
                label: 'Tương tác CTA (Hotline / Zalo / Form)',
                group: 'Lưu lượng',
                url: route('filament.admin.resources.cta-clicks.index'),
                stats: $ctaStats,
                highlightLabel: 'Hotline & Zalo: '.number_format($hotlineZaloCtas),
                highlightTone: 'success',
            ),
        ];
    }

    /**
     * @param  Builder<*>  $query
     * @param  array<string, string>  $ranges
     * @return array{today: int, week: int, month: int, year: int, total: int}
     */
    private function summarizePeriods(Builder $query, array $ranges): array
    {
        $row = $query
            ->selectRaw(
                'COUNT(*) as total_count, '
                .'SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as today_count, '
                .'SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as week_count, '
                .'SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as month_count, '
                .'SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as year_count',
                [
                    $ranges['today_start'],
                    $ranges['today_end'],
                    $ranges['week_start'],
                    $ranges['week_end'],
                    $ranges['month_start'],
                    $ranges['month_end'],
                    $ranges['year_start'],
                    $ranges['year_end'],
                ],
            )
            ->first();

        return [
            'today' => (int) ($row?->today_count ?? 0),
            'week' => (int) ($row?->week_count ?? 0),
            'month' => (int) ($row?->month_count ?? 0),
            'year' => (int) ($row?->year_count ?? 0),
            'total' => (int) ($row?->total_count ?? 0),
        ];
    }

    /**
     * @param  array{today: int, week: int, month: int, year: int, total: int}  $stats
     * @return array{
     *     label: string,
     *     group: string,
     *     url: string,
     *     today: int,
     *     week: int,
     *     month: int,
     *     year: int,
     *     total: int,
     *     highlight_label: string,
     *     highlight_tone: string
     * }
     */
    private function makeRow(
        string $label,
        string $group,
        string $url,
        array $stats,
        string $highlightLabel,
        string $highlightTone,
    ): array {
        return [
            'label' => $label,
            'group' => $group,
            'url' => $url,
            'today' => $stats['today'],
            'week' => $stats['week'],
            'month' => $stats['month'],
            'year' => $stats['year'],
            'total' => $stats['total'],
            'highlight_label' => $highlightLabel,
            'highlight_tone' => $highlightTone,
        ];
    }
}
