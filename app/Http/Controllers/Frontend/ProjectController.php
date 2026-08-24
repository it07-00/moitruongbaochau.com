<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->published()->latest('published_at')->paginate(12)->withQueryString();
        $seo = SeoData::forPage(
            'Dự án môi trường tiêu biểu',
            'Năng lực triển khai giấy phép môi trường, ĐTM, quan trắc và kiểm kê khí nhà kính.',
            route('projects.index'),
        );

        return view('frontend.projects.index', compact('projects', 'seo'));
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
