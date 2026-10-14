<?php

namespace App\Support;

class OptimizedImage
{
    /** @param array<string, array{width: int, height: int, variants: array<int, string>}>|null $manifest */
    public function __construct(private ?array $manifest = null) {}

    public function forgetManifest(): void
    {
        $this->manifest = null;
    }

    public function html(?string $html): ?string
    {
        if (! $html || ! str_contains(strtolower($html), '<img')) {
            return $html;
        }

        return preg_replace_callback('/<img\b[^>]*>/i', function (array $match): string {
            $document = new \DOMDocument;
            $previous = libxml_use_internal_errors(true);
            try {
                $document->loadHTML('<?xml encoding="UTF-8">'.$match[0], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $image = $document->getElementsByTagName('img')->item(0);
                if (! $image) {
                    return $match[0];
                }
                $attributes = $this->attributes($image->getAttribute('src'));
                foreach ($attributes as $name => $value) {
                    $image->setAttribute($name, (string) $value);
                }
                if (isset($attributes['srcset']) && ! $image->hasAttribute('sizes')) {
                    $image->setAttribute('sizes', '(min-width: 1024px) 800px, 100vw');
                }
                if (! $image->hasAttribute('loading')) {
                    $image->setAttribute('loading', 'lazy');
                }

                return $document->saveHTML($image);
            } finally {
                libxml_clear_errors();
                libxml_use_internal_errors($previous);
            }
        }, $html);
    }

    /** @return array{src: string, width?: int, height?: int, srcset?: string} */
    public function attributes(string $source): array
    {
        $sourceHost = parse_url($source, PHP_URL_HOST);
        if ($sourceHost && $sourceHost !== parse_url(asset('/'), PHP_URL_HOST)) {
            return ['src' => $source];
        }
        $path = ltrim(rawurldecode(parse_url($source, PHP_URL_PATH) ?: ''), '/');
        if ($this->manifest === null) {
            $file = public_path('assets/images/optimized/frontend-images.json');
            $this->manifest = is_file($file) ? (json_decode(file_get_contents($file), true) ?: []) : [];
        }
        $image = $this->manifest[$path] ?? null;
        if (! $image) {
            return ['src' => $source];
        }
        if (empty($image['variants'])) {
            return ['src' => $source, 'width' => $image['width'], 'height' => $image['height']];
        }
        $variants = $image['variants'];
        ksort($variants, SORT_NUMERIC);

        return [
            'src' => asset(end($variants)),
            'width' => $image['width'],
            'height' => $image['height'],
            'srcset' => implode(', ', array_map(fn (int $width, string $path): string => asset($path).' '.$width.'w', array_keys($variants), $variants)),
        ];
    }
}
