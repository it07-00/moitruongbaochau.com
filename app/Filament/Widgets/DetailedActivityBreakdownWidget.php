<?php

namespace App\Filament\Widgets;

use App\Services\ActivityStatisticsService;
use App\Services\ActivityStatsExcelExport;
use App\Services\DailyActivityReportSheetSync;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DetailedActivityBreakdownWidget extends Widget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.detailed-activity-breakdown-widget';

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
    public function getRows(): array
    {
        return app(ActivityStatisticsService::class)->getSummaryRows();
    }

    public function exportExcel(): StreamedResponse
    {
        return app(ActivityStatsExcelExport::class)->download();
    }

    public function syncToGoogleSheet(): void
    {
        abort_unless(auth()->user()?->is_admin, 403);

        $sync = app(DailyActivityReportSheetSync::class);

        if (! $sync->isConfigured()) {
            Notification::make()
                ->title('Chưa cấu hình Google Sheets Webhook')
                ->body('Vui lòng cấu hình GHG_SHEETS_WEBHOOK_URL và GHG_SHEETS_WEBHOOK_TOKEN trong .env.')
                ->warning()
                ->send();

            return;
        }

        if ($sync->sync()) {
            Notification::make()
                ->title('Đã đồng bộ lên Google Sheets')
                ->body('Báo cáo hoạt động ngày '.now('Asia/Ho_Chi_Minh')->format('d/m/Y').' đã được gửi tới tab DAILY REPORT.')
                ->success()
                ->send();

            return;
        }

        Notification::make()
            ->title('Đồng bộ Google Sheets thất bại')
            ->body('Vui lòng kiểm tra lại URL webhook, token hoặc Google Apps Script.')
            ->danger()
            ->send();
    }

    public function getDateSummary(): string
    {
        return Carbon::now()->format('d/m/Y H:i');
    }
}
