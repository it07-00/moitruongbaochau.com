<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Slider;
use App\Models\Testimonial;
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
        $serviceCategories = ServiceCategory::query()
            ->where('is_active', true)
            ->with(['services' => function ($query) {
                $query->published()->orderBy('sort_order');
            }])
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
            ->select(['id', 'title', 'slug', 'category', 'client', 'location', 'summary', 'thumbnail', 'completed_at'])
            ->latest('published_at')
            ->limit(9)
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
        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $partners = Partner::query()
            ->where('is_active', true)
            ->where('type', 'partner')
            ->orderBy('sort_order')
            ->get();
        $presses = Partner::query()
            ->where('is_active', true)
            ->where('type', 'press')
            ->orderBy('sort_order')
            ->get();
        $page = Page::query()->where('slug', 'trang-chu')->orWhere('template', 'home')->first();

        $seoTitle = $page?->meta_title ?: 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu';
        $seoDescription = $page?->meta_description ?: 'Tư vấn môi trường, giấy phép môi trường, quan trắc, kiểm kê khí nhà kính và giải pháp xử lý môi trường cho doanh nghiệp.';

        $seo = SeoData::forPage(
            $seoTitle,
            $seoDescription,
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
            $page?->og_image ? asset($page->og_image) : null,
        );

        return view('frontend.home', compact('page', 'sliders', 'serviceCategories', 'services', 'projects', 'posts', 'postCategories', 'testimonials', 'partners', 'presses', 'seo'));
    }
}
