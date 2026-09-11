<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSeoAttributes
{
    public static function bootHasSeoAttributes(): void
    {
        static::saving(function (Model $model): void {
            $oldTitle = self::generatedTitle($model, true);
            $newTitle = self::generatedTitle($model);
            $oldDescription = self::generatedDescription($model, true);
            $newDescription = self::generatedDescription($model);
            $oldImage = self::generatedImage($model, true);
            $newImage = self::generatedImage($model);

            if (self::shouldRefresh($model, 'meta_title', $oldTitle) && filled($newTitle)) {
                $model->setAttribute('meta_title', $newTitle);
            }

            if (self::shouldRefresh($model, 'meta_description', $oldDescription) && filled($newDescription)) {
                $model->setAttribute('meta_description', $newDescription);
            }

            if (blank($model->getAttribute('robots'))) {
                $model->setAttribute('robots', 'index,follow');
            }

            $oldMetaTitle = (string) ($model->getOriginal('meta_title') ?: $oldTitle);
            $newMetaTitle = (string) ($model->getAttribute('meta_title') ?: $newTitle);
            $oldMetaDescription = (string) ($model->getOriginal('meta_description') ?: $oldDescription);
            $newMetaDescription = (string) ($model->getAttribute('meta_description') ?: $newDescription);

            if (self::shouldRefresh($model, 'og_title', $oldMetaTitle) && filled($newMetaTitle)) {
                $model->setAttribute('og_title', $newMetaTitle);
            }

            if (self::shouldRefresh($model, 'og_description', $oldMetaDescription) && filled($newMetaDescription)) {
                $model->setAttribute('og_description', $newMetaDescription);
            }

            if (self::shouldRefresh($model, 'og_image', $oldImage) && filled($newImage)) {
                $model->setAttribute('og_image', $newImage);
            }

            $oldOgTitle = (string) ($model->getOriginal('og_title') ?: $oldMetaTitle);
            $newOgTitle = (string) ($model->getAttribute('og_title') ?: $newMetaTitle);
            $oldOgDescription = (string) ($model->getOriginal('og_description') ?: $oldMetaDescription);
            $newOgDescription = (string) ($model->getAttribute('og_description') ?: $newMetaDescription);
            $oldOgImage = (string) ($model->getOriginal('og_image') ?: $oldImage);
            $newOgImage = (string) ($model->getAttribute('og_image') ?: $newImage);

            if (self::shouldRefresh($model, 'twitter_title', $oldOgTitle) && filled($newOgTitle)) {
                $model->setAttribute('twitter_title', $newOgTitle);
            }

            if (self::shouldRefresh($model, 'twitter_description', $oldOgDescription) && filled($newOgDescription)) {
                $model->setAttribute('twitter_description', $newOgDescription);
            }

            if (self::shouldRefresh($model, 'twitter_image', $oldOgImage) && filled($newOgImage)) {
                $model->setAttribute('twitter_image', $newOgImage);
            }
        });
    }

    public function scopeIndexable(Builder $query): Builder
    {
        return $query->where(fn (Builder $query): Builder => $query
            ->whereNull('robots')
            ->orWhere('robots', 'not like', 'noindex%'));
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

    private static function shouldRefresh(Model $model, string $attribute, ?string $oldGeneratedValue): bool
    {
        if (blank($model->getAttribute($attribute))) {
            return true;
        }

        if (! $model->exists || $model->isDirty($attribute)) {
            return false;
        }

        return (string) $model->getOriginal($attribute) === (string) $oldGeneratedValue;
    }

    private static function generatedTitle(Model $model, bool $original = false): string
    {
        $attributes = $original ? $model->getOriginal() : $model->getAttributes();
        $title = (string) ($attributes['title'] ?? $attributes['name'] ?? '');

        return Str::limit(self::cleanText($title), 60, '');
    }

    private static function generatedDescription(Model $model, bool $original = false): string
    {
        $attributes = $original ? $model->getOriginal() : $model->getAttributes();

        foreach (['excerpt', 'summary', 'short_description', 'description', 'content'] as $attribute) {
            $value = (string) ($attributes[$attribute] ?? '');

            if (filled($value)) {
                return Str::limit(self::cleanText($value), 160, '');
            }
        }

        return '';
    }

    private static function generatedImage(Model $model, bool $original = false): string
    {
        $attributes = $original ? $model->getOriginal() : $model->getAttributes();

        return (string) ($attributes['thumbnail'] ?? $attributes['image'] ?? '');
    }

    private static function cleanText(string $value): string
    {
        return Str::squish(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }
}
