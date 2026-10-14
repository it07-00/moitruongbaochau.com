<?php

namespace App\Observers;

use App\Models\Media;
use App\Services\FrontendImageOptimizer;
use Illuminate\Database\Eloquent\Model;

class FrontendImageObserver
{
    public function __construct(private FrontendImageOptimizer $optimizer) {}

    public function saved(Model $model): void
    {
        if ($model instanceof Media && $model->disk !== 'public') {
            return;
        }
        $fields = ['image', 'thumbnail', 'logo', 'icon', 'avatar', 'og_image', 'twitter_image', 'content', 'requirements', 'benefits', 'metadata', 'value', 'path'];
        $imageFields = ['image', 'thumbnail', 'logo', 'icon', 'avatar', 'og_image', 'twitter_image'];
        $isContentEdit = array_diff(array_keys($model->getChanges()), ['updated_at', 'view_count']) !== [];
        $sources = [];
        foreach ($fields as $field) {
            if (! $model->wasChanged($field) && ! $model->wasRecentlyCreated && ! (in_array($field, $imageFields) && $isContentEdit)) {
                continue;
            }
            $value = $model->getAttribute($field);
            if (is_string($value) && in_array($field, ['value', 'metadata'])) {
                $decoded = json_decode($value, true);
                if (is_array($decoded)) {
                    $value = $decoded;
                }
            }
            if (is_array($value)) {
                array_walk_recursive($value, function (mixed $item) use (&$sources): void {
                    if (is_string($item)) {
                        $sources[] = $item;
                    }
                });
            } elseif (is_string($value)) {
                $sources[] = $value;
            }
        }
        foreach ($sources as $value) {
            preg_match_all('/<img\b[^>]*\bsrc=["\x27]([^"\x27]+)["\x27]/i', $value, $matches);
            array_push($sources, ...array_map(fn (string $source): string => html_entity_decode($source, ENT_QUOTES | ENT_HTML5), $matches[1]));
        }
        foreach (array_unique($sources) as $source) {
            try {
                $this->optimizer->optimize($source);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }
    }
}
