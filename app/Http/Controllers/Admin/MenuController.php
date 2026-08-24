<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItemRequest;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\MenuService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    public function __construct(private readonly MenuService $menus) {}

    public function index(): View
    {
        $menus = Menu::query()->with(['items:id,menu_id,parent_id,label,url,route_name,target,sort_order,is_active'])->withCount('items')->latest()->paginate(20);

        return view('admin.menus.index', compact('menus'));
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        Menu::query()->create([
            ...$request->safe()->only(['name', 'location']),
            'is_active' => $request->boolean('is_active'),
        ]);
        $this->menus->forget($request->string('location')->toString());

        return back()->with('success', 'Đã tạo menu.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $location = $menu->location;
        $menu->delete();
        $this->menus->forget($location);

        return back()->with('success', 'Đã xóa menu.');
    }

    public function storeItem(MenuItemRequest $request, Menu $menu): RedirectResponse
    {
        $menu->items()->create([
            ...$request->safe()->only(['parent_id', 'label', 'url', 'route_name', 'target', 'sort_order']),
            'is_active' => $request->boolean('is_active'),
        ]);
        $this->menus->forget($menu->location);

        return back()->with('success', 'Đã thêm mục menu.');
    }

    public function destroyItem(Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->getKey(), 404);
        $item->delete();
        $this->menus->forget($menu->location);

        return back()->with('success', 'Đã xóa mục menu.');
    }
}
