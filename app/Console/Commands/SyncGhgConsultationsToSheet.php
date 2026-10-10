<?php

namespace App\Console\Commands;

use App\Models\Contact;
use App\Services\GhgGoogleSheetSync;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SyncGhgConsultationsToSheet extends Command
{
    protected $signature = 'ghg-sheets:sync {--limit=20}';

    protected $description = 'Gửi lại các yêu cầu tư vấn khí nhà kính đang chờ đồng bộ Google Sheets';

    public function handle(GhgGoogleSheetSync $sync): int
    {
        if (! $sync->isConfigured()) {
            $this->warn('Chưa cấu hình URL Apps Script và token đồng bộ.');

            return self::FAILURE;
        }
        $contacts = Contact::ghgConsultations()->whereNotNull('sheets_sync_key')
            ->whereNull('sheets_synced_at')
            ->where(function (Builder $query): void {
                $query->whereNull('sheets_last_attempt_at')
                    ->orWhere('sheets_last_attempt_at', '<=', now()->subMinutes(5));
            })->oldest()->limit(max(1, min(50, (int) $this->option('limit'))))->get();
        $sent = 0;
        foreach ($contacts as $contact) {
            if ($sync->sync($contact)) {
                $sent++;
            }
        }
        $this->info('Đã đồng bộ '.$sent.'/'.$contacts->count().' yêu cầu.');

        return $sent === $contacts->count() ? self::SUCCESS : self::FAILURE;
    }
}
