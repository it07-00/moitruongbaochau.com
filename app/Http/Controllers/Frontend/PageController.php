<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = Page::query()->published()->where('slug', 'gioi-thieu')->firstOrFail();
        $seo = SeoData::forContent($page, route('about'), 'AboutPage');

        return view('frontend.pages.about', compact('page', 'seo'));
    }

    public function show(string $slug): View
    {
        $page = Page::query()->published()->where('slug', $slug)->firstOrFail();
        $seo = SeoData::forContent($page, route('pages.show', $page->slug), 'WebPage');

        return view('frontend.pages.show', compact('page', 'seo'));
    }
}
