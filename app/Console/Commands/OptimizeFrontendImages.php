<?php

namespace App\Console\Commands;

use App\Services\FrontendImageOptimizer;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('frontend:optimize-images')]
#[Description('Build responsive WebP copies of frontend images without modifying originals')]
class OptimizeFrontendImages extends Command
{
    public function handle(FrontendImageOptimizer $optimizer): int
    {
        $count = 0;
        foreach ([public_path('assets/images'), Storage::disk('public')->path('uploads'), Storage::disk('public')->path('media')] as $folder) {
            if (! is_dir($folder)) {
                continue;
            }
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS));
            foreach ($files as $file) {
                if (! $file->isFile() || str_contains($file->getPathname(), DIRECTORY_SEPARATOR.'optimized'.DIRECTORY_SEPARATOR)) {
                    continue;
                }
                $relative = str_starts_with($file->getPathname(), public_path('assets/images'))
                    ? 'assets/images/'.str_replace('\\', '/', substr($file->getPathname(), strlen(public_path('assets/images')) + 1))
                    : 'storage/'.str_replace('\\', '/', substr($file->getPathname(), strlen(Storage::disk('public')->path('')) + 1));
                try {
                    if ($optimizer->optimize($relative)) {
                        $count++;
                    }
                } catch (\Throwable $exception) {
                    $this->error($exception->getMessage());

                    return self::FAILURE;
                }
            }
        }
        $this->info($count.' images processed. New admin images are optimized automatically when records are saved.');

        return self::SUCCESS;
    }
}
