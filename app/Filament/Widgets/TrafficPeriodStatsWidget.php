<?php

namespace App\Filament\Widgets;

use App\Models\CtaClick;
use App\Models\PageView;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TrafficPeriodStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Thống kê Lượt xem & Chuyển đổi theo Thời gian (Ngày / Tuần / Tháng / Năm)';

    protected function getStats(): array
    {
        $now = now();

        // 1. Theo Ngày (Hôm nay vs Hôm qua)
        $viewsToday = PageView::query()->whereDate('created_at', $now->toDateString())->count();
        $viewsYesterday = PageView::query()->whereDate('created_at', $now->copy()->subDay()->toDateString())->count();
        $ctaToday = CtaClick::query()->whereDate('created_at', $now->toDateString())->count();
        $convToday = $viewsToday > 0 ? round(($ctaToday / $viewsToday) * 100, 1) : 0.0;

        // 2. Theo Tuần (Tuần này vs Tuần trước)
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();
        $startOfLastWeek = $now->copy()->subWeek()->startOfWeek();
        $endOfLastWeek = $now->copy()->subWeek()->endOfWeek();

        $viewsWeek = PageView::query()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $viewsLastWeek = PageView::query()->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();
        $ctaWeek = CtaClick::query()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $convWeek = $viewsWeek > 0 ? round(($ctaWeek / $viewsWeek) * 100, 1) : 0.0;

        // 3. Theo Tháng (Tháng này vs Tháng trước)
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $viewsMonth = PageView::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $viewsLastMonth = PageView::query()->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $ctaMonth = CtaClick::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $convMonth = $viewsMonth > 0 ? round(($ctaMonth / $viewsMonth) * 100, 1) : 0.0;

        // 4. Theo Năm (Năm nay vs Năm trước)
        $startOfYear = $now->copy()->startOfYear();
        $endOfYear = $now->copy()->endOfYear();
        $startOfLastYear = $now->copy()->subYear()->startOfYear();
        $endOfLastYear = $now->copy()->subYear()->endOfYear();

        $viewsYear = PageView::query()->whereBetween('created_at', [$startOfYear, $endOfYear])->count();
        $viewsLastYear = PageView::query()->whereBetween('created_at', [$startOfLastYear, $endOfLastYear])->count();
        $ctaYear = CtaClick::query()->whereBetween('created_at', [$startOfYear, $endOfYear])->count();
        $convYear = $viewsYear > 0 ? round(($ctaYear / $viewsYear) * 100, 1) : 0.0;

        return [
            Stat::make('Hôm nay ('.$now->format('d/m').')', number_format($viewsToday).' lượt xem')
                ->description("CTA: {$ctaToday} lượt ({$convToday}%) • Hôm qua: ".number_format($viewsYesterday))
                ->descriptionIcon($viewsToday >= $viewsYesterday ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                ->color($viewsToday >= $viewsYesterday ? 'success' : 'warning')
                ->url(route('filament.admin.resources.page-views.index', ['tab' => 'day::tab'])),

            Stat::make('Tuần này (Tuần '.$now->weekOfYear.')', number_format($viewsWeek).' lượt xem')
                ->description("CTA: {$ctaWeek} lượt ({$convWeek}%) • Tuần trước: ".number_format($viewsLastWeek))
                ->descriptionIcon($viewsWeek >= $viewsLastWeek ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                ->color($viewsWeek >= $viewsLastWeek ? 'info' : 'warning')
                ->url(route('filament.admin.resources.page-views.index', ['tab' => 'week::tab'])),

            Stat::make('Tháng này (Tháng '.$now->format('m/Y').')', number_format($viewsMonth).' lượt xem')
                ->description("CTA: {$ctaMonth} lượt ({$convMonth}%) • Tháng trước: ".number_format($viewsLastMonth))
                ->descriptionIcon($viewsMonth >= $viewsLastMonth ? Heroicon::OutlinedArrowTrendingUp : Heroicon::OutlinedArrowTrendingDown)
                ->color($viewsMonth >= $viewsLastMonth ? 'primary' : 'warning')
                ->url(route('filament.admin.resources.page-views.index', ['tab' => 'month::tab'])),

            Stat::make('Năm nay ('.$now->format('Y').')', number_format($viewsYear).' lượt xem')
                ->description("CTA: {$ctaYear} lượt ({$convYear}%) • Năm trước: ".number_format($viewsLastYear))
                ->descriptionIcon($viewsYear >= $viewsLastYear ? Heroicon::OutlinedCalendarDays : Heroicon::OutlinedArrowTrendingDown)
                ->color('success')
                ->url(route('filament.admin.resources.page-views.index', ['tab' => 'year::tab'])),
        ];
    }
}

