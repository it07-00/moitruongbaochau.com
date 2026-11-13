<?php

namespace App\Filament\Resources\PageViews\Pages;

use App\Filament\Resources\PageViews\PageViewResource;
use App\Filament\Widgets\TrafficChartWidget;
use App\Filament\Widgets\TrafficPeriodStatsWidget;
use App\Services\DailyActivityReportSheetSync;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ListPageViews extends ListRecords
{
    protected static string $resource = PageViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('syncDailyReportToSheet')
                ->label('Gửi báo cáo ngày lên Google Sheet')
                ->icon(Heroicon::OutlinedCloudArrowUp)
                ->color('success')
                ->schema([
                    DatePicker::make('report_date')
                        ->label('Chọn ngày báo cáo')
                        ->default(now()->toDateString())
                        ->required(),
                ])
                ->action(function (array $data, DailyActivityReportSheetSync $sync): void {
                    if (! $sync->isConfigured()) {
                        Notification::make()
                            ->title('Chưa cấu hình Google Sheets Webhook')
                            ->body('Vui lòng cấu hình GHG_SHEETS_WEBHOOK_URL và GHG_SHEETS_WEBHOOK_TOKEN trong file .env.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $date = Carbon::parse($data['report_date'], 'Asia/Ho_Chi_Minh');

                    if ($sync->sync($date)) {
                        Notification::make()
                            ->title('Đã đồng bộ lên Google Sheets')
                            ->body('Báo cáo hoạt động ngày '.$date->format('d/m/Y').' đã được gửi lên Google Sheet thành công.')
                            ->success()
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->title('Đồng bộ thất bại')
                        ->body('Không thể kết nối tới Google Apps Script Webhook. Vui lòng thử lại sau.')
                        ->danger()
                        ->send();
                }),
        ];
    }

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
