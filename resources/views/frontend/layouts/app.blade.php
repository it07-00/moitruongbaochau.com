<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-seo :seo="$seo ?? []" />
    <link rel="icon" href="{{ asset('assets/images/cropped-chuan-192x192.png') }}" sizes="192x192">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
</head>
<body class="{{ $bodyClass ?? '' }}" itemscope itemtype="https://schema.org/WebPage">
    <x-frontend.header />
    <main class="main site-content" id="site-content">
        <div class="webhd-shap-bg" aria-hidden="true">
            <img src="{{ asset('assets/images/bg-02.webp') }}" alt="" width="1698" height="1080">
        </div>
        <div class="webhd-shap" aria-hidden="true">
            <img src="{{ asset('assets/images/logo-leave-png-min.png') }}" alt="" width="536" height="522" class="opacity-15">
        </div>
        @yield('content')
    </main>
    <x-frontend.footer />
    <x-frontend.floating-contact />
    <a title="Về đầu trang" aria-label="Về đầu trang" rel="nofollow" href="#" class="c-back-to-top size-10 lg:size-12 right-3 bottom-20 lg:bottom-8 rounded-full" data-fx-scroll-top data-show="false" data-scroll-start="300">
        <span aria-hidden="true">↑</span>
    </a>
    <script src="{{ asset('assets/js/swiper.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
</body>
</html>
