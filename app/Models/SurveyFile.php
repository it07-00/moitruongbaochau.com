<?php

namespace App\Models;

use Database\Factories\SurveyFileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyFile extends Model
{
    /** @use HasFactory<SurveyFileFactory> */
    use HasFactory;

    protected $fillable = ['category', 'original_name', 'stored_name', 'path', 'mime_type', 'size', 'uploaded_at'];

    protected $hidden = ['path', 'stored_name'];

    protected function casts(): array
    {
        return ['environment_survey_id' => 'integer', 'size' => 'integer', 'uploaded_at' => 'datetime'];
    }

    public function survey(): BelongsTo
    {
        return $this->belongsTo(EnvironmentSurvey::class, 'environment_survey_id');
    }
}
