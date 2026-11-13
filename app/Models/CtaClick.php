<?php

namespace App\Models;

use App\CtaType;
use Database\Factories\CtaClickFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CtaClick extends Model
{
    /** @use HasFactory<CtaClickFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'label',
        'target_url',
        'page_url',
        'position',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $attributes = [
        'type' => CtaType::Other->value,
    ];

    /**
     * Record a CTA interaction or conversion safely.
     *
     * @param  array<string, mixed>  $metadata
     */
    public static function record(
        CtaType|string $type,
        ?string $label = null,
        ?string $targetUrl = null,
        ?string $pageUrl = null,
        ?string $position = null,
        ?Request $request = null,
        array $metadata = []
    ): self {
        $request ??= request();

        return self::query()->create([
            'type' => $type instanceof CtaType ? $type : (CtaType::tryFrom((string) $type) ?? CtaType::Other),
            'label' => $label !== null ? mb_substr(trim($label), 0, 255) : null,
            'target_url' => $targetUrl !== null ? mb_substr(trim($targetUrl), 0, 500) : null,
            'page_url' => $pageUrl !== null
                ? mb_substr(trim($pageUrl), 0, 500)
                : mb_substr((string) ($request?->headers->get('referer') ?: $request?->fullUrl()), 0, 500),
            'position' => $position !== null ? mb_substr(trim($position), 0, 100) : null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'metadata' => $metadata !== [] ? $metadata : null,
        ]);
    }

    protected function casts(): array
    {
        return [
            'type' => CtaType::class,
            'metadata' => 'array',
        ];
    }
}
