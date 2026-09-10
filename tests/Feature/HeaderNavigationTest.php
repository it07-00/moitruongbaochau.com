<?php

namespace Tests\Feature;

use App\ContentStatus;
use App\Filament\Resources\Menus\Pages\EditMenu;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Models\User;
use App\Services\MenuService;
use Database\Seeders\HeaderNavigationSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class HeaderNavigationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_header_renders_the_same_database_tree_and_hides_inactive_branches(): void
    {
        $menu = Menu::factory()->create(['location' => 'primary']);
        $root = MenuItem::factory()->for($menu)->create(['label' => 'Nhóm tuỳ chỉnh', 'sort_order' => 2]);
        $first = MenuItem::factory()->for($menu)->create(['label' => 'Liên kết đầu tiên', 'sort_order' => 1]);
        $child = MenuItem::factory()->for($menu)->create(['parent_id' => $root->id, 'label' => 'Nhóm con']);
        $leaf = MenuItem::factory()->for($menu)->create(['parent_id' => $child->id, 'label' => 'Liên kết cấp ba']);
        $hidden = MenuItem::factory()->for($menu)->create(['is_active' => false, 'label' => 'Nhóm ẩn']);
        MenuItem::factory()->for($menu)->create(['parent_id' => $hidden->id, 'label' => 'Con của nhóm ẩn']);

        $html = view('components.frontend.header')->render();
        $document = new \DOMDocument;
        @$document->loadHTML('<?xml encoding="UTF-8">'.$html);
        $labels = [];
        foreach ($document->getElementsByTagName('a') as $link) {
            $labels[] = trim($link->textContent);
        }
        foreach ([$first, $root, $child, $leaf] as $item) {
            $this->assertSame(2, count(array_filter($labels, fn (string $label): bool => $label === $item->label)));
        }
        $this->assertStringNotContainsString('Nhóm ẩn', $html);
        $this->assertStringNotContainsString('Con của nhóm ẩn', $html);
        $this->assertSame([$first->id, $root->id], app(MenuService::class)->items('primary')->modelKeys());
    }

    public function test_menu_mutations_invalidate_cached_trees_and_old_locations(): void
    {
        $menu = Menu::factory()->create(['location' => 'primary']);
        $item = MenuItem::factory()->for($menu)->create(['label' => 'Ban đầu']);
        $service = app(MenuService::class);
        $this->assertSame('Ban đầu', $service->items('primary')->first()->label);

        $item->update(['label' => 'Đã đổi']);
        $this->assertSame('Đã đổi', $service->items('primary')->first()->label);
        $item->update(['is_active' => false]);
        $this->assertCount(0, $service->items('primary'));
        $item->update(['is_active' => true]);

        $menu->update(['location' => 'secondary']);
        $this->assertCount(0, $service->items('primary'));
        $this->assertCount(1, $service->items('secondary'));
        $menu->update(['is_active' => false]);
        $this->assertCount(0, $service->items('secondary'));
        $menu->update(['is_active' => true]);
        $this->assertCount(1, $service->items('secondary'));
        $item->delete();
        $this->assertCount(0, $service->items('secondary'));
    }

    public function test_parent_relationship_rejects_cycles_and_other_menus(): void
    {
        $menu = Menu::factory()->create();
        $root = MenuItem::factory()->for($menu)->create();
        $child = MenuItem::factory()->for($menu)->create(['parent_id' => $root->id]);

        try {
            $root->update(['parent_id' => $child->id]);
            $this->fail('A cycle must be rejected.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('parent_id', $exception->errors());
        }

        $this->expectException(ValidationException::class);
        MenuItem::factory()->create(['parent_id' => $root->id]);
    }

    public function test_seeder_adds_legal_documents_and_keeps_old_records_recoverable(): void
    {
        $menu = Menu::factory()->create(['location' => 'primary']);
        $old = MenuItem::factory()->for($menu)->create(['label' => 'Tin tức', 'route_name' => 'posts.index']);
        $news = MenuItem::factory()->for($menu)->create(['label' => 'Tin tức & Pháp luật', 'route_name' => 'posts.index']);
        $custom = MenuItem::factory()->for($menu)->create(['label' => 'Tài liệu riêng']);
        $category = ServiceCategory::factory()->create(['is_active' => true]);
        $service = Service::factory()->create([
            'service_category_id' => $category->id,
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);

        $this->seed(HeaderNavigationSeeder::class);
        $count = $menu->items()->count();
        $this->seed(HeaderNavigationSeeder::class);
        $this->assertSame($count, $menu->items()->count());
        $this->assertModelExists($old);
        $this->assertFalse($old->fresh()->is_active);
        $this->assertTrue($custom->fresh()->is_active);
        $legal = PostCategory::query()->where('slug', 'van-ban-phap-luat')->firstOrFail();
        $this->assertTrue($legal->is_active);
        $this->assertTrue($news->children()->where('url', '/tin-tuc?category=van-ban-phap-luat')->exists());
        $this->assertTrue($menu->items()->where('url', '/dich-vu/'.$service->slug)->exists());

        $legalPost = Post::factory()->create([
            'post_category_id' => $legal->id,
            'status' => ContentStatus::Published,
            'published_at' => now(),
        ]);
        Post::factory()->create(['status' => ContentStatus::Published, 'published_at' => now()]);
        $this->get(route('posts.index', ['category' => $legal->slug]))
            ->assertOk()
            ->assertViewHas('posts', fn ($posts): bool => $posts->modelKeys() === [$legalPost->id]);
    }

    public function test_admin_can_save_label_parent_order_and_visibility_and_refresh_header(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $menu = Menu::factory()->create(['location' => 'primary']);
        $root = MenuItem::factory()->for($menu)->create(['label' => 'Nhóm quản trị']);
        $child = MenuItem::factory()->for($menu)->create(['label' => 'Mục cần đổi']);
        app(MenuService::class)->items('primary');

        $component = Livewire::test(EditMenu::class, ['record' => $menu->id]);
        $state = $component->get('data.items');
        $key = array_key_first(array_filter($state, fn (array $item): bool => $item['label'] === $child->label));
        $component->set('data.items.'.$key.'.label', 'Mục đã quản lý')
            ->set('data.items.'.$key.'.parent_id', $root->id)
            ->call('save')
            ->assertHasNoFormErrors();
        $this->assertSame($root->id, $child->fresh()->parent_id);
        $this->assertSame('Mục đã quản lý', app(MenuService::class)->items('primary')->first()->children->first()->label);

        $component->set('data.items.'.$key.'.is_active', false)->call('save')->assertHasNoFormErrors();
        $this->assertCount(0, app(MenuService::class)->items('primary')->first()->children);
    }

    public function test_header_settings_update_without_stale_cache_and_invalid_links_are_safe(): void
    {
        $setting = Setting::factory()->create(['key' => 'header_cta_label', 'value' => 'Tư vấn cũ']);
        $this->assertStringContainsString('Tư vấn cũ', view('components.frontend.header')->render());
        $setting->update(['value' => 'Tư vấn mới']);
        $this->assertStringContainsString('Tư vấn mới', view('components.frontend.header')->render());
        $this->assertSame('#', (new MenuItem(['url' => 'javascript:alert(1)']))->resolvedUrl());
        $this->assertSame('/tin-tuc/bai-viet', (new MenuItem([
            'route_name' => 'posts.show', 'url' => '/tin-tuc/bai-viet',
        ]))->resolvedUrl());
    }
}
