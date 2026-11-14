<?php

namespace App\Services;

use App\CtaType;
use App\Models\Contact;
use App\Models\CtaClick;
use App\Models\EnvironmentSurvey;
use App\Models\GhgDeclaration;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class DailyActivityReportSheetSync
{
    public function isConfigured(): bool
    {
        $url = config('ghg_landing.sheets_webhook_url');

        return is_string($url)
            && preg_match('~^https://script\.google\.com/macros/s/[A-Za-z0-9_-]+/exec$~D', $url) === 1
            && filled(config('ghg_landing.sheets_webhook_token'));
    }

    /**
     * Build the structured daily activity summary for a specific date.
     *
     * @return array{
     *     request_id: string,
     *     report_date: string,
     *     values: list<string>
     * }
     */
    public function buildPayload(?CarbonInterface $date = null): array
    {
        $targetDate = ($date ? Carbon::instance($date) : now())->timezone('Asia/Ho_Chi_Minh');
        $startOfDay = $targetDate->copy()->startOfDay()->utc();
        $endOfDay = $targetDate->copy()->endOfDay()->utc();
        $dateString = $targetDate->toDateString();

        // 1. Page Views in day
        $dailyViewsQuery = PageView::query()->whereBetween('created_at', [$startOfDay, $endOfDay]);
        $totalDailyViews = (clone $dailyViewsQuery)->count();
        $ghgLandingViews = (clone $dailyViewsQuery)->where('page_key', 'landing:ghg-service')->count();
        $serviceViews = (clone $dailyViewsQuery)->where('page_type', 'service')->count();
        $projectViews = (clone $dailyViewsQuery)->where('page_type', 'project')->count();
        $postViews = (clone $dailyViewsQuery)->where('page_type', 'post')->count();

        // 2. CTA Clicks in day
        $dailyCtaQuery = CtaClick::query()->whereBetween('created_at', [$startOfDay, $endOfDay]);
        $totalDailyCta = (clone $dailyCtaQuery)->count();
        $hotlineCta = (clone $dailyCtaQuery)->where('type', CtaType::Hotline)->count();
        $zaloCta = (clone $dailyCtaQuery)->where('type', CtaType::Zalo)->count();
        $formCta = (clone $dailyCtaQuery)->where('type', CtaType::FormSubmit)->count();
        $mapCta = (clone $dailyCtaQuery)->where('type', CtaType::Map)->count();

        $conversionRate = $totalDailyViews > 0
            ? round(($totalDailyCta / $totalDailyViews) * 100, 1)
            : 0.0;

        // 3. Leads, Declarations & Applications in day
        $generalContacts = Contact::generalContacts()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $ghgConsultations = Contact::ghgConsultations()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $bvmtSurveysCreated = EnvironmentSurvey::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $bvmtSurveysSubmitted = EnvironmentSurvey::query()->whereBetween('submitted_at', [$startOfDay, $endOfDay])->count();
        $ghgDeclarationsCreated = GhgDeclaration::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $ghgDeclarationsSubmitted = GhgDeclaration::query()->whereBetween('submitted_at', [$startOfDay, $endOfDay])->count();
        $jobApplications = JobApplication::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $newPosts = Post::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $newServices = Service::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $newProjects = Project::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $newJobPostings = JobPosting::query()->whereBetween('created_at', [$startOfDay, $endOfDay])->count();

        // 4. Cumulative totals
        $cumulativeViews = (int) Page::sum('view_count')
            + (int) Service::sum('view_count')
            + (int) Project::sum('view_count')
            + (int) Post::sum('view_count')
            + (int) JobPosting::sum('view_count')
            + PageView::where('page_key', 'landing:ghg-service')->count();
        $cumulativeCta = CtaClick::count();

        $requestId = 'daily-report-'.$dateString;

        return [
            'request_id' => $requestId,
            'report_date' => $targetDate->format('d/m/Y'),
            'values' => [
                $requestId,
                $targetDate->format('d/m/Y'),
                now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s'),
                (string) $totalDailyViews,
                (string) $ghgLandingViews,
                "Dịch vụ: {$serviceViews} | Dự án: {$projectViews} | Bài viết: {$postViews}",
                (string) $totalDailyCta,
                "Hotline: {$hotlineCta} | Zalo: {$zaloCta} | Form: {$formCta} | Bản đồ: {$mapCta}",
                $conversionRate.'%',
                (string) $generalContacts,
                (string) $ghgConsultations,
                "Tạo mới: {$bvmtSurveysCreated} | Đã nộp: {$bvmtSurveysSubmitted}",
                "Tạo mới: {$ghgDeclarationsCreated} | Đã nộp: {$ghgDeclarationsSubmitted}",
                (string) $jobApplications,
                "Tổng xem: {$cumulativeViews} | Tổng CTA: {$cumulativeCta} | Mới: {$newPosts} bài, {$newServices} DV, {$newProjects} DA, {$newJobPostings} tin TD",
            ],
        ];
    }

    public function sync(?CarbonInterface $date = null): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $payload = $this->buildPayload($date);

        try {
            $response = Http::asJson()
                ->acceptJson()
                ->connectTimeout(3)
                ->timeout(10)
                ->post(config('ghg_landing.sheets_webhook_url'), [
                    'token' => config('ghg_landing.sheets_webhook_token'),
                    'spreadsheet_id' => config('ghg_landing.sheets_spreadsheet_id'),
                    'sheet_name' => config('ghg_landing.daily_report_tab_name', 'DAILY REPORT'),
                    'request_id' => $payload['request_id'],
                    'values' => $payload['values'],
                ]);

            return $response->successful()
                && $response->json('ok') === true
                && $response->json('request_id') === $payload['request_id'];
        } catch (Throwable) {
            return false;
        }
    }
}
