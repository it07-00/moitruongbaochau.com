<?php

namespace App\Models;

use App\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use App\Models\Concerns\HasSeoAttributes;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    use HasPublicationStatus;
    use HasSeoAttributes;

    protected $fillable = [
        'service_category_id', 'name', 'slug', 'short_description', 'content', 'thumbnail',
        'icon', 'status', 'view_count', 'tags', 'rating_average', 'rating_count', 'is_featured', 'sort_order', 'published_at', 'meta_title',
        'meta_description', 'canonical_url', 'robots', 'og_title', 'og_description',
        'og_image', 'twitter_title', 'twitter_description', 'twitter_image',
    ];

    protected $attributes = ['status' => ContentStatus::Draft->value, 'robots' => 'index,follow'];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'view_count' => 'integer',
            'tags' => 'array',
            'rating_average' => 'decimal:1',
            'rating_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if (blank($this->thumbnail)) {
            return asset('assets/images/logo-leave-png-min.png');
        }

        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        if (str_starts_with($this->thumbnail, 'assets/')) {
            return asset($this->thumbnail);
        }

        if (str_starts_with($this->thumbnail, 'storage/')) {
            return asset($this->thumbnail);
        }

        if (str_starts_with($this->thumbnail, 'uploads/')) {
            return asset('storage/'.$this->thumbnail);
        }

        return asset('assets/images/'.ltrim($this->thumbnail, '/'));
    }
}
