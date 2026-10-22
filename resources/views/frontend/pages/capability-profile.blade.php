@extends('frontend.layouts.app')

@section('content')
<section class="section py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <nav class="text-sm text-gray-600 mb-6" aria-label="Đường dẫn trang">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true"> / </span>
            <span aria-current="page">Hồ sơ năng lực</span>
        </nav>
        <article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight">{{ $page->title }}</h1>
            @if(filled($page->excerpt))
                <p class="mt-6 text-gray-600 leading-relaxed">{{ $page->excerpt }}</p>
            @endif
            @if(filled($page->content))
                <div class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                    {!! app(\App\Support\OptimizedImage::class)->html($page->content) !!}
                </div>
            @endif
            @if($hasPdf)
                <div class="about-capability-actions">
                    <a href="{{ route('capability-profile.pdf') }}" target="_blank" rel="noopener noreferrer">Xem hồ sơ năng lực ↗</a>
                    <a href="{{ route('capability-profile.pdf', ['download' => 1]) }}" download="ho-so-nang-luc-bao-chau.pdf">Tải PDF ↓</a>
                </div>
                <p class="mt-6 text-sm text-gray-600">Nếu thiết bị không hiển thị bản xem trước, hãy chọn Xem hồ sơ năng lực hoặc Tải PDF.</p>
                <iframe class="capability-profile-frame" src="{{ route('capability-profile.pdf') }}" title="Hồ sơ năng lực Môi Trường Bảo Châu" loading="lazy"></iframe>
            @else
                <div class="about-capability-card">
                    <p>Hồ sơ năng lực đang được cập nhật. Vui lòng liên hệ để nhận bản mới nhất.</p>
                    <div class="about-capability-actions">
                        <a href="{{ route('contact.index') }}">Liên hệ nhận hồ sơ năng lực</a>
                    </div>
                </div>
            @endif
        </article>
    </div>
</section>
@endsection

@push('styles')
<style>
    .capability-profile-frame { display: block; width: 100%; height: 75vh; min-height: 400px; margin-top: 24px; border: 1px solid #e2e9e4; border-radius: 16px; }
</style>
@endpush
