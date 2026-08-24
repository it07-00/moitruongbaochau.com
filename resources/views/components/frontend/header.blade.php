<div class="off-canvas fixed top-0 right-0 h-full w-[310px] sm:w-[360px] max-w-[85vw] bg-white shadow-2xl z-[99999] flex flex-col justify-between transition-transform duration-300 translate-x-full invisible [&.is-open]:visible [&.is-open]:translate-x-0" id="offCanvasMenu" data-fx-off-canvas data-content-scroll="true">
    <div class="flex items-center justify-between px-4 py-3.5 border-b border-gray-100">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5" rel="home">
            <img src="{{ asset('assets/images/optimized/logo-bao-chau.webp') }}" width="36" height="36" alt="Môi Trường Bảo Châu">
            <strong class="text-sm">MÔI TRƯỜNG BẢO CHÂU</strong>
        </a>
        <button type="button" data-close aria-label="Đóng menu" class="size-10 rounded-full bg-gray-100">×</button>
    </div>
    <nav class="flex-1 overflow-y-auto p-4" aria-label="Điều hướng di động">
        <ul id="menu-29035c419b" class="space-y-1">
            @foreach ($primaryMenuItems as $item)
                <li><a class="mobile-nav-link block py-3 px-3 rounded-xl" href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}">{{ $item->label }}</a></li>
            @endforeach
            <li><form action="{{ route('search') }}" method="get" class="flex gap-2 mt-3"><label for="mobile-search" class="sr-only">Tìm kiếm</label><input id="mobile-search" type="search" name="q" placeholder="Tìm kiếm" class="min-w-0 flex-1 rounded-xl border border-gray-300 px-3 py-2"><button class="bg-secondary text-white rounded-xl px-3">Tìm</button></form></li>
        </ul>
    </nav>
    <div class="p-4 border-t border-gray-100 bg-gray-50/80">
        <a href="tel:0915549148" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-primary text-white font-bold">Hotline: 0915 549 148</a>
    </div>
</div>
<header data-fx-sticky id="header" class="site-header" itemscope itemtype="https://schema.org/WPHeader">
    <div id="masthead" class="masthead py-4 sm:py-5 glass-effect transition-all duration-300">
        <div class="container px-3 sm:px-4 mx-auto flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3" rel="home">
                <img src="{{ asset('assets/images/optimized/logo-bao-chau.webp') }}" width="56" height="56" alt="Môi Trường Bảo Châu" class="size-12 sm:size-14 object-contain">
                <span class="hidden sm:block">
                    <strong class="block text-secondary text-base lg:text-lg">MÔI TRƯỜNG BẢO CHÂU</strong>
                    <small class="block text-xs">Đồng hành cùng doanh nghiệp</small>
                </span>
            </a>
            <nav class="hidden lg:block" aria-label="Điều hướng chính">
                <ul class="flex items-center gap-6 font-semibold" data-fx-dropdown-menu>
                    @foreach ($primaryMenuItems as $item)
                        <li><a href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}" @class(['c-button bg-primary text-white rounded-full px-5 py-2.5' => $item->route_name === 'contact.index'])>{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <button id="btn-open-mobile-menu" type="button" data-open="offCanvasMenu" class="lg:hidden size-11 rounded-full glass-effect" aria-label="Mở menu">☰</button>
        </div>
    </div>
</header>
