<?php

namespace App\Support;

use App\Services\SettingService;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        $title = (string) ($content->getAttribute('meta_title') ?: $name);
        $description = self::descriptionFor($content);
        $canonicalUrl = (string) ($content->getAttribute('canonical_url') ?: $canonical);
        $image = self::absoluteAsset($content->getAttribute('og_image') ?? $content->getAttribute('thumbnail'));
        $twitterImage = self::absoluteAsset($content->getAttribute('twitter_image')) ?: $image;
        $publishedAt = self::isoDate($content->getAttribute('published_at'));
        $modifiedAt = self::isoDate($content->getAttribute('updated_at'));
        $schema = self::contentSchema($content, $schemaType, $name, $title, $description, $canonicalUrl, $image, $publishedAt, $modifiedAt);

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonicalUrl,
            'alternate' => $canonicalUrl,
            'robots' => self::robots((string) ($content->getAttribute('robots') ?: 'index,follow')),
            'og_type' => $schemaType === 'Article' ? 'article' : 'website',
            'og_title' => $content->getAttribute('og_title') ?: $title,
            'og_description' => self::cleanDescription((string) ($content->getAttribute('og_description') ?: $description)),
            'og_image' => $image,
            'og_image_alt' => $name,
            'og_locale' => self::setting('seo_locale', 'vi_VN'),
            'site_name' => self::siteName(),
            'article_published_time' => $schemaType === 'Article' ? $publishedAt : null,
            'article_modified_time' => $schemaType === 'Article' ? $modifiedAt : null,
            'twitter_card' => $twitterImage ? 'summary_large_image' : 'summary',
            'twitter_site' => self::setting('seo_twitter_site'),
            'twitter_title' => $content->getAttribute('twitter_title') ?: $title,
            'twitter_description' => self::cleanDescription((string) ($content->getAttribute('twitter_description') ?: $description)),
            'twitter_image' => $twitterImage,
            'twitter_image_alt' => $name,
            'schema' => [$schema],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $schema
     * @return array<string, mixed>
     */
    public static function forPage(string $title, string $description, string $canonical, array $schema = [], ?string $ogImage = null): array
    {
        $description = self::cleanDescription($description);
        $image = self::absoluteAsset($ogImage ?: self::setting('seo_default_image', 'assets/images/optimized/og-moi-truong-bao-chau.webp'));
        $pageSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => $canonical.'#webpage',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'isPartOf' => ['@id' => route('home').'#website'],
        ];

        return [
            'title' => $title,
            'description' => $description,
            'canonical' => $canonical,
            'alternate' => $canonical,
            'robots' => self::robots('index,follow'),
            'og_type' => 'website',
            'og_title' => $title,
            'og_description' => $description,
            'og_image' => $image,
            'og_image_alt' => $title,
            'og_locale' => self::setting('seo_locale', 'vi_VN'),
            'site_name' => self::siteName(),
            'twitter_card' => $image ? 'summary_large_image' : 'summary',
            'twitter_site' => self::setting('seo_twitter_site'),
            'twitter_title' => $title,
            'twitter_description' => $description,
            'twitter_image' => $image,
            'twitter_image_alt' => $title,
            'schema' => [$pageSchema, ...$schema],
        ];
    }

    /**
     * @param  array<string, mixed>  $seo
     * @return array<string, mixed>
     */
    public static function withPagination(array $seo, LengthAwarePaginator $paginator): array
    {
        $firstPageCanonical = $seo['canonical'];

        if ($paginator->currentPage() > 1) {
            $seo['canonical'] = $paginator->url($paginator->currentPage());
            $seo['alternate'] = $seo['canonical'];
        }

        $seo['prev'] = $paginator->currentPage() === 2
            ? $firstPageCanonical
            : $paginator->previousPageUrl();
        $seo['next'] = $paginator->nextPageUrl();

        foreach ($seo['schema'] as &$schema) {
            if (($schema['@type'] ?? null) === 'WebPage') {
                $schema['@id'] = $seo['canonical'].'#webpage';
                $schema['url'] = $seo['canonical'];
            }
        }
        unset($schema);

        return $seo;
    }

    /**
     * @return array<string, mixed>
     */
    public static function organizationSchema(): array
    {
        $sameAs = array_values(array_filter([
            self::setting('facebook'),
            self::setting('youtube'),
            self::setting('zalo'),
        ]));

        return array_filter([
            '@context' => 'https://schema.org',
            ...self::organizationReference(),
            'legalName' => self::setting('company_name'),
            'taxID' => self::setting('tax_id'),
            'email' => self::setting('email'),
            'telephone' => self::setting('hotline'),
            'address' => self::postalAddress(),
            'sameAs' => $sameAs ?: null,
        ], fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []);
    }

    /**
     * @return array<string, mixed>
     */
    public static function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => route('home').'#website',
            'name' => self::siteName(),
            'url' => route('home'),
            'publisher' => ['@id' => route('home').'#organization'],
            'inLanguage' => 'vi-VN',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public static function localBusinessSchema(): array
    {
        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => route('home').'#localbusiness',
            'name' => self::siteName(),
            'url' => route('contact.index'),
            'image' => self::absoluteAsset(self::setting('logo', 'assets/images/optimized/logo-bao-chau.webp')),
            'telephone' => self::setting('hotline'),
            'email' => self::setting('email'),
            'address' => self::postalAddress(),
            'parentOrganization' => ['@id' => route('home').'#organization'],
        ], fn (mixed $value): bool => $value !== null && $value !== '');
    }

    public static function absoluteAsset(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, 'uploads/')) {
            return asset('storage/'.$path);
        }

        if (Str::startsWith($path, ['assets/', 'storage/'])) {
            return asset($path);
        }

        return asset('assets/images/'.ltrim($path, '/'));
    }

    /**
     * @return array<string, mixed>
     */
    private static function contentSchema(Model $content, string $schemaType, string $name, string $title, string $description, string $canonical, ?string $image, ?string $publishedAt, ?string $modifiedAt): array
    {
        $organization = self::organizationReference();
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $schemaType,
            '@id' => $canonical.'#main',
            'name' => $name,
            'description' => $description,
            'url' => $canonical,
        ];

        if ($image !== null) {
            $schema['image'] = $image;
        }

        if ($schemaType === 'Article') {
            $authorName = $content->relationLoaded('author')
                ? $content->getRelation('author')?->getAttribute('name')
                : null;

            $schema += array_filter([
                'headline' => $title,
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
                'datePublished' => $publishedAt,
                'dateModified' => $modifiedAt,
                'author' => $authorName
                    ? ['@type' => 'Person', 'name' => $authorName]
                    : $organization,
                'publisher' => $organization,
            ], fn (mixed $value): bool => $value !== null);
        }

        if ($schemaType === 'Service') {
            $schema['serviceType'] = $name;
            $schema['provider'] = $organization;
        }

        if ($schemaType === 'JobPosting') {
            $location = (string) $content->getAttribute('location');
            $schema['description'] = self::jobDescription($content);
            $schema += array_filter([
                'title' => $name,
                'datePosted' => $publishedAt,
                'validThrough' => self::isoDate($content->getAttribute('expires_at')),
                'employmentType' => $content->getAttribute('employment_type'),
                'hiringOrganization' => $organization,
                'jobLocation' => filled($location) ? [
                    '@type' => 'Place',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => $location,
                        'addressCountry' => 'VN',
                    ],
                ] : null,
            ], fn (mixed $value): bool => $value !== null && $value !== '');
        }

        return $schema;
    }

    /**
     * @return array<string, mixed>
     */
    private static function organizationReference(): array
    {
        $logo = self::absoluteAsset(self::setting('logo', 'assets/images/optimized/logo-bao-chau.webp'));

        return array_filter([
            '@type' => 'Organization',
            '@id' => route('home').'#organization',
            'name' => self::siteName(),
            'url' => route('home'),
            'logo' => $logo ? ['@type' => 'ImageObject', 'url' => $logo] : null,
        ]);
    }

    /**
     * @return array<string, string>|null
     */
    private static function postalAddress(): ?array
    {
        $address = self::setting('address');

        if (blank($address)) {
            return null;
        }

        return [
            '@type' => 'PostalAddress',
            'streetAddress' => $address,
            'addressCountry' => 'VN',
        ];
    }

    private static function jobDescription(Model $content): string
    {
        $parts = [];

        foreach (['content', 'requirements', 'benefits'] as $attribute) {
            $value = trim((string) $content->getAttribute($attribute));

            if (filled($value)) {
                $parts[] = $value;
            }
        }

        if ($parts === []) {
            $summary = self::cleanDescription((string) $content->getAttribute('summary'));

            return filled($summary) ? '<p>'.$summary.'</p>' : '';
        }

        return trim(strip_tags(implode("\n", $parts), '<p><ul><li><br>'));
    }

    private static function descriptionFor(Model $content): string
    {
        foreach (['meta_description', 'short_description', 'excerpt', 'summary', 'content'] as $attribute) {
            $description = (string) $content->getAttribute($attribute);

            if (filled($description)) {
                return self::cleanDescription($description);
            }
        }

        return '';
    }

    private static function cleanDescription(string $description): string
    {
        return Str::limit(Str::squish(html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 160, '');
    }

    private static function robots(string $robots): string
    {
        return $robots === 'index,follow'
            ? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'
            : $robots;
    }

    private static function isoDate(mixed $date): ?string
    {
        return $date instanceof CarbonInterface ? $date->toIso8601String() : null;
    }

    private static function siteName(): string
    {
        return self::setting('company_short_name', (string) config('app.name')) ?: (string) config('app.name');
    }

    private static function setting(string $key, ?string $default = null): ?string
    {
        return app(SettingService::class)->get($key, $default);
    }
}
