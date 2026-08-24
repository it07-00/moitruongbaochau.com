<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RedirectRequest;
use App\Models\Redirect;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RedirectController extends Controller
{
    public function index(): View
    {
        $redirects = Redirect::query()->latest()->paginate(30);

        return view('admin.redirects.index', compact('redirects'));
    }

    public function store(RedirectRequest $request): RedirectResponse
    {
        Redirect::query()->create([
            ...$request->safe()->only(['old_path', 'new_path', 'status_code']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Đã tạo redirect.');
    }

    public function update(RedirectRequest $request, Redirect $redirect): RedirectResponse
    {
        $redirect->update([
            ...$request->safe()->only(['old_path', 'new_path', 'status_code']),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Đã cập nhật redirect.');
    }

    public function destroy(Redirect $redirect): RedirectResponse
    {
        $redirect->delete();

        return back()->with('success', 'Đã xóa redirect.');
    }
}
