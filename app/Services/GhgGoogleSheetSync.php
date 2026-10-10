<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Throwable;

class GhgGoogleSheetSync
{
    public function isConfigured(): bool
    {
        $url = config('ghg_landing.sheets_webhook_url');

        return is_string($url)
            && preg_match('~^https://script\.google\.com/macros/s/[A-Za-z0-9_-]+/exec$~D', $url) === 1
            && filled(config('ghg_landing.sheets_webhook_token'));
    }

    public function sync(Contact $contact): bool
    {
        $contact->refresh();
        if ($contact->sheets_synced_at !== null) {
            return true;
        }
        if (! $this->isConfigured() || ! $contact->sheets_sync_key || ! $contact->sheets_payload
            || ! Contact::ghgConsultations()->whereKey($contact->id)->exists()) {
            return false;
        }

        $contact->forceFill(['sheets_last_attempt_at' => now(), 'sheets_sync_error' => null])->save();
        try {
            $response = Http::asJson()->acceptJson()->connectTimeout(3)->timeout(10)
                ->post(config('ghg_landing.sheets_webhook_url'), [
                    'token' => config('ghg_landing.sheets_webhook_token'),
                    'spreadsheet_id' => config('ghg_landing.sheets_spreadsheet_id'),
                    'sheet_name' => config('ghg_landing.sheets_tab_name'),
                    'request_id' => $contact->sheets_sync_key,
                    'values' => [
                        $contact->sheets_sync_key,
                        $contact->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s'),
                        $contact->name, $contact->phone, $contact->email ?? '',
                        $contact->sheets_payload['company_name'] ?? '',
                        $contact->sheets_payload['consultation_type'] ?? '',
                        $contact->sheets_payload['message'] ?? '',
                        $contact->source, $contact->status->getLabel(),
                    ],
                ]);
            if (! $response->successful() || $response->json('ok') !== true
                || $response->json('request_id') !== $contact->sheets_sync_key) {
                $contact->forceFill(['sheets_sync_error' => 'rejected'])->save();

                return false;
            }
            $contact->forceFill(['sheets_synced_at' => now(), 'sheets_sync_error' => null])->save();

            return true;
        } catch (Throwable) {
            $contact->forceFill(['sheets_sync_error' => 'connection_failed'])->save();

            return false;
        }
    }
}
