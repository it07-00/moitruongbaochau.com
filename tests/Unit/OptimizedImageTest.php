<?php

namespace Tests\Unit;

use App\Support\OptimizedImage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class OptimizedImageTest extends TestCase
{
    private string $originalPublicPath;

    private string $temporaryPublicPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalPublicPath = public_path();
        $this->temporaryPublicPath = storage_path('framework/testing/optimized-image-'.bin2hex(random_bytes(8)));
        File::ensureDirectoryExists($this->temporaryPublicPath);
        $this->app->usePublicPath($this->temporaryPublicPath);
    }

    protected function tearDown(): void
    {
        $this->app->usePublicPath($this->originalPublicPath);
        File::deleteDirectory($this->temporaryPublicPath);
        parent::tearDown();
    }

    private function createVariant(string $path): void
    {
        File::ensureDirectoryExists(dirname(public_path($path)));
        File::put(public_path($path), 'image fixture');
    }

    public function test_responsive_variants_are_sorted_and_keep_original_aspect_ratio(): void
    {
        $this->createVariant('assets/images/optimized/banner-480.webp');
        $this->createVariant('assets/images/optimized/banner-960.webp');
        $image = new OptimizedImage([
            'storage/uploads/banner.png' => [
                'width' => 1536, 'height' => 568,
                'variants' => [960 => 'assets/images/optimized/banner-960.webp', 480 => 'assets/images/optimized/banner-480.webp'],
            ],
        ]);

        $result = $image->attributes(asset('storage/uploads/banner.png').'?v=123');
        $this->assertSame(asset('assets/images/optimized/banner-960.webp'), $result['src']);
        $this->assertSame(asset('assets/images/optimized/banner-480.webp').' 480w, '.asset('assets/images/optimized/banner-960.webp').' 960w', $result['srcset']);
        $this->assertSame(1536, $result['width']);
        $this->assertSame(568, $result['height']);
    }

    public function test_external_and_unoptimized_images_keep_the_original_url(): void
    {
        $image = new OptimizedImage([]);
        foreach (['https://external.example/banner.png', asset('storage/uploads/new-banner.png'), 'data:image/png;base64,abc'] as $source) {
            $this->assertSame(['src' => $source], $image->attributes($source));
        }
    }

    public function test_small_images_keep_the_original_file_and_reserve_their_dimensions(): void
    {
        $image = new OptimizedImage([
            'assets/icon.png' => ['width' => 24, 'height' => 24, 'variants' => []],
        ]);

        $this->assertSame(['src' => '/assets/icon.png', 'width' => 24, 'height' => 24], $image->attributes('/assets/icon.png'));
    }

    public function test_component_preserves_loading_priority_classes_alt_and_explicit_dimensions_for_fallback(): void
    {
        $this->app->instance(OptimizedImage::class, new OptimizedImage([]));
        $html = Blade::render('<x-frontend.image src="/new-image.png" width="600" height="200" alt="Ảnh doanh nghiệp" class="object-cover" loading="eager" fetchpriority="high" />');

        foreach (['src="/new-image.png"', 'width="600"', 'height="200"', 'alt="Ảnh doanh nghiệp"', 'class="object-cover"', 'loading="eager"', 'fetchpriority="high"'] as $attribute) {
            $this->assertStringContainsString($attribute, $html);
        }
        $this->assertStringNotContainsString('srcset=', $html);
    }

    public function test_component_uses_correct_intrinsic_dimensions_instead_of_a_placeholder_square(): void
    {
        $this->createVariant('assets/logo-480.webp');
        $this->app->instance(OptimizedImage::class, new OptimizedImage([
            'assets/logo.png' => ['width' => 536, 'height' => 522, 'variants' => [480 => 'assets/logo-480.webp']],
        ]));
        $html = Blade::render('<x-frontend.image src="/assets/logo.png" width="1024" height="1024" sizes="140px" alt="Logo" />');

        $this->assertStringContainsString('width="536"', $html);
        $this->assertStringContainsString('height="522"', $html);
        $this->assertStringContainsString('sizes="140px"', $html);
        $this->assertStringContainsString('480w', $html);
        $this->assertStringContainsString('src="'.asset('assets/logo-480.webp').'"', $html);
        $this->assertStringNotContainsString('1024', $html);
    }

    public function test_missing_optimized_files_fall_back_to_original_without_srcset(): void
    {
        $image = new OptimizedImage([
            'storage/uploads/banner.png' => [
                'width' => 1536, 'height' => 568,
                'variants' => [480 => 'assets/images/optimized/missing-480.webp', 960 => 'assets/images/optimized/missing-960.webp'],
            ],
        ]);
        $source = asset('storage/uploads/banner.png').'?v=123';

        $this->assertSame(['src' => $source, 'width' => 1536, 'height' => 568], $image->attributes($source));
        $this->app->instance(OptimizedImage::class, $image);
        $html = Blade::render('<x-frontend.image :src="$source" alt="Banner" />', ['source' => $source]);
        $this->assertStringContainsString('src="'.$source.'"', $html);
        $this->assertStringNotContainsString('srcset=', $html);
        $this->assertStringNotContainsString('missing-', $html);

        $html = $image->html('<img src="'.$source.'" alt="Banner">');
        $this->assertStringContainsString('src="'.$source.'"', $html);
        $this->assertStringNotContainsString('missing-', $html);
    }

    public function test_only_existing_variants_are_used_when_deployment_is_incomplete(): void
    {
        $this->createVariant('assets/images/optimized/banner-480.webp');
        $image = new OptimizedImage([
            'storage/uploads/banner.png' => [
                'width' => 1536, 'height' => 568,
                'variants' => [480 => 'assets/images/optimized/banner-480.webp', 960 => 'assets/images/optimized/missing-960.webp'],
            ],
        ]);

        $result = $image->attributes(asset('storage/uploads/banner.png'));
        $this->assertSame(asset('assets/images/optimized/banner-480.webp'), $result['src']);
        $this->assertSame(asset('assets/images/optimized/banner-480.webp').' 480w', $result['srcset']);
    }
}
