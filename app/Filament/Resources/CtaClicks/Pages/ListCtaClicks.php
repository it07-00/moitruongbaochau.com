<?php

namespace App\Filament\Resources\CtaClicks\Pages;

use App\Filament\Resources\CtaClicks\CtaClickResource;
use App\Filament\Widgets\TrafficChartWidget;
use App\Filament\Widgets\TrafficPeriodStatsWidget;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCtaClicks extends ListRecords
{
    protected static string $resource = CtaClickResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TrafficPeriodStatsWidget::class,
            TrafficChartWidget::class,
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $now = now();

        return [
            'all' => Tab::make('Tất cả')
                ->badge(fn (): int => static::getResource()::getEloquentQuery()->count()),
            'day' => Tab::make('Theo ngày (Hôm nay)')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereDate('created_at', $now->toDateString()))
                ->badge(fn (): int => static::getResource()::getEloquentQuery()->whereDate('created_at', $now->toDateString())->count())
                ->badgeColor('success'),
            'week' => Tab::make('Theo tuần (Tuần này)')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()]))
                ->badge(fn (): int => static::getResource()::getEloquentQuery()->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])->count())
                ->badgeColor('info'),
            'month' => Tab::make('Theo tháng (Tháng '.$now->format('m/Y').')')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()]))
                ->badge(fn (): int => static::getResource()::getEloquentQuery()->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->count())
                ->badgeColor('primary'),
            'year' => Tab::make('Theo năm ('.$now->format('Y').')')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereBetween('created_at', [$now->copy()->startOfYear(), $now->copy()->endOfYear()]))
                ->badge(fn (): int => static::getResource()::getEloquentQuery()->whereBetween('created_at', [$now->copy()->startOfYear(), $now->copy()->endOfYear()])->count())
                ->badgeColor('warning'),
        ];
    }
}
