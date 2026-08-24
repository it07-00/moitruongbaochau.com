<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\PostCategory;
use App\Models\ServiceCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /** @var array<string, class-string<Model>> */
    private const MODELS = ['services' => ServiceCategory::class, 'posts' => PostCategory::class];

    public function index(string $type): View
    {
        $modelClass = $this->modelClass($type);
        $categories = $modelClass::query()->orderBy('sort_order')->paginate(30);

        return view('admin.categories.index', compact('type', 'categories'));
    }

    public function store(CategoryRequest $request, string $type): RedirectResponse
    {
        $modelClass = $this->modelClass($type);
        $data = $request->validated();
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $modelClass::query()->create($data);

        return back()->with('success', 'Đã tạo danh mục.');
    }

    public function destroy(string $type, int $category): RedirectResponse
    {
        $modelClass = $this->modelClass($type);
        $modelClass::query()->findOrFail($category)->delete();

        return back()->with('success', 'Đã xóa danh mục.');
    }

    /** @return class-string<Model> */
    private function modelClass(string $type): string
    {
        abort_unless(array_key_exists($type, self::MODELS), 404);

        return self::MODELS[$type];
    }
}
