<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $page = Page::query()->where('slug', 'dich-vu')->orWhere('template', 'services')->first();

        $services = Service::query()
            ->published()
            ->with('category:id,name,slug')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $seoTitle = $page?->meta_title ?: 'Dịch vụ môi trường doanh nghiệp';
        $seoDescription = $page?->meta_description ?: 'Dịch vụ tư vấn giấy phép, quan trắc, kiểm kê khí nhà kính và xử lý môi trường.';

        $seo = SeoData::forPage(
            $seoTitle,
            $seoDescription,
            route('services.index'),
            [],
            $page?->og_image ? asset($page->og_image) : null,
        );

        return view('frontend.services.index', compact('page', 'services', 'seo'));
    }

    public function show(string $slug): View
    {
        $service = Service::query()->published()->with('category:id,name,slug')->where('slug', $slug)->firstOrFail();
        $relatedServices = Service::query()
            ->published()
            ->whereKeyNot($service->getKey())
            ->when($service->service_category_id, fn ($query) => $query->where('service_category_id', $service->service_category_id))
            ->select(['id', 'name', 'slug', 'short_description', 'thumbnail'])
            ->limit(3)
            ->get();
        $seo = SeoData::forContent($service, route('services.show', $service->slug), 'Service');

        return view('frontend.services.show', compact('service', 'relatedServices', 'seo'));
    }
}
