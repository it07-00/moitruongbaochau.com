<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Redirect;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create(['is_admin' => true]));
    }

    public function test_filament_resources_are_accessible_by_admin(): void
    {
        $this->get(route('filament.admin.resources.service-categories.index'))->assertOk();
        $this->get(route('filament.admin.resources.post-categories.index'))->assertOk();
        $this->get(route('filament.admin.resources.settings.index'))->assertOk();
        $this->get(route('filament.admin.resources.redirects.index'))->assertOk();
        $this->get(route('filament.admin.resources.menus.index'))->assertOk();
        $this->get(route('filament.admin.resources.job-postings.index'))->assertOk();
        $this->get(route('filament.admin.resources.users.index'))->assertOk();
    }

    public function test_models_can_be_mutated_directly_and_queried(): void
    {
        Setting::query()->updateOrCreate(['key' => 'company_name'], [
            'value' => 'Môi Trường Bảo Châu',
            'group' => 'general',
        ]);
        $this->assertDatabaseHas('settings', ['key' => 'company_name', 'value' => 'Môi Trường Bảo Châu']);

        Redirect::query()->create([
            'old_path' => '/old-service',
            'new_path' => '/dich-vu',
            'status_code' => 301,
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('redirects', ['old_path' => '/old-service']);

        ServiceCategory::query()->create([
            'name' => 'Tư vấn môi trường',
            'slug' => 'tu-van-moi-truong',
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('service_categories', ['slug' => 'tu-van-moi-truong']);

        $menu = Menu::query()->create([
            'name' => 'Menu chính',
            'location' => 'primary',
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('menus', ['location' => 'primary']);

        $menu->items()->create([
            'label' => 'Dịch vụ',
            'route_name' => 'services.index',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        $this->assertDatabaseHas('menu_items', ['menu_id' => $menu->id, 'route_name' => 'services.index']);
    }

    public function test_guests_cannot_access_filament_resources(): void
    {
        auth()->logout();

        $this->get(route('filament.admin.resources.redirects.index'))
            ->assertRedirect(route('filament.admin.auth.login'));
    }
}
