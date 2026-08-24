<!-- Mobile Drawer Menu -->
<div
  class="off-canvas fixed top-0 right-0 h-full w-[310px] sm:w-[360px] max-w-[85vw] bg-white shadow-2xl z-[99999] flex flex-col justify-between transition-transform duration-300 translate-x-full invisible [&.is-open]:visible [&.is-open]:translate-x-0"
  id="offCanvasMenu"
  data-fx-off-canvas=""
  data-content-scroll="true"
>
  <!-- Header Drawer: Logo & Close Button -->
  <div class="flex items-center justify-between px-4 py-3.5 border-b border-gray-100 bg-white gap-2">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5 min-w-0 flex-1" rel="home">
      <img
        src="{{ asset('assets/images/logo-leave-png-min.png') }}"
        width="36"
        height="36"
        class="h-9 w-9 shrink-0 object-contain"
        style="width: 36px; height: 36px; min-width: 36px; min-height: 36px; max-width: 36px; max-height: 36px;"
        alt="Môi Trường Bảo Châu"
        loading="eager"
      />
      <div class="flex flex-col min-w-0">
        <span class="font-bold text-[13px] text-[#064e3b] uppercase leading-tight tracking-tight truncate">Môi Trường Bảo Châu</span>
        <span class="text-[10px] text-black font-medium truncate">Tư vấn &amp; Kỹ thuật MT</span>
      </div>
    </a>
    <button
      class="flex items-center justify-center size-8 shrink-0 rounded-full bg-gray-100 hover:bg-gray-200 text-black hover:text-gray-900 transition-colors cursor-pointer"
      style="width: 32px; height: 32px; min-width: 32px; min-height: 32px"
      aria-label="Đóng menu"
      type="button"
      data-close=""
    >
      <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Quick Search -->
  <div class="px-4 pt-3.5 pb-2">
    <form action="{{ route('search') }}" class="relative flex items-center" method="get" accept-charset="UTF-8">
      <input
        id="mobile-search-input"
        required=""
        type="search"
        autocomplete="off"
        name="q"
        value=""
        placeholder="Tìm dịch vụ: ĐTM, Giấy phép MT..."
        class="w-full bg-gray-50 border border-gray-200 text-[13.5px] rounded-full pl-4 pr-10 py-2.5 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white transition-all shadow-xs"
      />
      <button type="submit" class="absolute right-3 text-gray-400 hover:text-primary transition-colors" aria-label="Tìm kiếm">
        <svg class="size-4.5 w-4.5 h-4.5" width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
      </button>
    </form>
  </div>

  <!-- Main Mobile Navigation Accordion -->
  <div class="menu-outer flex-1 overflow-y-auto px-4 py-2">
    <ul id="menu-29035c419b" class="menu vertical vertical-menu mobile-menu flex flex-col gap-1 text-[14.5px]">
      <li>
        <a href="{{ route('home') }}" class="mobile-nav-link flex items-center py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors">Trang chủ</a>
      </li>
      <li>
        <a href="{{ route('about') }}" class="mobile-nav-link flex items-center py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors">Giới thiệu</a>
      </li>

      <!-- Accordion: Dịch vụ môi trường (Load động từ Database) -->
      <li class="has-submenu">
        <button type="button" class="mobile-submenu-toggle w-full flex items-center justify-between py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors cursor-pointer text-left">
          <span>Dịch vụ môi trường</span>
          <svg class="submenu-chevron size-4 w-4 h-4 text-gray-400 transition-transform duration-200" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
        <ul class="submenu hidden pl-3.5 my-1 flex flex-col gap-0.5 border-l-2 border-primary/40 ml-3">
          @foreach($headerServiceCategories as $serviceCat)
            <li class="pt-2 pb-0.5"><span class="block px-2 text-[11.5px] font-bold uppercase tracking-wider text-primary">{{ $serviceCat->name }}</span></li>
            @foreach($serviceCat->services as $srv)
              <li><a href="{{ route('services.show', $srv->slug) }}" class="mobile-nav-link block py-1.5 px-2.5 text-[13.5px] rounded-lg text-gray-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium">{{ $srv->name }}</a></li>
            @endforeach
          @endforeach
        </ul>
      </li>

      <li>
        <a href="{{ route('projects.index') }}" class="mobile-nav-link flex items-center py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors">Dự án</a>
      </li>

      <!-- Accordion: Tin tức & Pháp luật (Load động từ Database) -->
      <li class="has-submenu">
        <button type="button" class="mobile-submenu-toggle w-full flex items-center justify-between py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors cursor-pointer text-left">
          <span>Tin tức & Pháp luật</span>
          <svg class="submenu-chevron size-4 w-4 h-4 text-gray-400 transition-transform duration-200" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
          </svg>
        </button>
        <ul class="submenu hidden pl-3.5 my-1 flex flex-col gap-0.5 border-l-2 border-primary/40 ml-3">
          @foreach($headerPostCategories as $postCat)
            <li class="pt-2 pb-0.5"><span class="block px-2 text-[11.5px] font-bold uppercase tracking-wider text-primary">{{ $postCat->name }}</span></li>
            @foreach($postCat->posts as $pst)
              <li><a href="{{ route('posts.show', $pst->slug) }}" class="mobile-nav-link block py-1.5 px-2.5 text-[13.5px] rounded-lg text-gray-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium">{{ $pst->title }}</a></li>
            @endforeach
          @endforeach
        </ul>
      </li>

      <li>
        <a href="{{ route('recruitment.index') }}" class="mobile-nav-link flex items-center py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors">Tuyển dụng</a>
      </li>

      <li>
        <a href="{{ route('contact.index') }}" class="mobile-nav-link flex items-center py-2.5 px-3 rounded-xl font-medium text-gray-800 hover:bg-gray-50 hover:text-primary transition-colors">Liên hệ</a>
      </li>
    </ul>
  </div>

  <!-- Quick Action Footer: Hotline & Zalo Button -->
  <div class="p-4 border-t border-gray-100 bg-gray-50/80 flex flex-col gap-2">
    <a
      href="tel:{{ $websiteSettings['hotline'] ?? '0915549148' }}"
      class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-primary hover:bg-[#e03e2f] text-white font-bold text-[14px] shadow-sm shadow-primary/25 transition-all text-center"
    >
      <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
      </svg>
      Hotline: {{ $websiteSettings['hotline'] ?? '0915 549 148' }}
    </a>
    <p class="text-[11px] text-black text-center">Hỗ trợ tư vấn 24/7 (Thứ 2 - Thứ 7)</p>
  </div>
</div>

<!-- Desktop Header -->
<div class="relative">
  <header data-fx-sticky="" id="header" class="site-header" itemtype="https://schema.org/WPHeader" itemscope="">
    <div id="masthead" class="masthead py-4 sm:py-5 glass-effect transition-all duration-300">
      <div class="container px-3 sm:px-4 mx-auto flex items-center justify-between gap-2 sm:gap-4">
        <div class="masthead-logo flex-shrink-0">
          <div class="site-logo">
            <a class="logo flex items-center" title="MÔI TRƯỜNG BẢO CHÂU" href="{{ route('home') }}" rel="home">
              <span class="custom-logo-link">
                <img
                  src="{{ asset('assets/images/logo-leave-png-min.png') }}"
                  class="custom-logo h-14 sm:h-16 lg:h-18 w-auto object-contain transition-transform duration-300 hover:scale-105"
                  alt="Môi Trường Bảo Châu"
                  loading="eager"
                  fetchpriority="high"
                  decoding="async"
                />
              </span>
            </a>
            <p class="sr-only">MÔI TRƯỜNG BẢO CHÂU</p>
          </div>
        </div>

        <div class="nav-container pl-2 pr-2 xl:pl-6 xl:pr-4 hidden lg:flex items-center justify-center flex-1">
          <nav class="nav" id="main-nav">
            <ul
              id="menu-8c6d27c2ee"
              class="dropdown menu horizontal-menu main-nav u-flex-x items-center gap-1 xl:gap-2 min-h-11 xl:min-h-12 bg-black/6 backdrop-blur-md pt-1 px-3.5 xl:px-6 pb-1 rounded-full"
              data-fx-dropdown-menu=""
              data-hover="true"
              data-autohide="true"
            >
              <li>
                <a href="{{ route('home') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5">Trang chủ</a>
              </li>

              <li>
                <a href="{{ route('about') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5">Giới thiệu</a>
              </li>

              <!-- Dịch vụ môi trường Mega Menu (Load động từ Database) -->
              <li class="col-3 menu-mega">
                <a href="{{ route('services.index') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5 gap-1">
                  Dịch vụ môi trường
                  <svg class="size-3.5 w-3.5 h-3.5 opacity-60" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                  </svg>
                </a>
                <ul class="submenu vertical menu">
                  @foreach($headerServiceCategories as $serviceCat)
                  <li>
                    <a href="{{ route('services.index') }}" class="text-[14.5px] font-bold! text-primary uppercase pb-1 border-b border-white/10">{{ $serviceCat->name }}</a>
                    <ul class="submenu vertical menu">
                      @foreach($serviceCat->services as $srv)
                      <li><a href="{{ route('services.show', $srv->slug) }}" title="{{ $srv->name }}">{{ $srv->name }}</a></li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </li>

              <li>
                <a href="{{ route('projects.index') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5">Dự án</a>
              </li>

              <!-- MORE MENU ITEM FOR COMPACT SCREENS (1024px - 1279px) -->
              <li class="nav-item-more relative">
                <a href="javascript:;" class="flex items-center justify-center h-full font-bold text-base text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5 leading-none cursor-pointer" title="Xem thêm" aria-label="Xem thêm menu">...</a>
                <ul class="submenu vertical menu bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-black/8 py-2 px-1.5 min-w-[210px] text-[14px]">
                  <li><a href="{{ route('posts.index') }}" class="flex items-center justify-between py-2 px-3 rounded-xl font-medium text-gray-800 hover:text-primary hover:bg-primary/5 transition-colors"><span>Tin tức &amp; Pháp luật</span></a></li>
                  <li><a href="{{ route('recruitment.index') }}" class="flex items-center py-2 px-3 rounded-xl font-medium text-gray-800 hover:text-primary hover:bg-primary/5 transition-colors">Tuyển dụng</a></li>
                  <li><a href="{{ route('contact.index') }}" class="flex items-center py-2 px-3 rounded-xl font-medium text-gray-800 hover:text-primary hover:bg-primary/5 transition-colors">Liên hệ</a></li>
                </ul>
              </li>

              <!-- Tin tức & Pháp luật Mega Menu (Load động từ Database) -->
              <li class="col-3 menu-mega nav-item-extended">
                <a href="{{ route('posts.index') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5 gap-1">
                  Tin tức & Pháp luật
                  <svg class="size-3.5 w-3.5 h-3.5 opacity-60" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                  </svg>
                </a>
                <ul class="submenu vertical menu">
                  @foreach($headerPostCategories as $postCat)
                  <li>
                    <a href="{{ route('posts.index') }}" class="text-[14px] font-bold! text-primary uppercase pb-1 border-b border-white/10">{{ $postCat->name }}</a>
                    <ul class="submenu vertical menu">
                      @foreach($postCat->posts as $pst)
                      <li><a href="{{ route('posts.show', $pst->slug) }}" title="{{ $pst->title }}">{{ $pst->title }}</a></li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </li>

              <li class="nav-item-extended">
                <a href="{{ route('recruitment.index') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5">Tuyển dụng</a>
              </li>

              <li class="nav-item-extended">
                <a href="{{ route('contact.index') }}" class="flex items-center h-full font-medium text-[14.5px] xl:text-[15px] text-gray-800 dark:text-gray-200 hover:text-primary dark:hover:text-primary transition-colors py-2 px-3 rounded-full hover:bg-black/5">Liên hệ</a>
              </li>
            </ul>
          </nav>
        </div>

        <div class="header-actions flex items-center gap-2 sm:gap-3 flex-shrink-0">
          <div class="all_search_dark_mode flex flex-[0_0_auto] items-center">
            <div class="dropdown-search relative">
              <a
                class="dropdown-trigger flex items-center justify-center size-10 sm:size-10.5 rounded-full bg-white/90 dark:bg-gray-800/90 border border-gray-200/90 dark:border-gray-700 shadow-xs hover:shadow-md hover:border-primary/50 text-gray-700 hover:text-primary hover:bg-primary/5 dark:text-gray-200 dark:hover:text-primary transition-all duration-200 active:scale-95"
                title="Tìm kiếm dịch vụ"
                href="javascript:;"
                data-fx-dropdown-toggle="#dropdown-search-aced3469f6"
              >
                <svg class="size-4.5 sm:size-5 svg-search" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                </svg>
                <svg class="size-4.5 sm:size-5 svg-close hidden" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </a>
              <div role="search" class="dropdown-pane alignment-right" id="dropdown-search-aced3469f6" data-fx-dropdown="" data-auto-focus="true">
                <form action="{{ route('search') }}" class="frm-search" method="get" accept-charset="UTF-8">
                  <div class="frm-container">
                    <label for="search-aced3469f6" class="sr-only">Tìm kiếm dịch vụ môi trường</label>
                    <input class="rounded-full" id="search-aced3469f6" required="" pattern="^(.*\S+.*)$" type="search" name="q" value="" placeholder="Tìm dịch vụ: ĐTM, Khí nhà kính, Nước thải..." />
                    <button class="btn-s" type="submit" aria-label="Search">
                      <svg class="size-5 w-5 h-5" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
                      </svg>
                      <span>Tìm kiếm</span>
                    </button>
                  </div>
                  <div class="frm-hint">
                    <p class="hint-title font-medium mt-6 mb-4">Dịch vụ môi trường nổi bật</p>
                    <ul class="hint-list flex flex-col gap-4 ml-3">
                      <li>
                        <a class="flex items-center gap-3 text-[14px] group" href="{{ route('services.index') }}" title="Kiểm Kê Khí Nhà Kính (ESG - CBAM)">
                          <svg class="w-4 h-4 text-primary" aria-hidden="true"><use href="#icon-check-circle-solid"></use></svg>
                          Kiểm Kê Khí Nhà Kính (ESG - CBAM)
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-3 text-[14px] group" href="{{ route('services.index') }}" title="Lập Báo Cáo Đánh Giá Tác Động Môi Trường (ĐTM)">
                          <svg class="w-4 h-4 text-primary" aria-hidden="true"><use href="#icon-check-circle-solid"></use></svg>
                          Lập Báo Cáo Đánh Giá Tác Động Môi Trường (ĐTM)
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-3 text-[14px] group" href="{{ route('services.index') }}" title="Cấp Giấy Phép Môi Trường Theo Luật 2020">
                          <svg class="w-4 h-4 text-primary" aria-hidden="true"><use href="#icon-check-circle-solid"></use></svg>
                          Cấp Giấy Phép Môi Trường Theo Luật 2020
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-3 text-[14px] group" href="{{ route('services.index') }}" title="Quan Trắc Môi Trường Lao Động Định Kỳ">
                          <svg class="w-4 h-4 text-primary" aria-hidden="true"><use href="#icon-check-circle-solid"></use></svg>
                          Quan Trắc Môi Trường Lao Động Định Kỳ
                        </a>
                      </li>
                      <li>
                        <a class="flex items-center gap-3 text-[14px] group" href="{{ route('services.index') }}" title="Thiết Kế & Thi Công Hệ Thống Xử Lý Nước Thải">
                          <svg class="w-4 h-4 text-primary" aria-hidden="true"><use href="#icon-check-circle-solid"></use></svg>
                          Thiết Kế & Thi Công Hệ Thống Xử Lý Nước Thải
                        </a>
                      </li>
                    </ul>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <a
            class="hidden sm:inline-flex btn btn-primary-1 items-center justify-center font-semibold text-[13.5px] sm:text-[14.5px] py-2 sm:py-2.5 px-4 sm:px-5 rounded-full shadow-lg shadow-primary/25 hover:shadow-primary/80 transition-all text-white whitespace-nowrap"
            href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $websiteSettings['hotline'] ?? '0915549148') }}"
            title="Tư vấn ngay"
            target="_blank"
            rel="noopener noreferrer nofollow"
          >
            Tư vấn ngay
          </a>

          <div class="off-canvas-content lg:hidden flex items-center" data-fx-off-canvas-content="">
            <button
              class="menu-lines flex items-center justify-center size-10 sm:size-10.5 rounded-full bg-white border border-gray-200/90 shadow-xs hover:shadow-md hover:border-primary/50 text-gray-700 hover:text-primary hover:bg-primary/5 transition-all duration-200 active:scale-95 cursor-pointer"
              type="button"
              data-open="offCanvasMenu"
              aria-label="Mở menu"
              id="btn-open-mobile-menu"
            >
              <svg class="size-5 w-5 h-5 transition-transform duration-200" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3.5" y1="6" x2="20.5" y2="6"></line>
                <line x1="3.5" y1="12" x2="15.5" y2="12"></line>
                <line x1="3.5" y1="18" x2="20.5" y2="18"></line>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
</div>

