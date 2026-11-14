<?php

namespace App\Filament\Widgets;

use App\Models\CtaClick;
use App\Models\PageView;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class TrafficChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Biểu đồ Lượt xem trang & Tương tác CTA';

    protected ?string $description = 'So sánh xu hướng truy cập toàn trang, Landing Page Kiểm kê Khí nhà kính và lượt bấm nút CTA theo Ngày / Tuần / Tháng / Năm';

    protected ?string $maxHeight = '320px';

    public ?string $filter = 'week';

    /**
     * @return array<string, string>
     */
    protected function getFilters(): ?array
    {
        return [
            'day' => 'Theo ngày (24 giờ hôm nay)',
            'week' => 'Theo tuần (7 ngày gần nhất)',
            'month' => 'Theo tháng (30 ngày gần nhất)',
            'year' => 'Theo năm (12 tháng năm nay)',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $activeFilter = $this->filter ?: 'week';

        return match ($activeFilter) {
            'day' => $this->getHourlyDataForToday(),
            'month' => $this->getDailyData(30),
            'year' => $this->getMonthlyDataForYear(),
            default => $this->getDailyData(7),
        };
    }

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * @return array<string, mixed>
     */
    private function getHourlyDataForToday(): array
    {
        $start = now()->startOfDay();
        $end = now()->endOfDay();

        $views = PageView::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'page_key']);

        $ctas = CtaClick::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at']);

        $labels = [];
        $totalViewsSeries = [];
        $ghgViewsSeries = [];
        $ctaSeries = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $labels[] = sprintf('%02d:00', $hour);
            $totalViewsSeries[$hour] = 0;
            $ghgViewsSeries[$hour] = 0;
            $ctaSeries[$hour] = 0;
        }

        foreach ($views as $view) {
            $hour = Carbon::parse($view->created_at)->hour;
            $totalViewsSeries[$hour]++;
            if ($view->page_key === 'landing:ghg-service') {
                $ghgViewsSeries[$hour]++;
            }
        }

        foreach ($ctas as $cta) {
            $hour = Carbon::parse($cta->created_at)->hour;
            $ctaSeries[$hour]++;
        }

        return $this->formatChartDatasets(
            $labels,
            array_values($totalViewsSeries),
            array_values($ghgViewsSeries),
            array_values($ctaSeries),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function getDailyData(int $days): array
    {
        $start = now()->subDays($days - 1)->startOfDay();
        $end = now()->endOfDay();

        $views = PageView::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'page_key']);

        $ctas = CtaClick::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at']);

        $labels = [];
        $totalViewsSeries = [];
        $ghgViewsSeries = [];
        $ctaSeries = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $labels[] = $date->format('d/m');
            $totalViewsSeries[$dateKey] = 0;
            $ghgViewsSeries[$dateKey] = 0;
            $ctaSeries[$dateKey] = 0;
        }

        foreach ($views as $view) {
            $dateKey = Carbon::parse($view->created_at)->format('Y-m-d');
            if (isset($totalViewsSeries[$dateKey])) {
                $totalViewsSeries[$dateKey]++;
                if ($view->page_key === 'landing:ghg-service') {
                    $ghgViewsSeries[$dateKey]++;
                }
            }
        }

        foreach ($ctas as $cta) {
            $dateKey = Carbon::parse($cta->created_at)->format('Y-m-d');
            if (isset($ctaSeries[$dateKey])) {
                $ctaSeries[$dateKey]++;
            }
        }

        return $this->formatChartDatasets(
            $labels,
            array_values($totalViewsSeries),
            array_values($ghgViewsSeries),
            array_values($ctaSeries),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function getMonthlyDataForYear(): array
    {
        $year = now()->year;
        $start = now()->startOfYear();
        $end = now()->endOfYear();

        $views = PageView::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at', 'page_key']);

        $ctas = CtaClick::query()
            ->whereBetween('created_at', [$start, $end])
            ->get(['created_at']);

        $labels = [];
        $totalViewsSeries = [];
        $ghgViewsSeries = [];
        $ctaSeries = [];

        for ($month = 1; $month <= 12; $month++) {
            $labels[] = sprintf('Tháng %02d/%d', $month, $year);
            $totalViewsSeries[$month] = 0;
            $ghgViewsSeries[$month] = 0;
            $ctaSeries[$month] = 0;
        }

        foreach ($views as $view) {
            $month = Carbon::parse($view->created_at)->month;
            $totalViewsSeries[$month]++;
            if ($view->page_key === 'landing:ghg-service') {
                $ghgViewsSeries[$month]++;
            }
        }

        foreach ($ctas as $cta) {
            $month = Carbon::parse($cta->created_at)->month;
            $ctaSeries[$month]++;
        }

        return $this->formatChartDatasets(
            $labels,
            array_values($totalViewsSeries),
            array_values($ghgViewsSeries),
            array_values($ctaSeries),
        );
    }

    /**
     * @param  array<int, string>  $labels
     * @param  array<int, int>  $totalViews
     * @param  array<int, int>  $ghgViews
     * @param  array<int, int>  $ctas
     * @return array<string, mixed>
     */
    private function formatChartDatasets(array $labels, array $totalViews, array $ghgViews, array $ctas): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Tổng lượt xem trang',
                    'data' => $totalViews,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.12)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Lượt xem Landing Page KNK',
                    'data' => $ghgViews,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.1)',
                    'fill' => false,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Lượt tương tác CTA',
                    'data' => $ctas,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                    'fill' => false,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
