@extends("frontend.layouts.app")

@section("content")
    <div id="content" class="site-content">
      <div id="primary" class="content-area">
        <!-- ABOUT HERO SECTION -->
        <section class="section section-about py-12 lg:py-20 overflow-hidden">
          <div class="container px-3 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
              <div class="lg:col-span-6 order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                  <span class="icon-list-icon">
                    <img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt="{{ $page->metadata['about_badge'] ?? ($websiteSettings['about_badge'] ?? 'Về chúng tôi') }}" />
                  </span>
                  <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">
                    {{ $page->metadata['about_badge'] ?? ($websiteSettings['about_badge'] ?? 'Về chúng tôi') }}
                  </span>
                </div>
                <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight">
                  {!! Str::replace(['Môi Trường Bảo Châu', 'MÔI TRƯỜNG BẢO CHÂU'], ['<span class="text-primary">Môi Trường Bảo Châu</span>', '<span class="text-primary">MÔI TRƯỜNG BẢO CHÂU</span>'], $page->title ?: ($websiteSettings['about_title'] ?? '<span class="text-primary">MÔI TRƯỜNG BẢO CHÂU</span> với sứ mệnh')) !!}
                </h1>
                <div class="mt-6 space-y-4 text-gray-600 leading-relaxed text-base">
                  @if(filled($page->content))
                    {!! $page->content !!}
                  @elseif(filled($page->excerpt))
                    <p>{!! nl2br(e($page->excerpt)) !!}</p>
                  @else
                    <p>
                      {!! $websiteSettings['about_desc_1'] ?? 'Giải quyết bài toán tồn tại, phát triển và <span class="font-medium">tăng trưởng doanh nghiệp bền vững</span> cho tất cả các khách hàng tin tưởng và đồng hành cùng MÔI TRƯỜNG BẢO CHÂU.' !!}
                    </p>
                    <p>
                      {!! $websiteSettings['about_desc_2'] ?? 'Luôn lấy chữ <span class="font-medium">Tâm</span> để nâng chữ <span class="font-medium">Tầm</span>. Chúng tôi không ngại tốn thời gian để lắng nghe khách hàng chia sẻ và cũng không ngại đưa ra phương án giải quyết phù hợp cho khách hàng.' !!}
                    </p>
                    <p>
                      {!! $websiteSettings['about_desc_3'] ?? 'Đồng hành cùng <span class="text-primary font-medium">MÔI TRƯỜNG BẢO CHÂU</span> chắc chắn bạn sẽ nhận được sự phục vụ <span class="font-medium">nhiệt tình và tận tâm</span> của toàn đội ngũ được đào tạo trong một môi trường phù hợp văn hóa doanh nghiệp của chúng tôi.' !!}
                    </p>
                  @endif
                </div>
              </div>
              <div class="lg:col-span-6 order-1 lg:order-2 flex justify-center">
                <div class="relative w-full max-w-lg">
                  <div class="absolute -inset-4 bg-primary/10 rounded-3xl blur-2xl -z-10"></div>
                  @php
                    $aboutImg = $page->thumbnail ? (str_starts_with($page->thumbnail, 'http') ? $page->thumbnail : (str_starts_with($page->thumbnail, 'uploads/') ? asset('storage/' . $page->thumbnail) : asset($page->thumbnail))) : asset($websiteSettings['about_image'] ?? 'assets/images/logo-leave-png-min.png');
                  @endphp
                  <img
                    src="{{ $aboutImg }}"
                    class="w-full h-auto object-contain max-h-[420px] drop-shadow-xl"
                    alt="{{ $page->title ?? 'Giới thiệu Môi Trường Bảo Châu' }}"
                  />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- VISION & MISSION SECTION -->
        <section class="section section-base py-12 lg:py-20 bg-gray-50/70 border-y border-gray-100 overflow-hidden">
          <div class="container px-3 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 lg:gap-14 items-start">
              <div class="lg:col-span-2">
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                  <span class="icon-list-icon">
                    <img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt="{{ $page->metadata['vision_badge'] ?? ($websiteSettings['vision_badge'] ?? 'TẦM NHÌN & SỨ MỆNH') }}" />
                  </span>
                  <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">
                    {{ $page->metadata['vision_badge'] ?? ($websiteSettings['vision_badge'] ?? 'TẦM NHÌN & SỨ MỆNH') }}
                  </span>
                </div>
                <h2 class="font-bold text-3xl md:text-4xl text-gray-900 leading-tight">
                  {!! $page->metadata['vision_title'] ?? ($websiteSettings['vision_title'] ?? '<span class="text-primary block">MÔI TRƯỜNG BẢO CHÂU</span> Kiến tạo biểu tượng phát triển bền vững') !!}
                </h2>
                <div class="mt-5 space-y-4 text-gray-600 leading-relaxed text-[15px]">
                  <p>
                    {!! $page->metadata['vision_desc_1'] ?? ($websiteSettings['vision_desc_1'] ?? 'Với tầm nhìn trở thành <strong>đơn vị tiên phong trong lĩnh vực môi trường tại Việt Nam</strong>, được khách hàng tin tưởng lựa chọn hàng đầu và là biểu tượng của sự phát triển bền vững, Môi trường Bảo Châu luôn nhận được sự tín nhiệm của khách hàng.') !!}
                  </p>
                  <p>
                    {!! $page->metadata['vision_desc_2'] ?? ($websiteSettings['vision_desc_2'] ?? 'Để có thể phát triển song hành cùng với khách hàng, Môi trường Bảo Châu luôn đặt sứ mệnh của bản thân lên đầu tiên:') !!}
                  </p>
                </div>
              </div>

              <div class="lg:col-span-3">
                <div class="grid md:grid-cols-2 gap-6 lg:gap-8">
                  <!-- Mission 1: Khách hàng -->
                  <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col items-start gap-4">
                    <div class="flex items-center justify-center bg-primary/10 text-primary rounded-xl shrink-0 size-[52px]">
                      <svg width="26" height="26" class="size-[26px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                      </svg>
                    </div>
                    <div>
                      <h3 class="text-[17px] font-bold text-gray-900 mb-2">
                        {{ $page->metadata['mission_1_title'] ?? ($websiteSettings['mission_1_title'] ?? 'Đối với khách hàng') }}
                      </h3>
                      <p class="text-gray-600 text-[14px] leading-relaxed">
                        {!! $page->metadata['mission_1_desc'] ?? ($websiteSettings['mission_1_desc'] ?? 'Cung cấp các giải pháp môi trường tối ưu, giúp doanh nghiệp nâng cao hiệu quả sản xuất, giảm thiểu tác động đến môi trường và đảm bảo tuân thủ các quy định pháp luật.') !!}
                      </p>
                    </div>
                  </div>

                  <!-- Mission 2: Đối tác -->
                  <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col items-start gap-4">
                    <div class="flex items-center justify-center bg-secondary/10 text-secondary rounded-xl shrink-0 size-[52px]">
                      <svg width="26" height="26" class="size-[26px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                      </svg>
                    </div>
                    <div>
                      <h3 class="text-[17px] font-bold text-gray-900 mb-2">
                        {{ $page->metadata['mission_2_title'] ?? ($websiteSettings['mission_2_title'] ?? 'Đối với đối tác') }}
                      </h3>
                      <p class="text-gray-600 text-[14px] leading-relaxed">
                        {!! $page->metadata['mission_2_desc'] ?? ($websiteSettings['mission_2_desc'] ?? 'Xây dựng mối quan hệ hợp tác bền vững, cùng nhau phát triển và chia sẻ thành công trên chặng đường chuyển đổi xanh.') !!}
                      </p>
                    </div>
                  </div>

                  <!-- Mission 3: Nhân viên -->
                  <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col items-start gap-4">
                    <div class="flex items-center justify-center bg-primary/10 text-primary rounded-xl shrink-0 size-[52px]">
                      <svg width="26" height="26" class="size-[26px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814" />
                      </svg>
                    </div>
                    <div>
                      <h3 class="text-[17px] font-bold text-gray-900 mb-2">
                        {{ $page->metadata['mission_3_title'] ?? ($websiteSettings['mission_3_title'] ?? 'Đối với nhân viên') }}
                      </h3>
                      <p class="text-gray-600 text-[14px] leading-relaxed">
                        {!! $page->metadata['mission_3_desc'] ?? ($websiteSettings['mission_3_desc'] ?? 'Tạo môi trường làm việc chuyên nghiệp, năng động, khuyến khích sáng tạo và tạo mọi điều kiện để phát triển bản thân toàn diện.') !!}
                      </p>
                    </div>
                  </div>

                  <!-- Mission 4: Cộng đồng -->
                  <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col items-start gap-4">
                    <div class="flex items-center justify-center bg-secondary/10 text-secondary rounded-xl shrink-0 size-[52px]">
                      <svg width="26" height="26" class="size-[26px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582" />
                      </svg>
                    </div>
                    <div>
                      <h3 class="text-[17px] font-bold text-gray-900 mb-2">
                        {{ $page->metadata['mission_4_title'] ?? ($websiteSettings['mission_4_title'] ?? 'Đối với cộng đồng') }}
                      </h3>
                      <p class="text-gray-600 text-[14px] leading-relaxed">
                        {!! $page->metadata['mission_4_desc'] ?? ($websiteSettings['mission_4_desc'] ?? 'Góp phần xây dựng một cộng đồng sống xanh, sạch, đẹp, bảo vệ tài nguyên thiên nhiên và nâng cao chất lượng cuộc sống cho thế hệ tương lai.') !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- ORGANIZATIONAL STRUCTURE SECTION (SƠ ĐỒ TỔ CHỨC) -->
        <section
          id="section-org-chart"
          class="section section-org py-12 lg:py-20 bg-white/60 overflow-hidden"
        >
          <div class="container px-3 mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col items-center mb-10 lg:mb-14 text-center">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="{{ $page->metadata['org_badge'] ?? ($websiteSettings['org_badge'] ?? 'SƠ ĐỒ BỘ MÁY') }}"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  {{ $page->metadata['org_badge'] ?? ($websiteSettings['org_badge'] ?? 'SƠ ĐỒ BỘ MÁY') }}
                </span>
              </div>
              <h2
                class="font-bold text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight uppercase tracking-tight"
              >
                {!! $page->metadata['org_title'] ?? ($websiteSettings['org_title'] ?? 'CƠ CẤU <span class="text-primary">TỔ CHỨC</span>') !!}
              </h2>
            </div>

            <!-- Org Tree Layout (Styled with exact structure) -->
            <div class="w-full max-w-7xl mx-auto flex flex-col items-center">
              <!-- LEVEL 1: GIÁM ĐỐC (Card trung tâm trên cùng) -->
              <div
                class="py-2.5 px-4 rounded-xl border-2 border-primary bg-[#e6f4ea] hover:bg-[#d1fae5] shadow-xs transition-all text-center flex items-center justify-center gap-2"
                style="width: 100%; max-width: 200px"
              >
                <!-- User Icon -->
                <svg
                  width="18"
                  height="18"
                  style="width: 18px; height: 18px; min-width: 18px; max-width: 18px;"
                  class="text-primary shrink-0"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                  />
                </svg>
                <span
                  class="text-primary font-bold text-sm md:text-[15px] uppercase tracking-wide"
                  style="white-space: nowrap"
                >
                  {{ $page->metadata['org_director'] ?? ($websiteSettings['org_director'] ?? 'GIÁM ĐỐC') }}
                </span>
              </div>

              <!-- DESKTOP CONNECTOR LINES -->
              <div class="hidden md:flex flex-col items-center w-full my-0">
                <!-- Vertical drop from Giám Đốc -->
                <div
                  style="width: 2px; height: 28px; background-color: #9ca3af"
                ></div>
                <!-- Horizontal bar connecting 3 columns -->
                <div
                  class="relative"
                  style="
                    width: 68%;
                    height: 2px;
                    background-color: #9ca3af;
                    margin-bottom: 28px;
                  "
                >
                  <!-- Drop line to Column 1 (Left) -->
                  <div
                    class="absolute left-0 top-0"
                    style="width: 2px; height: 28px; background-color: #9ca3af"
                  ></div>
                  <!-- Drop line to Column 2 (Center) -->
                  <div
                    class="absolute left-1/2 -translate-x-1/2 top-0"
                    style="width: 2px; height: 28px; background-color: #9ca3af"
                  ></div>
                  <!-- Drop line to Column 3 (Right) -->
                  <div
                    class="absolute right-0 top-0"
                    style="width: 2px; height: 28px; background-color: #9ca3af"
                  ></div>
                </div>
              </div>

              <!-- Mobile Spacer Line -->
              <div
                class="md:hidden my-3"
                style="width: 2px; height: 24px; background-color: #9ca3af"
              ></div>

              <!-- LEVEL 2 & 3: 3 PHÒNG BAN & CÁC BỘ PHẬN TRỰC THUỘC -->
              <div
                class="w-full items-start"
                style="
                  display: grid;
                  grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
                  gap: 28px;
                "
              >
                <!-- CỘT 1: PHÒNG KỸ THUẬT -->
                <div class="flex flex-col items-center w-full">
                  <!-- Node cấp 2: PHÒNG KỸ THUẬT -->
                  <div
                    class="w-full py-3 px-4 rounded-xl border-2 border-primary bg-[#e6f4ea] hover:bg-[#d1fae5] shadow-xs text-center flex items-center justify-center gap-2 transition-colors"
                  >
                    <svg
                      width="18"
                      height="18"
                      style="width: 18px; height: 18px; min-width: 18px; max-width: 18px;"
                      class="text-primary shrink-0"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                      />
                    </svg>
                    <span
                      class="text-primary font-bold text-sm md:text-[15px] uppercase tracking-wide"
                      style="white-space: nowrap"
                    >
                      {{ $page->metadata['org_dept_1'] ?? ($websiteSettings['org_dept_1'] ?? 'PHÒNG KỸ THUẬT') }}
                    </span>
                  </div>

                  <!-- Sub-branch lines to 2 peer units -->
                  <div class="flex flex-col items-center w-full">
                    <div
                      style="
                        width: 2px;
                        height: 16px;
                        background-color: #9ca3af;
                      "
                    ></div>
                    <div
                      class="relative"
                      style="
                        width: 50%;
                        height: 2px;
                        background-color: #9ca3af;
                        margin-bottom: 16px;
                      "
                    >
                      <div
                        class="absolute left-0 top-0"
                        style="
                          width: 2px;
                          height: 16px;
                          background-color: #9ca3af;
                        "
                      ></div>
                      <div
                        class="absolute right-0 top-0"
                        style="
                          width: 2px;
                          height: 16px;
                          background-color: #9ca3af;
                        "
                      ></div>
                    </div>
                  </div>

                  <!-- 2 Subordinate Units (Ngang cấp) -->
                  <div
                    class="w-full"
                    style="display: flex; gap: 10px; width: 100%"
                  >
                    <!-- Node cấp 3.1: Bộ phận Quan trắc -->
                    <div
                      class="py-2.5 px-2 rounded-xl border border-gray-300 bg-white hover:border-primary hover:bg-[#f0fdf4] text-gray-800 hover:text-primary font-semibold text-[12.5px] sm:text-[13px] text-center flex items-center justify-center gap-1.5 shadow-xs transition-all group"
                      style="flex: 1 1 0%; min-width: 0; white-space: nowrap"
                    >
                      <svg
                        width="15"
                        height="15"
                        style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;"
                        class="text-primary shrink-0"
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
                      <span style="white-space: nowrap">{{ $page->metadata['org_dept_1_sub1'] ?? ($websiteSettings['org_dept_1_sub1'] ?? 'Bộ phận Quan trắc') }}</span>
                    </div>

                    <!-- Node cấp 3.2: Bộ phận Tư vấn -->
                    <div
                      class="py-2.5 px-2 rounded-xl border border-gray-300 bg-white hover:border-primary hover:bg-[#f0fdf4] text-gray-800 hover:text-primary font-semibold text-[12.5px] sm:text-[13px] text-center flex items-center justify-center gap-1.5 shadow-xs transition-all group"
                      style="flex: 1 1 0%; min-width: 0; white-space: nowrap"
                    >
                      <svg
                        width="15"
                        height="15"
                        style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;"
                        class="text-primary shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                        />
                      </svg>
                      <span style="white-space: nowrap">{{ $page->metadata['org_dept_1_sub2'] ?? ($websiteSettings['org_dept_1_sub2'] ?? 'Bộ phận Tư vấn') }}</span>
                    </div>
                  </div>
                </div>

                <!-- CỘT 2: PHÒNG KINH DOANH -->
                <div class="flex flex-col items-center w-full">
                  <!-- Node cấp 2: PHÒNG KINH DOANH -->
                  <div
                    class="w-full py-3 px-4 rounded-xl border-2 border-primary bg-[#e6f4ea] hover:bg-[#d1fae5] shadow-xs text-center flex items-center justify-center gap-2 transition-colors"
                  >
                    <svg
                      width="18"
                      height="18"
                      style="width: 18px; height: 18px; min-width: 18px; max-width: 18px;"
                      class="text-primary shrink-0"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                      />
                    </svg>
                    <span
                      class="text-primary font-bold text-sm md:text-[15px] uppercase tracking-wide"
                      style="white-space: nowrap"
                    >
                      {{ $page->metadata['org_dept_2'] ?? ($websiteSettings['org_dept_2'] ?? 'PHÒNG KINH DOANH') }}
                    </span>
                  </div>

                  <!-- Connector line down -->
                  <div
                    style="width: 2px; height: 34px; background-color: #9ca3af"
                  ></div>

                  <!-- Node cấp 3.1: Bộ phận Kinh doanh -->
                  <div
                    class="py-2.5 px-3 rounded-xl border border-gray-300 bg-white hover:border-primary hover:bg-[#f0fdf4] text-gray-800 hover:text-primary font-semibold text-[12.5px] sm:text-[13px] text-center flex items-center justify-center gap-1.5 shadow-xs transition-all group"
                    style="width: 100%; max-width: 200px; white-space: nowrap"
                  >
                    <svg
                      width="15"
                      height="15"
                      style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;"
                      class="text-primary shrink-0"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.8"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3.6-3.091c-.555-.02-1.107-.05-1.65-.09a2.21 2.21 0 01-1.572-.733L7.75 11.25M3.75 4.5h16.5A2.25 2.25 0 0122.5 6.75v6a2.25 2.25 0 01-2.25 2.25H16.5l-4.5 3.75V15.25H3.75A2.25 2.25 0 011.5 13V6.75A2.25 2.25 0 013.75 4.5z"
                      />
                    </svg>
                    <span style="white-space: nowrap">{{ $page->metadata['org_dept_2_sub1'] ?? ($websiteSettings['org_dept_2_sub1'] ?? 'Bộ phận Kinh doanh') }}</span>
                  </div>
                </div>

                <!-- CỘT 3: PHÒNG TỔNG HỢP -->
                <div class="flex flex-col items-center w-full">
                  <!-- Node cấp 2: PHÒNG TỔNG HỢP -->
                  <div
                    class="w-full py-3 px-4 rounded-xl border-2 border-primary bg-[#e6f4ea] hover:bg-[#d1fae5] shadow-xs text-center flex items-center justify-center gap-2 transition-colors"
                  >
                    <svg
                      width="18"
                      height="18"
                      style="width: 18px; height: 18px; min-width: 18px; max-width: 18px;"
                      class="text-primary shrink-0"
                      fill="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                      />
                    </svg>
                    <span
                      class="text-primary font-bold text-sm md:text-[15px] uppercase tracking-wide"
                      style="white-space: nowrap"
                    >
                      {{ $page->metadata['org_dept_3'] ?? ($websiteSettings['org_dept_3'] ?? 'PHÒNG TỔNG HỢP') }}
                    </span>
                  </div>

                  <!-- Sub-branch lines to 2 peer units -->
                  <div class="flex flex-col items-center w-full">
                    <div
                      style="
                        width: 2px;
                        height: 16px;
                        background-color: #9ca3af;
                      "
                    ></div>
                    <div
                      class="relative"
                      style="
                        width: 50%;
                        height: 2px;
                        background-color: #9ca3af;
                        margin-bottom: 16px;
                      "
                    >
                      <div
                        class="absolute left-0 top-0"
                        style="
                          width: 2px;
                          height: 16px;
                          background-color: #9ca3af;
                        "
                      ></div>
                      <div
                        class="absolute right-0 top-0"
                        style="
                          width: 2px;
                          height: 16px;
                          background-color: #9ca3af;
                        "
                      ></div>
                    </div>
                  </div>

                  <!-- 2 Subordinate Units (Ngang cấp) -->
                  <div
                    class="w-full"
                    style="display: flex; gap: 10px; width: 100%"
                  >
                    <!-- Node cấp 3.1: Bộ phận Hành chính - Nhân sự -->
                    <div
                      class="py-2.5 px-2 rounded-xl border border-gray-300 bg-white hover:border-primary hover:bg-[#f0fdf4] text-gray-800 hover:text-primary font-semibold text-[12.5px] sm:text-[13px] text-center flex items-center justify-center gap-1.5 shadow-xs transition-all group"
                      style="flex: 1 1 0%; min-width: 0; white-space: nowrap"
                    >
                      <svg
                        width="15"
                        height="15"
                        style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;"
                        class="text-primary shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                        />
                      </svg>
                      <span style="white-space: nowrap">{{ $page->metadata['org_dept_3_sub1'] ?? ($websiteSettings['org_dept_3_sub1'] ?? 'BP HC – Nhân sự') }}</span>
                    </div>

                    <!-- Node cấp 3.2: Bộ phận Tài chính - Kế toán -->
                    <div
                      class="py-2.5 px-2 rounded-xl border border-gray-300 bg-white hover:border-primary hover:bg-[#f0fdf4] text-gray-800 hover:text-primary font-semibold text-[12.5px] sm:text-[13px] text-center flex items-center justify-center gap-1.5 shadow-xs transition-all group"
                      style="flex: 1 1 0%; min-width: 0; white-space: nowrap"
                    >
                      <svg
                        width="15"
                        height="15"
                        style="width: 15px; height: 15px; min-width: 15px; max-width: 15px;"
                        class="text-primary shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm6 0a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                      </svg>
                      <span style="white-space: nowrap">{{ $page->metadata['org_dept_3_sub2'] ?? ($websiteSettings['org_dept_3_sub2'] ?? 'BP TC – Kế toán') }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- TIMELINE SECTION (HÀNH TRÌNH PHÁT TRIỂN) -->
        <div class="section-history py-12 lg:py-20 overflow-hidden">
          <div class="container px-3 mx-auto">
            <div class="flex flex-col items-center mb-8 lg:mb-12">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt="{{ $page->metadata['timeline_badge'] ?? ($websiteSettings['timeline_badge'] ?? 'Hành trình phát triển') }}" />
                </span>
                <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">
                  {{ $page->metadata['timeline_badge'] ?? ($websiteSettings['timeline_badge'] ?? 'Hành trình phát triển') }}
                </span>
              </div>
              <h2 class="font-bold text-3xl md:text-4xl text-center text-gray-900">
                {!! $page->metadata['timeline_title'] ?? ($websiteSettings['timeline_title'] ?? 'Lịch sử <span class="text-primary">hình thành &amp; phát triển</span>') !!}
              </h2>
              <p class="mt-3 text-center text-gray-600 max-w-3xl text-[15px] leading-relaxed">
                {!! $page->metadata['timeline_desc'] ?? ($websiteSettings['timeline_desc'] ?? 'Hành trình hơn 8 năm xây dựng uy tín và khẳng định vị thế đơn vị tư vấn môi trường đáng tin cậy của Môi Trường Bảo Châu.') !!}
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <!-- Item 1 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <p class="text-3xl font-extrabold text-primary mb-2">{{ $page->metadata['timeline_1_year'] ?? ($websiteSettings['timeline_1_year'] ?? '2018') }}</p>
                  <h3 class="text-[16px] font-bold text-gray-900 mb-2">
                    {{ $page->metadata['timeline_1_title'] ?? ($websiteSettings['timeline_1_title'] ?? 'Thành lập công ty') }}
                  </h3>
                  <p class="text-sm text-gray-600 leading-relaxed">
                    {!! $page->metadata['timeline_1_desc'] ?? ($websiteSettings['timeline_1_desc'] ?? 'Môi Trường Bảo Châu chính thức thành lập, quy tụ các kỹ sư môi trường tâm huyết với định hướng cung cấp dịch vụ hồ sơ pháp lý chuẩn mực.') !!}
                  </p>
                </div>
              </div>

              <!-- Item 2 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <p class="text-3xl font-extrabold text-secondary mb-2">{{ $page->metadata['timeline_2_year'] ?? ($websiteSettings['timeline_2_year'] ?? '2020') }}</p>
                  <h3 class="text-[16px] font-bold text-gray-900 mb-2">
                    {{ $page->metadata['timeline_2_title'] ?? ($websiteSettings['timeline_2_title'] ?? 'Chuẩn hóa Luật BVMT 2020') }}
                  </h3>
                  <p class="text-sm text-gray-600 leading-relaxed">
                    {!! $page->metadata['timeline_2_desc'] ?? ($websiteSettings['timeline_2_desc'] ?? 'Tiên phong nghiên cứu và chuẩn hóa quy trình cấp Giấy phép môi trường (GPMT) và Báo cáo ĐTM theo khung quy định mới của Luật BVMT 2020.') !!}
                  </p>
                </div>
              </div>

              <!-- Item 3 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <p class="text-3xl font-extrabold text-primary mb-2">{{ $page->metadata['timeline_3_year'] ?? ($websiteSettings['timeline_3_year'] ?? '2022') }}</p>
                  <h3 class="text-[16px] font-bold text-gray-900 mb-2">
                    {{ $page->metadata['timeline_3_title'] ?? ($websiteSettings['timeline_3_title'] ?? 'Mở rộng Kỹ thuật & Xử lý nước') }}
                  </h3>
                  <p class="text-sm text-gray-600 leading-relaxed">
                    {!! $page->metadata['timeline_3_desc'] ?? ($websiteSettings['timeline_3_desc'] ?? 'Mở rộng quy mô thiết kế, thi công và vận hành trạm xử lý nước thải - khí thải công nghiệp cho các nhà máy quy mô lớn tại các KCN trọng điểm.') !!}
                  </p>
                </div>
              </div>

              <!-- Item 4 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <p class="text-3xl font-extrabold text-secondary mb-2">{{ $page->metadata['timeline_4_year'] ?? ($websiteSettings['timeline_4_year'] ?? '2024 – 2026') }}</p>
                  <h3 class="text-[16px] font-bold text-gray-900 mb-2">
                    {{ $page->metadata['timeline_4_title'] ?? ($websiteSettings['timeline_4_title'] ?? 'Khí nhà kính & Chiến lược ESG') }}
                  </h3>
                  <p class="text-sm text-gray-600 leading-relaxed">
                    {!! $page->metadata['timeline_4_desc'] ?? ($websiteSettings['timeline_4_desc'] ?? 'Triển khai tư vấn Kiểm kê Khí nhà kính (ISO 14064), báo cáo CBAM, LCA và chiến lược ESG, khẳng định vị thế đối tác môi trường toàn diện.') !!}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- PARTNERS & CLIENTS MARQUEE SLIDER SECTION -->
        <section id="section-partners" class="section section-partners partners py-10 lg:py-20 bg-gray-50/70 border-t border-gray-100 overflow-hidden">
          <div class="container px-3 mx-auto">
            <div class="flex flex-col items-center text-center mb-8 lg:mb-12">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt="Khách hàng tiêu biểu" />
                </span>
                <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">
                  Khách hàng tiêu biểu
                </span>
              </div>
              <h2 class="font-bold text-2xl md:text-3xl lg:text-4xl text-gray-900 leading-tight">
                Đối tác tin cậy đồng hành cùng
                <span class="text-primary">Bảo Châu</span>
              </h2>
            </div>

            <!-- ROW 1 (RTL) -->
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
                        <span class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white" title="{{ $partner->name }}">
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

            <!-- ROW 2 (LTR) -->
            <div class="swiper-container mt-3">
              <div class="swiper" data-fx-slider="">
                <div
                  class="swiper-marquee swiper-wrapper"
                  data-swiper-options='{"marquee":true,"pauseonmouseenter":true,"allowtouchmove":true,"slidesperview":"auto","spacebetween":12,"speed":6000,"mousewheel":true,"freemode":true,"sm":{"spacebetween":24}}'
                >
                  @foreach($partners->reverse() as $partner)
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
                        <span class="u-flex-center h-full py-4 px-6 c-light-button glass-effect rounded-xl border border-white" title="{{ $partner->name }}">
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
          </div>
        </section>
      </div>
    </div>
@endsection
