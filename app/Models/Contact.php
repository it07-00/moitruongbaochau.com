<?php

namespace App\Models;

use App\ContactStatus;
use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'topic', 'message', 'source', 'ip_address', 'user_agent',
        'status', 'read_at',
    ];

    protected $attributes = ['status' => ContactStatus::New->value];

    protected function casts(): array
    {
        return ['status' => ContactStatus::class, 'read_at' => 'datetime'];
    }
}
