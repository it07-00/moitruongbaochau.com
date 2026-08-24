<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContentResourceRequest;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ContentResourceController extends Controller
{
    /** @var array<string, class-string<Model>> */
    private const MODELS = [
        'pages' => Page::class,
        'services' => Service::class,
        'posts' => Post::class,
        'projects' => Project::class,
        'jobs' => JobPosting::class,
    ];

    public function index(string $resource): View
    {
        $items = $this->items($resource);

        return view('admin.content.index', compact('resource', 'items'));
    }

    public function create(string $resource): View
    {
        $this->modelClass($resource);
        $item = null;

        return view('admin.content.form', compact('resource', 'item'));
    }

    public function store(ContentResourceRequest $request, string $resource): RedirectResponse
    {
        $modelClass = $this->modelClass($resource);
        $data = $this->normalized($request->validated(), $resource);
        $modelClass::query()->create($data);

        return to_route('admin.content.index', $resource)->with('success', 'Đã tạo nội dung.');
    }

    public function edit(string $resource, int $item): View
    {
        $modelClass = $this->modelClass($resource);
        $item = $modelClass::query()->findOrFail($item);

        return view('admin.content.form', compact('resource', 'item'));
    }

    public function update(ContentResourceRequest $request, string $resource, int $item): RedirectResponse
    {
        $modelClass = $this->modelClass($resource);
        $model = $modelClass::query()->findOrFail($item);
        $model->update($this->normalized($request->validated(), $resource));

        return to_route('admin.content.index', $resource)->with('success', 'Đã cập nhật nội dung.');
    }

    public function destroy(string $resource, int $item): RedirectResponse
    {
        $modelClass = $this->modelClass($resource);
        $modelClass::query()->findOrFail($item)->delete();

        return to_route('admin.content.index', $resource)->with('success', 'Đã xóa nội dung.');
    }

    private function items(string $resource): LengthAwarePaginator
    {
        $modelClass = $this->modelClass($resource);

        return $modelClass::query()->latest()->paginate(20);
    }

    /** @return class-string<Model> */
    private function modelClass(string $resource): string
    {
        abort_unless(array_key_exists($resource, self::MODELS), 404);

        return self::MODELS[$resource];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalized(array $data, string $resource): array
    {
        $titleField = $resource === 'services' ? 'name' : 'title';
        $data['slug'] = filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data[$titleField]);
        if (in_array($resource, ['services', 'posts', 'projects'], true)) {
            $data['is_featured'] = (bool) ($data['is_featured'] ?? false);
        }

        $modelClass = $this->modelClass($resource);

        return Arr::only($data, (new $modelClass)->getFillable());
    }
}
