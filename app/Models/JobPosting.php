<?php

namespace App\Models;

use App\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use App\Models\Concerns\HasSeoAttributes;
use Database\Factories\JobPostingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    /** @use HasFactory<JobPostingFactory> */
    use HasFactory;

    use HasPublicationStatus;
    use HasSeoAttributes;

    protected $fillable = [
        'title', 'slug', 'location', 'employment_type', 'summary', 'content', 'requirements',
        'benefits', 'status', 'published_at', 'expires_at', 'meta_title', 'meta_description',
        'canonical_url', 'robots', 'og_title', 'og_description', 'og_image',
        'twitter_title', 'twitter_description', 'twitter_image',
    ];

    protected $attributes = ['status' => ContentStatus::Draft->value, 'robots' => 'index,follow'];

    protected function casts(): array
    {
        return ['expires_at' => 'datetime'];
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where(fn (Builder $query): Builder => $query
            ->whereNull('expires_at')
            ->orWhere('expires_at', '>=', now()));
    }
}
