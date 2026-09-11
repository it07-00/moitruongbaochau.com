<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = Page::query()
            ->published()
            ->indexable()
            ->where('template', 'default')
            ->select(['slug', 'canonical_url', 'updated_at'])
            ->get();
        $services = Service::query()->published()->indexable()->select(['slug', 'canonical_url', 'updated_at'])->get();
        $posts = Post::query()->published()->indexable()->select(['slug', 'canonical_url', 'updated_at'])->get();
        $projects = Project::query()->published()->indexable()->select(['slug', 'canonical_url', 'updated_at'])->get();
        $jobs = JobPosting::query()->published()->indexable()->open()->select(['slug', 'canonical_url', 'updated_at'])->get();

        return response()
            ->view('frontend.sitemap', compact('pages', 'services', 'posts', 'projects', 'jobs'))
            ->header('Content-Type', 'application/xml');
    }
}
