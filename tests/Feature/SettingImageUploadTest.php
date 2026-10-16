<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Filament\Resources\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\SettingResource;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use App\Services\SettingService;
use App\Support\SeoData;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SettingImageUploadTest extends TestCase
{
    use LazilyRefreshDatabase;

    private string $originalPublicPath;

    private string $temporaryPublicPath;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->originalPublicPath = public_path();
        $this->temporaryPublicPath = storage_path('framework/testing/setting-images-'.bin2hex(random_bytes(8)));
        File::ensureDirectoryExists($this->temporaryPublicPath);
        $this->app->usePublicPath($this->temporaryPublicPath);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs(User::factory()->create(['is_admin' => true]));
    }

    protected function tearDown(): void
    {
        $this->app->usePublicPath($this->originalPublicPath);
        File::deleteDirectory($this->temporaryPublicPath);
        parent::tearDown();
    }

    public function test_admin_can_upload_replace_and_reopen_all_image_settings(): void
    {
        foreach (array_keys(SettingResource::IMAGE_SETTINGS) as $key) {
            $setting = Setting::factory()->create(['key' => $key, 'value' => 'assets/images/old.png']);
            app(SettingService::class)->all();

            Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
                ->assertFormFieldVisible('image_value')
                ->assertFormFieldHidden('value')
                ->fillForm(['image_value' => []])
                ->fillForm(['image_value' => UploadedFile::fake()->image('replacement.png', 300, 150)])
                ->call('save')
                ->assertHasNoFormErrors();

            $path = $setting->refresh()->value;
            $this->assertStringStartsWith('uploads/settings/', $path);
            Storage::disk('public')->assertExists($path);
            $this->assertSame('public', Storage::disk('public')->getVisibility($path));
            $this->assertSame($path, app(SettingService::class)->get($key));

            Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
                ->assertFormSet(['image_value' => $path])
                ->assertFormFieldExists('image_value', fn (FileUpload $field): bool => in_array(SeoData::absoluteAsset($path), array_column($field->getUploadedFiles(), 'url'), true))
                ->call('save')
                ->assertHasNoFormErrors();
            $this->assertSame($path, $setting->refresh()->value);
        }
    }

    public function test_existing_asset_storage_and_external_paths_are_preserved_on_save(): void
    {
        foreach (['assets/images/optimized/og-moi-truong-bao-chau.webp', 'storage/uploads/seo/old.png', 'https://example.com/old.png'] as $path) {
            $setting = Setting::factory()->create(['key' => 'seo_default_image', 'value' => $path]);

            Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
                ->assertFormSet(['image_value' => $path])
                ->call('save')
                ->assertHasNoFormErrors();

            $this->assertSame($path, $setting->refresh()->value);
            $setting->delete();
        }
    }

    public function test_admin_can_create_an_image_setting_by_uploading_a_file(): void
    {
        Livewire::test(CreateSetting::class)
            ->fillForm(['key' => 'seo_default_image', 'group' => 'seo'])
            ->assertFormFieldVisible('image_value')
            ->fillForm(['image_value' => UploadedFile::fake()->image('seo.png', 300, 150)])
            ->call('create')
            ->assertHasNoFormErrors();

        $setting = Setting::query()->where('key', 'seo_default_image')->firstOrFail();
        Storage::disk('public')->assertExists($setting->value);
        $this->assertStringStartsWith('uploads/settings/', $setting->value);
    }

    public function test_admin_can_clear_an_image_without_deleting_shared_original(): void
    {
        Storage::disk('public')->put('uploads/settings/logo.png', 'original');
        $setting = Setting::factory()->create(['key' => 'logo', 'value' => 'uploads/settings/logo.png']);

        Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
            ->fillForm(['image_value' => []])->call('save')->assertHasNoFormErrors();

        $this->assertNull($setting->refresh()->value);
        Storage::disk('public')->assertExists('uploads/settings/logo.png');
    }

    public function test_text_settings_keep_their_text_editor_and_save_normally(): void
    {
        $setting = Setting::factory()->create(['key' => 'company_name', 'value' => 'Tên cũ']);

        Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
            ->assertFormFieldHidden('image_value')
            ->assertFormFieldVisible('value')
            ->fillForm(['value' => 'Tên doanh nghiệp mới'])
            ->call('save')->assertHasNoFormErrors();

        $this->assertSame('Tên doanh nghiệp mới', $setting->refresh()->value);
    }

    public function test_invalid_and_oversized_files_cannot_replace_an_image(): void
    {
        $setting = Setting::factory()->create(['key' => 'logo', 'value' => 'assets/images/logo.png']);
        foreach ([UploadedFile::fake()->create('document.pdf', 10, 'application/pdf'), UploadedFile::fake()->image('large.png')->size(5121)] as $file) {
            Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
                ->fillForm(['image_value' => []])
                ->fillForm(['image_value' => $file])->call('save')->assertHasFormErrors(['image_value']);
            $this->assertSame('assets/images/logo.png', $setting->refresh()->value);
        }
    }

    public function test_unrelated_existing_paths_cannot_be_submitted_as_an_upload(): void
    {
        Storage::disk('public')->put('uploads/other.png', 'other');
        $setting = Setting::factory()->create(['key' => 'logo', 'value' => 'assets/images/logo.png']);

        Livewire::test(EditSetting::class, ['record' => $setting->getRouteKey()])
            ->fillForm(['image_value' => ['uploads/other.png']])
            ->call('save')->assertHasFormErrors(['image_value']);

        $this->assertSame('assets/images/logo.png', $setting->refresh()->value);
    }

    public function test_uploaded_settings_are_rendered_on_frontend_with_public_urls(): void
    {
        foreach (array_keys(SettingResource::IMAGE_SETTINGS) as $key) {
            Setting::factory()->create(['key' => $key, 'value' => 'uploads/settings/'.$key.'.png']);
        }

        $this->app->usePublicPath($this->originalPublicPath);

        Page::factory()->create([
            'slug' => 'gioi-thieu', 'thumbnail' => null,
            'status' => ContentStatus::Published, 'published_at' => now(),
        ]);

        $this->get(route('home'))->assertOk()
            ->assertSee(asset('storage/uploads/settings/logo.png'))
            ->assertSee(asset('storage/uploads/settings/favicon.png'))
            ->assertSee(asset('storage/uploads/settings/seo_default_image.png'))
            ->assertSee(asset('storage/uploads/settings/about_image.png'));

        $this->get(route('about'))->assertOk()
            ->assertSee(asset('storage/uploads/settings/about_image.png'));
    }
}
