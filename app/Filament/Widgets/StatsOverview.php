<?php

namespace App\Filament\Widgets;

use App\ContactStatus;
use App\ContentStatus;
use App\CtaType;
use App\Models\Contact;
use App\Models\CtaClick;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\PageView;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Tổng quan hệ thống';

    protected function getStats(): array
    {
        $monthStart = now()->startOfMonth();

        $newContacts = Contact::generalContacts()->where('status', ContactStatus::New)->count();
        $todayContacts = Contact::generalContacts()->whereDate('created_at', today())->count();
        $totalContacts = Contact::generalContacts()->count();

        $newGhgConsultations = Contact::ghgConsultations()->where('status', ContactStatus::New)->count();
        $todayGhgConsultations = Contact::ghgConsultations()->whereDate('created_at', today())->count();

        $newApplications = JobApplication::where('status', 'new')->count();
        $monthApplications = JobApplication::where('created_at', '>=', $monthStart)->count();
        $totalApplications = JobApplication::count();

        $openJobs = JobPosting::published()->open()->count();
        $totalJobs = JobPosting::count();

        $totalPosts = Post::count();
        $monthPosts = Post::where('created_at', '>=', $monthStart)->count();
        $publishedPosts = Post::where('status', ContentStatus::Published)->count();

        $totalServices = Service::count();
        $monthServices = Service::where('created_at', '>=', $monthStart)->count();
        $totalProjects = Project::count();

        $totalCtaClicks = CtaClick::count();
        $hotlineAndZaloClicks = CtaClick::whereIn('type', [CtaType::Hotline, CtaType::Zalo])->count();

        $totalContentViews = (int) Page::sum('view_count')
            + (int) Service::sum('view_count')
            + (int) Project::sum('view_count')
            + (int) Post::sum('view_count')
            + (int) JobPosting::sum('view_count');
        $ghgLandingViews = PageView::where('page_key', 'landing:ghg-service')->count();
        $totalViews = $totalContentViews + $ghgLandingViews;
        $todayPageViews = PageView::whereDate('created_at', today())->count();
        $trackedPageViews = PageView::count();
        $conversionRate = $trackedPageViews > 0
            ? round(($totalCtaClicks / $trackedPageViews) * 100, 1)
            : 0.0;

        return [
            Stat::make('Liên hệ mới', $newContacts)
                ->description("Hôm nay: {$todayContacts} • Tổng: {$totalContacts}")
                ->descriptionIcon($newContacts > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckCircle)
                ->color($newContacts > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.contacts.index')),

            Stat::make('Tư vấn khí nhà kính mới', $newGhgConsultations)
                ->description("Hôm nay: {$todayGhgConsultations} • ".($newGhgConsultations > 0 ? 'Đang chờ xử lý' : 'Đã xử lý hết'))
                ->descriptionIcon(Heroicon::OutlinedPhone)
                ->color($newGhgConsultations > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.ghg-consultations.index')),

            Stat::make('Đơn tuyển dụng mới', $newApplications)
                ->description("Tháng này: {$monthApplications} • Tổng CV: {$totalApplications}")
                ->descriptionIcon(Heroicon::OutlinedDocumentText)
                ->color($newApplications > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.job-applications.index')),

            Stat::make('Tin tuyển dụng đang mở', $openJobs)
                ->description("Tổng tin tuyển dụng: {$totalJobs}")
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->color('info')
                ->url(route('filament.admin.resources.job-postings.index')),

            Stat::make('Bài viết / Tin tức', $totalPosts)
                ->description("Tháng này +{$monthPosts} • Đã đăng: {$publishedPosts}")
                ->descriptionIcon(Heroicon::OutlinedNewspaper)
                ->color('primary')
                ->url(route('filament.admin.resources.posts.index')),

            Stat::make('Dịch vụ & Dự án', $totalServices + $totalProjects)
                ->description("{$totalServices} dịch vụ (+{$monthServices} tháng này) • {$totalProjects} dự án")
                ->descriptionIcon(Heroicon::OutlinedBriefcase)
                ->color('primary')
                ->url(route('filament.admin.resources.services.index')),

            Stat::make('Tổng lượt xem trang', number_format($totalViews))
                ->description("Hôm nay: {$todayPageViews} lượt • Landing KNK: {$ghgLandingViews} lượt")
                ->descriptionIcon(Heroicon::OutlinedEye)
                ->color('success')
                ->url(route('filament.admin.resources.page-views.index')),

            Stat::make('Lượt tương tác CTA', $totalCtaClicks)
                ->description("Hotline & Zalo: {$hotlineAndZaloClicks} lượt • Chuyển đổi: {$conversionRate}%")
                ->descriptionIcon(Heroicon::OutlinedCursorArrowRays)
                ->color('info')
                ->url(route('filament.admin.resources.cta-clicks.index')),
        ];
    }
}
