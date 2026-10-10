<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <style>
      @keyframes thunder-shake {
        0% {
          transform: translateX(0) rotate(0deg);
        }
        10% {
          transform: translateX(-2px) rotate(-5deg);
        }
        20% {
          transform: translateX(2px) rotate(4deg);
        }
        30% {
          transform: translateX(-2px) rotate(-3deg);
        }
        40% {
          transform: translateX(2px) rotate(2deg);
        }
        50% {
          transform: translateX(-1px) rotate(-2deg);
        }
        60% {
          transform: translateX(1px) rotate(1deg);
        }
        70% {
          transform: translateX(-1px) rotate(-1deg);
        }
        80% {
          transform: translateX(1px) rotate(0.5deg);
        }
        90% {
          transform: translateX(0) rotate(0deg);
        }
        100% {
          transform: translateX(0) rotate(0deg);
        }
      }
      .animate-thunder-shake {
        animation: thunder-shake 1.1s cubic-bezier(0.36, 0.07, 0.19, 0.97)
          infinite;
        will-change: transform;
        display: inline-block;
      }
    </style>

    <meta name="googlebot" content="notranslate" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <meta
      name="csrf-token"
      content="{{ csrf_token() }}"
    />

    <title>Dịch vụ kiểm kê khí nhà kính 2026 | Môi Trường Bảo Châu</title>
    <meta name="description" content="Bảo Châu tư vấn kiểm kê khí nhà kính, lập báo cáo và rà soát nghĩa vụ theo quy định hiện hành năm 2026. Đăng ký tư vấn, nhận báo giá cho doanh nghiệp." />
    <meta name="robots" content="index, follow, max-image-preview:large" />
    <meta name="theme-color" content="#0c3532" />
    <link rel="canonical" href="{{ route('ghg-service.index') }}" />

    <meta property="og:title" content="Dịch vụ kiểm kê khí nhà kính 2026 | Môi Trường Bảo Châu" />
    <meta property="og:description" content="Bảo Châu tư vấn kiểm kê khí nhà kính, lập báo cáo và rà soát nghĩa vụ theo quy định hiện hành năm 2026. Đăng ký tư vấn, nhận báo giá cho doanh nghiệp." />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Môi Trường Bảo Châu" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:url" content="{{ route('ghg-service.index') }}" />
    <meta property="og:image" content="{{ asset('landing/ghg-service/images/bao-chau-ghg-inventory-banner.png') }}" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1448" />
    <meta property="og:image:height" content="1086" />
    <meta property="og:image:alt" content="Dịch vụ kiểm kê khí nhà kính cho doanh nghiệp - Môi Trường Bảo Châu" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Dịch vụ kiểm kê khí nhà kính 2026 | Môi Trường Bảo Châu" />
    <meta name="twitter:description" content="Bảo Châu tư vấn kiểm kê khí nhà kính, lập báo cáo và rà soát nghĩa vụ theo quy định hiện hành năm 2026. Đăng ký tư vấn, nhận báo giá cho doanh nghiệp." />
    <meta name="twitter:image" content="{{ asset('landing/ghg-service/images/bao-chau-ghg-inventory-banner.png') }}" />
    <meta name="twitter:image:alt" content="Dịch vụ kiểm kê khí nhà kính cho doanh nghiệp - Môi Trường Bảo Châu" />

    <script type="application/ld+json">{!! json_encode([
      '@context' => 'https://schema.org', '@graph' => [
        ['@type' => 'Organization', '@id' => route('home').'#organization', 'name' => 'Môi Trường Bảo Châu', 'url' => route('home'), 'logo' => asset('landing/ghg-service/images/Logo-160.webp'), 'telephone' => '+84915549148', 'email' => 'info@baochauenvir.com'],
        ['@type' => 'Service', '@id' => route('ghg-service.index').'#service', 'name' => 'Dịch vụ kiểm kê khí nhà kính', 'serviceType' => 'Tư vấn và lập báo cáo kiểm kê khí nhà kính', 'url' => route('ghg-service.index'), 'description' => 'Tư vấn kiểm kê, lập báo cáo, rà soát nghĩa vụ và hướng dẫn hồ sơ theo quy định hiện hành.', 'provider' => ['@id' => route('home').'#organization'], 'areaServed' => ['@type' => 'Country', 'name' => 'Việt Nam']],
        ['@type' => 'WebPage', '@id' => route('ghg-service.index').'#webpage', 'url' => route('ghg-service.index'), 'name' => 'Dịch vụ kiểm kê khí nhà kính 2026 | Môi Trường Bảo Châu', 'inLanguage' => 'vi-VN', 'mainEntity' => ['@id' => route('ghg-service.index').'#service'], 'breadcrumb' => ['@id' => route('ghg-service.index').'#breadcrumb']],
        ['@type' => 'BreadcrumbList', '@id' => route('ghg-service.index').'#breadcrumb', 'itemListElement' => [
          ['@type' => 'ListItem', 'position' => 1, 'name' => 'Trang chủ', 'item' => route('home')],
          ['@type' => 'ListItem', 'position' => 2, 'name' => 'Dịch vụ môi trường', 'item' => route('services.index')],
          ['@type' => 'ListItem', 'position' => 3, 'name' => 'Kiểm kê khí nhà kính', 'item' => route('ghg-service.index')],
        ]],
      ],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

    <!-- Facebook Pixel Code -->
    <script>
      // Skip analytics while previewing the static page locally.
      if (!["localhost", "127.0.0.1", "[::1]", ""].includes(window.location.hostname)) {
      !(function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
          n.callMethod
            ? n.callMethod.apply(n, arguments)
            : n.queue.push(arguments);
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = "2.0";
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s);
      })(
        window,
        document,
        "script",
        "https://connect.facebook.net/en_US/fbevents.js",
      );

      fbq("init", "771958201986148");
      fbq("track", "PageView");
      }
    </script>
    
    <script>
      // Facebook Pixel Helper Functions
      function fbPixelTrack(eventName, parameters = {}) {
        if (typeof fbq !== "undefined") {
          console.log("FB Pixel Event:", eventName, parameters);
          fbq("track", eventName, parameters);
        } else {
          console.log(
            "FB Pixel not loaded, would track:",
            eventName,
            parameters,
          );
        }
      }
    </script>

    <!-- fav icon -->
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('landing/ghg-service/images/favicon-48.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('landing/ghg-service/images/apple-touch-icon.png') }}" />

    <link rel="preload" href="{{ asset('landing/ghg-service/fonts/inter-latin.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ asset('landing/ghg-service/fonts/inter-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="{{ asset('landing/ghg-service/images/sect-hero-bg.webp') }}" as="image" fetchpriority="high" />
    <link rel="stylesheet" href="{{ asset('landing/ghg-service/css/tailwind.css') }}?v={{ filemtime(public_path('landing/ghg-service/css/tailwind.css')) }}" />

    <!-- Custom Scripts (Head) -->

    
  </head>

  <body>
    <noscript>
      <img alt=""
        height="1"
        width="1"
        style="display: none"
        src="https://www.facebook.com/tr?id=771958201986148&ev=PageView&noscript=1"
      />
    </noscript>
    <!-- Custom Scripts (Body Start) -->

    <header
      id="header"
      class="header fixed inset-x-0 top-0 z-[1000] w-full max-w-none bg-white xl:static"
    >
      <div
        class="mx-auto flex min-h-16 w-full items-center justify-between !px-3 md:min-h-[88px] lg:justify-start lg:gap-6 xl:max-w-7xl xl:gap-10 xl:!px-0 3xl:max-w-[1664px]"
      >
        <div class="flex shrink-0 items-center gap-x-1 px-0 sm:gap-x-2 xl:gap-x-4 xl:px-[11px]">
          <button
            class="menu-toggle inline-flex size-11 shrink-0 items-center justify-center rounded-lg border-0 bg-transparent transition-colors hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 lg:hidden"
            type="button"
            aria-label="Mở menu điều hướng"
            aria-controls="mobile-menu"
            aria-expanded="false"
          >
            <img
              src="{{ asset('landing/ghg-service/images/menu-bar.svg') }}"
              alt=""
              class="size-5 max-w-none"
              width="24"
              height="24"
            decoding="async" />
          </button>
          <a href="{{ route('home') }}" aria-label="Môi Trường Bảo Châu - Trang chủ">
            <img
              src="{{ asset('landing/ghg-service/images/Logo-160.webp') }}"
              alt="Môi Trường Bảo Châu"
              width="80"
              height="80"
              class="size-12 max-w-none object-contain md:size-20"
            decoding="async" loading="eager" fetchpriority="high" />
          </a>
        </div>

        <div class="shrink-0 lg:hidden">
          <a
            href="#form-register-login-features"
            class="flex min-h-11 flex-col items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 !px-3 !py-1.5 text-center text-[10px] leading-tight text-white shadow-sm transition-colors hover:from-blue-700 hover:to-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 sm:text-xs"
          >
            <strong>TƯ VẤN NGAY</strong>
            <span>HOÀN TOÀN MIỄN PHÍ</span>
          </a>
        </div>

        <div class="flex-auto hidden lg:block">
          <div
            class="py-2.5 !border-0 !border-b !border-solid border-[#C2C2C2]"
          >
            <div class="flex items-center justify-between">
              <!-- Contact Info -->
              <div class="flex items-center text-[#3A3A3A] text-xs xl:text-sm">
                <div class="flex items-center space-x-2">
                  <img
                    class="size-4"
                    width="16"
                    height="16"
                    src="{{ asset('landing/ghg-service/images/telephone.svg') }}"
                    alt=""
                  decoding="async" />
                  <span>
                    Hotline:
                    <a
                      href="tel:0915549148"
                      class="text-blue-500 font-semibold"
                      >0915.549.148</a
                    ></span
                  >
                </div>
                <hr
                  class="!border-0 h-3.5 !border-l !mx-4 border-solid border-[#C2C2C2]"
                />
                <div class="flex items-center space-x-2">
                  <img
                    class="size-4"
                    width="16"
                    height="16"
                    src="{{ asset('landing/ghg-service/images/email.svg') }}"
                    alt=""
                  decoding="async" />
                  <a href="mailto:info@baochauenvir.com" class="text-gray-700"
                    >Email: <strong>info@baochauenvir.com</strong></a
                  >
                </div>
              </div>

              <!-- Social Media Links -->
              <div
                class="flex items-center text-blue-500 text-xs xl:text-sm font-semibold"
              >
                <a
                  href="https://www.facebook.com/profile.php?id=100880909568347"
                  target="_blank"
                  class="flex items-center space-x-2"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/facebook.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-4 xl:size-6"
                  decoding="async" />
                  <span>Fanpage Bảo Châu</span>
                </a>
                <hr
                  class="!border-0 h-3.5 !border-l mx-2 xl:!mx-4 border-solid border-[#C2C2C2]"
                />
                <a
                  href="https://zalo.me/0915549148"
                  target="_blank"
                  class="flex items-center space-x-2"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/telephone.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-4 xl:size-6"
                  decoding="async" />
                  <span>Zalo: 0915.549.148</span>
                </a>
              </div>
            </div>
          </div>
          <div class="">
            <div
              class="flex flex-col xl:flex-row items-center justify-between text-sm font-semibold"
            >
              <!-- Navigation Menu -->
              <nav class="flex items-center space-x-4 xl:space-x-8">
                <a
                  href="#su-cap-thiet"
                  class="nav-item relative py-[22px] flex items-center space-x-2 text-[#3A3A3A] hover:text-[#273586] transition-colors"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/streaming.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                  decoding="async" />
                  <span>Sự cấp thiết</span>
                </a>
                <a
                  href="#loi-ich-che-tai"
                  class="nav-item relative py-[22px] flex items-center space-x-2 text-[#3A3A3A] hover:text-[#273586] transition-colors"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/benefit.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                  decoding="async" />
                  <span>Lợi ích & Chế tài</span>
                </a>
                <a
                  href="#don-vi-tu-van"
                  class="nav-item relative py-[22px] flex items-center space-x-2 text-[#3A3A3A] hover:text-[#273586] transition-colors"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/users.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                  decoding="async" />
                  <span>Đơn vị tư vấn</span>
                </a>
                <a
                  href="#quy-trinh-thuc-hien"
                  class="nav-item relative py-[22px] flex items-center space-x-2 text-[#3A3A3A] hover:text-[#273586] transition-colors"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/playlist.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                  decoding="async" />
                  <span>Quy trình thực hiện</span>
                </a>
                <a
                  href="#faqs"
                  class="nav-item relative py-[22px] flex items-center space-x-2 text-[#3A3A3A] hover:text-[#273586] transition-colors"
                >
                  <img
                    src="{{ asset('landing/ghg-service/images/chat.svg') }}"
                    alt=""
                    width="24"
                    height="24"
                    class="size-6"
                  decoding="async" />
                  <span>FAQs</span>
                </a>
              </nav>

              <!-- Auth Buttons / User Authentication -->
              <div class="hidden xl:flex items-center space-x-2">
                <a
                  class="text-[#3A3A3A] hover:text-[#273586] transition-colors px-6 !py-3 btn-app-login"
                  href="#form-register-login-features"
                 data-consultation-trigger="consultation">
                  Báo giá nhanh
                </a>
                <a
                  class="bg-blue-500 text-white px-6 !py-3 rounded transition-colors inline-block btn-app-register"
                  href="#form-register-login-features"
                 data-consultation-trigger="callback">
                  Liên hệ chuyên gia
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Auth Buttons -->
        <div class="hidden md:flex lg:hidden items-center space-x-2">
          <button
            class="text-[#3A3A3A] hover:text-[#273586] transition-colors px-6 py-3 btn-app-login"
           data-consultation-trigger="callback">
            Yêu cầu gọi lại
          </button>
          <button
            class="bg-blue-500 text-white px-6 !py-3 rounded transition-colors btn-app-register"
           data-consultation-trigger="consultation">
            Nhận tư vấn & Báo giá ngay
          </button>
        </div>
      </div>
    </header>

    <div
      id="mobile-menu"
      class="fixed inset-x-0 top-16 z-[1000] hidden max-h-[calc(100dvh-64px)] w-full overflow-y-auto border-t border-slate-200 bg-white shadow-xl md:inset-x-auto md:left-0 md:top-[88px] md:max-h-[calc(100dvh-88px)] md:w-[360px]"
    >
      <div
        class="flex flex-col gap-5 !px-4 !py-5"
      >
        <!-- Navigation Menu -->
        <nav class="grid gap-1">
          <a
            href="#su-cap-thiet"
            class="nav-item relative flex min-h-11 w-full items-center gap-3 rounded-lg !px-3 !py-2.5 text-sm font-medium text-[#3A3A3A] transition-colors hover:bg-blue-50 hover:text-[#273586]"
          >
            <img
              src="{{ asset('landing/ghg-service/images/streaming.svg') }}"
              alt=""
              width="24"
              height="24"
              class="size-5"
            decoding="async" />
            <span>Sự cấp thiết</span>
          </a>
          <a
            href="#loi-ich-che-tai"
            class="nav-item relative flex min-h-11 w-full items-center gap-3 rounded-lg !px-3 !py-2.5 text-sm font-medium text-[#3A3A3A] transition-colors hover:bg-blue-50 hover:text-[#273586]"
          >
            <img
              src="{{ asset('landing/ghg-service/images/benefit.svg') }}"
              alt=""
              width="24"
              height="24"
              class="size-5"
            decoding="async" />
            <span>Lợi ích & Chế tài</span>
          </a>
          <a
            href="#don-vi-tu-van"
            class="nav-item relative flex min-h-11 w-full items-center gap-3 rounded-lg !px-3 !py-2.5 text-sm font-medium text-[#3A3A3A] transition-colors hover:bg-blue-50 hover:text-[#273586]"
          >
            <img
              src="{{ asset('landing/ghg-service/images/users.svg') }}"
              alt=""
              width="24"
              height="24"
              class="size-5"
            decoding="async" />
            <span>Đơn vị tư vấn</span>
          </a>
          <a
            href="#quy-trinh-thuc-hien"
            class="nav-item relative flex min-h-11 w-full items-center gap-3 rounded-lg !px-3 !py-2.5 text-sm font-medium text-[#3A3A3A] transition-colors hover:bg-blue-50 hover:text-[#273586]"
          >
            <img
              src="{{ asset('landing/ghg-service/images/playlist.svg') }}"
              alt=""
              width="24"
              height="24"
              class="size-5"
            decoding="async" />
            <span>Quy trình thực hiện</span>
          </a>
          <a
            href="#faqs"
            class="nav-item relative flex min-h-11 w-full items-center gap-3 rounded-lg !px-3 !py-2.5 text-sm font-medium text-[#3A3A3A] transition-colors hover:bg-blue-50 hover:text-[#273586]"
          >
            <img
              src="{{ asset('landing/ghg-service/images/chat.svg') }}"
              alt=""
              width="24"
              height="24"
              class="size-5"
            decoding="async" />
            <span>FAQs</span>
          </a>
        </nav>

        <!-- Auth Buttons -->
        <div
          class="grid grid-cols-2 gap-3 border-t border-slate-200 !pt-4 md:hidden"
        >
          <button
            class="btn-app-login min-h-11 rounded-lg border border-blue-600 bg-white !px-3 !py-2.5 text-sm font-semibold text-blue-700 transition-colors hover:bg-blue-50"
           data-consultation-trigger="consultation">
            Báo giá nhanh
          </button>
          <button
            class="btn-app-register min-h-11 rounded-lg bg-blue-600 !px-3 !py-2.5 text-sm font-semibold text-white transition-colors hover:bg-blue-700"
           data-consultation-trigger="callback">
            Liên hệ chuyên gia
          </button>
        </div>

        <div class="border-t border-slate-200 !pt-4">
          <!-- Social Media Links -->
          <div
            class="grid grid-cols-1 gap-2 text-sm font-semibold text-blue-700 sm:grid-cols-3"
          >
            <a
              href="https://www.facebook.com/profile.php?id=100880909568347"
              target="_blank"
              class="flex min-h-10 items-center justify-center gap-2 rounded-lg !px-2 !py-2 transition-colors hover:bg-blue-50"
            >
              <img
                src="{{ asset('landing/ghg-service/images/facebook.svg') }}"
                alt=""
                width="24"
                height="24"
                class="size-4 xl:size-6"
              decoding="async" />
              <span>Fanpage Bảo Châu</span>
            </a>
            <hr
              class="hidden"
            />
            <a
              href="https://zalo.me/0915549148"
              target="_blank"
              class="flex min-h-10 items-center justify-center gap-2 rounded-lg !px-2 !py-2 transition-colors hover:bg-blue-50"
            >
              <img
                src="{{ asset('landing/ghg-service/images/telephone.svg') }}"
                alt=""
                width="24"
                height="24"
                class="size-4 xl:size-6"
              decoding="async" />
              <span>Zalo Tư Vấn</span>
            </a>
            <hr
              class="hidden"
            />
            <a
              href="https://moitruongbaochau.com"
              target="_blank"
              class="flex min-h-10 items-center justify-center gap-2 rounded-lg !px-2 !py-2 transition-colors hover:bg-blue-50"
            >
              <img
                src="{{ asset('landing/ghg-service/images/links.svg') }}"
                alt=""
                width="24"
                height="24"
                class="size-4 xl:size-6"
              decoding="async" />
              <span>Website Bảo Châu</span>
            </a>
          </div>

          <!-- Contact Info -->
          <div
            class="mt-3 grid gap-2 rounded-xl bg-slate-50 !p-3 text-sm text-[#3A3A3A]"
          >
            <div class="flex items-center justify-center gap-2">
              <img
                class="size-4"
                width="16"
                height="16"
                src="{{ asset('landing/ghg-service/images/telephone.svg') }}"
                alt=""
              decoding="async" />
              <span>
                Hotline:
                <a
                  href="tel:0915549148"
                  class="text-blue-500 font-semibold"
                  >0915.549.148</a
                ></span
              >
            </div>
            <hr
              class="hidden md:block !border-0 h-3.5 !border-l !mx-4 border-solid border-[#C2C2C2]"
            />
            <div class="flex items-center justify-center gap-2">
              <img
                class="size-4"
                width="16"
                height="16"
                src="{{ asset('landing/ghg-service/images/email.svg') }}"
                alt=""
              decoding="async" />
              <a href="mailto:info@baochauenvir.com" class="text-gray-700"
                >Email: <strong>info@baochauenvir.com</strong></a
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <main class="pt-16 md:pt-[88px] xl:pt-0">
      <!-- Hero Section -->
      <section
        class="relative sect-hero scroll-mt-24 bg-cover bg-center bg-no-repeat overflow-hidden xl:scroll-mt-28"
        id="su-cap-thiet"
      >
        <div
          class="relative z-10 !px-4 md:!px-0 xl:max-w-7xl 2xl:max-w-6xl mx-auto pt-8"
        >
          <nav aria-label="Đường dẫn trang" class="mb-4 text-sm text-white/90">
              <a class="underline" href="{{ route('home') }}">Trang chủ</a>
              <span aria-hidden="true"> / </span>
              <a class="underline" href="{{ route('services.index') }}">Dịch vụ môi trường</a>
              <span aria-hidden="true"> / </span>
              <span aria-current="page">Kiểm kê khí nhà kính</span>
            </nav>
          <div
            class="flex flex-col xl:flex-row justify-center gap-10 xl:gap-12 2xl:gap-[96px] items-start"
          >
            <!-- Left Content -->
            <div
              class="w-full mx-auto max-w-2xl xl:!mx-0 xl:max-w-none xl:w-[52.5%]"
            >
              <!-- ISO 14064-1 Badge -->
              <div
                class="flex text-lg md:text-2xl xl:text-[32px] xl:leading-[44px] w-fit items-center bg-white text-blue-500 pl-2 py-2 pr-8 gap-x-2.5 rounded-full font-semibold"
                data-x-aos="zoom-in"
              >
                <img
                  alt=""
                  class="size-8 xl:size-11"
                  data-x-aos="zoom-in"
                  height="44"
                  src="{{ asset('landing/ghg-service/images/rounded-arrow.svg') }}"
                  width="44"
                decoding="async" />
                <span> ISO 14064-1 & GHG </span>
              </div>
              <!-- Main Heading -->
              <div class="!mt-4">
                <h1
                  class="text-white text-3xl md:text-5xl xl:text-[51px] xl:leading-[68px] font-bold uppercase"
                  data-x-aos="fade-up"
                >
                  <span class="text-yellow-500">
                    Dịch vụ kiểm kê khí nhà kính cho doanh nghiệp
                  </span>
                </h1>
              </div>
              <!-- Description -->
              <p
                class="text-white text-lg md:text-xl leading-normal font-semibold mt-2"
                data-x-aos="fade-up"
              >
                Tư vấn, lập báo cáo kiểm kê khí nhà kính theo Nghị định 06/2022/NĐ-CP, được sửa đổi bởi Nghị định 119/2025/NĐ-CP và 83/2026/NĐ-CP. Rà soát nghĩa vụ theo danh mục mới tại Quyết định 42/2026/QĐ-TTg.
              </p>

              <p id="can-cu-phap-ly" class="text-white text-sm leading-relaxed mt-3" data-x-aos="fade-up">
                Cập nhật pháp lý ngày 10/10/2026:
                <a class="underline" href="https://vanban.chinhphu.vn/?classid=0&amp;docid=217277&amp;pageid=27160" target="_blank" rel="noopener noreferrer">Nghị định 83/2026/NĐ-CP</a> (hiệu lực 23/03/2026),
                <a class="underline" href="https://datafiles.chinhphu.vn/cpp/files/vbpq/2026/4/48-vbhn-bnnmt.pdf" target="_blank" rel="noopener noreferrer">quy định hợp nhất về kiểm kê khí nhà kính</a> và
                <a class="underline" href="https://vanban.chinhphu.vn/?classid=1&amp;docid=219154&amp;orggroupid=3&amp;pageid=27160" target="_blank" rel="noopener noreferrer">Quyết định 42/2026/QĐ-TTg</a> (hiệu lực 25/09/2026).
              </p>
              <!-- Feature Cards -->
              <div class="grid md:grid-cols-2 gap-4 mt-6">
                <!-- Card 1 -->
                <div
                  class="bg-white/20 backdrop-blur-[8px] rounded-xl p-4"
                  data-x-aos="zoom-in"
                >
                  <img
                    alt=""
                    class="size-10 mb-2"
                    data-x-aos="zoom-in"
                    height="40"
                    src="{{ asset('landing/ghg-service/images/benefit-2.svg') }}"
                    width="40"
                  decoding="async" />
                  <p
                    class="text-white text-base md:text-lg font-normal"
                    data-x-aos="fade-up"
                  >
                    Phương pháp kiểm kê chuẩn hóa giúp doanh nghiệp
                    <span class="text-yellow-500 font-semibold"
                      >nhận diện điểm nóng lãng phí năng lượng</span
                    >, tối ưu hóa chi phí vận hành và tăng năng lực cạnh tranh.
                  </p>
                </div>
                <!-- Card 2 -->
                <div
                  class="bg-white/20 backdrop-blur-[8px] rounded-xl p-4"
                  data-x-aos="zoom-in"
                >
                  <img
                    alt=""
                    class="size-10 mb-2"
                    data-x-aos="zoom-in"
                    height="40"
                    src="{{ asset('landing/ghg-service/images/target.svg') }}"
                    width="40"
                  decoding="async" />
                  <p
                    class="text-white text-base md:text-lg font-normal"
                    data-x-aos="fade-up"
                  >
                    Tuân thủ nghĩa vụ pháp luật,
                    <span class="text-yellow-500 font-semibold"
                      >chủ động lập và nộp báo cáo kiểm kê đúng quy định.</span
                    >
                    Tổ chức không lập báo cáo theo quy định có thể bị phạt 60–100 triệu đồng theo Điều 45 Nghị định 45/2022/NĐ-CP.
                  </p>
                </div>
              </div>
              <!-- Instructor Card -->
              <div
                class="md:gap-x-4 rounded-xl backdrop-blur-sm !px-4 !pt-4 md:!px-6 md:!pt-6 flex flex-col md:flex-row !mt-4 bg-cover bg-center"
                data-x-aos="zoom-in"
                style="
                  background-image:
                    url('{{ asset('landing/ghg-service/images/sect-hero-bg.webp') }}'),
                    linear-gradient(
                      90deg,
                      #0093cd 0%,
                      #233e8d 48.9%,
                      #273586 100%
                    );
                "
              >
                <img
                  alt="Môi Trường Bảo Châu"
                  class="w-[146px] h-[146px] object-contain self-center mb-4 md:mb-6"
                  data-x-aos="zoom-in"
                  height="146"
                  src="{{ asset('landing/ghg-service/images/sect-hero-2-292.webp') }}"
                  width="146"
                decoding="async" />
                <div class="pb-4 md:!pb-6 text-base md:text-lg">
                  <p class="text-white !mb-2" data-x-aos="fade-up">
                    ĐƠN VỊ TƯ VẤN CHUYÊN NGHIỆP:
                  </p>
                  <h2
                    class="font-medium text-yellow-500 !mb-2"
                    data-x-aos="fade-up"
                  >
                    Đơn vị hàng đầu<br />
                    <span class="text-lg md:text-2xl text-white">
                      MÔI TRƯỜNG BẢO CHÂU
                    </span>
                  </h2>
                  <p class="text-white" data-x-aos="fade-up">
                    <span class="text-yellow-500">
                      Hơn
                      <span class="text-lg md:text-xl"> 10+ </span> năm kinh nghiệm
                    </span>
                    tư vấn giải pháp môi trường, đo đạc phát thải, lập báo cáo kiểm kê khí nhà kính và hồ sơ pháp lý cho doanh nghiệp.
                  </p>
                </div>
              </div>
              <!-- Video Giới thiệu KKKNK -->
              <div
                class="relative rounded-xl overflow-hidden mt-8 shadow-lg"
                data-x-aos="zoom-in"
              >
                <video
                  class="w-full h-[414px] object-cover rounded-xl"
                  controls
                  muted
                  loop
                  playsinline
                  preload="none"
                  poster="{{ asset('landing/ghg-service/images/sect-hero-1.webp') }}"
                >
                  <source src="{{ asset('landing/ghg-service/kkknk-intro-4k.mp4') }}" type="video/mp4" />
                  Trình duyệt của bạn không hỗ trợ phát video.
                </video>
              </div>
            </div>
            <!-- Right Content - Registration Form -->
            <div
              class="space-y-6 w-full pb-10 max-w-xl mx-auto xl:!mx-0 xl:max-w-none xl:w-[40.65%]"
            >
              <!-- Header -->
              <div class="text-center">
                <h2
                  class="text-white text-[15px] md:text-[20px] font-semibold md:leading-[28px] mb-1"
                  data-x-aos="fade-up"
                >
                  ĐĂNG KÝ NHẬN BÁO GIÁ & TƯ VẤN KIỂM KÊ KNK<br />
                  BỞI CÁC CHUYÊN GIA MÔI TRƯỜNG BẢO CHÂU
                </h2>
                <p
                  class="text-white text-base md:text-lg font-semibold"
                  data-x-aos="fade-up"
                >
                  Tư vấn miễn phí - Quy trình bài bản - Hỗ trợ toàn quốc!
                </p>
              </div>
              <!-- Form Card -->
              <style>
                .form-control.is-invalid {
                  border-color: #dc3545;
                }
                .invalid-feedback {
                  display: block;
                  color: #dc3545;
                  font-size: 0.875em;
                  margin-top: 0.25rem;
                }
                .text-muted {
                  font-size: 0.8em;
                  color: #6c757d !important;
                }
              </style>

              <div
                class="bg-white shadow-md rounded-2xl form-register-login"
                data-x-aos="zoom-in"
              >
                <!-- Benefits -->
                <div
                  class="!p-2 md:!p-4 flex items-center space-x-3 !border-0 !border-b border-solid border-grey-100"
                >
                  <img
                    alt="Môi Trường Bảo Châu"
                    class="w-10 h-10 md:w-20 md:h-20 object-contain form-logo"
                    data-x-aos="zoom-in"
                    height="80"
                    src="{{ asset('landing/ghg-service/images/Logo-160.webp') }}"
                    width="80"
                  decoding="async" loading="lazy" />
                  <p
                    class="text-base md:text-xl leading-normal text-blue-500 font-semibold heading-text"
                    data-x-aos="fade-up"
                  >
                    Để lại thông tin dưới đây để nhận ngay tư vấn và tài liệu hướng dẫn kiểm kê khí nhà kính miễn phí!
                  </p>
                </div>
                <!-- Feature Icons -->
                <div
                  id="form-register-login-features"
                  class="flex items-center text-xs md:text-sm text-neutral-black font-semibold lst-benefit"
                >
                  <div
                    class="text-center flex-auto basis-44 md:min-w-40 !p-2 md:!py-3 md:!px-4"
                  >
                    <img
                      alt=""
                      class="size-6 mx-auto mb-2 form-icon"
                      data-x-aos="zoom-in"
                      height="24"
                      src="{{ asset('landing/ghg-service/images/blocked.svg') }}"
                      width="24"
                    decoding="async" />
                    <p class="" data-x-aos="fade-up">TƯ VẤN<br />MIỄN PHÍ</p>
                  </div>
                  <hr
                    class="h-8 !border-0 !border-l border-solid border-grey-100"
                  />
                  <div
                    class="text-center flex-auto basis-44 md:min-w-40 !p-2 md:!py-3 md:!px-4"
                  >
                    <img
                      alt=""
                      class="size-6 mx-auto mb-2 form-icon"
                      data-x-aos="zoom-in"
                      height="24"
                      src="{{ asset('landing/ghg-service/images/infinity.svg') }}"
                      width="24"
                    decoding="async" />
                    <p class="" data-x-aos="fade-up">
                      CHUẨN HÓA<br />ISO 14064
                    </p>
                  </div>
                  <hr
                    class="h-8 !border-0 !border-l border-solid border-grey-100"
                  />
                  <div
                    class="text-center flex-auto basis-44 md:min-w-40 !p-2 md:!py-3 md:!px-4"
                  >
                    <img
                      alt=""
                      class="size-6 mx-auto mb-2 form-icon"
                      data-x-aos="zoom-in"
                      height="24"
                      src="{{ asset('landing/ghg-service/images/no-spam.svg') }}"
                      width="24"
                    decoding="async" />
                    <p class="" data-x-aos="fade-up">
                      BẢO MẬT <br />
                      THÔNG TIN
                    </p>
                  </div>
                </div>

                <!-- Google Login Button -->

                <!-- form -->
                <div
                  id="form-register-login-form_2ae8a491e2"
                  class="!p-2 md:!p-4"
                >
                  <div
                    class="rounded-xl bg-[#273586] !p-1.5 !mt-3"
                    data-consultation-tabs
                    data-x-aos="zoom-in"
                  >
                    <!-- Divider -->
                    <div
                      class="grid w-full grid-cols-2 gap-1 text-sm font-semibold leading-[26px] md:text-base"
                      role="tablist"
                      aria-label="Chọn hình thức tư vấn"
                    >
                      <button
                        class="consultation-tab flex min-h-11 w-full items-center justify-center rounded-lg border-0 bg-white !px-3 !py-2.5 text-blue-600 shadow-sm transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#273586]"
                        type="button"
                        data-action="register"
                        data-form-id="form_2ae8a491e2"
                        id="register-tab-form_2ae8a491e2"
                        role="tab"
                        aria-controls="register-section-form_2ae8a491e2"
                        aria-selected="true"
                      >
                        <span class="">Đăng ký tư vấn</span>
                      </button>
                      <button
                        class="consultation-tab flex min-h-11 w-full items-center justify-center rounded-lg border-0 bg-transparent !px-3 !py-2.5 text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#273586]"
                        type="button"
                        data-action="login"
                        data-form-id="form_2ae8a491e2"
                        id="login-tab-form_2ae8a491e2"
                        role="tab"
                        aria-controls="login-section-form_2ae8a491e2"
                        aria-selected="false"
                      >
                        <span class="">Yêu cầu gọi lại</span>
                      </button>
                    </div>
                    <div
                      class="rounded-xl bg-white !p-3"
                      data-x-aos="zoom-in"
                    >
<!-- Consultation form -->
                      <div
                        class="consultation-panel"
                        id="register-section-form_2ae8a491e2"
                        role="tabpanel"
                        aria-labelledby="register-tab-form_2ae8a491e2"
                      >
                        <p
                          class="text-sm text-neutral-black"
                          data-x-aos="fade-up"
                        >
                          Chỉ 1 bước đơn giản.
                          <span class="text-blue-500 font-semibold"
                            >Đăng ký nhận báo giá chi tiết!</span
                          >
                        </p>

                        @include('frontend.landing.ghg-service.form', ['formId' => 'inline-consultation', 'consultationType' => 'consultation'])
                      </div>

                      <!-- Login Form -->
                      <div
                        class="consultation-panel hidden"
                        id="login-section-form_2ae8a491e2"
                        role="tabpanel"
                        aria-labelledby="login-tab-form_2ae8a491e2"
                      >
                        <p
                          class="text-sm text-neutral-black"
                          data-x-aos="fade-up"
                        >
                          Yêu cầu chuyên gia liên hệ lại.
                          <span class="text-blue-500 font-semibold"
                            >Chúng tôi sẽ gọi lại ngay!</span
                          >
                        </p>

                        @include('frontend.landing.ghg-service.form', ['formId' => 'inline-callback', 'consultationType' => 'callback'])
                      </div>
                    </div>
                  </div>
                  <!-- Bottom Text -->
                  <div
                    class="text-xs md:text-sm text-center text-neutral-black space-y-2 mt-4"
                  >
                    <p data-x-aos="fade-up">
                      Môi Trường Bảo Châu đồng hành cùng doanh nghiệp phát triển bền vững.
                    </p>
                    <div
                      class="mx-5 !border-0 !border-t border-solid border-grey-100 h-px"
                    ></div>
                    <p data-x-aos="fade-up">
                      Giải pháp kiểm kê khí nhà kính của Bảo Châu
                      <strong class="text-blue-500 font-semibold"
                        >giúp doanh nghiệp tuân thủ pháp luật,</strong
                      ><br /><strong
                        class="text-blue-500 font-semibold"
                        >chuẩn bị dữ liệu phát thải và phát triển lâu dài.</strong
                      >
                    </p>
                  </div>
                </div>
                <!-- end form -->

            </div>
          </div>
        </div>
      </section>
      <section
        class="bg-cover sect-guideline scroll-mt-24 bg-center -mt-[120px] relative z-[1] xl:scroll-mt-28"
        id="loi-ich-che-tai"
      >
        <div
          class="ghg-benefits-container xl:max-w-7xl 2xl:max-w-6xl mx-auto pt-32 pb-14 md:py-36 lg:py-40 xl:py-52 2xl:!pt-[362px] 2xl:!pb-[196px]"
        >
          <!-- Header -->
          <div
            class="text-center text-lg md:text-3xl xl:text-[40px] xl:leading-[1.3] font-semibold text-neutral-black mb-8"
          >
            <h2 class="mb-1" data-x-aos="fade-up">
              DỊCH VỤ KIỂM KÊ KHÍ NHÀ KÍNH<br />
              TẤM VÉ VÀNG CHO DOANH NGHIỆP
            </h2>
            <div class="inline-block bg-yellow-500 !px-4 !py-2 rounded-lg">
              HỖ TRỢ DOANH NGHIỆP NHỮNG GÌ?
            </div>
          </div>
          <div
            class="ghg-benefits-layout"
          >
            <!-- Left Column - Guidelines List -->
            <div class="ghg-benefits-list">
              <!-- Guideline 01 -->
              <div class="flex !gap-3 items-start">
                <div class="flex-shrink-0">
                  <div
                    class="min-w-12 md:min-w-20 xl:min-w-0 text-red-500 text-3xl md:text-5xl xl:text-6xl font-bold"
                  >
                    01.
                  </div>
                </div>
                <div>
                  <h3
                    class="font-semibold text-lg md:text-xl xl:text-2xl text-neutral-black mb-1"
                    data-x-aos="fade-up"
                  >
                    TUÂN THỦ QUY ĐỊNH HIỆN HÀNH
                  </h3>
                  <p
                    class="font-normal text-neutral-black text-sm md:text-lg"
                    data-x-aos="fade-up"
                  >
                    Rà soát nghĩa vụ, lập báo cáo đúng hướng dẫn kỹ thuật và xác định thời hạn, nơi tiếp nhận phù hợp với từng cơ sở.
                  </p>
                </div>
              </div>
              <!-- Guideline 02 -->
              <div class="flex !gap-3 items-start">
                <div class="flex-shrink-0">
                  <div
                    class="min-w-12 md:min-w-20 xl:min-w-0 text-red-500 text-3xl md:text-5xl xl:text-6xl font-bold"
                  >
                    02.
                  </div>
                </div>
                <div>
                  <h3
                    class="font-semibold text-lg md:text-xl xl:text-2xl text-neutral-black mb-1"
                    data-x-aos="fade-up"
                  >
                    CHUẨN HÓA DỮ LIỆU QUỐC TẾ
                  </h3>
                  <p
                    class="font-normal text-neutral-black text-sm md:text-lg"
                    data-x-aos="fade-up"
                  >
                    Chuẩn hóa dữ liệu theo ISO 14064-1, GHG Protocol khi cần; báo cáo trong nước tuân theo biểu mẫu và hướng dẫn áp dụng.
                  </p>
                </div>
              </div>
              <!-- Guideline 03 -->
              <div class="flex !gap-3 items-start">
                <div class="flex-shrink-0">
                  <div
                    class="min-w-12 md:min-w-20 xl:min-w-0 text-red-500 text-3xl md:text-5xl xl:text-6xl font-bold"
                  >
                    03.
                  </div>
                </div>
                <div>
                  <h3
                    class="font-semibold text-lg md:text-xl xl:text-2xl text-neutral-black mb-1"
                    data-x-aos="fade-up"
                  >
                    HỖ TRỢ YÊU CẦU XUẤT KHẨU
                  </h3>
                  <p
                    class="font-normal text-neutral-black text-sm md:text-lg"
                    data-x-aos="fade-up"
                  >
                    Tổng hợp dữ liệu, tính toán phát thải theo sản phẩm để đáp ứng yêu cầu của khách hàng và thị trường xuất khẩu.
                  </p>
                </div>
              </div>
              <!-- Guideline 04 -->
              <div class="flex !gap-3 items-start">
                <div class="flex-shrink-0">
                  <div
                    class="min-w-12 md:min-w-20 xl:min-w-0 text-red-500 text-3xl md:text-5xl xl:text-6xl font-bold"
                  >
                    04.
                  </div>
                </div>
                <div>
                  <h3
                    class="font-semibold text-lg md:text-xl xl:text-2xl text-neutral-black mb-1"
                    data-x-aos="fade-up"
                  >
                    TIẾT KIỆM NĂNG LƯỢNG, CHI PHÍ
                  </h3>
                  <p
                    class="font-normal text-neutral-black text-sm md:text-lg"
                    data-x-aos="fade-up"
                  >
                    Xác định nguồn tiêu thụ năng lượng lớn, đề xuất cải tiến vận hành để giảm phát thải và tiết kiệm chi phí.
                  </p>
                </div>
              </div>
              <!-- Guideline 05 -->
              <div class="flex !gap-3 items-start">
                <div class="flex-shrink-0">
                  <div
                    class="min-w-12 md:min-w-20 xl:min-w-0 text-red-500 text-3xl md:text-5xl xl:text-6xl font-bold"
                  >
                    05.
                  </div>
                </div>
                <div>
                  <h3
                    class="font-semibold text-lg md:text-xl xl:text-2xl text-neutral-black mb-1"
                    data-x-aos="fade-up"
                  >
                    XÂY DỰNG LỘ TRÌNH GIẢM PHÁT THẢI
                  </h3>
                  <p
                    class="font-normal text-neutral-black text-sm md:text-lg"
                    data-x-aos="fade-up"
                  >
                    Cung cấp dữ liệu cho báo cáo ESG, xác định mục tiêu và lộ trình giảm phát thải phù hợp với doanh nghiệp.
                  </p>
                </div>
              </div>
            </div>
            <!-- Right Column - Images -->
            <div
              class="ghg-benefits-media"
            >
              <img
                alt="Chuyên gia môi trường tư vấn giảm phát thải và tối ưu năng lượng cho nhà máy"
                class="ghg-benefits-image rounded-2xl shadow-lg"
                data-x-aos="zoom-in"
                height="534"
                src="{{ asset('landing/ghg-service/images/bao-chau-business-benefits.webp') }}"
                width="712"
              decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-business-benefits-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-business-benefits-768.webp') }} 768w, {{ asset('landing/ghg-service/images/bao-chau-business-benefits.webp') }} 1448w" sizes="(min-width: 1280px) 50vw, 100vw" />
            </div>
          </div>
        </div>
      </section>
      <section
        class="sect-benefit-3 bg-cover bg-top rounded-b-3xl md:rounded-b-[36px] lg:rounded-b-[56px] xl:rounded-b-[80px] pb-11 md:pb-14 lg:pb-20 xl:pb-[120px] pt-16 overflow-hidden"
      >
        <div class="!px-4 md:!px-0 xl:max-w-7xl 2xl:max-w-6xl mx-auto">
          <!-- Header -->
          <div
            class="font-semibold uppercase text-center text-lg md:text-3xl xl:text-[40px] xl:leading-[1.3] mb-8"
          >
            <h2 class="text-white mb-2" data-x-aos="fade-up">
              PHẠM VI KIỂM KÊ KHÍ NHÀ KÍNH TIÊU CHUẨN
            </h2>
            <div
              class="inline-block bg-yellow-500 text-neutral-black !px-4 !py-2 rounded-lg"
            >
              (PHÂN LOẠI THEO SCOPES PHÁT THẢI)
            </div>
          </div>
          <!-- Three Cards -->
          <div
            class="grid grid-cols-1 gap-6 text-left md:grid-cols-2 md:!px-4 xl:grid-cols-3 2xl:!px-0 mb-6"
          >
            <!-- Scope 1 Card -->
            <div
              class="flex h-full flex-col overflow-hidden rounded-md border-t-4 border-red-500 bg-white !p-4 card-shadow md:rounded-xl lg:rounded-2xl"
              data-x-aos="zoom-in"
            >
              <img
                alt="Minh họa Scope 1: phát thải trực tiếp từ nguồn doanh nghiệp sở hữu hoặc kiểm soát"
                class="aspect-[4/3] w-full rounded-md object-cover !mb-4"
                data-x-aos="zoom-in"
                height="314px"
                src="{{ asset('landing/ghg-service/images/bao-chau-scope-1.webp') }}"
                width="418px"
              decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-1-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-1.webp') }} 1402w" sizes="(min-width: 1024px) 33vw, 100vw" />
              <h3
                class="font-semibold text-red-500 text-lg md:text-xl xl:text-2xl mb-2"
                data-x-aos="fade-up"
              >
                Scope 1: Phát thải trực tiếp
              </h3>
              <p
                class="text-sm md:text-base leading-relaxed text-neutral-black font-normal"
                data-x-aos="fade-up"
              >
                <span class="font-semibold">
                  Phát thải từ các nguồn thuộc sở hữu hoặc kiểm soát trực tiếp
                </span>
                của doanh nghiệp như đốt nhiên liệu tại lò hơi, lò nung, các phương tiện vận chuyển nội bộ và rò rỉ gas hệ thống làm lạnh.
              </p>
            </div>
            <!-- Scope 2 Card -->
            <div
              class="flex h-full flex-col overflow-hidden rounded-md border-t-4 border-yellow-500 bg-white !p-4 card-shadow md:rounded-xl lg:rounded-2xl"
              data-x-aos="zoom-in"
            >
              <img
                alt="Minh họa Scope 2: phát thải gián tiếp từ điện và năng lượng mua ngoài"
                class="aspect-[4/3] w-full rounded-md object-cover !mb-4"
                data-x-aos="zoom-in"
                height="314px"
                src="{{ asset('landing/ghg-service/images/bao-chau-scope-2.webp') }}"
                width="418px"
              decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-2-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-2.webp') }} 1402w" sizes="(min-width: 1024px) 33vw, 100vw" />
              <h3
                class="font-semibold text-yellow-600 text-lg md:text-xl xl:text-2xl mb-2"
                data-x-aos="fade-up"
              >
                Scope 2: Phát thải gián tiếp
              </h3>
              <p
                class="text-sm md:text-base leading-relaxed text-neutral-black font-normal"
                data-x-aos="fade-up"
              >
                <span class="font-semibold">
                  Phát thải từ việc tiêu dùng điện năng mua ngoài,
                </span>
                hơi nước, nhiệt lượng hoặc năng lượng làm lạnh được cung cấp bởi bên thứ ba phục vụ hoạt động sản xuất kinh doanh của nhà máy.
              </p>
            </div>
            <!-- Scope 3 Card -->
            <div
              class="flex h-full flex-col overflow-hidden rounded-md border-t-4 border-green-600 bg-white !p-4 card-shadow md:col-span-2 md:w-[calc(50%-12px)] md:justify-self-center md:rounded-xl lg:rounded-2xl xl:col-span-1 xl:w-full"
              data-x-aos="zoom-in"
            >
              <img
                alt="Minh họa Scope 3: phát thải gián tiếp trong toàn bộ chuỗi giá trị"
                class="aspect-[4/3] w-full rounded-md object-cover !mb-4"
                data-x-aos="zoom-in"
                height="314px"
                src="{{ asset('landing/ghg-service/images/bao-chau-scope-3.webp') }}"
                width="418px"
              decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-3-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-3.webp') }} 1448w" sizes="(min-width: 1024px) 33vw, 100vw" />
              <h3
                class="font-semibold text-green-600 text-lg md:text-xl xl:text-2xl mb-2"
                data-x-aos="fade-up"
              >
                Scope 3: Phát thải chuỗi cung ứng
              </h3>
              <p
                class="text-sm md:text-base leading-relaxed text-neutral-black font-normal"
                data-x-aos="fade-up"
              >
                <span class="font-semibold">
                  Phát thải gián tiếp khác phát sinh
                </span>
                từ các nguồn không do doanh nghiệp kiểm soát nhưng nằm trong chuỗi cung ứng (logistics đầu vào/ra, xử lý chất thải, hoạt động đi lại của nhân viên...).
              </p>
            </div>
          </div>
          <!-- Business Cooperation Banner -->
          <div
            class="sect-card !mx-4 2xl:!mx-0 bg-center bg-cover rounded md:rounded-md lg:rounded-2xl overflow-hidden"
          >
            <div class="hidden grid-cols-1 items-center gap-6 !p-4 md:!p-6 lg:grid-cols-[1.1fr_1fr] lg:gap-8 lg:!p-8">
              <div class="grid grid-cols-1 gap-3 sm:grid-cols-3" data-x-aos="zoom-in">
                <figure class="group relative aspect-[4/3] overflow-hidden rounded-xl border-2 border-white/70 shadow-lg">
                  <img
                    alt="Scope 1 - Phát thải trực tiếp"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none"
                    src="{{ asset('landing/ghg-service/images/bao-chau-scope-1.webp') }}"
                  width="1402" height="1122" decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-1-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-1.webp') }} 1402w" sizes="(min-width: 1024px) 33vw, 100vw" />
                  <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-red-950/95 to-red-700/70 !px-3 !py-2 text-center text-sm font-extrabold text-white md:text-base">
                    SCOPE 1
                  </figcaption>
                </figure>
                <figure class="group relative aspect-[4/3] overflow-hidden rounded-xl border-2 border-white/70 shadow-lg">
                  <img
                    alt="Scope 2 - Phát thải từ năng lượng mua ngoài"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none"
                    src="{{ asset('landing/ghg-service/images/bao-chau-scope-2.webp') }}"
                  width="1402" height="1122" decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-2-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-2.webp') }} 1402w" sizes="(min-width: 1024px) 33vw, 100vw" />
                  <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-amber-950/95 to-amber-600/70 !px-3 !py-2 text-center text-sm font-extrabold text-white md:text-base">
                    SCOPE 2
                  </figcaption>
                </figure>
                <figure class="group relative aspect-[4/3] overflow-hidden rounded-xl border-2 border-white/70 shadow-lg">
                  <img
                    alt="Scope 3 - Phát thải trong chuỗi giá trị"
                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 motion-reduce:transition-none"
                    src="{{ asset('landing/ghg-service/images/bao-chau-scope-3.webp') }}"
                  width="1448" height="1086" decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-scope-3-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-scope-3.webp') }} 1448w" sizes="(min-width: 1024px) 33vw, 100vw" />
                  <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-green-950/95 to-green-600/70 !px-3 !py-2 text-center text-sm font-extrabold text-white md:text-base">
                    SCOPE 3
                  </figcaption>
                </figure>
              </div>

              <div class="text-white" data-x-aos="fade-up">
                <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-yellow-300 md:text-sm">
                  Tổng quan phạm vi phát thải
                </p>
                <h3 class="mb-4 text-2xl font-extrabold uppercase leading-tight md:text-3xl xl:text-4xl">
                  3 loại Scope trong kiểm kê khí nhà kính
                </h3>
                <div class="space-y-3 text-sm leading-relaxed md:text-base">
                  <div class="rounded-xl border border-white/30 bg-white/10 !p-3 backdrop-blur-sm">
                    <span class="font-extrabold text-red-200">Scope 1:</span>
                    Phát thải trực tiếp từ nguồn doanh nghiệp sở hữu hoặc kiểm soát.
                  </div>
                  <div class="rounded-xl border border-white/30 bg-white/10 !p-3 backdrop-blur-sm">
                    <span class="font-extrabold text-yellow-200">Scope 2:</span>
                    Phát thải gián tiếp từ điện, hơi, nhiệt hoặc năng lượng mua ngoài.
                  </div>
                  <div class="rounded-xl border border-white/30 bg-white/10 !p-3 backdrop-blur-sm">
                    <span class="font-extrabold text-green-200">Scope 3:</span>
                    Phát thải gián tiếp khác trong toàn bộ chuỗi giá trị của doanh nghiệp.
                  </div>
                </div>
              </div>
            </div>
            <div
              class="flex flex-col-reverse items-center gap-5 !p-4 md:flex-row md:gap-7 md:!p-6 lg:gap-10 lg:!p-8"
            >
              <!-- Left side with image -->
              <div
                class="w-full shrink-0 self-stretch overflow-hidden rounded-xl bg-white shadow-lg md:w-2/5 lg:w-80 xl:w-[420px]"
              >
                <img
                  alt="Chuyên gia môi trường thực hiện kiểm kê khí nhà kính tại nhà máy"
                  class="h-full w-full object-cover object-center"
                  data-x-aos="zoom-in"
                  height="420"
                  src="{{ asset('landing/ghg-service/images/bao-chau-ghg-inventory-banner.webp') }}"
                  width="560"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-ghg-inventory-banner-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-ghg-inventory-banner.webp') }} 1448w" sizes="(min-width: 1280px) 50vw, 100vw" />
              </div>
              <!-- Right side with content -->
              <div class="flex-auto text-center text-white md:text-left">
                <h3
                  class="text-xl font-extrabold leading-tight md:text-2xl lg:text-3xl xl:text-[32px] !mb-3 lg:!mb-4"
                  data-x-aos="fade-up"
                >
                  <div>ĐỐI TƯỢNG BẮT BUỘC THỰC HIỆN KIỂM KÊ</div>
                </h3>
                <p
                  class="text-sm font-normal leading-relaxed lg:text-base xl:text-lg"
                  data-x-aos="fade-up"
                >
                  <span class="font-semibold">
                    Theo Quyết định số 42/2026/QĐ-TTg, có hiệu lực từ 25/09/2026 và thay thế Quyết định 13/2024/QĐ-TTg,
                  </span>
                  cơ sở cần đối chiếu tên trong danh mục để xác định nghĩa vụ kiểm kê. Các ngưỡng <span class="font-semibold text-yellow-500">3.000 tấn CO2eq/năm</span> hoặc <span class="font-semibold text-yellow-500">1.000 TOE/năm</span> là tiêu chí rà soát theo loại hình, không thay thế việc kiểm tra danh mục hiện hành.
                </p>
                <div class="mt-4 rounded-xl border border-white/40 bg-black/20 !p-4 text-left backdrop-blur-sm" data-x-aos="fade-up">
                  <p class="text-xs md:text-sm text-yellow-400 font-semibold mb-1">
                    ⚠️ CHẾ TÀI ĐỐI VỚI TỔ CHỨC (Điều 6 và Điều 45 Nghị định 45/2022/NĐ-CP):
                  </p>
                  <ul class="list-disc pl-4 text-xs md:text-sm text-white space-y-1">
                    <li><strong>Phạt tiền từ 60.000.000đ - 100.000.000đ</strong> đối với hành vi không lập báo cáo kiểm kê KNK theo quy định.</li>
                    <li><strong>Phạt tiền từ 10.000.000đ - 20.000.000đ</strong> đối với hành vi cung cấp thông tin không đúng hoặc không đầy đủ.</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section
        class="sect-about scroll-mt-24 bg-cover bg-center !px-4 2xl:!px-0 pt-8 md:pt-12 xl:pt-16 2xl:pt-20 relative xl:scroll-mt-28"
        id="don-vi-tu-van"
      >
        <div class="2xl:px-0 xl:max-w-7xl 2xl:max-w-6xl mx-auto">
          <!-- Main Content -->
          <div class="grid grid-cols-1 items-start gap-8 xl:grid-cols-2 xl:gap-10">
            <!-- Left Side - Image -->
            <div
              class="relative flex justify-center items-start !order-1 xl:!order-none"
            >
              <!-- Profile Image -->
              <img
                alt="Môi Trường Bảo Châu"
                class="h-auto w-full max-w-[480px] rounded-2xl object-contain object-top shadow-lg xl:max-w-[520px]"
                data-x-aos="zoom-in"
                height="1536"
                src="{{ asset('landing/ghg-service/images/bao-chau-about-portrait.webp') }}"
                width="1024"
              decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-about-portrait-640.webp') }} 427w, {{ asset('landing/ghg-service/images/bao-chau-about-portrait.webp') }} 966w" sizes="(min-width: 1280px) 50vw, 100vw" />
            </div>
            <!-- Right Side - Content -->
            <div class="xl:pb-16 2xl:pb-20">
              <!-- Header -->
              <div
                class="sect-about-2 inline-block mb-8 bg-yellow-500 px-6 !py-2 rounded-lg bg-center"
              >
                <h2
                  class="text-center text-lg md:text-3xl xl:text-[40px] xl:leading-[1.3] uppercase font-bold text-black"
                  data-x-aos="fade-up"
                >
                  MÔI TRƯỜNG BẢO CHÂU LÀ AI?
                </h2>
              </div>
              <!-- Credentials -->
              <div class="space-y-4 mt-0 text-sm md:text-lg font-normal mb-6">
                <div class="flex items-start space-x-2">
                  <div class="pt-1.5 flex-shrink-0">
                    <img
                      alt=""
                      class="size-4 object-cover"
                      data-x-aos="zoom-in"
                      height="16"
                      src="{{ asset('landing/ghg-service/images/gem.svg') }}"
                      width="16"
                    decoding="async" />
                  </div>
                  <div>
                    <h3
                      class="font-semibold text-red-500 uppercase mb-1"
                      data-x-aos="fade-up"
                    >
                      ĐỐI TÁC TIN CẬY CỦA HÀNG TRĂM DOANH NGHIỆP
                    </h3>
                    <p class="text-neutral-black" data-x-aos="fade-up">
                      Môi Trường Bảo Châu là đối tác tư vấn môi trường quen thuộc của các tập đoàn, tổng công ty và nhà máy FDI tại Việt Nam, liên tục đồng hành cùng doanh nghiệp đạt được chứng nhận xanh và giảm thiểu rủi ro pháp lý.
                    </p>
                  </div>
                </div>
                <div class="flex items-start space-x-2">
                  <div class="pt-1.5 flex-shrink-0">
                    <img
                      alt=""
                      class="size-4 object-cover"
                      data-x-aos="zoom-in"
                      height="16"
                      src="{{ asset('landing/ghg-service/images/gem.svg') }}"
                      width="16"
                    decoding="async" />
                  </div>
                  <div>
                    <h3
                      class="font-semibold text-red-500 uppercase mb-1"
                      data-x-aos="fade-up"
                    >
                      HỆ THỐNG PHÒNG THỬ NGHIỆM ĐẠT CHUẨN QUỐC GIA
                    </h3>
                    <p
                      class="text-gray-700 leading-relaxed"
                      data-x-aos="fade-up"
                    >
                      Phối hợp với phòng thử nghiệm có chứng nhận đủ điều kiện hoạt động dịch vụ quan trắc môi trường (VIMCERTS) trong phạm vi phù hợp khi cần đo đạc, lấy mẫu phục vụ kiểm kê. Báo cáo được lập theo hướng dẫn kỹ thuật của lĩnh vực áp dụng.
                    </p>
                  </div>
                </div>
              </div>
              <!-- Stats Card -->
              <div
                class="sect-status bg-blue-500 text-white !p-4 rounded-lg bg-cover bg-center"
              >
                <div class="!mb-4">
                  <h3
                    class="text-lg text-yellow-500 font-medium"
                    data-x-aos="fade-up"
                  >
                    Tư vấn Môi trường
                  </h3>
                  <h2 class="text-2xl font-semibold" data-x-aos="fade-up">
                    MÔI TRƯỜNG BẢO CHÂU
                  </h2>
                </div>
                <div class="space-y-4 text-sm md:text-lg font-normal">
                  <div class="flex items-center space-x-3">
                    <div class="pt-[26px] flex-shrink-0">
                      <img
                        alt=""
                        class="size-4 object-cover"
                        data-x-aos="zoom-in"
                        height="16"
                        src="{{ asset('landing/ghg-service/images/gem.svg') }}"
                        width="16"
                      decoding="async" />
                    </div>
                    <span>
                      <span class="text-yellow-500">
                        Hơn
                        <span class="font-bold text-xl md:text-5xl">10+</span>
                        năm kinh nghiệm
                      </span>
                      trong lĩnh vực tư vấn giải pháp môi trường, đo đạc nguồn thải và kiểm kê khí nhà kính cho doanh nghiệp toàn quốc.
                    </span>
                  </div>
                  <div class="flex items-center space-x-3">
                    <div class="pt-[26px] flex-shrink-0">
                      <img
                        alt=""
                        class="size-4 object-cover"
                        data-x-aos="zoom-in"
                        height="16"
                        src="{{ asset('landing/ghg-service/images/gem.svg') }}"
                        width="16"
                      decoding="async" />
                    </div>
                    <span>
                      <span class="text-yellow-500">
                        Đã tư vấn hỗ trợ hơn
                        <span class="font-bold text-xl md:text-5xl"
                          >500+</span
                        >
                        doanh nghiệp
                      </span>
                      giúp họ hoàn thiện hồ sơ môi trường, báo cáo kiểm kê khí nhà kính và đáp ứng các rào cản xuất khẩu khó tính.
                    </span>
                  </div>
                  <div class="flex items-center space-x-3">
                    <div class="pt-[26px] flex-shrink-0">
                      <img
                        alt=""
                        class="size-4 object-cover"
                        data-x-aos="zoom-in"
                        height="16"
                        src="{{ asset('landing/ghg-service/images/gem.svg') }}"
                        width="16"
                      decoding="async" />
                    </div>
                    <span>
                      <span class="text-yellow-500">
                        Đồng hành thực hiện dự án cho hơn
                        <span class="font-bold text-xl md:text-5xl">15+</span>
                        nhóm ngành nghề
                      </span>
                      chủ đạo bao gồm: Dệt may, da giày, bao bì, sắt thép, xi măng, cơ khí chế tạo, chế biến thực phẩm, chăn nuôi...
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="sect-status-2 absolute left-0 -bottom-1 bg-top bg-cover w-full h-[112px]"
        ></div>
      </section>
      <section
        class="sect-archivement bg-cover bg-center !px-4 2xl:!px-0 pt-9 md:pt-16 lg:pt-22 pb-60 2xl:pt-[120px] 2xl:pb-[282px] relative"
      >
        <div class="xl:max-w-7xl 2xl:max-w-6xl mx-auto">
          <h2
            class="relative text-xl md:text-2xl lg:text-[32px] lg:leading-[44px] font-bold text-yellow-500 text-center mb-8"
            data-x-aos="fade-up"
          >
            <span> Các Dự án & Năng lực Tư vấn Nổi bật </span>
            <svg
              class="w-full"
              fill="none"
              height="16"
              viewBox="0 0 796 16"
              width="796"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M1 14C208.952 7.72626 658.886 -2.93911 795 4.58938"
                stroke="#FFCB08"
                stroke-width="3"
              ></path>
            </svg>
          </h2>
          <div
            class="text-sm md:text-base lg:text-lg font-semibold uppercase text-white text-center"
          >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center mb-8">
              <div>
                <img
                  alt="Giấy phép môi trường - Công ty TNHH Samduk Việt Nam"
                  class="w-full aspect-[68/51] 2xl:aspect-auto 2xl:h-[513px] object-cover !mb-4"
                  data-x-aos="zoom-in"
                  height="1717"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-01.webp') }}"
                  width="2048"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-project-01-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-project-01.webp') }} 1448w" sizes="(min-width: 1280px) 50vw, 100vw" />
                <p data-x-aos="fade-up">
                  GIẤY PHÉP MÔI TRƯỜNG - CÔNG TY TNHH SAMDUK VIỆT NAM
                </p>
              </div>
              <div>
                <img
                  alt="Phân loại lao động tại Công ty Cổ phần Greenfeed Việt Nam"
                  class="w-full aspect-[68/51] 2xl:aspect-auto 2xl:h-[513px] object-cover !mb-4"
                  data-x-aos="zoom-in"
                  height="1536"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-02.webp') }}"
                  width="2048"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-project-02-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-project-02.webp') }} 1448w" sizes="(min-width: 1280px) 50vw, 100vw" />
                <p data-x-aos="fade-up">
                  PHÂN LOẠI LAO ĐỘNG TẠI CÔNG TY CỔ PHẦN GREENFEED VIỆT NAM
                </p>
              </div>
              <div>
                <img
                  alt="Nhà máy Hongik Vina"
                  class="w-full aspect-[68/51] 2xl:aspect-auto 2xl:h-[513px] object-cover !mb-4"
                  data-x-aos="zoom-in"
                  height="289"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-03.webp') }}"
                  width="396"
                decoding="async" loading="lazy" />
                <p data-x-aos="fade-up">
                  NHÀ MÁY HONGIK VINA
                </p>
              </div>
              <div>
                <img
                  alt="Nhà máy Mabuchi Motor Việt Nam"
                  class="w-full aspect-[68/51] 2xl:aspect-auto 2xl:h-[513px] object-cover !mb-4"
                  data-x-aos="zoom-in"
                  height="1080"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-04.webp') }}"
                  width="1580"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-project-04-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-project-04.webp') }} 1448w" sizes="(min-width: 1280px) 50vw, 100vw" />
                <p data-x-aos="fade-up">
                  NHÀ MÁY MABUCHI MOTOR VIỆT NAM
                </p>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div>
                <img
                  alt="Phân loại lao động tại Nhà máy Suntory Pepsico Việt Nam"
                  class="w-full !mb-4 aspect-video object-cover object-center"
                  data-x-aos="zoom-in"
                  height="515"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-05.webp') }}"
                  width="900"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-project-05-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-project-05.webp') }} 900w" sizes="(min-width: 1280px) 50vw, 100vw" />
                <p data-x-aos="fade-up">PHÂN LOẠI LAO ĐỘNG TẠI NHÀ MÁY SUNTORY PEPSICO VIỆT NAM</p>
              </div>
              <div>
                <img
                  alt="Đánh giá phân loại lao động tại Nhà máy Bericap Việt Nam"
                  class="w-full !mb-4 aspect-video object-cover object-center"
                  data-x-aos="zoom-in"
                  height="449"
                  src="{{ asset('landing/ghg-service/images/bao-chau-project-06.webp') }}"
                  width="800"
                decoding="async" loading="lazy" srcset="{{ asset('landing/ghg-service/images/bao-chau-project-06-640.webp') }} 640w, {{ asset('landing/ghg-service/images/bao-chau-project-06.webp') }} 800w" sizes="(min-width: 1280px) 50vw, 100vw" />
                <p data-x-aos="fade-up">ĐÁNH GIÁ PHÂN LOẠI LAO ĐỘNG TẠI NHÀ MÁY BERICAP VIỆT NAM</p>
              </div>
            </div>
          </div>
        </div>
        <div class="absolute -bottom-1 left-0 w-full">
          <img
            alt=""
            class="w-full h-[155px] object-cover object-center"
            data-x-aos="zoom-in"
            height="155"
            src="{{ asset('landing/ghg-service/images/sect-archivement-footer.svg') }}"
          decoding="async" />
        </div>
      </section>
            <section
        class="sec-timeline scroll-mt-24 bg-cover bg-top !pt-12 2xl:!pt-[72px] pb-16 md:pb-20 lg:pb-24 xl:pb-28 !px-4 2xl:!px-0 relative xl:scroll-mt-28"
        id="quy-trinh-thuc-hien"
        style="background-image: url('{{ asset('landing/ghg-service/images/sect-timeline-bg.webp') }}');"
      >
        <!-- Overlay to ensure text readability and card contrast -->
        <div class="absolute inset-0 bg-neutral-black/40 pointer-events-none"></div>

        <div class="xl:max-w-7xl 2xl:max-w-6xl mx-auto relative z-10">
          <!-- Section Header -->
          <div class="text-center mb-16">
            <h2 class="text-gray-300 tracking-wider text-sm md:text-base lg:text-lg font-semibold uppercase mb-3" data-x-aos="fade-up">
              QUY TRÌNH KIỂM KÊ KHÍ NHÀ KÍNH
            </h2>
            <div class="text-yellow-500 font-extrabold text-2xl md:text-3xl lg:text-4xl xl:text-[40px] uppercase leading-tight" data-x-aos="fade-up">
              CHUẨN HÓA THEO QUY ĐỊNH VIỆT NAM VÀ QUỐC TẾ
            </div>
          </div>

          <!-- Cards Container with padding to avoid bottom overlap -->
          <div class="pb-16 md:pb-24 lg:pb-32">
            <!-- Row 1: Steps 01 to 04 (4 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12 mb-12 [&>div]:!px-4 [&>div>div]:!-top-7 [&>div>div]:!size-14 [&>div>div>span]:!text-xl [&_h3]:!text-sm md:[&_h3]:!text-base [&_h3]:!leading-snug [&_p]:!text-xs md:[&_p]:!text-[13px]">
              <!-- Step 1 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="100">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">01</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Xác định ranh giới và phạm vi
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Xác định các hoạt động sản xuất, kinh doanh thuộc quyền kiểm soát của cơ sở. Phân loại các nguồn phát thải thành nguồn trực tiếp và gián tiếp.
                </p>
              </div>

              <!-- Step 2 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="200">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">02</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Lựa chọn phương pháp kiểm kê
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Lựa chọn phương pháp luận tính toán phát thải KNK phù hợp với đặc thù ngành, đảm bảo tính khoa học và tuân thủ các quy định hiện hành.
                </p>
              </div>

              <!-- Step 3 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="300">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">03</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Lựa chọn hệ số phát thải
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Lựa chọn hệ số phát thải theo hướng dẫn kỹ thuật của lĩnh vực và danh mục được công bố phù hợp; nêu rõ nguồn, phương pháp và hệ số sử dụng trong báo cáo.
                </p>
              </div>

              <!-- Step 4 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="400">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">04</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Thu thập số liệu hoạt động
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Tổng hợp hóa đơn điện, nhiên liệu, nguyên liệu, sản lượng và dữ liệu nguồn thải theo kỳ kiểm kê; lưu chứng từ để kiểm tra và truy xuất.
                </p>
              </div>
            </div>

            <!-- Row 2: Steps 05 to 09 (5 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-x-6 gap-y-12 [&>div]:!px-4 [&>div>div]:!-top-7 [&>div>div]:!size-14 [&>div>div>span]:!text-xl [&_h3]:!text-sm md:[&_h3]:!text-base [&_h3]:!leading-snug [&_p]:!text-xs md:[&_p]:!text-[13px]">
              <!-- Step 5 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="100">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">05</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Tính toán phát thải
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Áp dụng công thức cơ bản: Lượng phát thải = Số liệu hoạt động × Hệ số phát thải. Tổng hợp kết quả cho toàn bộ cơ sở.
                </p>
              </div>

              <!-- Step 6 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="200">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">06</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Kiểm soát chất lượng (QC)
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Thực hiện các quy trình kiểm tra nội bộ để đảm bảo tính chính xác, đầy đủ và nhất quán của dữ liệu và các phép tính.
                </p>
              </div>

              <!-- Step 7 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="300">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">07</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Đánh giá độ không chắc chắn
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Đánh giá mức độ tin cậy của kết quả kiểm kê dựa trên chất lượng của số liệu hoạt động và hệ số phát thải đã sử dụng.
                </p>
              </div>

              <!-- Step 8 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="400">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">08</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Tính toán lại (nếu có)
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Thực hiện tính toán lại kết quả của các kỳ trước nếu có thay đổi lớn về ranh giới, phương pháp hoặc phát hiện sai sót đáng kể.
                </p>
              </div>

              <!-- Step 9 -->
              <div class="relative bg-white rounded-[20px] shadow-lg border border-neutral-100 flex flex-col pt-12 pb-8 px-5 transition-all hover:-translate-y-1 duration-300" data-x-aos="fade-up" data-x-aos-delay="500">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 rounded-full bg-white border-2 border-yellow-500 flex items-center justify-center shadow-md">
                  <span class="text-yellow-600 font-black text-lg">09</span>
                </div>
                <h3 class="text-neutral-black font-bold text-base md:text-lg text-center mb-3">
                  Xây dựng báo cáo
                </h3>
                <p class="text-neutral-gray text-xs md:text-sm leading-relaxed text-center">
                  Tổng hợp tất cả thông tin và kết quả vào biểu mẫu báo cáo chính thức theo quy định để nộp cho cơ quan chức năng.
                </p>
              </div>
            </div>
          </div>

        </div>
      </section>
      <section
        class="sect-faq shopee-faq-section relative scroll-mt-24 bg-gradient-to-b from-white via-slate-50 to-white !px-4 pb-10 2xl:!px-0 lg:pb-0 xl:scroll-mt-28"
        id="faqs"
      >
        <div
          class="mx-auto max-w-6xl pb-20 pt-16 md:pt-20 xl:py-24"
        >
          <!-- Header -->
          <div
            class="mb-10 flex flex-col items-center justify-center text-center font-semibold uppercase text-neutral-black md:mb-12"
          >
            <h2 class="mb-3 text-2xl leading-tight md:text-3xl xl:text-[40px] xl:leading-[1.2]" data-x-aos="fade-up">
              CÂU HỎI THƯỜNG GẶP VỀ KIỂM KÊ KNK
            </h2>
            <div class="inline-block rounded-lg bg-yellow-500 !px-5 !py-2 text-xl font-bold shadow-sm md:text-2xl xl:text-3xl">
              BẢO CHÂU ENVIR GIẢI ĐÁP
            </div>
          </div>
          <!-- FAQ Items -->
          <div class="space-y-3">
            <!-- FAQ Item 1 - Expanded -->
            <div class="faq-item overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">
              <div
                class="faq-question flex min-h-14 w-full cursor-pointer items-center justify-between rounded-xl !px-4 !py-3 text-left text-base font-semibold leading-normal text-neutral-black transition-colors duration-200 hover:bg-yellow-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 [.active_&]:bg-yellow-50 [.active_&]:text-red-500 lg:text-lg xl:text-xl"
              >
                <h3 class="flex items-center" data-x-aos="fade-up">
                  <span class="!mr-3 flex size-8 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-sm font-bold text-yellow-700">1</span>
                  Đối tượng nào bắt buộc phải thực hiện kiểm kê khí nhà kính?
                </h3>
                <span>
                  <svg
                    class="[.active_&]:hidden inline-block size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g clip-path="url(#clip0_51_9654)">
                      <path
                        d="M14.5714 6.82143H9.71429C9.5565 6.82143 9.42857 6.6935 9.42857 6.53572V1.67857C9.42857 0.889649 8.78892 0.25 8 0.25C7.21108 0.25 6.57143 0.889649 6.57143 1.67857V6.53572C6.57143 6.6935 6.4435 6.82143 6.28572 6.82143H1.42857C0.639649 6.82143 0 7.46108 0 8.25C0 9.03892 0.639649 9.67857 1.42857 9.67857H6.28572C6.4435 9.67857 6.57143 9.8065 6.57143 9.96429V14.8214C6.57143 15.6104 7.21108 16.25 8 16.25C8.78892 16.25 9.42857 15.6104 9.42857 14.8214V9.96429C9.42857 9.8065 9.5565 9.67857 9.71429 9.67857H14.5714C15.3604 9.67857 16 9.03892 16 8.25C16 7.46108 15.3604 6.82143 14.5714 6.82143Z"
                        fill="currentColor"
                      ></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_51_9654">
                        <rect
                          fill="white"
                          height="16"
                          transform="translate(0 0.25)"
                          width="16"
                        ></rect>
                      </clipPath>
                    </defs>
                  </svg>
                  <svg
                    class="[.active_&]:inline-block hidden size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M14.4516 6.70117H1.54839C0.696774 6.70117 0 7.39795 0 8.24956C0 9.10117 0.696774 9.79795 1.54839 9.79795H14.4516C15.3032 9.79795 16 9.10117 16 8.24956C16 7.39795 15.3032 6.70117 14.4516 6.70117Z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </span>
              </div>
              <!-- Expanded Content -->
              <div
                class="faq-answer space-y-2 overflow-hidden border-t border-slate-100 !px-4 !pb-5 !pt-4 text-sm leading-relaxed text-neutral-black collapsed [&.collapsed]:hidden md:!px-16 md:text-base xl:text-lg"
              >
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Đối chiếu tên cơ sở trong các phụ lục Quyết định 42/2026/QĐ-TTg để xác định nghĩa vụ. Mức phát thải từ 3.000 tấn CO2 tương đương/năm là một tiêu chí rà soát danh mục theo Điều 6 Nghị định 06/2022/NĐ-CP.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Các nhà máy nhiệt điện, cơ sở sản xuất công nghiệp có tổng tiêu thụ năng lượng hằng năm từ 1.000 tấn dầu tương đương (TOE) trở lên.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Công ty kinh doanh vận tải hàng hóa có tổng tiêu thụ nhiên liệu hằng năm từ 1.000 TOE trở lên là nhóm tiêu chí rà soát danh mục.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Các tòa nhà thương mại tiêu thụ năng lượng hằng năm từ 1.000 TOE trở lên; cơ sở xử lý chất thải rắn có công suất hằng năm từ 65.000 tấn trở lên. Đây cũng là các tiêu chí rà soát danh mục. Cơ sở có tên trong Quyết định 13/2024 nhưng không còn trong Quyết định 42/2026 không phải nộp báo cáo kiểm kê cấp cơ sở từ năm 2027 cho năm 2026 theo quy định chuyển tiếp tại Quyết định 42/2026.
                  </p>
                </div>
              </div>
            </div>
            <!-- FAQ Item 2 - Collapsed -->
            <div class="faq-item overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">
              <div
                class="faq-question flex min-h-14 w-full cursor-pointer items-center justify-between rounded-xl !px-4 !py-3 text-left text-base font-semibold leading-normal text-neutral-black transition-colors duration-200 hover:bg-yellow-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 [.active_&]:bg-yellow-50 [.active_&]:text-red-500 lg:text-lg xl:text-xl"
              >
                <h3 class="flex items-center" data-x-aos="fade-up">
                  <span class="!mr-3 flex size-8 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-sm font-bold text-yellow-700">2</span>
                  Thời hạn thực hiện và nộp báo cáo kiểm kê KNK là khi nào?
                </h3>
                <span>
                  <svg
                    class="[.active_&]:hidden inline-block size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g clip-path="url(#clip0_51_9654)">
                      <path
                        d="M14.5714 6.82143H9.71429C9.5565 6.82143 9.42857 6.6935 9.42857 6.53572V1.67857C9.42857 0.889649 8.78892 0.25 8 0.25C7.21108 0.25 6.57143 0.889649 6.57143 1.67857V6.53572C6.57143 6.6935 6.4435 6.82143 6.28572 6.82143H1.42857C0.639649 6.82143 0 7.46108 0 8.25C0 9.03892 0.639649 9.67857 1.42857 9.67857H6.28572C6.4435 9.67857 6.57143 9.8065 6.57143 9.96429V14.8214C6.57143 15.6104 7.21108 16.25 8 16.25C8.78892 16.25 9.42857 15.6104 9.42857 14.8214V9.96429C9.42857 9.8065 9.5565 9.67857 9.71429 9.67857H14.5714C15.3604 9.67857 16 9.03892 16 8.25C16 7.46108 15.3604 6.82143 14.5714 6.82143Z"
                        fill="currentColor"
                      ></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_51_9654">
                        <rect
                          fill="white"
                          height="16"
                          transform="translate(0 0.25)"
                          width="16"
                        ></rect>
                      </clipPath>
                    </defs>
                  </svg>
                  <svg
                    class="[.active_&]:inline-block hidden size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M14.4516 6.70117H1.54839C0.696774 6.70117 0 7.39795 0 8.24956C0 9.10117 0.696774 9.79795 1.54839 9.79795H14.4516C15.3032 9.79795 16 9.10117 16 8.24956C16 7.39795 15.3032 6.70117 14.4516 6.70117Z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </span>
              </div>
              <div
                class="faq-answer space-y-2 overflow-hidden border-t border-slate-100 !px-4 !pb-5 !pt-4 text-sm leading-relaxed text-neutral-black collapsed [&.collapsed]:hidden md:!px-16 md:text-base xl:text-lg"
              >
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Nhóm cơ sở thuộc điểm b khoản 4 Điều 11: lập báo cáo định kỳ 02 năm/lần theo Mẫu số 06 Phụ lục II, gửi UBND cấp tỉnh trước ngày 31/3 kể từ năm 2025. Không áp dụng lịch này cho nhóm quy định tại điểm c, d cùng khoản.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Nhà máy nhiệt điện, cơ sở sắt thép, xi măng trong danh mục lập báo cáo 02 năm/lần cho năm 2026 trở đi. Cơ sở khác được phân bổ hạn ngạch từ năm 2027 lập báo cáo 02 năm/lần cho năm 2028 trở đi. Cơ sở được phân bổ hạn ngạch gửi báo cáo đã được thẩm định đến Bộ Nông nghiệp và Môi trường trước ngày 01/12 kể từ năm 2027 (khoản 6a Điều 11).
                  </p>
                </div>
              </div>
            </div>
            <!-- FAQ Item 3 - Collapsed -->
            <div class="faq-item overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">
              <div
                class="faq-question flex min-h-14 w-full cursor-pointer items-center justify-between rounded-xl !px-4 !py-3 text-left text-base font-semibold leading-normal text-neutral-black transition-colors duration-200 hover:bg-yellow-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 [.active_&]:bg-yellow-50 [.active_&]:text-red-500 lg:text-lg xl:text-xl"
              >
                <h3 class="flex items-center" data-x-aos="fade-up">
                  <span class="!mr-3 flex size-8 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-sm font-bold text-yellow-700">3</span>
                  Quy trình tư vấn kiểm kê khí nhà kính của Bảo Châu mất bao lâu?
                </h3>
                <span>
                  <svg
                    class="[.active_&]:hidden inline-block size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g clip-path="url(#clip0_51_9654)">
                      <path
                        d="M14.5714 6.82143H9.71429C9.5565 6.82143 9.42857 6.6935 9.42857 6.53572V1.67857C9.42857 0.889649 8.78892 0.25 8 0.25C7.21108 0.25 6.57143 0.889649 6.57143 1.67857V6.53572C6.57143 6.6935 6.4435 6.82143 6.28572 6.82143H1.42857C0.639649 6.82143 0 7.46108 0 8.25C0 9.03892 0.639649 9.67857 1.42857 9.67857H6.28572C6.4435 9.67857 6.57143 9.8065 6.57143 9.96429V14.8214C6.57143 15.6104 7.21108 16.25 8 16.25C8.78892 16.25 9.42857 15.6104 9.42857 14.8214V9.96429C9.42857 9.8065 9.5565 9.67857 9.71429 9.67857H14.5714C15.3604 9.67857 16 9.03892 16 8.25C16 7.46108 15.3604 6.82143 14.5714 6.82143Z"
                        fill="currentColor"
                      ></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_51_9654">
                        <rect
                          fill="white"
                          height="16"
                          transform="translate(0 0.25)"
                          width="16"
                        ></rect>
                      </clipPath>
                    </defs>
                  </svg>
                  <svg
                    class="[.active_&]:inline-block hidden size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M14.4516 6.70117H1.54839C0.696774 6.70117 0 7.39795 0 8.24956C0 9.10117 0.696774 9.79795 1.54839 9.79795H14.4516C15.3032 9.79795 16 9.10117 16 8.24956C16 7.39795 15.3032 6.70117 14.4516 6.70117Z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </span>
              </div>
              <div
                class="faq-answer space-y-2 overflow-hidden border-t border-slate-100 !px-4 !pb-5 !pt-4 text-sm leading-relaxed text-neutral-black collapsed [&.collapsed]:hidden md:!px-16 md:text-base xl:text-lg"
              >
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Thông thường thời gian triển khai từ lúc khảo sát đến khi ra báo cáo hoàn thiện kéo dài từ 4 đến 8 tuần.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Thời gian thực tế phụ thuộc lớn vào việc cung cấp số liệu hoạt động của doanh nghiệp. Bảo Châu luôn cử kỹ sư hỗ trợ trực tiếp tại nhà máy để tối ưu hóa tiến độ này.
                  </p>
                </div>
              </div>
            </div>
            <!-- FAQ Item 4 - Collapsed -->
            <div class="faq-item overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-shadow duration-200 hover:shadow-md">
              <div
                class="faq-question flex min-h-14 w-full cursor-pointer items-center justify-between rounded-xl !px-4 !py-3 text-left text-base font-semibold leading-normal text-neutral-black transition-colors duration-200 hover:bg-yellow-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 [.active_&]:bg-yellow-50 [.active_&]:text-red-500 lg:text-lg xl:text-xl"
              >
                <h3 class="flex items-center" data-x-aos="fade-up">
                  <span class="!mr-3 flex size-8 shrink-0 items-center justify-center rounded-full bg-yellow-100 text-sm font-bold text-yellow-700">4</span>
                  Mức xử phạt hành chính đối với hành vi vi phạm về kiểm kê khí nhà kính là bao nhiêu?
                </h3>
                <span>
                  <svg
                    class="[.active_&]:hidden inline-block size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g clip-path="url(#clip0_51_9654)">
                      <path
                        d="M14.5714 6.82143H9.71429C9.5565 6.82143 9.42857 6.6935 9.42857 6.53572V1.67857C9.42857 0.889649 8.78892 0.25 8 0.25C7.21108 0.25 6.57143 0.889649 6.57143 1.67857V6.53572C6.57143 6.6935 6.4435 6.82143 6.28572 6.82143H1.42857C0.639649 6.82143 0 7.46108 0 8.25C0 9.03892 0.639649 9.67857 1.42857 9.67857H6.28572C6.4435 9.67857 6.57143 9.8065 6.57143 9.96429V14.8214C6.57143 15.6104 7.21108 16.25 8 16.25C8.78892 16.25 9.42857 15.6104 9.42857 14.8214V9.96429C9.42857 9.8065 9.5565 9.67857 9.71429 9.67857H14.5714C15.3604 9.67857 16 9.03892 16 8.25C16 7.46108 15.3604 6.82143 14.5714 6.82143Z"
                        fill="currentColor"
                      ></path>
                    </g>
                    <defs>
                      <clipPath id="clip0_51_9654">
                        <rect
                          fill="white"
                          height="16"
                          transform="translate(0 0.25)"
                          width="16"
                        ></rect>
                      </clipPath>
                    </defs>
                  </svg>
                  <svg
                    class="[.active_&]:inline-block hidden size-4"
                    height="16"
                    viewBox="0 0 16 17"
                    width="16"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      d="M14.4516 6.70117H1.54839C0.696774 6.70117 0 7.39795 0 8.24956C0 9.10117 0.696774 9.79795 1.54839 9.79795H14.4516C15.3032 9.79795 16 9.10117 16 8.24956C16 7.39795 15.3032 6.70117 14.4516 6.70117Z"
                      fill="currentColor"
                    ></path>
                  </svg>
                </span>
              </div>
              <div
                class="faq-answer space-y-2 overflow-hidden border-t border-slate-100 !px-4 !pb-5 !pt-4 text-sm leading-relaxed text-neutral-black collapsed [&.collapsed]:hidden md:!px-16 md:text-base xl:text-lg"
              >
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Theo khoản 2 Điều 6 và Điều 45 Nghị định 45/2022/NĐ-CP, mức phạt tiền dưới đây áp dụng cho tổ chức (gấp 02 lần mức của cá nhân). Cần phân biệt từng hành vi:
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Phạt cảnh cáo đối với hành vi không nộp báo cáo kiểm kê KNK hoặc báo cáo mức giảm phát thải KNK cho cơ quan quản lý nhà nước theo quy định.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Phạt tiền từ 10.000.000 VNĐ đến 20.000.000 VNĐ đối với hành vi cung cấp thông tin không đúng, không đầy đủ trong báo cáo kiểm kê KNK.
                  </p>
                </div>
                <div class="flex items-start gap-x-2">
                  <img
                    alt=""
                    class="size-5 mt-1 shrink-0"
                    data-x-aos="zoom-in"
                    height="20"
                    src="{{ asset('landing/ghg-service/images/arrow-right.svg') }}"
                    width="20"
                  decoding="async" />
                  <p data-x-aos="fade-up">
                    Phạt tiền từ 60.000.000 VNĐ đến 100.000.000 VNĐ đối với hành vi không lập báo cáo kiểm kê KNK theo quy định. Ngoài tiền phạt, cơ sở phải thực hiện biện pháp khắc phục theo khoản 4 Điều 45. <a class="underline" href="https://vanban.chinhphu.vn/?classid=1&amp;docid=206083&amp;orggroupid=2&amp;pageid=27160" target="_blank" rel="noopener noreferrer">Xem Nghị định 45/2022/NĐ-CP</a>.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section
        class="bao-chau-partners relative overflow-hidden bg-[#3ca707] px-3 py-10 sm:px-4 sm:py-12 lg:pb-14"
        aria-labelledby="bao-chau-partners-title"
      >
        <div class="mx-auto w-full max-w-[1280px]">
          <header class="mb-6 text-center text-white sm:mb-8" data-x-aos="fade-up">
            <div class="mb-2 flex items-center justify-center gap-3 text-sm font-medium leading-none" aria-hidden="true">
              <span class="h-px w-12 bg-white/90 sm:w-[70px]"></span>
              <b class="font-medium">PARTNER</b>
              <span class="h-px w-12 bg-white/90 sm:w-[70px]"></span>
            </div>
            <h2
              id="bao-chau-partners-title"
              class="m-0 text-[26px] font-extrabold leading-[1.2] tracking-[0.01em] sm:text-3xl lg:text-[40px]"
            >
              ĐỐI TÁC CỦA CHÚNG TÔI
            </h2>
          </header>

          <div class="relative h-[86px] px-[42px] sm:h-[92px] sm:px-[52px]">
            <button
              class="bao-chau-partners__nav--prev absolute left-0 top-1/2 z-10 inline-flex size-9 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border-0 bg-white/80 text-[#4ba91a] transition-[background-color,box-shadow] duration-200 hover:bg-white hover:shadow-[0_6px_16px_rgba(21,76,3,0.2)] focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-[3px] focus-visible:outline-white motion-reduce:transition-none sm:size-11"
              type="button"
              aria-label="Xem đối tác trước"
            >
              <svg class="size-6 fill-none stroke-current" aria-hidden="true" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25">
                <path d="m15 18-6-6 6-6"></path>
              </svg>
            </button>

            <div class="bao-chau-partners__viewport h-full overflow-hidden">
              <div class="bao-chau-partners__track -mx-2 flex h-full transition-transform duration-[450ms] ease-out will-change-transform motion-reduce:transition-none">
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-06.jpg') }}" alt="Bồ Công Anh Foods" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-07.jpg') }}" alt="Mabuchi Motor" width="345" height="241" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-08.png') }}" alt="Pharmedic" width="500" height="500" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-09.jpg') }}" alt="Thịnh Phát Environment Construction Investment" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-10.jpg') }}" alt="Môi Trường Xuyên Á" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-11.jpg') }}" alt="Hải Sơn Industrial Park" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-01.jpg') }}" alt="Thuận Việt Construction Investment" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-02.jpg') }}" alt="Nova Land" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-03.jpg') }}" alt="Capella Gallery Hall" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-04.jpg') }}" alt="BMT FICO" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
                <div class="bao-chau-partners__slide h-full w-1/2 shrink-0 px-2 sm:w-1/3 md:w-1/4 lg:w-1/6 xl:w-[14.285714%] 2xl:w-[12.5%]">
                  <figure class="m-0 flex h-[86px] items-center justify-center overflow-hidden rounded-md bg-white shadow-[0_6px_18px_rgba(21,76,3,0.14)] sm:h-[92px]">
                    <img class="h-full w-full object-contain object-center p-[7px]" src="{{ asset('landing/ghg-service/images/bao-chau-client-05.jpg') }}" alt="Alpha Engineering" width="196" height="120" loading="lazy" decoding="async" />
                  </figure>
                </div>
              </div>
            </div>

            <button
              class="bao-chau-partners__nav--next absolute right-0 top-1/2 z-10 inline-flex size-9 -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border-0 bg-white/80 text-[#4ba91a] transition-[background-color,box-shadow] duration-200 hover:bg-white hover:shadow-[0_6px_16px_rgba(21,76,3,0.2)] focus-visible:outline focus-visible:outline-[3px] focus-visible:outline-offset-[3px] focus-visible:outline-white motion-reduce:transition-none sm:size-11"
              type="button"
              aria-label="Xem đối tác tiếp theo"
            >
              <svg class="size-6 fill-none stroke-current" aria-hidden="true" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25">
                <path d="m9 18 6-6-6-6"></path>
              </svg>
            </button>
          </div>
        </div>
      </section>
    </main>

    <footer
      class="relative bg-cover bg-center flex sect-footer justify-center items-center text-white min-h-[500px] !px-4 lg:!px-0"
    >
      <div class="w-full md:w-[688px] m-auto">
        <!-- Main Content -->
        <!-- Logos -->
        <div class="flex justify-center items-center !gap-4 !mb-4 md:!mb-8">
          <img
            src="{{ asset('landing/ghg-service/images/Logo-160.webp') }}"
            alt="Môi Trường Bảo Châu"
            width="128"
            height="128"
            class="w-22 h-22 md:w-32 md:h-32 object-contain"
          decoding="async" loading="lazy" />
        </div>

        <!-- Main Heading -->
        <h2
          class="text-lg lg:text-xl leading-normal font-semibold uppercase !mb-2 text-center"
        >
          DỊCH VỤ KIỂM KÊ KHÍ NHÀ KÍNH - MÔI TRƯỜNG BẢO CHÂU
        </h2>

        <!-- Subtitle -->
        <p class="text-center text-sm font-normal mb-4">
          Cung cấp dịch vụ tư vấn kiểm kê khí nhà kính, kiểm toán năng lượng, lập hồ sơ môi trường và báo cáo ESG trọn gói, chuyên nghiệp và uy tín hàng đầu cho doanh nghiệp Việt Nam.
        </p>

