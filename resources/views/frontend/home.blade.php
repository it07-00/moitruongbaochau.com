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
                  src="{{ $page?->thumbnail ? (str_starts_with($page->thumbnail, 'http') ? $page->thumbnail : (str_starts_with($page->thumbnail, 'uploads/') ? asset('storage/' . $page->thumbnail) : asset($page->thumbnail))) : asset($websiteSettings['about_image'] ?? 'assets/images/logo-leave-png-min.png') }}"
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
                      alt="{{ $page?->metadata['about_badge'] ?? ($websiteSettings['about_badge'] ?? 'Về chúng tôi') }}"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                  >
                    {{ $page?->metadata['about_badge'] ?? ($websiteSettings['about_badge'] ?? 'Về chúng tôi') }}
                  </span>
                </div>
                <h2 class="font-bold leading-tight mb-6 lg:mb-8 text-3xl md:text-4xl lg:text-5xl text-gray-900">
                  {!! $page?->title ? Str::replace(['Môi Trường Bảo Châu', 'MÔI TRƯỜNG BẢO CHÂU'], ['<span class="text-primary">Môi Trường Bảo Châu</span>', '<span class="text-primary">MÔI TRƯỜNG BẢO CHÂU</span>'], $page->title) : ($websiteSettings['about_title'] ?? '<span class="text-primary">MÔI TRƯỜNG BẢO CHÂU</span> với sứ mệnh') !!}
                </h2>
                <div>
                  <div class="mt-6 lg:mt-8 p-fs-clamp-[15,17] space-y-4 text-gray-600 leading-relaxed">
                    <p>
                      {!! $page?->metadata['about_desc_1'] ?? ($websiteSettings['about_desc_1'] ?? 'Giải quyết bài toán tồn tại, phát triển và <span class="font-medium">tăng trưởng doanh nghiệp bền vững</span> cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.') !!}
                    </p>
                    <p>
                      {!! $page?->metadata['about_desc_2'] ?? ($websiteSettings['about_desc_2'] ?? 'Luôn lấy chữ <span class="font-medium">Tâm</span> để nâng chữ <span class="font-medium">Tầm</span>. Chúng tôi không ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng không ngại đưa ra phương án giải quyết phù hợp cho khách hàng.') !!}
                    </p>
                    <p>
                      {!! $page?->metadata['about_desc_3'] ?? ($websiteSettings['about_desc_3'] ?? 'Đồng hành cùng <span class="text-primary font-medium">MÔI TRƯỜNG BẢO CHÂU</span> chắc chắn bạn sẽ nhận được sự phục vụ <span class="font-medium">nhiệt tình và tận tâm</span> của toàn đội ngũ được đào tạo trong một môi trường phù hợp văn hóa doanh nghiệp của chúng tôi.') !!}
                    </p>
                  </div>
                </div>
                <a
                  class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                  href="{{ $page?->metadata['about_link'] ?? ($websiteSettings['about_link'] ?? route('about')) }}"
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
                  class="card-item relative flex flex-col glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-20 shadow-sm hover:shadow-lg transition-all"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="{{ $page?->metadata['stat_1_number'] ?? ($websiteSettings['stat_1_number'] ?? '7') }}"
                    >
                      {{ $page?->metadata['stat_1_number'] ?? ($websiteSettings['stat_1_number'] ?? '7') }}
                    </span>
                    {{ $page?->metadata['stat_1_suffix'] ?? ($websiteSettings['stat_1_suffix'] ?? '+') }}
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    {{ $page?->metadata['stat_1_title'] ?? ($websiteSettings['stat_1_title'] ?? 'Năm kinh nghiệm') }}
                  </p>
                  <p
                    class="leading-relaxed text-sm text-gray-600 group-hover:text-black group-focus:text-black"
                  >
                    {!! $page?->metadata['stat_1_desc'] ?? ($websiteSettings['stat_1_desc'] ?? 'Chúng tôi luôn tự tin để tư vấn và đưa ra giải pháp phù hợp nhằm giải quyết tất cả các vấn đề khó khăn của doanh nghiệp về Giấy phép Môi trường, Báo cáo ĐTM, Khí nhà kính ESG và Xử lý Nước thải.') !!}
                  </p>
                </div>
                <div
                  class="card-item relative glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-10 shadow-sm hover:shadow-lg transition-all"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="{{ $page?->metadata['stat_2_number'] ?? ($websiteSettings['stat_2_number'] ?? '500') }}"
                    >
                      {{ $page?->metadata['stat_2_number'] ?? ($websiteSettings['stat_2_number'] ?? '500') }}
                    </span>
                    {{ $page?->metadata['stat_2_suffix'] ?? ($websiteSettings['stat_2_suffix'] ?? '+') }}
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    {{ $page?->metadata['stat_2_title'] ?? ($websiteSettings['stat_2_title'] ?? 'Dự án đã hoàn thành') }}
                  </p>
                  <p
                    class="leading-relaxed text-sm text-gray-600 group-hover:text-black group-focus:text-black"
                  >
                    {!! $page?->metadata['stat_2_desc'] ?? ($websiteSettings['stat_2_desc'] ?? 'Hơn 500+ hồ sơ pháp lý, đề án và công trình xử lý môi trường được nghiệm thu đúng hạn, đảm bảo 100% tuân thủ quy định pháp luật BVMT hiện hành.') !!}
                  </p>
                </div>
                <div
                  class="card-item relative glass-effect group focus:outline-none border border-black/14 bg-white/90 hover:bg-white focus:bg-white rounded-3xl p-6 lg:p-8 lg:translate-y-0 shadow-sm hover:shadow-lg transition-all"
                >
                  <span
                    class="relative flex p-fs-clamp-[52,72] font-bold text-primary/90 leading-[1.3] group-hover:text-primary group-focus:text-primary"
                  >
                    <span
                      class="counter text-left w-fit inline-block tracking-tight"
                      data-counter="{{ $page?->metadata['stat_3_number'] ?? ($websiteSettings['stat_3_number'] ?? '30') }}"
                    >
                      {{ $page?->metadata['stat_3_number'] ?? ($websiteSettings['stat_3_number'] ?? '30') }}
                    </span>
                    {{ $page?->metadata['stat_3_suffix'] ?? ($websiteSettings['stat_3_suffix'] ?? '+') }}
                  </span>
                  <p
                    class="mt-2 mb-3 h6 font-semibold text-black/90 c-hover group-hover:text-black group-focus:text-black"
                  >
                    {{ $page?->metadata['stat_3_title'] ?? ($websiteSettings['stat_3_title'] ?? 'Chuyên gia & Kỹ sư') }}
                  </p>
                  <p
                    class="leading-relaxed text-sm text-gray-600 group-hover:text-black group-focus:text-black"
                  >
                    {!! $page?->metadata['stat_3_desc'] ?? ($websiteSettings['stat_3_desc'] ?? 'Đội ngũ chuyên gia, kỹ sư công nghệ môi trường giàu kinh nghiệm, tận tâm, nhiệt huyết và luôn đặt uy tín, trách nhiệm lên hàng đầu.') !!}
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
                  @foreach($serviceCategories as $index => $category)
                    <li class="tabs-title {{ $index === 0 ? 'is-active active' : '' }}">
                      <a
                        href="#cat-tab-{{ $category->id }}"
                        class="py-5 px-6 sm:py-6 sm:px-7 lg:py-6.5 lg:px-8 rounded-2xl lg:rounded-3xl bg-white border border-black/8 shadow-sm hover:shadow-lg hover:border-primary/50 transition-all flex items-center gap-5 sm:gap-6 lg:gap-7 {{ $index === 0 ? 'is-active active' : '' }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        title="{{ $category->name }}"
                      >
                        <span class="shrink-0 flex items-center justify-center">
                          @if($category->icon)
                            @if(str_starts_with($category->icon, '<svg'))
                              {!! $category->icon !!}
                            @else
                              <img src="{{ str_starts_with($category->icon, 'uploads/') ? asset('storage/' . $category->icon) : asset($category->icon) }}" class="size-8 sm:size-9 lg:size-10 object-contain" alt="{{ $category->name }}" />
                            @endif
                          @elseif($category->slug === 'phap-ly-moi-truong')
                            <!-- Scale / Legal Icon -->
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
                                d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-16.5-.52a48.423 48.423 0 00-3 .52m19.5 0l-2.25 6.75a3 3 0 01-2.848 2.05h-.004a3 3 0 01-2.848-2.05L15 5.49m-6 0L6.75 12.24a3 3 0 01-2.848 2.05h-.004a3 3 0 01-2.848-2.05L3 5.49"
                              />
                            </svg>
                          @elseif($category->slug === 'khi-nha-kinh-esg')
                            <!-- Globe & Climate ESG Icon -->
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
                                d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m-6.364 8.418a6 6 0 0110.607 0"
                              />
                            </svg>
                          @elseif($category->slug === 'quan-trac-moi-truong')
                            <!-- Flask / Monitoring Icon -->
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
                                d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23.693l-1.57-.393m15.6 0l1.196 5.981A1.5 1.5 0 0119.528 22.5H4.472a1.5 1.5 0 01-1.468-1.794L4.2 15.3"
                              />
                            </svg>
                          @elseif($category->slug === 'ky-thuat-xu-ly')
                            <!-- Treatment & Engineering Tool/Wrench Icon -->
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
                                d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.07a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091.455.084.937-.024 1.388"
                              />
                            </svg>
                          @else
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
                          @endif
                        </span>
                        <span
                          class="tab-text font-bold text-[16px] sm:text-[17.5px] lg:text-[19px] leading-snug text-[#1e293b] transition-colors"
                        >
                          {{ $category->name }}
                        </span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
              <div class="w-full flex-1">
                <div
                  class="tabs-content mt-6 lg:mt-8"
                  data-fx-tabs-content="services-extra-tabs-4bdc829f17"
                >
                  @foreach($serviceCategories as $index => $category)
                    <div class="tabs-panel {{ $index === 0 ? 'is-active' : '' }}" id="cat-tab-{{ $category->id }}">
                      <div
                        class="flex flex-row items-start flex-wrap lg:flex-nowrap gap-8 lg:gap-10 xl:gap-12"
                      >
                        <div class="w-full lg:w-7/12">
                          <div
                            class="thumb w-full overflow-hidden rounded-2xl shadow-xl shadow-black/10"
                          >
                            @php
                              $firstService = $category->services->first();
                              $thumbImg = $category->image ?: ($firstService?->thumbnail ?: 'assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png');
                            @endphp
                            <img
                              src="{{ str_starts_with($thumbImg, 'http') ? $thumbImg : (str_starts_with($thumbImg, 'uploads/') ? asset('storage/' . $thumbImg) : asset($thumbImg)) }}"
                              class="block object-cover w-full h-full rounded-2xl aspect-16/9"
                              alt="{{ $category->name }}"
                              decoding="async"
                              loading="lazy"
                            />
                          </div>
                        </div>
                        <div class="w-full lg:w-5/12">
                          <div
                            class="mb-5 lg:mb-6 p-fs-clamp-[18,28] font-bold uppercase leading-[1.3]"
                          >
                            {{ $category->name }}
                          </div>
                          <div class="leading-[1.7] p-fs-clamp-[15,17]">
                            @if($category->description)
                              <p class="mb-3">{{ $category->description }}</p>
                            @else
                              <p class="mb-3">
                                Cung cấp giải pháp kỹ thuật và pháp lý môi trường chuyên nghiệp, cam kết tuân thủ quy chuẩn pháp luật và tiến độ nhanh chóng.
                              </p>
                            @endif
                            @if($category->services->isNotEmpty())
                              <div class="mt-4 flex flex-col gap-2">
                                @foreach($category->services->take(4) as $s)
                                  <a href="{{ route('services.show', $s->slug) }}" class="flex items-center gap-2 text-sm font-semibold text-gray-800 hover:text-primary transition-colors">
                                    <svg class="size-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <span>{{ $s->name }}</span>
                                  </a>
                                @endforeach
                              </div>
                            @endif
                          </div>
                          <a
                            href="{{ route('services.index') }}"
                            class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80 mt-6 lg:mt-10"
                            title="Xem tất cả dịch vụ"
                          >
                            <span>Xem tất cả</span>
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
                  @endforeach
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

            <!-- PROJECTS GRID 3 X 3 (DỰ ÁN TIÊU BIỂU) -->
            <div class="filter-content w-full">
              <div
                class="filter-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8"
              >
                @php
                  $catNameMap = [
                    'giay-phep' => 'Giấy phép Môi trường',
                    'dtm' => 'Báo cáo ĐTM',
                    'khi-nha-kinh' => 'Khí nhà kính & ESG',
                    'xu-ly-nuoc' => 'Xử lý Nước & Khí thải',
                    'quan-trac' => 'Quan trắc Môi trường',
                  ];
                @endphp
                @forelse($projects as $proj)
                  <div
                    class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
                    data-category="{{ $proj->category ?? 'giay-phep' }}"
                  >
                    <div
                      class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                    >
                      <a
                        class="block w-full h-full c-scale-effect"
                        href="{{ route('projects.show', $proj->slug) }}"
                        aria-label="{{ $proj->title }}"
                        title="{{ $proj->title }}"
                      >
                        <img
                          src="{{ str_starts_with($proj->thumbnail ?? '', 'http') ? $proj->thumbnail : (str_starts_with($proj->thumbnail ?? '', 'uploads/') ? asset('storage/' . $proj->thumbnail) : asset('assets/images/' . ($proj->thumbnail ?: 'BERICAP.jpg'))) }}"
                          class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                          width="1024"
                          height="683"
                          alt="{{ $proj->title }}"
                          decoding="async"
                          loading="lazy"
                        />
                      </a>
                      @if($proj->location)
                        <span
                          class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                        >
                          {{ $proj->location }}
                        </span>
                      @endif
                    </div>
                    <div class="p-content flex flex-col flex-1 justify-between">
                      <div>
                        <div
                          class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                        >
                          <a
                            href="{{ route('projects.index', ['category' => $proj->category]) }}"
                            class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full hover:bg-primary hover:text-white transition-colors"
                            title="Xem các dự án {{ $catNameMap[$proj->category] ?? ($proj->category ?: 'Dự án') }}"
                          >
                            {{ $catNameMap[$proj->category] ?? ($proj->category ?: 'Dự án') }}
                          </a>
                          @if($proj->completed_at)
                            <span class="text-xs text-gray-400 font-medium">
                              Hoàn thành {{ $proj->completed_at->format('Y') }}
                            </span>
                          @elseif($proj->client)
                            <span class="text-xs text-gray-400 font-medium truncate max-w-[140px]">
                              {{ $proj->client }}
                            </span>
                          @endif
                        </div>
                        <a
                          class="c-hover block"
                          href="{{ route('projects.show', $proj->slug) }}"
                          title="{{ $proj->title }}"
                        >
                          <h3
                            class="filter-title font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug line-clamp-2"
                          >
                            {{ $proj->title }}
                          </h3>
                        </a>
                        <p
                          class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                        >
                          {{ $proj->summary }}
                        </p>
                      </div>
                      <div
                        class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                      >
                        <span class="text-xs text-black font-medium truncate">
                          {{ $proj->client ? 'Khách hàng: ' . $proj->client : ($proj->location ?? 'Toàn quốc') }}
                        </span>
                        <a
                          href="{{ route('projects.show', $proj->slug) }}"
                          class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                          title="Xem chi tiết {{ $proj->title }}"
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
                @empty
                  <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Đang cập nhật danh sách dự án...</p>
                  </div>
                @endforelse
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
                  @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                      <div
                        class="relative flex flex-col flex-nowrap glass-effect h-full pt-6 pb-5 px-5 lg:pt-12 lg:pb-8 lg:px-8 rounded-xl md:rounded-2xl border border-black/15 bg-white/90 hover:bg-white shadow-md shadow-black/5 hover:shadow-xl hover:border-primary/90 hover:shadow-primary/15 c-hover"
                      >
                        <div class="flex-none icon">
                          <div
                            class="flex items-center justify-between flex-nowrap gap-2"
                            title="{{ $testimonial->client_company ?: $testimonial->client_name }}"
                          >
                            <span
                              class="flex flex-1 c-hover items-center justify-start group hover:text-primary font-bold h6 tracking-tight"
                            >
                              {{ $testimonial->client_company ?: $testimonial->client_name }}
                            </span>
                            @if($testimonial->avatar)
                              <span class="flex-none block">
                                <img
                                  src="{{ str_starts_with($testimonial->avatar, 'http') ? $testimonial->avatar : (str_starts_with($testimonial->avatar, 'uploads/') ? asset('storage/' . $testimonial->avatar) : asset('assets/images/' . $testimonial->avatar)) }}"
                                  class="pointer-events-none block w-auto h-10 object-contain"
                                  alt="{{ $testimonial->client_company ?: $testimonial->client_name }}"
                                  loading="lazy"
                                />
                              </span>
                            @endif
                          </div>
                        </div>
                        <blockquote
                          class="flex-1 mb-8 relative z-10 p-fs-clamp-[14,16] text-black font-light leading-[1.6] tracking-[-0.03em] pt-5 px-0 mt-5 border-t border-black/10"
                        >
                          <span class="line-clamp-6">{{ $testimonial->content }}</span>
                        </blockquote>
                        <div
                          class="flex-none flex items-center justify-between text-left gap-5 relative z-10 pt-7.5 border-t border-black/10"
                        >
                          <div>
                            <p class="text-black mb-1">
                              <span
                                class="text-base leading-[1.4em] font-medium capitalize mb-0"
                                >{{ $testimonial->client_name }}</span
                              >
                            </p>
                            @if($testimonial->client_role)
                              <p
                                class="text-sm leading-[1.4] font-medium tracking-[-0.02em] text-[#889188] capitalize"
                              >{{ $testimonial->client_role }}</p>
                            @endif
                          </div>
                          @if($testimonial->source_url)
                            <a
                              class="flex items-center gap-2"
                              href="{{ $testimonial->source_url }}"
                              target="_blank"
                              rel="noopener noreferrer nofollow"
                              title="Đánh giá trên {{ $testimonial->source }}"
                            >
                              <img
                                src="{{ asset('assets/images/google-reviews.png') }}"
                                class="w-14 xl:w-16 pointer-events-none"
                                alt="{{ $testimonial->source }}"
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
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
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
                  @foreach($partners as $partner)
                    <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                      @if($partner->link)
                        <a href="{{ $partner->link }}" target="_blank" rel="noopener noreferrer" class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300" title="{{ $partner->name }}">
                          <img
                            src="{{ str_starts_with($partner->logo, 'http') ? $partner->logo : (str_starts_with($partner->logo, 'uploads/') ? asset('storage/' . $partner->logo) : asset('assets/images/' . $partner->logo)) }}"
                            class="block h-[50px] md:h-[68px] w-auto max-w-[170px] object-contain"
                            alt="{{ $partner->name }}"
                            loading="lazy"
                          />
                        </a>
                      @else
                        <span
                          class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white"
                          title="{{ $partner->name }}"
                        >
                          <img
                            src="{{ str_starts_with($partner->logo, 'http') ? $partner->logo : (str_starts_with($partner->logo, 'uploads/') ? asset('storage/' . $partner->logo) : asset('assets/images/' . $partner->logo)) }}"
                            class="block h-[50px] md:h-[68px] w-auto max-w-[170px] object-contain"
                            alt="{{ $partner->name }}"
                            loading="lazy"
                          />
                        </span>
                      @endif
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            <!-- BÁO CHÍ SECTION -->
            <div class="mt-14 lg:mt-20">
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
                    data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                  >
                    @foreach($presses as $press)
                      <div class="swiper-slide w-auto! h-auto! my-2 mr-4 md:mr-6">
                        <a
                          class="u-flex-center h-full py-5 px-6 c-light-button glass-effect rounded-xl border border-white hover:scale-105 transition-transform duration-300"
                          href="{{ $press->link ?? '#' }}"
                          target="_blank"
                          rel="noopener noreferrer"
                          title="{{ $press->name }}"
                        >
                          <img
                            src="{{ str_starts_with($press->logo, 'http') ? $press->logo : (str_starts_with($press->logo, 'uploads/') ? asset('storage/' . $press->logo) : asset('assets/images/' . $press->logo)) }}"
                            class="object-contain block h-[50px] md:h-[68px] w-auto max-w-[170px]"
                            alt="{{ $press->name }}"
                            loading="lazy"
                          />
                        </a>
                      </div>
                    @endforeach
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
              href="{{ $websiteSettings['zalo'] ?? 'https://zalo.me/0915549148' }}"
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
