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
                ->orderBy('id')])
            ->first();

        /** @var Collection<int, MenuItem> $items */
        $items = $menu?->items ?? new Collection;

        $groups = $items->groupBy(fn (MenuItem $item): int => $item->parent_id ?? 0);
        $attachChildren = function (MenuItem $item, array $ancestors = []) use (&$attachChildren, $groups): void {
            $ancestors[] = $item->getKey();
            $children = new Collection($groups->get($item->getKey(), collect())
                ->reject(fn (MenuItem $child): bool => in_array($child->getKey(), $ancestors, true))
                ->values()->all());
            $item->setRelation('children', $children);

            foreach ($children as $child) {
                $attachChildren($child, $ancestors);
            }
        };
        $items = new Collection($groups->get(0, collect())->all());

        foreach ($items as $item) {
            $attachChildren($item);
        }

        Cache::forever($cacheKey, $items);

        return $items;
    }

    public function forget(string $location): void
    {
        Cache::forget('website.menu.'.$location);
    }
}