<nav aria-label="Liên kết dịch vụ" class="flex flex-wrap justify-center gap-4 text-sm !mb-5">
          <a class="underline" href="{{ route('home') }}">Môi Trường Bảo Châu</a>
          <a class="underline" href="{{ route('services.index') }}">Các dịch vụ môi trường</a>
          <a class="underline" href="{{ route('contact.index') }}">Liên hệ tư vấn</a>
        </nav>
        <!-- Contact Information -->
        <div
          class="flex flex-wrap md:flex-nowrap justify-center !gap-4 md:!gap-0 md:justify-between !mb-4 pb-6 text-sm lg:text-base font-normal leading-[26px] !border-0 !border-b border-solid border-grey-100"
        >
          <!-- Hotline -->
          <div class="text-center w-fit">
            <div class="flex items-center justify-center !gap-2 mb-1">
              <img
                src="{{ asset('landing/ghg-service/images/telephone-2.svg') }}"
                alt=""
                width="16"
                height="16"
                class="size-4"
              decoding="async" />
              <span class="text-white">Hotline tư vấn</span>
            </div>
            <a
              href="tel:0915549148"
              class="block text-yellow-500 font-bold text-xl lg:text-3xl"
              >0915.549.148</a
            >
          </div>

          <div class="hidden md:block h-14 w-px bg-white/25"></div>

          <!-- Email -->
          <div class="text-center w-fit">
            <div class="flex items-center justify-center !gap-2 mb-2">
              <img
                src="{{ asset('landing/ghg-service/images/email-2.svg') }}"
                alt=""
                width="16"
                height="16"
                class="size-4"
              decoding="async" />
              <span class="text-white">Địa chỉ Email</span>
            </div>
            <a href="mailto:info@baochauenvir.com" class="font-semibold text-yellow-500"
              >info@baochauenvir.com</a
            >
          </div>

          <div class="hidden md:block h-14 w-px bg-white/25"></div>
          <!-- Social -->
          <div class="text-center w-fit">
            <div class="flex items-center justify-center !gap-2 mb-2">
              <img
                src="{{ asset('landing/ghg-service/images/links.svg') }}"
                alt=""
                width="16"
                height="16"
                class="size-4"
              decoding="async" />
              <span class="text-white">Liên kết</span>
            </div>
            <div class="flex justify-center !gap-2">
              <a
                href="https://www.facebook.com/profile.php?id=100880909568347"
                target="_blank"
                title="Facebook"
                ><img
                  src="{{ asset('landing/ghg-service/images/facebook-2.svg') }}"
                  alt=""
                  width="24"
                  height="24"
                  class="size-6"
              decoding="async" /></a>
              <a
                href="https://zalo.me/0915549148"
                target="_blank"
                title="Zalo"
                ><img
                  src="{{ asset('landing/ghg-service/images/tiktok.svg') }}"
                  alt=""
                  width="24"
                  height="24"
                  class="size-6"
              decoding="async" /></a>
              <a
                href="https://moitruongbaochau.com"
                target="_blank"
                title="Website"
                ><img
                  src="{{ asset('landing/ghg-service/images/youtube-2.svg') }}"
                  alt=""
                  width="24"
                  height="24"
                  class="size-6"
              decoding="async" /></a>
            </div>
          </div>
        </div>

        <!-- Bottom Section -->
        <div
          class="flex flex-col md:flex-row justify-between items-center text-sm lg:text-base text-white"
        ></div>
      </div>
    </footer>

    <style>
      .form-control.is-invalid {
        border-color: #dc3545;
      }
      .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
      }
      .text-muted {
        font-size: 0.8em;
        color: #6c757d !important;
      }
    </style>
    <div
      class="modal fade"
      id="modal-auth"
      tabindex="-1"
      aria-labelledby="auth-modal-title"
      aria-hidden="true"
      data-bs-backdrop="static"
    >
      <div class="modal-dialog modal-dialog-centered modal-auth !mx-auto w-[calc(100%-24px)] max-w-[540px]">
        <div class="modal-content">
          <!-- Header -->
          <div class="modal-header">
            <div class="w-100 text-center">
              <h5 class="modal-title" id="auth-modal-title">[ ĐĂNG KÝ TƯ VẤN KIỂM KÊ KHÍ NHÀ KÍNH ]</h5>
              <div
                class="d-flex align-items-center gap-1 justify-content-center"
              >
                <img src="{{ asset('landing/ghg-service/images/target-icon.png') }}" alt="" decoding="async" />
                <span class="text-white"
                  >Tư vấn miễn phí · Báo giá dịch vụ · Hỗ trợ doanh nghiệp toàn quốc</span
                >
              </div>
            </div>
            <button
              type="button"
              class="close-btn"
              data-bs-dismiss="modal"
              aria-label="Close"
            >
              <i class="bi bi-x-circle"></i>
            </button>
          </div>

          <!-- Body -->
          <div class="modal-body p-0">
            <div class="form-login">
              <div
                class="!grid grid-cols-2 gap-1 rounded-t-xl bg-[#273586] !p-1.5"
                id="authTabs"
                role="tablist"
              >
                  <button
                    class="auth-modal-tab inline-flex min-h-11 w-full items-center justify-center rounded-lg border-0 bg-transparent !px-2 !py-2.5 text-center text-xs font-bold text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#273586] sm:text-sm [&.active]:bg-white [&.active]:text-blue-600 [&.active]:shadow-sm [&.active]:hover:bg-white"
                    id="login-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#login-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="login-tab-pane"
                    aria-selected="false"
                  >
                    <span>YÊU CẦU GỌI LẠI</span>
                  </button>
                  <button
                    class="auth-modal-tab active inline-flex min-h-11 w-full items-center justify-center rounded-lg border-0 bg-transparent !px-2 !py-2.5 text-center text-xs font-bold text-white transition-colors duration-200 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#273586] sm:text-sm [&.active]:bg-white [&.active]:text-blue-600 [&.active]:shadow-sm [&.active]:hover:bg-white"
                    id="register-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#register-tab-pane"
                    type="button"
                    role="tab"
                    aria-controls="register-tab-pane"
                    aria-selected="true"
                  >
                    <span>ĐĂNG KÝ TƯ VẤN</span>
                  </button>
              </div>

              <!-- Tab Content -->
              <div class="tab-content" id="authTabsContent">
