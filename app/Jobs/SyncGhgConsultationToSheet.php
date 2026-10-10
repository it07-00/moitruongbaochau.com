<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Services\GhgGoogleSheetSync;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SyncGhgConsultationToSheet implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $contactId) {}

    public function handle(GhgGoogleSheetSync $sync): void
    {
        $contact = Contact::find($this->contactId);
        if ($contact !== null) {
            $sync->sync($contact);
        }
    }
}
