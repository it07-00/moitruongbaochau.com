<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class MenuService
{
    /** @return Collection<int, MenuItem> */
    public function items(string $location): Collection
    {
        if (! Schema::hasTable((new Menu)->getTable())) {
            return new Collection;
        }

        $cacheKey = 'website.menu.'.$location;
        $cached = Cache::get($cacheKey);

        if ($cached instanceof Collection) {
            return $cached;
        }

        $menu = Menu::query()
            ->where('location', $location)
            ->where('is_active', true)
            ->with(['items' => fn ($query) => $query
                ->where('is_active', true)
                ->whereNull('parent_id')
                ->with(['children' => fn ($query) => $query->where('is_active', true)])])
            ->first();

        /** @var Collection<int, MenuItem> $items */
        $items = $menu?->items ?? new Collection;

        Cache::forever($cacheKey, $items);

        return $items;
    }

    public function forget(string $location): void
    {
        Cache::forget('website.menu.'.$location);
    }
}
