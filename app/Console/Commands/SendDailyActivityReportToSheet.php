<?php

namespace App\Console\Commands;

use App\Services\DailyActivityReportSheetSync;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Throwable;

class SendDailyActivityReportToSheet extends Command
{
    protected $signature = 'report:daily-sheet {--date= : Ngày cần gửi báo cáo (YYYY-MM-DD), mặc định là hôm nay}';

    protected $description = 'Tổng hợp toàn bộ thông tin hoạt động website trong ngày và đồng bộ lên Google Sheets';

    public function handle(DailyActivityReportSheetSync $sync): int
    {
        if (! $sync->isConfigured()) {
            $this->warn('Chưa cấu hình URL Apps Script (GHG_SHEETS_WEBHOOK_URL) và token đồng bộ (GHG_SHEETS_WEBHOOK_TOKEN).');

            return self::FAILURE;
        }

        $dateOption = $this->option('date');
        try {
            $targetDate = filled($dateOption)
                ? Carbon::parse((string) $dateOption, 'Asia/Ho_Chi_Minh')
                : now('Asia/Ho_Chi_Minh');
        } catch (Throwable) {
            $this->error('Định dạng ngày không hợp lệ. Vui lòng dùng YYYY-MM-DD.');

            return self::FAILURE;
        }

        if ($sync->sync($targetDate)) {
            $this->info('Đã gửi báo cáo hoạt động website ngày '.$targetDate->format('d/m/Y').' lên Google Sheets thành công.');

            return self::SUCCESS;
        }

        $this->error('Không thể gửi báo cáo lên Google Sheets. Vui lòng kiểm tra kết nối hoặc cấu hình Apps Script.');

        return self::FAILURE;
    }
}
