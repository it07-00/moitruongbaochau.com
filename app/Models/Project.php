<?php

namespace App\Models;

use App\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use App\Models\Concerns\HasSeoAttributes;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    use HasPublicationStatus;
    use HasSeoAttributes;

    protected $fillable = [
        'title', 'slug', 'category', 'client', 'location', 'summary', 'content', 'thumbnail',
        'completed_at', 'status', 'is_featured', 'published_at', 'meta_title',
        'meta_description', 'canonical_url', 'robots', 'og_title', 'og_description',
        'og_image', 'twitter_title', 'twitter_description', 'twitter_image',
    ];

    protected $attributes = ['status' => ContentStatus::Draft->value, 'robots' => 'index,follow'];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'completed_at' => 'date'];
    }
}
