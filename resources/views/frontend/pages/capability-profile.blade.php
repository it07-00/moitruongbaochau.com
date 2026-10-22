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
            @if($flipbookUrl || $hasPdf)
                <div class="about-capability-actions">
                    <a href="{{ $flipbookUrl ?: route('capability-profile.pdf') }}" target="_blank" rel="noopener noreferrer">Xem hồ sơ năng lực ↗</a>
                    @if($hasPdf)
                        <a href="{{ route('capability-profile.pdf', ['download' => 1]) }}" download="ho-so-nang-luc-bao-chau.pdf">Tải PDF ↓</a>
                    @endif
                </div>
                <p class="mt-6 text-sm text-gray-600">{{ $flipbookUrl ? 'Lật trang để xem hồ sơ năng lực. Bạn có thể mở sách trong tab mới bằng nút Xem hồ sơ năng lực.' : 'Nếu thiết bị không hiển thị bản xem trước, hãy chọn Xem hồ sơ năng lực hoặc Tải PDF.' }}</p>
                @if($flipbookUrl)
                    <div class="heyzine-flipbook capability-profile-viewer" aria-label="Sách lật Hồ sơ năng lực Môi Trường Bảo Châu">
                        <a href="{{ $flipbookUrl }}" target="_blank" rel="noopener noreferrer">Mở sách lật hồ sơ năng lực</a>
                    </div>
                @else
                    <div class="capability-profile-viewer">
                        <iframe class="capability-profile-frame" src="{{ route('capability-profile.pdf') }}" title="Hồ sơ năng lực Môi Trường Bảo Châu" loading="lazy" allow="fullscreen" allowfullscreen></iframe>
                    </div>
                @endif
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
    .capability-profile-viewer { position: relative; width: 100%; height: 400px; max-height: 70svh; min-height: 260px; margin: 24px auto 0; border: 1px solid #e2e9e4; border-radius: 12px; }
    .capability-profile-frame { position: absolute; inset: 0; display: block; width: 100%; height: 100%; border: 1px solid #e2e9e4; border-radius: 16px; }
</style>
@endpush

@if($flipbookUrl)
    @push('scripts')
        <script async src="https://heyzine.com/release/embed.min.js"></script>
    @endpush
@endif
