<?php

namespace App\Models;

use Database\Factories\EnvironmentSurveyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EnvironmentSurvey extends Model
{
    /** @use HasFactory<EnvironmentSurveyFactory> */
    use HasFactory;

    protected $fillable = ['reference', 'token', 'company_name', 'contact_email', 'status', 'current_step', 'data', 'history', 'submitted_at'];

    protected $attributes = ['status' => 'draft', 'current_step' => 1];

    protected $hidden = ['token'];

    protected static function booted(): void
    {
        static::creating(function (self $survey): void {
            $survey->reference ??= (string) Str::ulid();
            $survey->token ??= Str::random(64);
        });
    }

    protected function casts(): array
    {
        return ['data' => 'array', 'history' => 'array', 'current_step' => 'integer', 'submitted_at' => 'datetime'];
    }

    public function files(): HasMany
    {
        return $this->hasMany(SurveyFile::class);
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['draft', 'revision_required'], true);
    }
}
