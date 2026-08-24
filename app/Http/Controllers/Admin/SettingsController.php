<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function __construct(private readonly SettingService $settings) {}

    public function index(): View
    {
        $settings = $this->settings->all();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(SettingRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request): void {
            foreach ($request->validated('settings') as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => 'string', 'group' => str_starts_with($key, 'seo_') ? 'seo' : 'general'],
                );
            }
        });
        $this->settings->forget();

        return back()->with('success', 'Đã cập nhật thông tin website.');
    }
}
