<?php

namespace App\Observers;

use App\Models\Menu;
use App\Services\MenuService;

class MenuObserver
{
    public function __construct(private MenuService $menuService) {}

    public function created(Menu $menu): void
    {
        $this->menuService->forget($menu->location);
    }

    public function updated(Menu $menu): void
    {
        $this->menuService->forget($menu->location);

        if ($menu->wasChanged('location')) {
            $this->menuService->forget((string) $menu->getOriginal('location'));
        }
    }

    public function deleted(Menu $menu): void
    {
        $this->menuService->forget($menu->location);
    }
}
