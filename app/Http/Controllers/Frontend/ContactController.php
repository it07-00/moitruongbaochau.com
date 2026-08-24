<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index(): View
    {
        $seo = SeoData::forPage(
            'Liên hệ tư vấn môi trường',
            'Liên hệ Môi Trường Bảo Châu để được tư vấn hồ sơ, quan trắc và giải pháp môi trường cho doanh nghiệp.',
            route('contact.index'),
            [[
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => 'Môi Trường Bảo Châu',
                'url' => route('contact.index'),
                'telephone' => '+84915549148',
                'email' => 'info@baochauenvir.com',
            ]],
        );

        return view('frontend.contact', compact('seo'));
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        Contact::query()->create([
            ...$request->safe()->only(['name', 'email', 'phone', 'topic', 'message']),
            'source' => $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return to_route('contact.index')->with('success', 'Cảm ơn bạn đã liên hệ. Bảo Châu sẽ phản hồi trong thời gian sớm nhất.');
    }
}
