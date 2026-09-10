<?php

namespace App\Observers;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\MenuService;
use Illuminate\Validation\ValidationException;

class MenuItemObserver
{
    public function __construct(private MenuService $menuService) {}

    public function saving(MenuItem $menuItem): void
    {
        $parentId = $menuItem->parent_id;
        $visited = [$menuItem->getKey()];

        while ($parentId !== null) {
            if (in_array($parentId, $visited)) {
                throw ValidationException::withMessages(['parent_id' => 'Mục cha không được tạo vòng lặp menu.']);
            }
            $visited[] = $parentId;
            $parent = MenuItem::query()->whereKey($parentId)->where('menu_id', $menuItem->menu_id)->first();

            if ($parent === null) {
                throw ValidationException::withMessages(['parent_id' => 'Mục cha phải thuộc cùng menu.']);
            }
            $parentId = $parent->parent_id;
        }
    }

    public function created(MenuItem $menuItem): void
    {
        $this->forgetMenu($menuItem->menu_id);
    }

    public function updated(MenuItem $menuItem): void
    {
        $this->forgetMenu($menuItem->menu_id);

        if ($menuItem->wasChanged('menu_id')) {
            $this->forgetMenu((int) $menuItem->getOriginal('menu_id'));
        }
    }

    public function deleted(MenuItem $menuItem): void
    {
        $this->forgetMenu($menuItem->menu_id);
    }

    private function forgetMenu(int $menuId): void
    {
        $location = Menu::query()->whereKey($menuId)->value('location');

        if (is_string($location)) {
            $this->menuService->forget($location);
        }
    }
}
