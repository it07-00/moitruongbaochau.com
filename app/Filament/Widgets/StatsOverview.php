<?php

namespace App\Filament\Widgets;

use App\ContactStatus;
use App\CtaType;
use App\Models\Contact;
use App\Models\CtaClick;
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
    protected ?string $heading = 'Tổng quan hệ thống';

    protected function getStats(): array
    {
        $newContacts = Contact::generalContacts()->where('status', ContactStatus::New)->count();
        $newGhgConsultations = Contact::ghgConsultations()->where('status', ContactStatus::New)->count();
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

        $totalServices = Service::count();
        $totalProjects = Project::count();
        $totalPosts = Post::count();

        return [
            Stat::make('Yêu cầu liên hệ mới', $newContacts)
                ->description($newContacts > 0 ? 'Khách hàng đang chờ phản hồi' : 'Tất cả liên hệ đã xử lý')
                ->descriptionIcon($newContacts > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckCircle)
                ->color($newContacts > 0 ? 'warning' : 'success'),

            Stat::make('Tư vấn khí nhà kính mới', $newGhgConsultations)
                ->description($newGhgConsultations > 0 ? 'Đăng ký tư vấn / Yêu cầu gọi lại' : 'Tất cả yêu cầu đã xử lý')
                ->descriptionIcon(Heroicon::OutlinedPhone)
                ->color($newGhgConsultations > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.ghg-consultations.index')),

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

            Stat::make('Dịch vụ môi trường', $totalServices)
                ->description('Đang cung cấp cho khách hàng')
                ->descriptionIcon(Heroicon::OutlinedBriefcase)
                ->color('primary'),

            Stat::make('Dự án & Tin tức', $totalProjects + $totalPosts)
                ->description("{$totalProjects} dự án • {$totalPosts} bài viết")
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('gray'),
        ];
    }
}
