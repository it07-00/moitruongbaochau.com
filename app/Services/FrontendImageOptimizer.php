<?php

namespace App\Services;

use App\Support\OptimizedImage;
use Illuminate\Support\Facades\Storage;

class FrontendImageOptimizer
{
    public function __construct(private OptimizedImage $images) {}

    public function optimize(string $source, bool $includeSmallImages = true): bool
    {
        $host = parse_url($source, PHP_URL_HOST);
        if ($host && $host !== parse_url(asset('/'), PHP_URL_HOST)) {
            return false;
        }
        $path = ltrim(rawurldecode(parse_url($source, PHP_URL_PATH) ?: ''), '/');
        if (preg_match('#(?:^|[/\\\\])\.\.?([/\\\\]|$)#', $path)) {
            return false;
        }
        if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'media/')) {
            $path = 'storage/'.$path;
        }
        if (str_starts_with($path, 'storage/uploads/') || str_starts_with($path, 'storage/media/')) {
            $folder = str_starts_with($path, 'storage/uploads/') ? 'uploads' : 'media';
            $root = Storage::disk('public')->path($folder);
            $file = Storage::disk('public')->path(substr($path, strlen('storage/')));
        } elseif (str_starts_with($path, 'assets/images/') && ! str_contains($path, '/optimized/')) {
            $root = public_path('assets/images');
            $file = public_path($path);
        } else {
            return false;
        }
        $file = realpath($file);
        $root = realpath($root);
        if (! $file || ! $root || ! str_starts_with(str_replace('\\', '/', $file), str_replace('\\', '/', $root).'/') || ! in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg', 'webp'])) {
            return false;
        }
        $dimensions = @getimagesize($file);
        if (! $dimensions || $dimensions[0] * $dimensions[1] > 20000000) {
            return false;
        }
        if (preg_match('#^storage/(?:media/|uploads/(?:sliders|partners|pages|service-categories|posts|projects|services|testimonials|job-postings|seo|settings)/)#', $path)) {
            if (! Storage::disk('public')->setVisibility(substr($path, strlen('storage/')), 'public')) {
                throw new \RuntimeException('Cannot make frontend image readable.');
            }
        }
        $output = public_path('assets/images/optimized');
        if (! is_dir($output) && ! mkdir($output, 0755, true) && ! is_dir($output)) {
            throw new \RuntimeException('Cannot create optimized image directory.');
        }
        $variants = [];
        if ($includeSmallImages || filesize($file) >= 15000) {
            if (! function_exists('imagewebp')) {
                throw new \RuntimeException('GD with WebP support is required.');
            }
            $original = @imagecreatefromstring(file_get_contents($file));
            if (! $original) {
                return false;
            }
            $orientation = 1;
            if ($dimensions[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
                $orientation = (int) (@exif_read_data($file)['Orientation'] ?? 1);
                if (in_array($orientation, [2, 4, 5, 7])) {
                    imageflip($original, in_array($orientation, [2, 5, 7]) ? IMG_FLIP_HORIZONTAL : IMG_FLIP_VERTICAL);
                }
                $angle = match ($orientation) {
                    3 => 180, 5, 8 => 90, 6, 7 => -90, default => 0
                };
                if ($angle !== 0) {
                    $original = imagerotate($original, $angle, 0);
                }
                $dimensions[0] = imagesx($original);
                $dimensions[1] = imagesy($original);
            }
            $hash = substr(hash_file('sha256', $file), 0, 16);
            if ($orientation !== 1) {
                $hash = substr(hash('sha256', $hash.':orientation-'.$orientation), 0, 16);
            }
            foreach (array_unique(array_map(fn (int $width): int => min($width, $dimensions[0]), [160, 480, 960, 1536, 1920])) as $width) {
                $name = 'frontend-'.$hash.'-'.$width.'.webp';
                $target = $output.'/'.$name;
                if (! is_file($target)) {
                    $height = max(1, (int) round($dimensions[1] * $width / $dimensions[0]));
                    $resized = imagecreatetruecolor($width, $height);
                    imagealphablending($resized, false);
                    imagesavealpha($resized, true);
                    imagefill($resized, 0, 0, imagecolorallocatealpha($resized, 0, 0, 0, 127));
                    imagecopyresampled($resized, $original, 0, 0, 0, 0, $width, $height, $dimensions[0], $dimensions[1]);
                    $temporary = tempnam($output, 'image-');
                    try {
                        if (! imagewebp($resized, $temporary, 82) || ! chmod($temporary, 0644) || ! rename($temporary, $target)) {
                            throw new \RuntimeException('Cannot write optimized image.');
                        }
                    } finally {
                        if (is_file($temporary)) {
                            unlink($temporary);
                        }
                    }
                }
                $variants[$width] = 'assets/images/optimized/'.$name;
            }
        }
        $lock = fopen($output.'/frontend-images.lock', 'c');
        if (! $lock || ! flock($lock, LOCK_EX)) {
            throw new \RuntimeException('Cannot lock image manifest.');
        }
        try {
            $manifestFile = $output.'/frontend-images.json';
            $manifest = is_file($manifestFile) ? json_decode(file_get_contents($manifestFile), true, flags: JSON_THROW_ON_ERROR) : [];
            $entry = ['width' => $dimensions[0], 'height' => $dimensions[1], 'variants' => $variants];
            if (($manifest[$path] ?? null) !== $entry) {
                $manifest[$path] = $entry;
                ksort($manifest);
                $temporary = tempnam($output, 'manifest-');
                try {
                    if (file_put_contents($temporary, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)) === false || ! chmod($temporary, 0644) || ! rename($temporary, $manifestFile)) {
                        throw new \RuntimeException('Cannot update image manifest.');
                    }
                } finally {
                    if (is_file($temporary)) {
                        unlink($temporary);
                    }
                }
            }
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
        $this->images->forgetManifest();

        return true;
    }
}
