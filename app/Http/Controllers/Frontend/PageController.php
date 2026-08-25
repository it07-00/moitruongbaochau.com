<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Partner;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = Page::query()->published()->where('slug', 'gioi-thieu')->firstOrFail();
        $seo = SeoData::forContent($page, route('about'), 'AboutPage');
        $partners = Partner::query()->active()->where('type', 'partner')->orderBy('sort_order')->get();
        $presses = Partner::query()->active()->where('type', 'press')->orderBy('sort_order')->get();

        return view('frontend.pages.about', compact('page', 'seo', 'partners', 'presses'));
    }

    public function show(string $slug): View
    {
        $page = Page::query()->published()->where('slug', $slug)->firstOrFail();
        $seo = SeoData::forContent($page, route('pages.show', $page->slug), 'WebPage');

        return view('frontend.pages.show', compact('page', 'seo'));
    }
}
