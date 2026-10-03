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
    public const DECLARATION_ROUTES = [
        'khai-bao-kiem-ke-khi-nha-kinh-2026' => 'declarations.greenhouse-gas-2026',
        'khai-bao-kiem-toan-nang-luong-2026' => 'declarations.energy-audit-2026',
    ];

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

    public function getPublicUrl(): string
    {
        $routeName = self::DECLARATION_ROUTES[$this->slug] ?? null;

        return $routeName ? route($routeName) : route('services.show', $this->slug);
    }

    public function getDeclarationFormUrl(): ?string
    {
        if ($this->slug === 'bao-cao-cong-tac-bao-ve-moi-truong-dinh-ky') {
            return route('bvmt.index');
        }

        return isset(self::DECLARATION_ROUTES[$this->slug]) ? url('/form-'.$this->slug) : null;
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
