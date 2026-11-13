<?php

namespace App\Models;

use Database\Factories\GhgDeclarationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GhgDeclaration extends Model
{
    /** @use HasFactory<GhgDeclarationFactory> */
    use HasFactory;

    protected $fillable = ['reference', 'company_name', 'contact_email', 'status', 'current_step', 'data', 'evidence', 'submitted_at'];

    protected $attributes = ['status' => 'draft', 'current_step' => 1];

    protected static function booted(): void
    {
        static::deleting(function (self $declaration): void {
            foreach ($declaration->evidence ?? [] as $file) {
                if (! empty($file['path'])) {
                    Storage::disk('local')->delete($file['path']);
                }
            }
        });
    }

    protected function casts(): array
    {
        return ['data' => 'array', 'evidence' => 'array', 'current_step' => 'integer', 'submitted_at' => 'datetime'];
    }
}
