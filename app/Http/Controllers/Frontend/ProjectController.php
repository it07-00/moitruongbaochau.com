<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $categoryFilter = request('category');

        $categories = [
            'giay-phep' => 'Giấy phép Môi trường',
            'dtm' => 'Báo cáo ĐTM',
            'khi-nha-kinh' => 'Khí nhà kính & ESG',
            'xu-ly-nuoc' => 'Xử lý Nước & Khí thải',
            'quan-trac' => 'Quan trắc Môi trường',
        ];

        $projects = Project::query()
            ->published()
            ->when($categoryFilter && $categoryFilter !== '-1' && $categoryFilter !== 'all', function ($query) use ($categoryFilter) {
                $query->where('category', $categoryFilter);
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categoryCounts = Project::query()
            ->published()
            ->selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $totalProjects = Project::query()->published()->count();

        $page = Page::query()->where('slug', 'du-an')->orWhere('template', 'projects')->first();

        $categoryTitle = $categoryFilter && isset($categories[$categoryFilter])
            ? 'Dự án '.$categories[$categoryFilter]
            : ($page?->meta_title ?: 'Dự án môi trường tiêu biểu');

        $seoDescription = $page?->meta_description ?: 'Năng lực triển khai giấy phép môi trường, ĐTM, quan trắc và kiểm kê khí nhà kính của Môi Trường Bảo Châu.';

        $seo = SeoData::forPage(
            $categoryTitle,
            $seoDescription,
            route('projects.index', $categoryFilter ? ['category' => $categoryFilter] : []),
            [],
            $page?->og_image ? asset($page->og_image) : null,
        );

        return view('frontend.projects.index', compact('page', 'projects', 'categories', 'categoryCounts', 'totalProjects', 'categoryFilter', 'seo'));
    }

    public function show(string $slug): View
    {
        $project = Project::query()->published()->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::query()
            ->published()
            ->whereKeyNot($project->getKey())
            ->when($project->category, fn ($query) => $query->where('category', $project->category))
            ->select(['id', 'title', 'slug', 'summary', 'thumbnail', 'client'])
            ->limit(3)
            ->get();
        $seo = SeoData::forContent($project, route('projects.show', $project->slug), 'CreativeWork');

        return view('frontend.projects.show', compact('project', 'relatedProjects', 'seo'));
    }
}
