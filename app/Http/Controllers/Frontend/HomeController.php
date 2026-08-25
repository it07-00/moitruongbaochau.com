<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $services = Service::query()
            ->published()
            ->where('is_featured', true)
            ->select(['id', 'name', 'slug', 'short_description', 'thumbnail', 'icon', 'sort_order'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();
        $projects = Project::query()
            ->published()
            ->where('is_featured', true)
            ->select(['id', 'title', 'slug', 'category', 'client', 'summary', 'thumbnail', 'completed_at'])
            ->latest('published_at')
            ->limit(6)
            ->get();
        $postCategories = PostCategory::query()
            ->where('is_active', true)
            ->with(['posts' => function ($query) {
                $query->published()
                    ->with(['category', 'author'])
                    ->latest('published_at');
            }])
            ->orderBy('sort_order')
            ->get();
        $posts = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(6)
            ->get();
        $seo = SeoData::forPage(
            'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu',
            'Tư vấn môi trường, giấy phép môi trường, quan trắc, kiểm kê khí nhà kính và giải pháp xử lý môi trường cho doanh nghiệp.',
            route('home'),
            [[
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => route('home').'#organization',
                'name' => 'Môi Trường Bảo Châu',
                'url' => route('home'),
                'logo' => asset('assets/images/optimized/logo-bao-chau.webp'),
            ], [
                '@context' => 'https://schema.org',
                '@type' => 'WebSite',
                '@id' => route('home').'#website',
                'name' => 'Môi Trường Bảo Châu',
                'url' => route('home'),
            ]],
        );

        return view('frontend.home', compact('sliders', 'services', 'projects', 'posts', 'postCategories', 'seo'));
    }
}
