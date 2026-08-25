@extends('frontend.layouts.app', ['bodyClass' => 'home'])

@section('content')

@if(isset($services) && $services->isNotEmpty())
  <div class="sr-only" aria-hidden="true">
    @foreach($services as $item)
      <span>{{ $item->name }}</span>
    @endforeach
  </div>
@endif
@if(isset($projects) && $projects->isNotEmpty())
  <div class="sr-only" aria-hidden="true">
    @foreach($projects as $item)
      <span>{{ $item->title }}</span>
    @endforeach
  </div>
@endif
@if(isset($posts) && $posts->isNotEmpty())
  <div class="sr-only" aria-hidden="true">
    @foreach($posts as $item)
      <span>{{ $item->title }}</span>
    @endforeach
  </div>
@endif

<section
          id="section-613b4656be"
          class="section section-hero relative overflow-hidden"
          style="height: clamp(380px, 55vw, 700px);"
        >
          <!-- Swiper Hero Slider (Load động từ Database) -->
          <div class="swiper swiper-hero-banner w-full h-full" id="hero-swiper">
            <div class="swiper-wrapper">
              @forelse ($sliders as $index => $slide)
              @php
                $imgSrc = str_starts_with($slide->image, 'http')
                    ? $slide->image
                    : (str_starts_with($slide->image, 'uploads/')
                        ? asset('storage/' . $slide->image)
                        : (str_starts_with($slide->image, 'assets/')
                            ? asset($slide->image)
                            : asset('assets/images/' . $slide->image)));
                $slideTitle = $slide->title ?: 'Môi Trường Bảo Châu';
              @endphp
              <div class="swiper-slide">
                @if ($slide->link)
                <a href="{{ $slide->link }}" {!! $slide->open_in_new_tab ? 'target="_blank" rel="noopener noreferrer"' : '' !!} class="block w-full h-full" title="{{ $slideTitle }}">
                  <img
                    src="{{ $imgSrc }}"
                    class="w-full h-full object-cover object-center"
                    width="1536"
                    height="568"
                    alt="{{ $slideTitle }}"
                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                    {!! $index === 0 ? 'fetchpriority="high"' : '' !!}
                    decoding="async"
                  />
                </a>
                @else
                <img
                  src="{{ $imgSrc }}"
                  class="w-full h-full object-cover object-center"
                  width="1536"
                  height="568"
                  alt="{{ $slideTitle }}"
                  loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                  {!! $index === 0 ? 'fetchpriority="high"' : '' !!}
                  decoding="async"
                />
                @endif
              </div>
              @empty
              <div class="swiper-slide">
                <img
                  src="{{ asset("assets/images/slide-1.png") }}"
                  class="w-full h-full object-cover object-center"
                  width="1024"
                  height="379"
                  alt="Công ty TNHH Dịch vụ và Kỹ thuật Môi Trường Bảo Châu"
                  loading="eager"
                  fetchpriority="high"
                  decoding="async"
                />
              </div>
              @endforelse
            </div>

            <!-- Prev / Next arrows (Swiper standard classes) -->
            <div class="swiper-button-prev !w-11 !h-11 !rounded-full !bg-white/70 hover:!bg-white !backdrop-blur-sm !shadow-lg !text-gray-800 after:!text-sm after:!font-black"></div>
            <div class="swiper-button-next !w-11 !h-11 !rounded-full !bg-white/70 hover:!bg-white !backdrop-blur-sm !shadow-lg !text-gray-800 after:!text-sm after:!font-black"></div>

            <!-- Pagination dots (Swiper standard class) -->
            <div class="swiper-pagination" id="hero-pagination"></div>
          </div>

        </section>
        <section id="section-db7ea4e65d" class="relative overflow-hidden">
          <div class="container px-3 mx-auto relative py-10 lg:py-20">
            <div
              class="grid lg:grid-cols-2 grid-cols-1 gap-12 items-center mb-6 md:mb-0"
            >
              <div
                class="px-[8%] sm:px-[12%] flex justify-center items-center relative"
              >
                <!-- Hiệu ứng ánh sáng nền mờ nhẹ (ambient glow) -->
                <div
                  class="absolute w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"
                ></div>
                <img
                  src="{{ asset("assets/images/logo-leave-png-min.png") }}"
                  class="relative bottom-0 lg:-bottom-6 max-w-[400px] w-full h-auto opacity-80 hover:opacity-100 drop-shadow-xl hover:scale-105 transition-all duration-500"
                  width="1024"
                  height="1024"
                  alt="Logo MÔI TRƯỜNG BẢO CHÂU"
                  decoding="async"
                  loading="lazy"
                />
              </div>
              <div>
                <div
                  class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4"
                >
                  <span class="icon-list-icon">
                    <img
                      src="{{ asset("assets/images/asterisk.png") }}"
                      class="size-5"
                      width="24"
                      height="24"
                      alt="Về chúng tôi"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent"
                  >
                    Về chúng tôi
                  </span>
                </div>
                <h2 class="font-bold leading-tight mb-6 lg:mb-8">
                  <span class="text-primary">MÔI TRƯỜNG BẢO CHÂU</span>
                  với sứ mệnh
                </h2>
                <div>
                  <div class="mt-6 lg:mt-8 p-fs-clamp-[15,17]">
                    <p>
                      Giải quyết bài toán tồn tại, phát triển và
                      <span class="font-medium"
                        >tăng trưởng doanh nghiệp bền vững</span
                      >
                      cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI
                      TRƯỜNG BẢO CHÂU.
                    </p>
                    <p>
                      Luôn lấy chữ <span class="font-medium">Tâm</span> để nâng
                      chữ <span class="font-medium">Tầm</span>. Chúng tôi không
                      ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng
                      không ngại đưa ra phương án giải quyết phù hợp cho khách
                      hàng.
                    </p>
                    <p>
                      Đồng hành cùng
                      <span class="text-primary font-medium"
                        >MÔI TRƯỜNG BẢO CHÂU</span
                      >
                      chắc chắn bạn sẽ nhận được sự phục vụ
                      <span class="font-medium">nhiệt tình và tận tâm</span> của
                      toàn đội ngũ được đào tạo trong một môi trường phù hợp văn
                      hóa doanh nghiệp của chúng tôi.
                    </p>
                  </div>
                </div>
                <a
                  class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                  href="#"
                  title="Xem thêm"
                  >Xem thêm<svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                    ></path></svg
                ></a>
              </div>
            </div>
            <div class="w-full flex gap-8 py-6 relative top-0 mt-6 lg:mt-0">
              <div
                class="cards grid lg:grid-cols-3 grid-cols-1 gap-6"
                data-fx-counter=""
                data-once="false"
                data-duration="1500"
              >
                <div
                  class="card-item relative flex flex-col glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-20"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="7"
                    >
                      7
                    </span>
                    +
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    Năm kinh nghiệm
                  </p>
                  <p
                    class="leading-relaxed group-hover:text-black group-focus:text-black"
                  >
                    Chúng tôi luôn tự tin để tư vấn và đưa ra giải pháp phù hợp
                    nhằm giải quyết tất cả các vấn đề khó khăn của doanh nghiệp
                    về Giấy phép Môi trường, Báo cáo ĐTM, Khí nhà kính ESG và Xử
                    lý Nước thải.
                  </p>
                </div>
                <div
                  class="card-item relative glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-10"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="500"
                    >
                      500
                    </span>
                    +
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    Dự án đã hoàn thành
                  </p>
                  <p
                    class="leading-relaxed group-hover:text-black group-focus:text-black"
                  >
                    Hơn 500+ hồ sơ pháp lý, đề án và công trình xử lý môi trường
                    được nghiệm thu đúng hạn, đảm bảo 100% tuân thủ quy định
                    pháp luật BVMT hiện hành.
                  </p>
                </div>
                <div
                  class="card-item relative glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-0"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="30"
                    >
                      30
                    </span>
                    +
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    Chuyên gia &amp; Kỹ sư
                  </p>
                  <p
                    class="leading-relaxed group-hover:text-black group-focus:text-black"
                  >
                    Đội ngũ chuyên gia, kỹ sư công nghệ môi trường giàu kinh
                    nghiệm, <i>tận tâm</i>, <i>nhiệt huyết</i> và luôn đặt uy
                    tín, trách nhiệm lên hàng đầu.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section
          id="section-4bdc829f17"
          class="section section-core-services section-services-bg pt-10 pb-20 md:pb-28 lg:pt-20 lg:pb-40"
        >
          <div class="container px-3 mx-auto z-2 relative">
            <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
              <span class="icon-list-icon">
                <img
                  src="{{ asset("assets/images/asterisk.png") }}"
                  class="size-5"
                  width="24"
                  height="24"
                  alt="Dịch vụ"
                />
              </span>
              <span
                class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent"
              >
                Dịch vụ
              </span>
            </div>
            <h2 class="font-bold leading-tight">
              Các <span class="text-primary">dịch vụ</span> cốt lõi
            </h2>
            <div class="max-w-7xl mb-0 pt-4 lg:pt-6 p-fs-clamp-[15,17]">
              <p>
                Cung cấp hệ sinh thái dịch vụ kỹ thuật và pháp lý môi trường
                toàn diện, giúp doanh nghiệp an tâm sản xuất kinh doanh và phát
                triển bền vững.
              </p>
              <p>
                Từ <i>Tư vấn Giấy phép Môi trường (GPMT, ĐTM)</i>,
                <i>Kiểm kê Khí nhà kính (ESG, CBAM, LCA)</i> đến
                <i>Quan trắc môi trường lao động</i> và
                <i>Xử lý nước thải - khí thải</i> công nghiệp.
              </p>
            </div>
            <div
              class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
            >
              <div class="w-full lg:w-[25%] lg:max-w-xl">
                <ul
                  class="tabs flex flex-col gap-4 sm:gap-5 lg:gap-5 mt-6 lg:mt-8 [&_.is-active>a]:border-primary! [&_.is-active>a]:bg-white! [&_.is-active>a]:shadow-xl! [&_.is-active>a]:shadow-primary/10! [&_.is-active>a]:border-2! [&_.is-active_span.tab-text]:text-primary! [&_.is-active_svg]:text-primary!"
                  data-fx-tabs=""
                  id="services-extra-tabs-4bdc829f17"
                >
                  <li class="tabs-title is-active">
                    <a
                      href="#hoso"
                      class="py-5 px-6 sm:py-6 sm:px-7 lg:py-6.5 lg:px-8 rounded-2xl lg:rounded-3xl bg-white border border-black/8 shadow-sm hover:shadow-lg hover:border-primary/50 transition-all flex items-center gap-5 sm:gap-6 lg:gap-7"
                      aria-selected="true"
                      title="Hồ sơ & Giấy phép Môi trường"
                    >
                      <span class="shrink-0 flex items-center justify-center">
                        <svg
                          class="size-8 sm:size-9 lg:size-10 text-[#334155] transition-colors"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.8"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 2v6h6"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 13h6"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 17h4"
                          />
                        </svg>
                      </span>
                      <span
                        class="tab-text font-bold text-[16px] sm:text-[17.5px] lg:text-[19px] leading-snug text-[#1e293b] transition-colors"
                      >
                        Hồ sơ &amp; Giấy phép Môi trường
                      </span>
                    </a>
                  </li>
                  <li class="tabs-title">
                    <a
                      href="#khi-nha-kinh"
                      class="py-5 px-6 sm:py-6 sm:px-7 lg:py-6.5 lg:px-8 rounded-2xl lg:rounded-3xl bg-white border border-black/8 shadow-sm hover:shadow-lg hover:border-primary/50 transition-all flex items-center gap-5 sm:gap-6 lg:gap-7"
                      aria-selected="false"
                      title="Kiểm kê Khí nhà kính & ESG"
                    >
                      <span class="shrink-0 flex items-center justify-center">
                        <svg
                          class="size-8 sm:size-9 lg:size-10 text-[#334155] transition-colors"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.8"
                          stroke="currentColor"
                        >
                          <circle cx="12" cy="12" r="10" />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2 12h20"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                          />
                        </svg>
                      </span>
                      <span
                        class="tab-text font-bold text-[16px] sm:text-[17.5px] lg:text-[19px] leading-snug text-[#1e293b] transition-colors"
                      >
                        Kiểm kê Khí nhà kính &amp; ESG
                      </span>
                    </a>
                  </li>
                  <li class="tabs-title">
                    <a
                      href="#quan-trac"
                      class="py-5 px-6 sm:py-6 sm:px-7 lg:py-6.5 lg:px-8 rounded-2xl lg:rounded-3xl bg-white border border-black/8 shadow-sm hover:shadow-lg hover:border-primary/50 transition-all flex items-center gap-5 sm:gap-6 lg:gap-7"
                      aria-selected="false"
                      title="Quan trắc Môi trường Lao động"
                    >
                      <span class="shrink-0 flex items-center justify-center">
                        <svg
                          class="size-8 sm:size-9 lg:size-10 text-[#334155] transition-colors"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.8"
                          stroke="currentColor"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9 12 2 2 4-4"
                          />
                        </svg>
                      </span>
                      <span
                        class="tab-text font-bold text-[16px] sm:text-[17.5px] lg:text-[19px] leading-snug text-[#1e293b] transition-colors"
                      >
                        Quan trắc Môi trường Lao động
                      </span>
                    </a>
                  </li>
                  <li class="tabs-title">
                    <a
                      href="#xu-ly-nuoc"
                      class="py-5 px-6 sm:py-6 sm:px-7 lg:py-6.5 lg:px-8 rounded-2xl lg:rounded-3xl bg-white border border-black/8 shadow-sm hover:shadow-lg hover:border-primary/50 transition-all flex items-center gap-5 sm:gap-6 lg:gap-7"
                      aria-selected="false"
                      title="Xử lý Nước thải & Khí thải"
                    >
                      <span class="shrink-0 flex items-center justify-center">
                        <svg
                          class="size-8 sm:size-9 lg:size-10 text-[#334155] transition-colors"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke-width="1.8"
                          stroke="currentColor"
                        >
                          <circle cx="12" cy="12" r="4" />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41m14.14-14.14l-1.41 1.41"
                          />
                        </svg>
                      </span>
                      <span
                        class="tab-text font-bold text-[16px] sm:text-[17.5px] lg:text-[19px] leading-snug text-[#1e293b] transition-colors"
                      >
                        Xử lý Nước thải &amp; Khí thải
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="w-full flex-1">
                <div
                  class="tabs-content mt-6 lg:mt-8"
                  data-fx-tabs-content="services-extra-tabs-4bdc829f17"
                >
                  <div class="tabs-panel is-active" id="hoso">
                    <div
                      class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
                    >
                      <div class="w-full lg:w-7/12">
                        <div
                          class="thumb w-full overflow-hidden rounded-2xl shadow-xl shadow-black/10"
                        >
                          <img
                            src="{{ asset("assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png") }}"
                            class="block object-cover w-full h-full rounded-2xl"
                            width="1024"
                            height="576"
                            alt="Tư vấn Hồ sơ & Giấy phép Môi trường"
                            decoding="async"
                            loading="lazy"
                          />
                        </div>
                      </div>
                      <div class="w-full lg:w-5/12">
                        <div
                          class="mb-5 lg:mb-6 p-fs-clamp-[18,28] font-bold uppercase leading-[1.3]"
                        >
                          Tư vấn
                          <span class="text-primary"
                            >Hồ sơ &amp; Giấy phép</span
                          >
                          Môi trường
                        </div>
                        <div class="leading-[1.7] p-fs-clamp-[15,17]">
                          <p class="mb-3">
                            Các thủ tục pháp lý môi trường theo Luật BVMT 2020
                            đòi hỏi quy trình lập hồ sơ khắt khe, chặt chẽ và
                            chuẩn xác cao.
                          </p>
                          <p>
                            Môi Trường Bảo Châu cung cấp giải pháp trọn gói: Lập
                            Báo cáo đánh giá tác động môi trường (ĐTM), Giấy
                            phép môi trường (GPMT), Đăng ký môi trường, Giấy
                            phép khai thác nước dưới đất... Đội ngũ chuyên gia
                            giàu kinh nghiệm hỗ trợ từ khảo sát, phân tích mẫu,
                            lập hồ sơ đến bảo vệ hội đồng thẩm định và bàn giao
                            giấy phép nhanh nhất.
                          </p>
                        </div>
                        <a
                          href="#"
                          class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                          title="Liên hệ ngay"
                        >
                          <span>Xem thêm</span>
                          <svg
                            class="size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="tabs-panel" id="khi-nha-kinh">
                    <div
                      class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
                    >
                      <div class="w-full lg:w-7/12">
                        <div
                          class="thumb w-full overflow-hidden rounded-2xl shadow-xl shadow-black/10"
                        >
                          <img
                            src="{{ asset("assets/images/Bai-Dang-Bao-Chau-1024x572.png") }}"
                            class="block object-cover w-full h-full rounded-2xl"
                            width="1024"
                            height="572"
                            alt="Kiểm kê Khí nhà kính & ESG"
                            decoding="async"
                            loading="lazy"
                          />
                        </div>
                      </div>
                      <div class="w-full lg:w-5/12">
                        <div
                          class="mb-5 lg:mb-6 p-fs-clamp-[18,28] font-bold uppercase leading-[1.3]"
                        >
                          Kiểm kê
                          <span class="text-primary">Khí nhà kính</span> &amp;
                          ESG
                        </div>
                        <div class="leading-[1.7] p-fs-clamp-[15,17]">
                          <p class="mb-3">
                            Xu hướng chuyển đổi xanh và các rào cản quốc tế
                            (CBAM châu Âu, tiêu chuẩn ISO 14064, ISO 14067) đặt
                            ra yêu cầu cấp thiết về báo cáo phát thải cho các
                            doanh nghiệp sản xuất và xuất khẩu.
                          </p>
                          <p>
                            Bảo Châu đồng hành kiểm kê khí nhà kính toàn diện
                            (Phạm vi 1, 2, 3), tính toán dấu chân carbon (LCA),
                            lập hồ sơ CBAM và báo cáo phát triển bền vững ESG,
                            giúp doanh nghiệp tối ưu chi phí năng lượng và nâng
                            cao năng lực cạnh tranh toàn cầu.
                          </p>
                        </div>
                        <a
                          href="#"
                          class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                          title="Liên hệ ngay"
                        >
                          <span>Xem thêm</span>
                          <svg
                            class="size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="tabs-panel" id="quan-trac">
                    <div
                      class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
                    >
                      <div class="w-full lg:w-7/12">
                        <div
                          class="thumb w-full overflow-hidden rounded-2xl shadow-xl shadow-black/10"
                        >
                          <img
                            src="{{ asset("assets/images/Hinh-1-1024x683.jpg") }}"
                            class="block object-cover w-full h-full rounded-2xl"
                            width="1024"
                            height="683"
                            alt="Quan trắc Môi trường Lao động"
                            decoding="async"
                            loading="lazy"
                          />
                        </div>
                      </div>
                      <div class="w-full lg:w-5/12">
                        <div
                          class="mb-5 lg:mb-6 p-fs-clamp-[18,28] font-bold uppercase leading-[1.3]"
                        >
                          Quan trắc
                          <span class="text-primary">Môi trường</span> Lao động
                        </div>
                        <div class="leading-[1.7] p-fs-clamp-[15,17]">
                          <p class="mb-3">
                            Môi trường lao động an toàn, trong lành là nền tảng
                            bảo vệ sức khỏe công nhân viên và đáp ứng đầy đủ quy
                            chuẩn kỹ thuật an toàn vệ sinh lao động theo quy
                            định pháp luật.
                          </p>
                          <p>
                            Chúng tôi trang bị thiết bị đo kiểm hiện đại: đo vi
                            khí hậu, bụi, tiếng ồn, ánh sáng, rung động, hơi khí
                            độc hại tại vị trí làm việc, quan trắc định kỳ khí
                            thải và nước thải nhà máy, lập hồ sơ vệ sinh lao
                            động chuẩn chỉnh, hợp pháp.
                          </p>
                        </div>
                        <a
                          href="#"
                          class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                          title="Liên hệ ngay"
                        >
                          <span>Xem thêm</span>
                          <svg
                            class="size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="tabs-panel" id="xu-ly-nuoc">
                    <div
                      class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
                    >
                      <div class="w-full lg:w-7/12">
                        <div
                          class="thumb w-full overflow-hidden rounded-2xl shadow-xl shadow-black/10"
                        >
                          <img
                            src="{{ asset("assets/images/CTY-TAN-TIEN-1024x640.png") }}"
                            class="block object-cover w-full h-full rounded-2xl"
                            width="1024"
                            height="640"
                            alt="Xử lý Nước thải & Khí thải"
                            decoding="async"
                            loading="lazy"
                          />
                        </div>
                      </div>
                      <div class="w-full lg:w-5/12">
                        <div
                          class="mb-5 lg:mb-6 p-fs-clamp-[18,28] font-bold uppercase leading-[1.4]"
                        >
                          Xử lý
                          <span class="text-primary"
                            >Nước thải &amp; Khí thải</span
                          >
                        </div>
                        <div class="leading-[1.7] p-fs-clamp-[15,17]">
                          <p class="mb-3">
                            Hệ thống xử lý lỗi thời, không đạt chuẩn đầu ra gây
                            nguy cơ bị xử phạt nặng và ảnh hưởng uy tín sản xuất
                            kinh doanh của nhà máy.
                          </p>
                          <p>
                            Môi Trường Bảo Châu chuyên thiết kế, thi công, cải
                            tạo và chuyển giao công nghệ xử lý nước thải sinh
                            hoạt, công nghiệp (dệt nhuộm, thực phẩm, xi mạ, bao
                            bì...) và xử lý bụi, khí thải. Ứng dụng công nghệ
                            màng MBR, vi sinh tiên tiến, đảm bảo nước đầu ra đạt
                            chuẩn QCVN với chi phí đầu tư và vận hành tối ưu
                            nhất.
                          </p>
                        </div>
                        <a
                          href="#"
                          class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                          title="Liên hệ ngay"
                        >
                          <span>Xem thêm</span>
                          <svg
                            class="size-4"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- PROJECT FILTER & LIST GRID SECTION (3x3 TABS & FULL-WIDTH GRID ĐỒNG BỘ TRANG DỰ ÁN) -->
        <section
          id="section-2e070d0c2f"
          class="section section-projects py-10 lg:py-20"
        >
          <div class="container px-3 mx-auto z-2 relative">
            <div class="w-full text-center max-w-4xl mx-auto">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Dự án"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  Dự án
                </span>
              </div>
              <h2 class="project-title font-bold leading-tight text-3xl sm:text-4xl lg:text-5xl text-gray-900 mb-4">
                Dự án <span class="text-1">tiêu biểu</span>
              </h2>
              <p
                class="project-desc max-w-3xl mx-auto pt-2 mb-8 lg:mb-12 p-fs-clamp-[15,17] text-gray-600 leading-relaxed"
              >
                Tổng hợp các dự án tư vấn hồ sơ môi trường, kiểm kê khí nhà kính
                ESG, thiết kế thi công hệ thống xử lý nước thải và quan trắc môi
                trường tiêu biểu do Môi Trường Bảo Châu trực tiếp triển khai cho
                các tập đoàn, nhà máy và khu công nghiệp trên toàn quốc.
              </p>
            </div>
          </div>
          <div
            class="container px-3 mx-auto z-2 relative home-projects-filters"
            data-limit="9"
            data-title-tag="h3"
          >
            <!-- TOP HORIZONTAL TAB PILLS -->
            <div class="filter-menu mb-10 lg:mb-14">
              <style>
                .home-projects-filters .filter-ul {
                  display: flex;
                  flex-wrap: wrap;
                  align-items: center;
                  justify-content: center;
                  gap: 10px 12px;
                  list-style: none !important;
                  padding: 0 !important;
                  margin: 0 !important;
                }
                .home-projects-filters .filter-ul li {
                  list-style: none !important;
                  margin: 0 !important;
                  padding: 0 !important;
                }
                .home-projects-filters .filter-ul a {
                  display: inline-flex;
                  align-items: center;
                  justify-content: center;
                  gap: 6px;
                  padding: 9px 22px;
                  border-radius: 9999px;
                  background-color: #f1f2f4;
                  color: #374151 !important;
                  font-weight: 500;
                  font-size: 14px;
                  text-decoration: none;
                  transition: all 0.25s ease-in-out;
                  border: 1px solid transparent;
                  outline: none;
                }
                .home-projects-filters .filter-ul a::before,
                .home-projects-filters .filter-ul a::after,
                .home-projects-filters .filter-ul li::before,
                .home-projects-filters .filter-ul li::after {
                  display: none !important;
                  content: none !important;
                  width: 0 !important;
                  height: 0 !important;
                  opacity: 0 !important;
                  visibility: hidden !important;
                }
                .home-projects-filters .filter-ul a:hover {
                  background-color: #e5e7eb;
                  color: #111827 !important;
                }
                .home-projects-filters .filter-ul a.active {
                  background-color: #fe5242 !important;
                  color: #ffffff !important;
                  font-weight: 700 !important;
                  box-shadow: 0 8px 20px rgba(254, 82, 66, 0.35) !important;
                }
                .home-projects-filters .filter-ul a.active .filter-count {
                  color: rgba(255, 255, 255, 0.9) !important;
                }
                .home-projects-filters .filter-count {
                  font-size: 12px;
                  color: #6b7280;
                  font-weight: normal;
                }
              </style>
              <ul class="filter-ul">
                <li>
                  <a href="#" class="active" data-filter="-1">
                    Tất cả <span class="filter-count">(9)</span>
                  </a>
                </li>
                <li>
                  <a href="#" data-filter="giay-phep">
                    Giấy phép Môi trường <span class="filter-count">(3)</span>
                  </a>
                </li>
                <li>
                  <a href="#" data-filter="dtm">
                    Báo cáo ĐTM <span class="filter-count">(2)</span>
                  </a>
                </li>
                <li>
                  <a href="#" data-filter="khi-nha-kinh">
                    Khí nhà kính &amp; ESG <span class="filter-count">(2)</span>
                  </a>
                </li>
                <li>
                  <a href="#" data-filter="xu-ly-nuoc">
                    Xử lý Nước &amp; Khí thải
                    <span class="filter-count">(1)</span>
                  </a>
                </li>
                <li>
                  <a href="#" data-filter="quan-trac">
                    Quan trắc Môi trường <span class="filter-count">(1)</span>
                  </a>
                </li>
              </ul>
            </div>

            <!-- PROJECTS GRID 3 X 3 (9 DỰ ÁN TIÊU BIỂU) -->
            <div class="filter-content w-full">
              <div
                class="filter-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8"
              >
                <!-- Project 1: BERICAP -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="giay-phep"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="DỰ ÁN GIẤY PHÉP MÔI TRƯỜNG NHÀ MÁY BERICAP"
                    >
                      <img
                        src="{{ asset("assets/images/BERICAP.jpg") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="683"
                        alt="DỰ ÁN GIẤY PHÉP MÔI TRƯỜNG NHÀ MÁY BERICAP"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Long Thành - Đồng Nai
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Giấy phép Môi trường</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="DỰ ÁN GIẤY PHÉP MÔI TRƯỜNG NHÀ MÁY BERICAP"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Dự Án Giấy Phép Môi Trường Nhà Máy BERICAP Việt Nam
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Tư vấn lập hồ sơ đề nghị cấp Giấy phép môi trường cấp Bộ
                        Tài nguyên và Môi trường cho nhà máy sản xuất bao bì
                        nhựa chính xác quy mô lớn.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Quy mô: 25.000 m²</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 2: PEPSICO -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="khi-nha-kinh"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="DỰ ÁN KIỂM KÊ KHÍ NHÀ KÍNH CÔNG TY PEPSICO"
                    >
                      <img
                        src="{{ asset("assets/images/PEPSICO.jpg") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="683"
                        alt="DỰ ÁN KIỂM KÊ KHÍ NHÀ KÍNH CÔNG TY PEPSICO"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Sóng Thần - Bình Dương
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Khí nhà kính &amp; ESG</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="DỰ ÁN KIỂM KÊ KHÍ NHÀ KÍNH CÔNG TY PEPSICO"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho PepsiCo
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Xác định phạm vi phát thải Scope 1, 2, 3, xây dựng báo
                        cáo kiểm kê khí nhà kính và lộ trình giảm phát thải Net
                        Zero theo chuẩn quốc tế.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Chuẩn: ISO 14064-1:2018</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 3: CÔNG TY TÂN TIẾN -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="dtm"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="BÁO CÁO ĐTM NHÀ MÁY BAO BÌ NHỰA TÂN TIẾN"
                    >
                      <img
                        src="{{ asset("assets/images/CTY-TAN-TIEN.png") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="640"
                        alt="BÁO CÁO ĐTM NHÀ MÁY BAO BÌ NHỰA TÂN TIẾN"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Tân Bình - TP.HCM
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Báo cáo ĐTM</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2023</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="BÁO CÁO ĐTM NHÀ MÁY BAO BÌ NHỰA TÂN TIẾN"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Báo Cáo Đánh Giá Tác Động Môi Trường ĐTM Nhựa Tân Tiến
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Lập báo cáo ĐTM dự án mở rộng nhà xưởng sản xuất màng
                        ghép phức hợp, bảo vệ thành công trước Hội đồng thẩm
                        định Sở TN&amp;MT TP.HCM.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Công suất: 50.000 tấn/năm</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 4: CERAGEM -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="xu-ly-nuoc"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="XỬ LÝ NƯỚC THẢI & KHÍ THẢI CERAGEM VIỆT NAM"
                    >
                      <img
                        src="{{ asset("assets/images/5.-ceragem-1024x683.jpg") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="683"
                        alt="XỬ LÝ NƯỚC THẢI & KHÍ THẢI CERAGEM VIỆT NAM"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN VSIP II - Bình Dương
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Xử lý Nước &amp; Khí thải</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="XỬ LÝ NƯỚC THẢI & KHÍ THẢI CERAGEM VIỆT NAM"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Hệ Thống Xử Lý Nước Thải &amp; Khí Thải Ceragem Vina
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Thiết kế, thi công và chuyển giao công nghệ trạm xử lý
                        nước thải sinh hoạt - sản xuất đạt chuẩn Cột A QCVN
                        40:2011/BTNMT kết hợp lọc bụi khí thải.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Công suất: 350 m³/ngày đêm</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 5: MITSUBISHI -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="quan-trac"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="QUAN TRẮC MÔI TRƯỜNG LAO ĐỘNG MITSUBISHI"
                    >
                      <img
                        src="{{ asset("assets/images/Hinh-1-1024x683.jpg") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="683"
                        alt="QUAN TRẮC MÔI TRƯỜNG LAO ĐỘNG MITSUBISHI"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      Bình Dương - TP.HCM
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Quan trắc Môi trường</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Định kỳ 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="QUAN TRẮC MÔI TRƯỜNG LAO ĐỘNG MITSUBISHI"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Quan Trắc Môi Trường Lao Động &amp; Khí Thải Định Kỳ
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Thực hiện đo đạc các yếu tố vi khí hậu, tiếng ồn, ánh
                        sáng, bụi và phân tích mẫu nước thải định kỳ 4 đợt/năm
                        cho hệ thống chuỗi nhà máy.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Hơn 120 vị trí đo đạc</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 6: BIDRICO -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="giay-phep"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="GIẤY PHÉP MÔI TRƯỜNG NƯỚC GIẢI KHÁT BIDRICO"
                    >
                      <img
                        src="{{ asset("assets/images/Bai-Dang-Bao-Chau-1024x572.png") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="572"
                        alt="GIẤY PHÉP MÔI TRƯỜNG NƯỚC GIẢI KHÁT BIDRICO"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Vĩnh Lộc - TP.HCM
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Giấy phép Môi trường</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="GIẤY PHÉP MÔI TRƯỜNG NƯỚC GIẢI KHÁT BIDRICO"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Cấp Giấy Phép Môi Trường Nhà Máy Nước Giải Khát
                          Bidrico
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Tư vấn chuyển đổi hồ sơ ĐTM cũ sang Giấy phép môi trường
                        theo Luật BVMT 2020, hoàn thiện tích hợp xả nước thải và
                        khí thải lò hơi.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Cơ quan cấp: UBND TP.HCM</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 7: CJ FOODS -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="giay-phep"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="GIẤY PHÉP MÔI TRƯỜNG TỔ HỢP CJ FOODS"
                    >
                      <img
                        src="{{ asset("assets/images/moi-truong-bao-chau-1024x603.jpg") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="603"
                        alt="GIẤY PHÉP MÔI TRƯỜNG TỔ HỢP CJ FOODS"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Hiệp Phước - TP.HCM
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Giấy phép Môi trường</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="GIẤY PHÉP MÔI TRƯỜNG TỔ HỢP CJ FOODS"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Giấy Phép Môi Trường Tổ Hợp Sản Xuất Thực Phẩm CJ
                          Foods
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Tư vấn hoàn thiện hồ sơ nghiệm thu công trình bảo vệ môi
                        trường và cấp Giấy phép môi trường tích hợp xả thải công
                        suất lớn.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Quy mô: 40.000 m²</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 8: LOCK&LOCK -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="dtm"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="BÁO CÁO ĐTM NHÀ MÁY LOCK&LOCK"
                    >
                      <img
                        src="{{ asset("assets/images/Thiet-ke-chua-co-ten-2-768x429.png") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="768"
                        height="429"
                        alt="BÁO CÁO ĐTM NHÀ MÁY LOCK&LOCK"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      KCN Mỹ Xuân A2 - BR-VT
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Báo cáo ĐTM</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="BÁO CÁO ĐTM NHÀ MÁY LOCK&LOCK"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Báo Cáo ĐTM Mở Rộng Nhà Máy Sản Xuất Gia Dụng
                          Lock&amp;Lock
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Lập báo cáo đánh giá tác động môi trường giai đoạn 2
                        nâng công suất dây chuyền ép nhựa và sơn tĩnh điện, phê
                        duyệt đúng tiến độ.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Công suất: 15.000 tấn/năm</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Project 9: VINAMILK -->
                <div
                  class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                  data-category="khi-nha-kinh"
                >
                  <div
                    class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                  >
                    <a
                      class="block w-full h-full c-scale-effect"
                      href="{{ route("projects.index") }}"
                      aria-label="KIỂM KÊ KHÍ NHÀ KÍNH & ESG VINAMILK"
                    >
                      <img
                        src="{{ asset("assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png") }}"
                        class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        width="1024"
                        height="576"
                        alt="KIỂM KÊ KHÍ NHÀ KÍNH & ESG VINAMILK"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                    <span
                      class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                    >
                      Bình Dương &amp; Cần Thơ
                    </span>
                  </div>
                  <div class="p-content flex flex-col flex-1 justify-between">
                    <div>
                      <div
                        class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                      >
                        <span
                          class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                          >Khí nhà kính &amp; ESG</span
                        >
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành 2024</span
                        >
                      </div>
                      <a
                        class="c-hover block"
                        href="{{ route("projects.index") }}"
                        title="KIỂM KÊ KHÍ NHÀ KÍNH & ESG VINAMILK"
                      >
                        <h3
                          class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug"
                        >
                          Tư Vấn Khí Nhà Kính &amp; Lộ Trình ESG Cho Chuỗi
                          Vinamilk
                        </h3>
                      </a>
                      <p
                        class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                      >
                        Kiểm kê phát thải KNK chuỗi nhà máy chế biến sữa, xây
                        dựng chỉ số carbon footprint trên từng đơn vị sản phẩm
                        và lộ trình Net Zero.
                      </p>
                    </div>
                    <div
                      class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                    >
                      <span class="text-xs text-black font-medium truncate"
                        >Chuẩn: ISO 14064 &amp; GHG</span
                      >
                      <a
                        href="{{ route("projects.index") }}"
                        class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                      >
                        Xem chi tiết
                        <svg
                          class="size-3.5"
                          fill="none"
                          viewBox="0 0 24 24"
                          stroke="currentColor"
                          stroke-width="2"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m8.25 4.5 7.5 7.5-7.5 7.5"
                          />
                        </svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- BUTTON XEM TẤT CẢ DỰ ÁN -->
              <div class="text-center mt-10 lg:mt-14">
                <a
                  title="Xem tất cả dự án"
                  href="{{ route("projects.index") }}"
                  class="button-link btn btn-primary-1 shadow-xl shadow-white/10 hover:shadow-lg hover:shadow-white/30 inline-flex items-center gap-2"
                >
                  Xem tất cả dự án
                  <svg
                    class="size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                    ></path>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </section>
        <section
          id="section-de0db3881d"
          class="section section-recent-posts py-10 lg:py-20"
          data-categories="[5,6,12]"
          data-limit="6"
          data-title-tag="p"
          data-view-more-url="https://webhd.vn/tin-tuc/"
          data-view-more-title="Xem thêm"
        >
          <div class="container px-3 mx-auto">
            <div
              class="all_title_recent_post flex flex-row flex-wrap items-center justify-between gap-6"
            >
              <div class="title_top">
                <div
                  class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4"
                >
                  <span class="icon-list-icon">
                    <img
                      src="{{ asset("assets/images/asterisk.png") }}"
                      class="size-5"
                      width="24"
                      height="24"
                      alt="Tin tức"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent"
                  >
                    Tin tức
                  </span>
                </div>
                <h2 class="font-bold leading-tight">
                  <span class="text-1">Bài viết</span> mới cập nhật
                </h2>
              </div>
              <ul
                class="filter-ul filter-ul-news flex flex-row flex-wrap items-center gap-2 sm:gap-3 lg:gap-4"
                data-active-class="bg-primary text-white"
                data-inactive-class="bg-black/8 hover:bg-primary text-black/80 hover:text-white"
              >
                <li class="shrink-0">
                  <a
                    href="#"
                    class="active inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-bold whitespace-nowrap c-hover bg-primary text-white shadow-xs transition-all"
                    data-filter="-1"
                    >Tất cả</a
                  >
                </li>
                @foreach ($postCategories as $cat)
                <li class="shrink-0">
                  <a
                    class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold whitespace-nowrap c-hover bg-black/8 hover:bg-primary text-black/80 hover:text-white transition-all"
                    href="#"
                    data-filter="{{ $cat->slug }}"
                    >{{ $cat->name }}</a
                  >
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="w-full 2xl:max-w-[95%] px-3 mx-auto">
            <div class="p-news-list mt-9">
              <div class="filter-content-news">
                <!-- Tab Pane: Tất cả -->
                <div class="news-tab-pane" data-pane="-1">
                  @include('frontend.partials.news-grid-set', ['posts' => $posts])
                </div>

                <!-- Tab Panes: Từng danh mục -->
                @foreach ($postCategories as $cat)
                <div class="news-tab-pane" data-pane="{{ $cat->slug }}" style="display: none;">
                  @if ($cat->posts->isNotEmpty())
                    @include('frontend.partials.news-grid-set', ['posts' => $cat->posts])
                  @else
                    <div class="text-center py-12 text-gray-500 font-medium">
                      Chưa có bài viết nào trong danh mục này.
                    </div>
                  @endif
                </div>
                @endforeach
              </div>
                <div class="relative flex justify-center">
                  <a
                    class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 inline-flex! mt-8"
                    href="{{ route('posts.index') }}"
                    title="Xem thêm"
                    >Xem thêm<svg
                      class="size-4"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                      ></path></svg
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section
          id="section-cb80cc5ab6"
          class="section section-feedback py-10 lg:py-20"
        >
          <div class="container px-3 mx-auto">
            <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
              <span class="icon-list-icon">
                <img
                  src="{{ asset("assets/images/asterisk.png") }}"
                  class="size-5"
                  width="24"
                  height="24"
                  alt="Đánh giá"
                />
              </span>
              <span
                class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent"
              >
                Đánh giá
              </span>
            </div>
            <h2 class="font-bold leading-tight">
              <span class="text-1">Khách hàng</span> nói gì về chúng tôi
            </h2>
            <div class="swiper-container relative">
              <div class="swiper swiper-main py-6! lg:py-8!" data-fx-slider="">
                <div
                  class="swiper-marquee swiper-wrapper"
                  data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"pagination":"bullets","mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                >
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="In Minh Khang"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            In Minh Khang
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/innhanhminhkhang.webp") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="1918"
                              height="392"
                              alt="In Minh Khang"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Môi Trường Bảo Châu đã hỗ trợ nhà máy chúng tôi hoàn
                          thành hồ sơ Giấy phép Môi trường rất nhanh chóng và
                          chuyên nghiệp. Đội ngũ kỹ sư am hiểu luật, tận tâm và
                          giải quyết vướng mắc rất hiệu quả.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Đỗ Thị Chí Hậu</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/PwuyTg2VsWBEJtFHm"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Bình Minh Toàn Cầu"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Bình Minh Toàn Cầu
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/breadtalkvietnam.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="648"
                              height="156"
                              alt="Bình Minh Toàn Cầu"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Dịch vụ kiểm kê khí nhà kính và tư vấn ESG của Bảo
                          Châu rất chi tiết, chuẩn xác theo tiêu chuẩn quốc tế
                          ISO 14064. Báo cáo rõ ràng, hỗ trợ đối chiếu số liệu
                          tận tình.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Phúc Nguyễn</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/U5OCbXDUWuu8KiEGF"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="V-Holdings"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            V-Holdings
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/v-holdings.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="225"
                              height="192"
                              alt="V-Holdings"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Hệ thống xử lý nước thải 500m³/ngày do Bảo Châu thiết
                          kế và thi công vận hành cực kỳ ổn định, nước đầu ra
                          luôn đạt chuẩn QCVN 40 cột A, chi phí hóa chất tiết
                          kiệm đáng kể.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Hà Thuận</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/YC065ETKlBCG2opUk"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Tân Quang Minh"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Tân Quang Minh
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/bidrico.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="522"
                              height="264"
                              alt="Tân Quang Minh"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Chi phí tư vấn hồ sơ ĐTM và Giấy phép môi trường tại
                          Bảo Châu rất hợp lý, minh bạch và không phát sinh. Đội
                          ngũ chuyên gia hỗ trợ giải trình với đoàn thẩm định
                          rất xuất sắc.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Bùi Phương Loan</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/LspJ1c9ifp0DlagxM"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Thiết Bị Công Nghệ Năng Lực"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Thiết Bị Công Nghệ Năng Lực
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/nangluc.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="358"
                              height="128"
                              alt="Thiết Bị Công Nghệ Năng Lực"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Khi hợp tác với MÔI TRƯỜNG BẢO CHÂU trong dự án quan
                          trắc môi trường lao động và lập bản đồ tiếng ồn, chúng
                          tôi hoàn toàn yên tâm về sự chính xác, quy trình đo
                          đạc bài bản và nhanh chóng.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Trần Chí Hiếu</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/BUjKxg1ooqeAVHFhA"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Kiến Trúc Xây Dựng AHD"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Kiến Trúc Xây Dựng AHD
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/2-1-768x427.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="768"
                              height="427"
                              alt="Kiến Trúc Xây Dựng AHD"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Tôi rất hài lòng với dịch vụ tư vấn cơ chế CBAM và
                          đánh giá vòng đời sản phẩm LCA của Môi Trường Bảo
                          Châu. Nhờ đó lô hàng xuất khẩu sang EU của chúng tôi
                          đã thông quan thuận lợi.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Bùi Thị Quỳnh Nhi</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/Xl0iQs3xqZSJJHsqW"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Sạch Store"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Sạch Store
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/sachstore.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="500"
                              height="497"
                              alt="Sạch Store"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Doanh nghiệp chúng tôi ban đầu rất lo lắng về các quy
                          định mới của Luật Bảo vệ Môi trường 2020. Nhờ Bảo Châu
                          tư vấn tận tình, toàn bộ hồ sơ cấp phép đã được phê
                          duyệt suôn sẻ.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Nguyễn Nhất Sinh</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/BSsiI53iMgG7P5Iex"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Trung Tâm Giáo Dục Nghề Nghiệp Mỹ Nghệ Kim Hoàn"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Trung Tâm Giáo Dục Nghề Nghiệp Mỹ Nghệ Kim Hoàn
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/daynghekimhoan.jpg") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="741"
                              height="693"
                              alt="Trung Tâm Giáo Dục Nghề Nghiệp Mỹ Nghệ Kim Hoàn"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Chúng tôi và Môi Trường Bảo Châu đã hợp tác hơn 5 năm
                          nay trong các đợt quan trắc môi trường định kỳ. Rất
                          tin tưởng năng lực, uy tín và sự nhiệt tình của đội
                          ngũ kỹ sư.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Trung Tâm Dạy nghề Kim Hoàn</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/v5Wx34UJeESzs6ZZE"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Kami Nail Academy"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Kami Nail Academy
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/kaminail.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="945"
                              height="918"
                              alt="Kami Nail Academy"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Đã hợp tác nhiều dự án xử lý nước thải và khí thải
                          với Bảo Châu. Rất hài lòng về chất lượng công trình,
                          tiến độ thi công chuẩn xác và dịch vụ hậu mãi, bảo trì
                          cực kỳ chu đáo.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Bella</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/VulCXrccTwnV1OrSQ"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Kỹ Thuận Lạnh Quảng Long"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Kỹ Thuận Lạnh Quảng Long
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/thosuachuaviet.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="232"
                              height="126"
                              alt="Kỹ Thuận Lạnh Quảng Long"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Chân thành cảm ơn đội ngũ MÔI TRƯỜNG BẢO CHÂU đã hỗ
                          trợ hết sức nhiệt tình trong đợt thanh kiểm tra môi
                          trường vừa qua. Tác phong làm việc nhanh nhẹn và
                          chuyên môn rất vững vàng.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Long - Điện lạnh Quảng Long</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/sxHVPSTIwn4VtN4Ne"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Laptop TÈO EM"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Laptop TÈO EM
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/laptopgaming.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="2239"
                              height="1952"
                              alt="Laptop TÈO EM"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Nhà máy chúng tôi nằm trong diện phải kiểm kê khí nhà
                          kính bắt buộc. Nhờ Bảo Châu hướng dẫn thu thập dữ liệu
                          và tính toán phát thải, báo cáo đã hoàn thành đúng hạn
                          quy định.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Dương Minh Tâm</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/GT1DEqTVvjHeIgC27"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Nha Khoa Thanh Tâm"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Nha Khoa Thanh Tâm
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/nhakhoathanhtam.webp") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="1920"
                              height="557"
                              alt="Nha Khoa Thanh Tâm"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Dịch vụ tư vấn môi trường hỗ trợ nhiệt tình, giải
                          pháp kỹ thuật tối ưu và chi phí rất cạnh tranh.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Thị Lệ Hường Dương</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/D0EHbPAZVOd2J7Bu7"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Nha Khoa Anna"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Nha Khoa Anna
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/nhakhoaanna.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="284"
                              height="69"
                              alt="Nha Khoa Anna"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Đơn vị môi trường chuyên nghiệp, uy tín! Bên mình đã
                          thực hiện nhiều gói hồ sơ ĐTM và Giấy phép môi trường
                          ở đây, dịch vụ tận tâm và đáng tin cậy.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Chị Võ Thị Thu Thùy</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/Rmdp4mY8UKRt650xk"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="BBRACING"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            BBRACING
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/bbracing.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="2501"
                              height="701"
                              alt="BBRACING"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Kỹ thuật môi trường chuyên nghiệp. Dịch vụ rất tốt.
                          Tư vấn chu đáo, pháp lý vững vàng và luôn đồng hành
                          cùng khách hàng.</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Phú Minh</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/SOAgpl3N2lddSnwxk"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Nước Hoa Chính Hãng – MISS LUXURY"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Nước Hoa Chính Hãng – MISS LUXURY
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/missluxury.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="240"
                              height="168"
                              alt="Nước Hoa Chính Hãng – MISS LUXURY"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Hỗ trợ tận tình, xử lý hồ sơ nhanh gọn, đo đạc quan
                          trắc chính xác và nghiệm thu đúng hạn!</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Lê Khoa</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/hdsigoQr0dqrZnSPy"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="TRUNG THÁI"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            TRUNG THÁI
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/nongnghieptrungthai.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="180"
                              height="178"
                              alt="TRUNG THÁI"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Đội ngũ rất chuyên nghiệp - làm việc rất có tâm và
                          trách nhiệm. Cám ơn MÔI TRƯỜNG BẢO CHÂU đã đồng hành
                          cùng nhà máy chúng tôi suốt thời gian qua!</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Thái - Nông nghiệp Trung Thái</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/gqu6U4uDlvVnHrGA7"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Bencat USA"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Bencat USA
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/bencatusa.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="300"
                              height="60"
                              alt="Bencat USA"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Các bạn rất nhiệt tình &amp; tận tâm trong công
                          việc... Thank you!</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Bến Cát USA</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/Fey3kprloQ8FFdXOl"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Kế toán Sao Kim"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Kế toán Sao Kim
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/ketoansaokim.webp") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="413"
                              height="100"
                              alt="Kế toán Sao Kim"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Các bạn rất nhiệt tình &amp; tận tâm trong công
                          việc... Thank you!</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Mạnh Sầm</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/inHHPmLZDlOkLpJSu"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="DOCHI HOME"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            DOCHI HOME
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/dochihome.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="1920"
                              height="444"
                              alt="DOCHI HOME"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >làm rất chuyên nghiệp và giá hợp lý</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Lê Văn Đô</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/xXX8JE1bFnmbxvBX5"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Recolor"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Recolor
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/vuabaobigiay.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="1920"
                              height="708"
                              alt="Recolor"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >Hỗ trợ rất nhiệt tình nha ^^</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Anh Văn Tây</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/1FcImvDBuWCribbqC"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Bao Bì Thành Tiến"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Bao Bì Thành Tiến
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/baobithanhtien.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="800"
                              height="187"
                              alt="Bao Bì Thành Tiến"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >MÔI TRƯỜNG BẢO CHÂU làm việc rất uy tín - Chuyên
                          nghiệp</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Xưởng in bao bì Thành Tiến</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/daDAvcCfbY8npulqf"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-slide">
                    <div
                      class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                    >
                      <div class="flex-none icon">
                        <div
                          class="flex items-center justify-between flex-nowrap gap-2"
                          title="Thiết bị chữa cháy Miền Nam"
                        >
                          <span
                            class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                          >
                            Thiết bị chữa cháy Miền Nam
                          </span>
                          <span class="flex-none block">
                            <img
                              src="{{ asset("assets/images/thietbichuachaymiennam.png") }}"
                              class="pointer-events-none block w-auto h-10 object-contain"
                              width="306"
                              height="345"
                              alt="Thiết bị chữa cháy Miền Nam"
                              loading="lazy"
                            />
                          </span>
                        </div>
                      </div>
                      <blockquote
                        class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                      >
                        <span class="line-clamp-6"
                          >MÔI TRƯỜNG BẢO CHÂU làm việc rất Uy tín - Chuyên
                          nghiệp</span
                        >
                      </blockquote>
                      <div
                        class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                      >
                        <div>
                          <p class="text-black mb-1">
                            <span
                              class="text-base leading-[1.4em] font-medium capitalize mb-0"
                              >Thiết bị chữa cháy Miền Nam</span
                            >
                          </p>
                          <p
                            class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                          ></p>
                        </div>
                        <a
                          class="flex items-center gap-2"
                          href="https://share.google/sGXhpyMd09pnkT8l7"
                          target="_blank"
                          rel="noopener noreferrer nofollow"
                          title="Đánh giá trên Google"
                        >
                          <img
                            src="{{ asset("assets/images/google-reviews.png") }}"
                            class="w-14 xl:w-16 pointer-events-none"
                            alt="Đánh giá trên Google"
                            width="1000"
                            height="414"
                          />
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4 text-1"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                            ></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- PARTNERS & CLIENTS SECTION -->
        <section
          id="section-partners"
          class="section section-partners partners py-10 lg:py-20"
        >
          <div class="container px-3 mx-auto">
            <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
              <span class="icon-list-icon">
                <img
                  src="{{ asset("assets/images/asterisk.png") }}"
                  class="size-5"
                  width="24"
                  height="24"
                  alt="Khách hàng &amp; Đối tác"
                />
              </span>
              <span
                class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
              >
                Khách hàng &amp; Đối tác
              </span>
            </div>
            <h2 class="font-bold leading-tight mb-6 lg:mb-8">
              Khách hàng &amp; Đối tác của <span class="text-1">MÔI TRƯỜNG BẢO CHÂU</span>
            </h2>
            <div class="swiper-container">
              <div class="swiper" data-fx-slider="">
                <div
                  class="swiper-marquee swiper-wrapper"
                  data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"rtl":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                >
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="Mon Ngon Moi Ngay Logo"
                        decoding="async"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/2-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="HAKUHODO LOGO"
                        decoding="async"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/mitsubishi-768x768.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="768"
                        alt="mitsubishi logo"
                        decoding="async"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/3-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="UOB LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/4-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="CBAS LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-em-biet-doc-1-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="I CAN READ Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/5-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="KAMINAIL LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/6-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="TRIBECO LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-bidridco-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="bidrico logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-breaktalk-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="logo breaktalk"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/7-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="FOODS FOR YOU LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logodaidongtien-768x448-71611-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Dai Dong Tien Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/8-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="NASPHARMA LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/9-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="TALENT GATE LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-v-holding-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="v-holdings logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/10-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="ABBANK LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-me-since-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Me Since Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/11-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="THE TUTORX VIET NAM LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/12-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="VIETNAM ECO LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="swiper-container mt-3">
              <div class="swiper" data-fx-slider="">
                <div
                  class="swiper-marquee swiper-wrapper"
                  data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                >
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-Rart-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt=""
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-gocons-768x344.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Gocons Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-hucons-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Hucons Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-thanh-tam-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Nha Khoa Thanh Tam Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-nu-cuoi-duyen-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="Nu Cuoi Duyen Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/logo-dochi-office-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="DOCHI OFFICE LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/1-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="DOCHI HOME LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/2-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="METALIX INTERIOR Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/3-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="BBRACING Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/4-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="TMA FARMS LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/5-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="Trung Thanh Print Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/6-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="Thebabyshopvn Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/7-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="Tra Hoa Viet Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/cropped-logo-inthanhtien-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="In Thanh Tien Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/cropped-logo-inminhkhang-1-768x344.webp") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="344"
                        alt="In Minh Khang Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/8-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="Nha Khoa Anna Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/9-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="TOPLAND LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/10-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="DH LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/11-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="THE BOOKKEEPING PEOPLE LOGO"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <span
                      class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                    >
                      <img
                        src="{{ asset("assets/images/12-1-768x427.png") }}"
                        class="block h-[50px] md:h-[68px] w-auto"
                        width="768"
                        height="427"
                        alt="TQQ Logo"
                        decoding="async"
                        loading="lazy"
                      />
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section
          id="section-aceb87eef9"
          class="section section-press py-10 lg:py-20"
        >
          <div class="container px-3 mx-auto">
            <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
              <span class="icon-list-icon">
                <img
                  src="{{ asset("assets/images/asterisk.png") }}"
                  class="size-5"
                  width="24"
                  height="24"
                  alt="Báo chí"
                />
              </span>
              <span
                class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
              >
                Báo chí
              </span>
            </div>
            <h2 class="font-bold leading-tight mb-6 lg:mb-8">
              Báo chí nói gì về <span class="text-1">MÔI TRƯỜNG BẢO CHÂU</span>
            </h2>
            <div class="swiper-container">
              <div class="swiper" data-fx-slider="">
                <div
                  class="swiper-marquee swiper-wrapper"
                  data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"rtl":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                >
                  <!-- 1. Báo Gia Lai -->
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baogialai.com.vn/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-post564776.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Gia Lai – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-gia-lai.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Gia Lai"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <!-- 2. Kinh Tế Xanh -->
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://kinhtexanh.vn/chuyen-dich-sang-kinh-te-tuan-hoan-tu-ly-thuyet-den-thuc-thi-16811.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Kinh Tế Xanh – Chuyển dịch sang Kinh tế tuần hoàn từ lý thuyết đến thực thi"
                    >
                      <img
                        src="{{ asset("assets/images/bao-kinh-te-xanh.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Kinh Tế Xanh"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <!-- 3. Báo Mới -->
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baomoi.com/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-c53088786.epi"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Mới – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-moi.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Mới"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <!-- Set 2 for smooth marquee flow -->
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baogialai.com.vn/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-post564776.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Gia Lai – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-gia-lai.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Gia Lai"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://kinhtexanh.vn/chuyen-dich-sang-kinh-te-tuan-hoan-tu-ly-thuyet-den-thuc-thi-16811.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Kinh Tế Xanh – Chuyển dịch sang Kinh tế tuần hoàn từ lý thuyết đến thực thi"
                    >
                      <img
                        src="{{ asset("assets/images/bao-kinh-te-xanh.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Kinh Tế Xanh"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baomoi.com/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-c53088786.epi"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Mới – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-moi.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Mới"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <!-- Set 3 for smooth marquee flow -->
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baogialai.com.vn/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-post564776.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Gia Lai – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-gia-lai.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Gia Lai"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://kinhtexanh.vn/chuyen-dich-sang-kinh-te-tuan-hoan-tu-ly-thuyet-den-thuc-thi-16811.html"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Kinh Tế Xanh – Chuyển dịch sang Kinh tế tuần hoàn từ lý thuyết đến thực thi"
                    >
                      <img
                        src="{{ asset("assets/images/bao-kinh-te-xanh.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Kinh Tế Xanh"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                  <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                    <a
                      class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                      href="https://baomoi.com/huong-dan-su-dung-nang-luong-tiet-kiem-giam-phat-thai-khi-nha-kinh-c53088786.epi"
                      target="_blank"
                      rel="noopener noreferrer"
                      title="Báo Mới – Hướng dẫn sử dụng năng lượng tiết kiệm, giảm phát thải khí nhà kính"
                    >
                      <img
                        src="{{ asset("assets/images/bao-moi.png") }}"
                        class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                        alt="Báo Mới"
                        decoding="async"
                        loading="lazy"
                      />
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section id="section-5021941492" class="section section-cta py-20">
          <div class="container px-3 mx-auto flex flex-col items-center">
            <p class="h2 font-bold leading-tight mb-8 sm:mb-12 text-center">
              Luôn sẵn sàng
              <span class="text-1">giải quyết mọi vướng mắc môi trường</span>
              của bạn.
            </p>
            <a
              href="https://zalo.me/0915549148"
              target="_blank"
              class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80"
              title="Liên hệ ngay"
            >
              <span>Liên hệ ngay</span>
              <svg
                class="size-4"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                ></path>
              </svg>
            </a>
          </div>
        </section>
@endsection
