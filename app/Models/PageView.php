<?php

namespace App\Models;

use Database\Factories\PageViewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class PageView extends Model
{
    /** @use HasFactory<PageViewFactory> */
    use HasFactory;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'page_key',
        'page_type',
        'page_title',
        'page_url',
        'referrer',
        'ip_address',
        'session_id',
        'user_agent',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Record a page view and increment the model's view_count (with session deduplication against F5 spam).
     */
    public static function record(
        ?Model $viewable = null,
        string $pageType = 'page',
        ?string $pageKey = null,
        ?string $pageTitle = null,
        ?string $pageUrl = null,
        ?Request $request = null,
        int $cooldownMinutes = 30
    ): ?self {
        $request ??= request();
        $resolvedUrl = $pageUrl !== null
            ? mb_substr(trim($pageUrl), 0, 500)
            : mb_substr('/'.ltrim((string) $request?->path(), '/'), 0, 500);

        $resolvedKey = $pageKey !== null
            ? mb_substr(trim($pageKey), 0, 150)
            : ($viewable !== null
                ? strtolower(class_basename($viewable)).':'.$viewable->getKey()
                : 'url:'.md5($resolvedUrl));

        $sessionKey = 'viewed_pages.'.md5($resolvedKey);
        $hasSession = $request !== null && $request->hasSession();

        if ($hasSession && $cooldownMinutes > 0) {
            $lastViewedAt = (int) $request->session()->get($sessionKey, 0);
            if ($lastViewedAt > 0 && (now()->timestamp - $lastViewedAt) < ($cooldownMinutes * 60)) {
                return null;
            }

            $request->session()->put($sessionKey, now()->timestamp);
        }

        if ($viewable !== null && $viewable->exists) {
            $viewable->increment('view_count');
        }

        $resolvedTitle = $pageTitle
            ?? ($viewable?->getAttribute('title') ?: $viewable?->getAttribute('name'));

        return self::query()->create([
            'viewable_type' => $viewable !== null && $viewable->exists ? $viewable->getMorphClass() : null,
            'viewable_id' => $viewable !== null && $viewable->exists ? $viewable->getKey() : null,
            'page_key' => $resolvedKey,
            'page_type' => mb_substr(trim($pageType), 0, 50),
            'page_title' => $resolvedTitle !== null ? mb_substr(trim((string) $resolvedTitle), 0, 255) : null,
            'page_url' => $resolvedUrl,
            'referrer' => $request?->headers->get('referer')
                ? mb_substr((string) $request->headers->get('referer'), 0, 500)
                : null,
            'ip_address' => $request?->ip(),
            'session_id' => $hasSession ? $request->session()->getId() : null,
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
