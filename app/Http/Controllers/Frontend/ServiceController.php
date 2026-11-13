<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageView;
use App\Models\Service;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $page = Page::query()->where('slug', 'dich-vu')->orWhere('template', 'services')->first();

        PageView::record(
            viewable: $page,
            pageType: 'page',
            pageKey: 'page:services',
            pageTitle: $page?->title ?: 'Dịch vụ môi trường',
            pageUrl: route('services.index', [], false),
        );

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
            $page?->og_image,
        );
        $seo = SeoData::withPagination($seo, $services);

        return view('frontend.services.index', compact('page', 'services', 'seo'));
    }

    public function show(string $slug): View
    {
        $service = Service::query()->published()->with('category:id,name,slug')->where('slug', $slug)->firstOrFail();

        PageView::record(
            viewable: $service,
            pageType: 'service',
            pageKey: 'service:'.$service->slug,
            pageTitle: $service->name,
            pageUrl: isset(Service::DECLARATION_ROUTES[$service->slug])
                ? route(Service::DECLARATION_ROUTES[$service->slug], [], false)
                : route('services.show', $service->slug, false),
        );

        $relatedServices = Service::query()
            ->published()
            ->with('category:id,name,slug')
            ->whereKeyNot($service->getKey())
            ->when($service->service_category_id, fn ($query) => $query->where('service_category_id', $service->service_category_id))
            ->select(['id', 'service_category_id', 'name', 'slug', 'short_description', 'thumbnail'])
            ->limit(3)
            ->get();
        $seo = SeoData::forContent($service, $service->getPublicUrl(), 'Service');

        return view('frontend.services.show', compact('service', 'relatedServices', 'seo'));
    }
}
