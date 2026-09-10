<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\PostCategory;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Services\MenuService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeaderNavigationSeeder extends Seeder
{
    public function run(MenuService $menuService): void
    {
        DB::transaction(function (): void {
            Setting::query()->firstOrCreate(
                ['key' => 'header_cta_label'],
                ['value' => 'Tư vấn ngay', 'type' => 'string', 'group' => 'general'],
            );
            PostCategory::query()->firstOrCreate(
                ['slug' => 'van-ban-phap-luat'],
                ['name' => 'Văn bản pháp luật', 'sort_order' => 4, 'is_active' => true],
            );
            $menu = Menu::query()->firstOrCreate(
                ['location' => 'primary'],
                ['name' => 'Menu chính', 'is_active' => true],
            );
            $systemItems = [
                ['label' => 'Trang chủ', 'route_name' => 'home'],
                ['label' => 'Giới thiệu', 'route_name' => 'about'],
                ['label' => 'Dịch vụ môi trường', 'route_name' => 'services.index'],
                ['label' => 'Dự án', 'route_name' => 'projects.index'],
                ['label' => 'Tin tức & Pháp luật', 'route_name' => 'posts.index'],
                ['label' => 'Tuyển dụng', 'route_name' => 'recruitment.index'],
                ['label' => 'Liên hệ', 'route_name' => 'contact.index'],
            ];
            $roots = [];

            foreach ($systemItems as $sortOrder => $systemItem) {
                $matches = $menu->items()->whereNull('parent_id')
                    ->where('route_name', $systemItem['route_name'])->get();
                $item = $matches->firstWhere('label', $systemItem['label'])
                    ?? $matches->first()
                    ?? $menu->items()->create([...$systemItem, 'sort_order' => $sortOrder]);
                if (in_array($item->label, ['Dịch vụ', 'Tin tức'], true)) {
                    $item->update(['label' => $systemItem['label']]);
                }

                foreach ($matches as $duplicate) {
                    if ($duplicate->isNot($item) && in_array($duplicate->label, [
                        'Giới thiệu', 'Về chúng tôi', 'Dịch vụ', 'Hồ sơ & GP MT',
                        'Dịch vụ môi trường', 'Tin tức', 'Tin tức & Pháp luật',
                    ], true)) {
                        $duplicate->update(['is_active' => false]);
                    }
                }
                $roots[$systemItem['route_name']] = $item;
            }

            $services = $roots['services.index'];
            $categories = ServiceCategory::query()->where('is_active', true)->orderBy('sort_order')
                ->with(['services' => fn ($query) => $query->published()->orderBy('sort_order')])->get();
            foreach ($categories as $index => $category) {
                $group = $menu->items()->firstOrCreate(
                    ['parent_id' => $services->id, 'label' => $category->name],
                    ['url' => route('services.index', absolute: false), 'sort_order' => $index],
                );
                foreach ($category->services as $serviceIndex => $service) {
                    $url = route('services.show', $service->slug, false);
                    $menu->items()->firstOrCreate(
                        ['parent_id' => $group->id, 'url' => $url],
                        ['label' => $service->name, 'sort_order' => $serviceIndex],
                    );
                    $menu->items()->where('parent_id', $services->id)->where('url', $url)
                        ->update(['is_active' => false]);
                }
            }

            $news = $roots['posts.index'];
            $legacyUrls = [
                '/tin-tuc?category=phap-luat-moi-truong',
                '/tin-tuc?category=khi-nha-kinh-esg',
                '/tin-tuc?category=ky-thuat-moi-truong',
            ];
            $menu->items()->where('parent_id', $news->id)->whereIn('url', $legacyUrls)
                ->update(['is_active' => false]);
            foreach (PostCategory::query()->where('is_active', true)->orderBy('sort_order')->get() as $index => $category) {
                $menu->items()->firstOrCreate(
                    ['parent_id' => $news->id, 'url' => route('posts.index', ['category' => $category->slug], false)],
                    ['label' => $category->name, 'sort_order' => $index],
                );
            }
        });
        $menuService->forget('primary');
    }
}
