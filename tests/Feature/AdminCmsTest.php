<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create(['is_admin' => true]));
    }

    public function test_admin_operational_modules_are_available(): void
    {
        $this->get(route('admin.categories.index', 'services'))->assertOk();
        $this->get(route('admin.categories.index', 'posts'))->assertOk();
        $this->get(route('admin.settings.index'))->assertOk();
        $this->get(route('admin.redirects.index'))->assertOk();
        $this->get(route('admin.media.index'))->assertOk();
        $this->get(route('admin.menus.index'))->assertOk();
    }

    public function test_admin_can_update_settings_and_create_redirects_categories_and_menus(): void
    {
        $this->put(route('admin.settings.update'), [
            'settings' => [
                'company_name' => 'Môi Trường Bảo Châu',
                'phone' => '0915549148',
            ],
        ])->assertRedirect();
        $this->assertDatabaseHas('settings', ['key' => 'company_name', 'value' => 'Môi Trường Bảo Châu']);

        $this->post(route('admin.redirects.store'), [
            'old_path' => '/old-service',
            'new_path' => '/dich-vu',
            'status_code' => 301,
            'is_active' => true,
        ])->assertRedirect();
        $this->assertDatabaseHas('redirects', ['old_path' => '/old-service']);

        $this->post(route('admin.categories.store', 'services'), [
            'name' => 'Tư vấn môi trường',
            'slug' => 'tu-van-moi-truong',
            'is_active' => true,
        ])->assertRedirect();
        $this->assertDatabaseHas('service_categories', ['slug' => 'tu-van-moi-truong']);

        $this->post(route('admin.menus.store'), [
            'name' => 'Menu chính',
            'location' => 'primary',
            'is_active' => true,
        ])->assertRedirect();
        $this->assertDatabaseHas('menus', ['location' => 'primary']);

        $menu = Menu::query()->where('location', 'primary')->sole();
        $this->post(route('admin.menus.items.store', $menu), [
            'label' => 'Dịch vụ',
            'route_name' => 'services.index',
            'sort_order' => 1,
            'is_active' => true,
        ])->assertRedirect();
        $this->assertDatabaseHas('menu_items', ['menu_id' => $menu->id, 'route_name' => 'services.index']);
    }

    public function test_media_upload_accepts_safe_images_and_rejects_php_files(): void
    {
        Storage::fake('public');

        $this->post(route('admin.media.store'), [
            'file' => UploadedFile::fake()->image('project.jpg', 1200, 800)->size(500),
            'alt_text' => 'Dự án môi trường',
        ])->assertRedirect();

        $media = Media::query()->sole();
        Storage::disk('public')->assertExists($media->path);

        $this->post(route('admin.media.store'), [
            'file' => UploadedFile::fake()->createWithContent('shell.php', '<?php echo "bad";'),
        ])->assertSessionHasErrors('file');

        $this->assertSame(1, Media::query()->count());
    }

    public function test_guests_cannot_mutate_cms_modules(): void
    {
        auth()->logout();

        $this->post(route('admin.redirects.store'), [])->assertRedirect(route('admin.login'));
    }
}
