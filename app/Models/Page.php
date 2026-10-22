<?php

namespace App\Models;

use App\ContentStatus;
use App\Models\Concerns\HasPublicationStatus;
use App\Models\Concerns\HasSeoAttributes;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public const CAPABILITY_FLIPBOOK_URL_PATTERN = '#\Ahttps://heyzine\.com/flip-book/[a-zA-Z0-9]+\.html\z#';

    /** @use HasFactory<PageFactory> */
    use HasFactory;

    use HasPublicationStatus;
    use HasSeoAttributes;

    protected $fillable = [
        'title', 'slug', 'template', 'excerpt', 'content', 'thumbnail', 'metadata', 'status', 'published_at',
        'meta_title', 'meta_description', 'canonical_url', 'robots', 'og_title',
        'og_description', 'og_image', 'twitter_title', 'twitter_description', 'twitter_image',
    ];

    protected $attributes = [
        'status' => ContentStatus::Draft->value,
        'template' => 'default',
        'robots' => 'index,follow',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getCapabilityFlipbookUrl(): ?string
    {
        $url = $this->metadata['capability_flipbook_url'] ?? null;

        return is_string($url) && preg_match(self::CAPABILITY_FLIPBOOK_URL_PATTERN, $url) === 1 ? $url : null;
    }

    public function getPublicUrl(): string
    {
        return match ($this->template) {
            'home' => route('home'),
            'about' => route('about'),
            'capability-profile' => route('capability-profile'),
            'services' => route('services.index'),
            'projects' => route('projects.index'),
            'posts' => route('posts.index'),
            'recruitment' => route('recruitment.index'),
            'contact' => route('contact.index'),
            default => route('pages.show', $this->slug),
        };
    }
}
