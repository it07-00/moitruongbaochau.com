<?php

namespace App\Models;

use Database\Factories\RedirectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    /** @use HasFactory<RedirectFactory> */
    use HasFactory;

    protected $fillable = ['old_path', 'new_path', 'status_code', 'is_active'];

    protected $attributes = ['status_code' => 301, 'is_active' => true, 'hit_count' => 0];

    protected function casts(): array
    {
        return [
            'status_code' => 'integer',
            'is_active' => 'boolean',
            'hit_count' => 'integer',
            'last_hit_at' => 'datetime',
        ];
    }
}
