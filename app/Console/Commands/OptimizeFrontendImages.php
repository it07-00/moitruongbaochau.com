<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('frontend:optimize-images')]
#[Description('Build responsive WebP copies of frontend images without modifying originals')]
class OptimizeFrontendImages extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! function_exists('imagewebp')) {
            $this->error('GD with WebP support is required.');

            return self::FAILURE;
        }
        $output = public_path('assets/images/optimized');
        if (! is_dir($output)) {
            mkdir($output, 0755, true);
        }
        $manifest = [];
        foreach ([public_path('assets/images'), storage_path('app/public/uploads')] as $folder) {
            if (! is_dir($folder)) {
                continue;
            }
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if (! $file->isFile() || str_contains($file->getPathname(), DIRECTORY_SEPARATOR.'optimized'.DIRECTORY_SEPARATOR) || ! in_array(strtolower($file->getExtension()), ['png', 'jpg', 'jpeg', 'webp'])) {
                    continue;
                }
                $dimensions = @getimagesize($file->getPathname());
                if (! $dimensions || $dimensions[0] * $dimensions[1] > 20000000) {
                    continue;
                }
                $relative = str_starts_with($file->getPathname(), public_path('assets/images'))
                    ? 'assets/images/'.str_replace('\\', '/', substr($file->getPathname(), strlen(public_path('assets/images')) + 1))
                    : 'storage/uploads/'.str_replace('\\', '/', substr($file->getPathname(), strlen(storage_path('app/public/uploads')) + 1));
                if ($file->getSize() < 15000) {
                    $manifest[$relative] = ['width' => $dimensions[0], 'height' => $dimensions[1], 'variants' => []];

                    continue;
                }
                $original = @imagecreatefromstring(file_get_contents($file->getPathname()));
                if (! $original) {
                    continue;
                }
                $hash = substr(hash_file('sha256', $file->getPathname()), 0, 16);
                $variants = [];
                foreach (array_unique([min(160, $dimensions[0]), min(480, $dimensions[0]), min(960, $dimensions[0]), min(1536, $dimensions[0]), min(1920, $dimensions[0])]) as $width) {
                    $name = 'frontend-'.$hash.'-'.$width.'.webp';
                    if (! is_file($output.DIRECTORY_SEPARATOR.$name)) {
                        $height = max(1, (int) round($dimensions[1] * $width / $dimensions[0]));
                        $resized = imagecreatetruecolor($width, $height);
                        imagealphablending($resized, false);
                        imagesavealpha($resized, true);
                        imagefill($resized, 0, 0, imagecolorallocatealpha($resized, 0, 0, 0, 127));
                        imagecopyresampled($resized, $original, 0, 0, 0, 0, $width, $height, $dimensions[0], $dimensions[1]);
                        if (! imagewebp($resized, $output.DIRECTORY_SEPARATOR.$name, 82)) {
                            $this->error('Cannot write '.$name);

                            return self::FAILURE;
                        }
                    }
                    $variants[$width] = 'assets/images/optimized/'.$name;
                }
                $manifest[$relative] = ['width' => $dimensions[0], 'height' => $dimensions[1], 'variants' => $variants];
                unset($original, $resized);
            }
        }
        ksort($manifest);
        file_put_contents($output.'/frontend-images.json', json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
        $optimizedCount = count(array_filter($manifest, fn (array $image): bool => $image['variants'] !== []));
        $this->info($optimizedCount.' images optimized; dimensions recorded for '.count($manifest).' images. Re-run after adding or replacing uploaded images.');

        return self::SUCCESS;
    }
}
