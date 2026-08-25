<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SeoData
{
    /**
     * @return array<string, mixed>
     */
    public static function forContent(Model $content, string $canonical, string $schemaType): array
    {
        $name = (string) ($content->getAttribute('title') ?? $content->getAttribute('name'));
        $description = (string) ($content->getAttribute('meta_description')
            ?? $content->getAttribute('short_description')
            ?? $content->getAttribute('excerpt')
            ?? $content->getAttribute('summary')
            ?? '');
        $description = Str::limit(strip_tags($description), 300, '');
        $image = self::absoluteAsset($content->getAttribute('og_image') ?? $content->getAttribute('thumbnail'));

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $schemaType,
            'name' => $name,
            'description' => $description,
            'url' => $canonical,
        ];

        if ($schemaType === 'Article') {
            $schema['headline'] = $name;
            $schema['datePublished'] = $content->getAttribute('published_at')?->toIso8601String();
        }

        if ($image !== null) {
            $schema['image'] = $image;
        }

        return [
            'title' => $content->getAttribute('meta_title') ?: $name,
            'description' => $description,
            'canonical' => $content->getAttribute('canonical_url') ?: $canonical,
            'robots' => $content->getAttribute('robots') ?: 'index,follow',
            'og_title' => $content->getAttribute('og_title') ?: ($content->getAttribute('meta_title') ?: $name),
            'og_description' => $content->getAttribute('og_description') ?: $description,
            'og_image' => $image,
            'twitter_title' => $content->getAttribute('twitter_title') ?: ($content->getAttribute('meta_title') ?: $name),
            'twitter_description' => $content->getAttribute('twitter_description') ?: $description,
            'twitter_image' => self::absoluteAsset($content->getAttribute('twitter_image')) ?: $image,
            'schema' => [$schema],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $schema
     * @return array<string, mixed>
     */
    public static function forPage(string $title, string $description, string $canonical, array $schema = [], ?string $ogImage = null): array
    {
        $image = $ogImage ?: asset('assets/images/optimized/og-moi-truong-bao-chau.webp');

        return [
            'title' => $title,
            'description' => Str::limit(strip_tags($description), 300, ''),
            'canonical' => $canonical,
            'robots' => 'index,follow',
            'og_title' => $title,
            'og_description' => $description,
            'og_image' => $image,
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image,
            'schema' => $schema,
        ];
    }

    private static function absoluteAsset(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(Str::startsWith($path, 'assets/') ? $path : 'assets/images/'.ltrim($path, '/'));
    }
}
