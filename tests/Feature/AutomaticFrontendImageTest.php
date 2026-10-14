<?php

namespace Tests\Feature;

use App\Filament\Resources\Sliders\Pages\CreateSlider;
use App\Models\JobPosting;
use App\Models\Media;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\User;
use App\Services\FrontendImageOptimizer;
use App\Support\OptimizedImage;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AutomaticFrontendImageTest extends TestCase
{
    use LazilyRefreshDatabase;

    private string $originalPublicPath;

    private string $temporaryPublicPath;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->originalPublicPath = public_path();
        $this->temporaryPublicPath = storage_path('framework/testing/frontend-images-'.bin2hex(random_bytes(8)));
        File::ensureDirectoryExists($this->temporaryPublicPath);
        $this->app->usePublicPath($this->temporaryPublicPath);
    }

    protected function tearDown(): void
    {
        $this->app->usePublicPath($this->originalPublicPath);
        File::deleteDirectory($this->temporaryPublicPath);
        parent::tearDown();
    }

    private function image(string $name, int $width = 2000, int $height = 1000): string
    {
        return UploadedFile::fake()->image($name, $width, $height)->storeAs('uploads/sliders', $name, 'public');
    }

    private function manifest(): array
    {
        return json_decode(File::get(public_path('assets/images/optimized/frontend-images.json')), true, flags: JSON_THROW_ON_ERROR);
    }

    public function test_admin_upload_creates_webp_variants_without_changing_original(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Livewire::test(CreateSlider::class)
            ->fillForm(['title' => 'New banner', 'image' => UploadedFile::fake()->image('banner.png', 2000, 1000), 'sort_order' => 0, 'is_active' => true])
            ->call('create')
            ->assertHasNoFormErrors();
        $slider = Slider::query()->latest('id')->firstOrFail();
        Storage::disk('public')->assertExists($slider->image);
        $entry = $this->manifest()['storage/'.$slider->image];
        $this->assertSame([160, 480, 960, 1536, 1920], array_keys($entry['variants']));
        foreach ($entry['variants'] as $width => $path) {
            $dimensions = getimagesize(public_path($path));
            $this->assertSame(IMAGETYPE_WEBP, $dimensions[2]);
            $this->assertSame($width, $dimensions[0]);
            $this->assertSame((int) ($width / 2), $dimensions[1]);
        }
    }

    public function test_replacing_an_image_updates_manifest_and_preserves_other_images(): void
    {
        $path = $this->image('banner.png');
        $originalHash = hash_file('sha256', Storage::disk('public')->path($path));
        $slider = Slider::factory()->create(['image' => $path]);
        $before = $this->manifest()['storage/'.$path];
        $this->assertSame($originalHash, hash_file('sha256', Storage::disk('public')->path($path)));
        $replacement = $this->image('new-banner.png', 800, 400);
        $slider->update(['image' => $replacement]);
        $manifest = $this->manifest();
        $this->assertSame($before, $manifest['storage/'.$path]);
        $this->assertSame([160, 480, 800], array_keys($manifest['storage/'.$replacement]['variants']));
        $this->assertStringContainsString('800w', app(OptimizedImage::class)->attributes(asset('storage/'.$replacement))['srcset']);
    }

    public function test_rich_editor_images_and_setting_images_are_processed_on_save(): void
    {
        $path = $this->image('editor.png', 600, 300);
        $html = '<p>Giữ nội dung</p><img src="'.asset('storage/'.$path).'" alt="Ảnh doanh nghiệp">';
        $post = Post::factory()->create(['content' => $html]);
        $this->assertArrayHasKey('storage/'.$path, $this->manifest());
        $this->assertSame($html, $post->fresh()->content);
        $rendered = app(OptimizedImage::class)->html($html);
        $this->assertStringContainsString('srcset=', $rendered);
        $this->assertStringContainsString('Ảnh doanh nghiệp', $rendered);
        $logo = $this->image('logo.png', 100, 80);
        Setting::factory()->create(['key' => 'logo', 'value' => $logo]);
        $this->assertSame([100], array_keys($this->manifest()['storage/'.$logo]['variants']));
        $about = $this->image('about.png', 300, 200);
        Page::factory()->create(['metadata' => ['about_image' => $about]]);
        $this->assertArrayHasKey('storage/'.$about, $this->manifest());
    }

    public function test_same_path_replacement_gets_new_hashed_variants(): void
    {
        $path = $this->image('same.png', 400, 200);
        $slider = Slider::factory()->create(['image' => $path]);
        $before = $this->manifest()['storage/'.$path]['variants'];
        $this->image('same.png', 600, 300);
        $slider->update(['image' => $path, 'title' => 'Changed']);
        $this->assertNotSame($before, $this->manifest()['storage/'.$path]['variants']);
    }

    public function test_remote_missing_and_traversal_paths_are_not_processed(): void
    {
        $optimizer = app(FrontendImageOptimizer::class);
        foreach (['https://outside.example/image.png', 'uploads/missing.png', 'storage/uploads/../private.png', 'data:image/png;base64,abc', 'uploads/document.pdf'] as $source) {
            $this->assertFalse($optimizer->optimize($source));
        }
        $this->assertFileDoesNotExist(public_path('assets/images/optimized/frontend-images.json'));
    }

    public function test_other_admin_image_fields_and_media_library_are_covered(): void
    {
        $fields = [
            Service::class => 'thumbnail',
            Project::class => 'thumbnail',
            JobPosting::class => 'thumbnail',
            ServiceCategory::class => 'image',
            Partner::class => 'logo',
            Testimonial::class => 'avatar',
        ];
        foreach ($fields as $model => $field) {
            $path = $this->image(class_basename($model).'.png', 240, 120);
            $attributes = [$field => $path];
            if ($model === Partner::class) {
                $attributes['name'] = 'Đối tác';
            }
            if ($model === Testimonial::class) {
                $attributes['client_name'] = 'Khách hàng';
                $attributes['content'] = 'Đánh giá dịch vụ';
            }
            $model::factory()->create($attributes);
            $this->assertArrayHasKey('storage/'.$path, $this->manifest());
        }
        $path = UploadedFile::fake()->image('library.png', 320, 160)->store('media', 'public');
        Media::factory()->create(['path' => $path]);
        $this->assertArrayHasKey('storage/'.$path, $this->manifest());
    }

    public function test_transparent_png_keeps_transparency_and_original_bytes(): void
    {
        $image = imagecreatetruecolor(120, 60);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        ob_start();
        imagepng($image);
        $bytes = ob_get_clean();
        Storage::disk('public')->put('uploads/sliders/transparent.png', $bytes);
        Slider::factory()->create(['image' => 'uploads/sliders/transparent.png']);
        $entry = $this->manifest()['storage/uploads/sliders/transparent.png'];
        $copy = imagecreatefromwebp(public_path($entry['variants'][120]));
        $this->assertSame(127, imagecolorsforindex($copy, imagecolorat($copy, 0, 0))['alpha']);
        $this->assertSame($bytes, Storage::disk('public')->get('uploads/sliders/transparent.png'));
    }

    public function test_camera_jpeg_orientation_is_preserved_in_variants(): void
    {
        if (! function_exists('exif_read_data')) {
            $this->markTestSkipped('EXIF extension is unavailable.');
        }
        $upload = UploadedFile::fake()->image('camera.jpg', 400, 200);
        $jpeg = file_get_contents($upload->getPathname());
        $exif = "Exif\0\0II*\0\x08\0\0\0\x01\0\x12\x01\x03\0\x01\0\0\0\x06\0\0\0\0\0\0\0";
        $bytes = substr($jpeg, 0, 2)."\xFF\xE1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
        Storage::disk('public')->put('uploads/sliders/camera.jpg', $bytes);
        Slider::factory()->create(['image' => 'uploads/sliders/camera.jpg']);
        $entry = $this->manifest()['storage/uploads/sliders/camera.jpg'];
        $this->assertSame(200, $entry['width']);
        $this->assertSame(400, $entry['height']);
        $dimensions = getimagesize(public_path($entry['variants'][160]));
        $this->assertSame(320, $dimensions[1]);
        $this->assertSame($bytes, Storage::disk('public')->get('uploads/sliders/camera.jpg'));
    }
}
