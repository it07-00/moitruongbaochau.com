<?php

namespace App\Support;

class OptimizedImage
{
    /** @param array<string, array{width: int, height: int, variants: array<int, string>}>|null $manifest */
    public function __construct(private ?array $manifest = null) {}

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
