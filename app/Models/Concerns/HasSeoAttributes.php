<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSeoAttributes
{
    /**
     * Boot the SEO trait to automatically generate SEO attributes if blank.
     */
    public static function bootHasSeoAttributes(): void
    {
        static::saving(function (Model $model): void {
            $title = (string) ($model->getAttribute('title') ?? $model->getAttribute('name') ?? '');

            // 1. Meta Title
            if (blank($model->getAttribute('meta_title')) && filled($title)) {
                $model->setAttribute('meta_title', Str::limit(strip_tags($title), 255, ''));
            }

            // 2. Meta Description
            if (blank($model->getAttribute('meta_description'))) {
                $rawDesc = (string) (
                    $model->getAttribute('excerpt')
                    ?? $model->getAttribute('summary')
                    ?? $model->getAttribute('short_description')
                    ?? $model->getAttribute('description')
                    ?? $model->getAttribute('content')
                    ?? ''
                );
                if (filled($rawDesc)) {
                    $cleanDesc = trim(preg_replace('/\s+/', ' ', strip_tags($rawDesc)));
                    $model->setAttribute('meta_description', Str::limit($cleanDesc, 160, ''));
                }
            }

            // 3. Robots
            if (blank($model->getAttribute('robots'))) {
                $model->setAttribute('robots', 'index,follow');
            }

            // 4. OG Title
            if (blank($model->getAttribute('og_title'))) {
                $model->setAttribute('og_title', $model->getAttribute('meta_title') ?: Str::limit(strip_tags($title), 255, ''));
            }

            // 5. OG Description
            if (blank($model->getAttribute('og_description'))) {
                $model->setAttribute('og_description', $model->getAttribute('meta_description') ?: null);
            }

            // 6. OG Image
            if (blank($model->getAttribute('og_image'))) {
                $img = $model->getAttribute('thumbnail') ?? $model->getAttribute('image');
                if (filled($img)) {
                    $model->setAttribute('og_image', $img);
                }
            }

            // 7. Twitter Meta
            if (blank($model->getAttribute('twitter_title'))) {
                $model->setAttribute('twitter_title', $model->getAttribute('og_title'));
            }
            if (blank($model->getAttribute('twitter_description'))) {
                $model->setAttribute('twitter_description', $model->getAttribute('og_description'));
            }
            if (blank($model->getAttribute('twitter_image')) && filled($model->getAttribute('og_image'))) {
                $model->setAttribute('twitter_image', $model->getAttribute('og_image'));
            }
        });
    }

    /**
     * @return array<int, string>
     */
    public static function seoFillable(): array
    {
        return [
            'meta_title',
            'meta_description',
            'canonical_url',
            'robots',
            'og_title',
            'og_description',
            'og_image',
            'twitter_title',
            'twitter_description',
            'twitter_image',
        ];
    }
}
