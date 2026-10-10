<?php

namespace App\Models;

use App\ContactStatus;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'topic', 'message', 'source', 'ip_address', 'user_agent',
        'status', 'read_at', 'sheets_sync_key', 'sheets_payload',
    ];

    protected $attributes = ['status' => ContactStatus::New->value];

    #[Scope]
    protected function ghgConsultations(Builder $query): Builder
    {
        return $query->whereLike('source', '%'.route('ghg-service.index', [], false));
    }

    #[Scope]
    protected function generalContacts(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->whereNull('source')
                ->orWhereNotLike('source', '%'.route('ghg-service.index', [], false));
        });
    }

    protected function casts(): array
    {
        return [
            'status' => ContactStatus::class,
            'read_at' => 'datetime',
            'sheets_payload' => 'array',
            'sheets_synced_at' => 'datetime',
            'sheets_last_attempt_at' => 'datetime',
        ];
    }
}
