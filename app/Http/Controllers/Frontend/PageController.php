<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Partner;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function capabilityProfile(): View
    {
        $page = Page::query()->published()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $seo = SeoData::forContent($page, route('capability-profile'), 'WebPage');
        $path = $page->metadata['capability_pdf'] ?? '';
        $hasPdf = $this->isCapabilityPdfPath($path) && Storage::disk('public')->exists($path);

        return view('frontend.pages.capability-profile', compact('page', 'seo', 'hasPdf'));
    }

    public function capabilityPdf(Request $request): StreamedResponse
    {
        $page = Page::query()->published()->where('slug', 'ho-so-nang-luc')->firstOrFail();
        $path = $page->metadata['capability_pdf'] ?? '';
        abort_unless($this->isCapabilityPdfPath($path) && Storage::disk('public')->exists($path), 404);

        return Storage::disk('public')->response(
            $path,
            'ho-so-nang-luc-bao-chau.pdf',
            ['Content-Type' => 'application/pdf', 'X-Content-Type-Options' => 'nosniff'],
            $request->boolean('download') ? 'attachment' : 'inline',
        );
    }

    private function isCapabilityPdfPath(mixed $path): bool
    {
        return is_string($path)
            && str_starts_with($path, 'uploads/company-profile/')
            && ! preg_match('#(^|/)\.\.?(/|$)|[\\\\%]#', $path)
            && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf';
    }

    public function show(string $slug): View|RedirectResponse
    {
        $page = Page::query()->published()->where('slug', $slug)->firstOrFail();
        if ($page->template === 'capability-profile') {
            return redirect()->route('capability-profile', status: 301);
        }
        $seo = SeoData::forContent($page, route('pages.show', $page->slug), 'WebPage');

        return view('frontend.pages.show', compact('page', 'seo'));
    }
}
