<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-seo :seo="$seo ?? []" />
    <link rel="icon" href="{{ asset('assets/images/cropped-chuan-192x192.png') }}" sizes="192x192">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}?v={{ filemtime(public_path('assets/css/header.css')) }}">
    @livewireStyles
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
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}?v={{ file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : time() }}" defer></script>
    @livewireScripts
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: {!! json_encode(session('success')) !!},
                    confirmButtonColor: '#ff4d38',
                    confirmButtonText: 'Đồng ý'
                });
            }
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Thông báo',
                    text: {!! json_encode(session('error')) !!},
                    confirmButtonColor: '#ff4d38',
                    confirmButtonText: 'Đóng'
                });
            }
        });
    </script>
    @endif
</body>
</html>
