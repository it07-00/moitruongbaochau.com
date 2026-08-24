<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->published()
            ->with('category:id,name,slug')
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();
        $seo = SeoData::forPage(
            'Dịch vụ môi trường doanh nghiệp',
            'Dịch vụ tư vấn giấy phép, quan trắc, kiểm kê khí nhà kính và xử lý môi trường.',
            route('services.index'),
        );

        return view('frontend.services.index', compact('services', 'seo'));
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
