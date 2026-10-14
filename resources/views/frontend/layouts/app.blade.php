<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-seo :seo="$seo ?? []" />
    <link rel="icon" href="{{ asset(str_starts_with($websiteSettings['favicon'] ?? '', 'uploads/') ? 'storage/'.$websiteSettings['favicon'] : ($websiteSettings['favicon'] ?? 'assets/images/cropped-chuan-192x192.png')) }}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{ asset(str_starts_with($websiteSettings['favicon'] ?? '', 'uploads/') ? 'storage/'.$websiteSettings['favicon'] : ($websiteSettings['favicon'] ?? 'assets/images/cropped-chuan-192x192.png')) }}">
    @foreach(['Regular', 'SemiBold'] as $fontWeight)
        <link rel="preload" href="{{ asset('assets/fonts/SVN-Poppins-'.$fontWeight.'.subset.woff') }}?v={{ substr(hash_file('sha256', public_path('assets/fonts/SVN-Poppins-'.$fontWeight.'.subset.woff')), 0, 12) }}" as="font" type="font/woff" crossorigin>
    @endforeach
    <style>{!! file_get_contents(public_path('assets/css/frontend-fonts.css')) !!}</style>
    @if(($bodyClass ?? '') === 'home')
        <style>{!! file_get_contents(public_path('assets/css/frontend-critical.css')) !!}</style>
        <link rel="preload" href="{{ asset('assets/css/frontend.min.css') }}?v={{ substr(hash_file('sha256', public_path('assets/css/frontend.min.css')), 0, 12) }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="{{ asset('assets/css/frontend.min.css') }}?v={{ substr(hash_file('sha256', public_path('assets/css/frontend.min.css')), 0, 12) }}"></noscript>
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/frontend.min.css') }}?v={{ substr(hash_file('sha256', public_path('assets/css/frontend.min.css')), 0, 12) }}">
    @endif
    @if($usesLivewire ?? false)
        @livewireStyles
    @endif
    @stack('styles')
</head>
<body class="{{ $bodyClass ?? '' }}" itemscope itemtype="https://schema.org/WebPage">
    <x-frontend.header />
    <main class="main site-content" id="site-content">
        <div class="webhd-shap-bg" aria-hidden="true">
            <x-frontend.image src="{{ asset('assets/images/bg-02.webp') }}" alt="" width="1698" height="1080" sizes="100vw" fetchpriority="{{ ($bodyClass ?? '') === 'home' ? 'high' : 'low' }}" decoding="async" />
        </div>
        <div class="webhd-shap" aria-hidden="true">
            <x-frontend.image src="{{ asset('assets/images/logo-leave-png-min.png') }}" alt="" width="536" height="522" sizes="520px" class="opacity-15" fetchpriority="low" decoding="async" />
        </div>
        @yield('content')
    </main>
    <x-frontend.footer />
    <x-frontend.floating-contact />
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}?v={{ file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : time() }}" defer></script>
    @if($usesLivewire ?? false)
        @livewireScripts
    @endif
    @stack('scripts')
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
