<?php

namespace App\Models;

use App\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use App\Models\Concerns\HasSeoAttributes;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use HasPublicationStatus;
    use HasSeoAttributes;

    protected $fillable = [
        'post_category_id', 'author_id', 'title', 'slug', 'excerpt', 'content', 'thumbnail', 'pdf_file',
        'status', 'is_featured', 'published_at', 'meta_title', 'meta_description',
        'canonical_url', 'robots', 'og_title', 'og_description', 'og_image',
        'twitter_title', 'twitter_description', 'twitter_image',
    ];

    protected $attributes = ['status' => ContentStatus::Draft->value, 'robots' => 'index,follow'];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean'];
    }

    public function getPdfUrlAttribute(): ?string
    {
        if (blank($this->pdf_file)) {
            return null;
        }

        if (str_starts_with($this->pdf_file, 'http://') || str_starts_with($this->pdf_file, 'https://')) {
            return $this->pdf_file;
        }

        return asset(str_starts_with($this->pdf_file, 'uploads/') ? 'storage/'.$this->pdf_file : $this->pdf_file);
    }

    public function getPdfFileNameAttribute(): ?string
    {
        if (blank($this->pdf_file)) {
            return null;
        }

        return basename($this->pdf_file);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