<!-- Callback tab -->
                <div
                  class="tab-pane fade"
                  id="login-tab-pane"
                  role="tabpanel"
                  aria-labelledby="login-tab"
                  tabindex="0"
                >
                  <p class="mb-4">
                    Để lại thông tin liên hệ. <span class="red-text">Chuyên viên sẽ gọi lại tư vấn miễn phí.</span>
                  </p>
                  @include('frontend.landing.ghg-service.form', ['formId' => 'modal-callback', 'consultationType' => 'callback'])
                </div>
<!-- Consultation tab -->
                <div
                  class="tab-pane fade show active"
                  id="register-tab-pane"
                  role="tabpanel"
                  aria-labelledby="register-tab"
                  tabindex="0"
                >
                  @include('frontend.landing.ghg-service.form', ['formId' => 'modal-consultation', 'consultationType' => 'consultation'])
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- SweetAlert2 for better notifications - chỉ cho modal này -->
    <style>
      /* Custom styling cho modal tư vấn */
      .swal2-popup {
        border-radius: 12px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif !important;
      }
      .swal2-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
        color: #2c3e50 !important;
      }
      .swal2-content {
        font-size: 1rem !important;
        color: #5a6c7d !important;
      }
      .swal2-confirm {
        border-radius: 8px !important;
        padding: 10px 24px !important;
        font-weight: 500 !important;
      }
    </style>

    <!-- Common Scripts -->
    <script src="{{ asset('landing/ghg-service/js/bootstrap.bundle.min.js') }}" defer></script>

    <!-- AOS JS -->
    <script src="{{ asset('landing/ghg-service/js/aos.js') }}" defer></script>

    <script src="{{ asset('landing/ghg-service/js/partners-carousel.js') }}" defer></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const authModalTitle = document.querySelector("#auth-modal-title");
        document.querySelectorAll("#authTabs [data-bs-toggle='tab']").forEach((tab) => {
          tab.addEventListener("shown.bs.tab", function () {
            if (!authModalTitle) return;
            authModalTitle.textContent = this.id === "login-tab"
              ? "[ YÊU CẦU CHUYÊN VIÊN GỌI LẠI ]"
              : "[ ĐĂNG KÝ TƯ VẤN KIỂM KÊ KHÍ NHÀ KÍNH ]";
          });
        });

        document.querySelectorAll("[data-consultation-tabs]").forEach((group) => {
          const tabs = Array.from(group.querySelectorAll(".consultation-tab"));
          const panels = Array.from(group.querySelectorAll(".consultation-panel"));

          const activateTab = (selectedTab) => {
            tabs.forEach((tab) => {
              const isActive = tab === selectedTab;
              tab.setAttribute("aria-selected", String(isActive));
              tab.tabIndex = isActive ? 0 : -1;
              tab.classList.toggle("bg-white", isActive);
              tab.classList.toggle("text-blue-600", isActive);
              tab.classList.toggle("shadow-sm", isActive);
              tab.classList.toggle("bg-transparent", !isActive);
              tab.classList.toggle("text-white", !isActive);
              tab.classList.toggle("hover:bg-white/10", !isActive);
            });

            panels.forEach((panel) => {
              const isActive = panel.id === selectedTab.getAttribute("aria-controls");
              panel.classList.toggle("hidden", !isActive);
            });
          };

          tabs.forEach((tab, index) => {
            tab.addEventListener("click", () => activateTab(tab));
            tab.addEventListener("keydown", (event) => {
              if (!["ArrowLeft", "ArrowRight", "Home", "End"].includes(event.key)) return;
              event.preventDefault();

              let nextIndex = index;
              if (event.key === "ArrowLeft") nextIndex = (index - 1 + tabs.length) % tabs.length;
              if (event.key === "ArrowRight") nextIndex = (index + 1) % tabs.length;
              if (event.key === "Home") nextIndex = 0;
              if (event.key === "End") nextIndex = tabs.length - 1;

              tabs[nextIndex].focus();
              activateTab(tabs[nextIndex]);
            });
          });
        });
      });
    </script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get all FAQ question buttons
        const faqQuestions = document.querySelectorAll(
          ".shopee-faq-section .faq-question",
        );

        // Add click event listener to each question
        faqQuestions.forEach((question) => {
          question.addEventListener("click", function () {
            // Get the parent FAQ item
            const faqItem = this.parentElement;

            // Get the answer element
            const answer = faqItem.querySelector(".faq-answer");

            // Check if this FAQ item is already active
            const isActive = faqItem.classList.contains("active");

            // Close all FAQ items first
            document
              .querySelectorAll(".shopee-faq-section .faq-item")
              .forEach((item) => {
                item.classList.remove("active");
                item.querySelector(".faq-answer").classList.add("collapsed");
              });

            // If the clicked item wasn't active, open it
            if (!isActive) {
              faqItem.classList.add("active");
              answer.classList.remove("collapsed");
            }
          });
        });
      });
    </script>

    <script>
      // Generic function to initialize all YouTube players
      document.addEventListener("DOMContentLoaded", function () {
        const videoContainers = document.querySelectorAll(
          ".youtube-video-container",
        );

        videoContainers.forEach((container) => {
          const videoSrc = container.getAttribute("data-video-src");
          const posterWrapper = container.querySelector(".poster-wrapper");
          const iframeContainer = container.querySelector(".iframe-container");

          // Make the entire poster wrapper clickable
          posterWrapper.addEventListener("click", function () {
            // Hide poster
            posterWrapper.style.display = "none";

            // Show and populate iframe
            iframeContainer.classList.remove("hidden");
            iframeContainer.classList.add("active");

            // Create and add iframe
            const iframe = document.createElement("iframe");
            iframe.src = videoSrc;
            iframe.className = "absolute inset-0 w-full h-full";
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute(
              "allow",
              "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture",
            );

            iframeContainer.appendChild(iframe);
          });
        });
      });
    </script>

    <script>
      function toggleFAQ(index) {
        const faqItems = document.querySelectorAll(".faq-item");
        const currentItem = faqItems[index - 1];
        const answer = currentItem.querySelector(".faq-answer");
        const icon = currentItem.querySelector(".faq-icon");

        // Close all other FAQ items
        faqItems.forEach((item, i) => {
          if (i !== index - 1) {
            item.classList.remove("active"); // Add background colo
            const otherAnswer = item.querySelector(".faq-answer");
            const otherIcon = item.querySelector(".faq-icon");
            otherAnswer.classList.add("hidden");
            otherIcon.classList.remove("rotate-180");
          }
        });

        // Toggle current FAQ item
        if (answer.classList.contains("hidden")) {
          currentItem.classList.add("active"); // Add background colo
          answer.classList.remove("hidden");
          icon.classList.add("rotate-180");
        } else {
          answer.classList.add("hidden");
          icon.classList.remove("rotate-180");
          currentItem.classList.remove("active"); // Add background colo
        }
      }
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("[data-x-aos]").forEach((element) => {
          if (!element.closest("#su-cap-thiet")) {
            element.setAttribute("data-aos", element.getAttribute("data-x-aos"));
          }
        });
        AOS.init({ duration: 650, once: true });
      });

      document.addEventListener("DOMContentLoaded", function () {
        // Get the header element
        const header = document.querySelector(".header");
        let headerHeight = header.offsetHeight; // Get the header height
        let ticking = false; // For scroll performance

        // Function to handle scroll events
        function handleScroll() {
          const currentScrollTop = window.scrollY;

          // Add or remove sticky class based on scroll position
          if (currentScrollTop > 50) {
            // If scrolling down past threshold and header is not already sticky
            if (!header.classList.contains("sticky-header")) {
              // Remove returning class if it exists
              header.classList.remove("returning");
              // Add sticky class
              header.classList.add("sticky-header");
            }
          } else {
            // If at top or scrolling back up to top
            if (header.classList.contains("sticky-header")) {
              // Add returning class for animation
              header.classList.add("returning");

              // Wait for animation to complete before removing sticky
              setTimeout(() => {
                header.classList.remove("sticky-header");
                header.classList.remove("returning");
              }, 100); // Match this with the animation duration
            }
          }

          // Keep the scrolled class for visual changes (if needed)
          if (currentScrollTop > 50) {
            header.classList.add("scrolled");
          } else {
            header.classList.remove("scrolled");
          }

          ticking = false;
        }

        // Add scroll event listener with requestAnimationFrame for performance
        window.addEventListener("scroll", function () {
          if (!ticking) {
            window.requestAnimationFrame(function () {
              handleScroll();
            });
            ticking = true;
          }
        });

        // Initial check
        handleScroll();

        // Recalculate header height on window resize
        window.addEventListener("resize", function () {
          headerHeight = header.offsetHeight;
          handleScroll();
        });

        // Mobile menu toggle functionality
        const menuToggle = document.querySelector(".menu-toggle");
        const mobileMenu = document.querySelector("#mobile-menu");
        const menuIcon = menuToggle ? menuToggle.querySelector("img") : null;

        if (menuToggle && mobileMenu && menuIcon) {
          menuToggle.addEventListener("click", function () {
            const isMenuOpen = !mobileMenu.classList.contains("hidden");

            if (isMenuOpen) {
              // Close menu
              mobileMenu.classList.add("hidden");
              header.classList.remove("active");
              menuToggle.setAttribute("aria-expanded", "false");
              // Change icon back to hamburger
              menuIcon.src = "{{ asset('landing/ghg-service/images/menu-bar.svg') }}";
              menuIcon.alt = "Menu";
              // Enable body scroll
              document.body.style.overflow = "";
            } else {
              // Open menu
              mobileMenu.classList.remove("hidden");
              header.classList.add("active");
              menuToggle.setAttribute("aria-expanded", "true");
              // Change icon to X
              menuIcon.src =
                "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M6 18L18 6M6 6l12 12' /%3E%3C/svg%3E";
              menuIcon.alt = "Close";
              // Disable body scroll
              document.body.style.overflow = "hidden";
            }
          });

          const closeMobileMenu = () => {
            mobileMenu.classList.add("hidden");
            header.classList.remove("active");
            menuToggle.setAttribute("aria-expanded", "false");
            menuIcon.src = "{{ asset('landing/ghg-service/images/menu-bar.svg') }}";
            menuIcon.alt = "Menu";
            document.body.style.overflow = "";
          };

          mobileMenu
            .querySelectorAll("a[href^='#'], [data-consultation-trigger]")
            .forEach((item) => item.addEventListener("click", closeMobileMenu));

          document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && !mobileMenu.classList.contains("hidden")) {
              closeMobileMenu();
              menuToggle.focus();
            }
          });
        }
      });


    </script>



    <!-- Custom Scripts (Body End) -->
  
    <div hidden data-consultation-settings data-site-key="{{ $recaptchaSiteKey }}" data-previous-form="{{ old('form_id', session('consultation_form_id')) }}"></div>
    <script src="{{ asset('landing/ghg-service/js/consultation-form.js') }}?v={{ filemtime(public_path('landing/ghg-service/js/consultation-form.js')) }}" defer></script>
  </body>
</html>
