<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $validated = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = trim((string) ($validated['q'] ?? ''));

        $services = collect();
        $posts = collect();
        $projects = collect();

        if (mb_strlen($query) >= 2) {
            $like = '%'.$query.'%';
            $services = Service::query()->published()->where(fn ($builder) => $builder->where('name', 'like', $like)->orWhere('short_description', 'like', $like))->limit(10)->get();
            $posts = Post::query()->published()->with(['category', 'author'])->where(fn ($builder) => $builder->where('title', 'like', $like)->orWhere('excerpt', 'like', $like))->limit(10)->get();
            $projects = Project::query()->published()->where(fn ($builder) => $builder->where('title', 'like', $like)->orWhere('summary', 'like', $like))->limit(10)->get();
        }

        $seo = SeoData::forPage('Tìm kiếm', 'Tìm kiếm nội dung trên website Môi Trường Bảo Châu.', route('search'));
        $seo['robots'] = 'noindex,follow';

        return view('frontend.search', compact('query', 'services', 'posts', 'projects', 'seo'));
    }
}
