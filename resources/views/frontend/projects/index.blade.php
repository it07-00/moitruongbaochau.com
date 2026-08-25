@extends('frontend.layouts.app', ['bodyClass' => 'archive post-type-archive post-type-archive-project'])

@section('content')
<!-- BACKGROUND DECORATION SHAPES -->
        

        <!-- HERO / PAGE TITLE & BREADCRUMB -->
        <section
          class="section relative pt-8 pb-12 lg:pt-14 lg:pb-16 overflow-hidden"
        >
          <div class="container px-3 mx-auto">
            <div class="max-w-4xl mx-auto text-center">
              <!-- Subtitle Badge chuẩn quy chuẩn -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Môi Trường Bảo Châu"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  DỰ ÁN TIÊU BIỂU &amp; HỒ SƠ NĂNG LỰC
                </span>
              </div>

              <h1
                class="entry-title p-fs-clamp-[32,56] font-bold tracking-tight text-gray-900 leading-[1.2] mb-4 lg:mb-6"
              >
                Dự Án Môi Trường <span class="text-primary">Tiêu Biểu</span>
              </h1>

              <p
                class="text-gray-600 p-fs-clamp-[15,18] leading-relaxed max-w-3xl mx-auto mb-0"
              >
                Tổng hợp các công trình tư vấn hồ sơ pháp lý môi trường, cấp
                Giấy phép môi trường, kiểm kê khí nhà kính ESG, thiết kế thi
                công hệ thống xử lý nước thải và quan trắc môi trường do Bảo
                Châu thực hiện trên toàn quốc.
              </p>
            </div>
          </div>
        </section>

        <!-- STATS COUNTER SECTION -->
        <section class="section relative pb-12 lg:pb-16">
          <div class="container px-3 mx-auto">
            <div
              class="cards grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6"
              data-fx-counter=""
              data-once="false"
              data-duration="1500"
            >
              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 lg:p-8 shadow-sm hover:shadow-lg transition-all text-center"
              >
                <span
                  class="relative flex justify-center p-fs-clamp-[40,56] font-bold text-primary leading-tight"
                >
                  <span class="counter" data-counter="500">500</span>+
                </span>
                <p
                  class="mt-2 font-semibold text-gray-900 text-sm lg:text-base"
                >
                  Dự án hoàn thành
                </p>
                <p class="mt-1 text-xs lg:text-sm text-black">
                  Đúng tiến độ và quy chuẩn
                </p>
              </div>

              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 lg:p-8 shadow-sm hover:shadow-lg transition-all text-center"
              >
                <span
                  class="relative flex justify-center p-fs-clamp-[40,56] font-bold text-primary leading-tight"
                >
                  <span class="counter" data-counter="10">10</span>+
                </span>
                <p
                  class="mt-2 font-semibold text-gray-900 text-sm lg:text-base"
                >
                  Năm kinh nghiệm
                </p>
                <p class="mt-1 text-xs lg:text-sm text-black">
                  Thực chiến pháp lý &amp; kỹ thuật
                </p>
              </div>

              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 lg:p-8 shadow-sm hover:shadow-lg transition-all text-center"
              >
                <span
                  class="relative flex justify-center p-fs-clamp-[40,56] font-bold text-primary leading-tight"
                >
                  <span class="counter" data-counter="99">99</span>%
                </span>
                <p
                  class="mt-2 font-semibold text-gray-900 text-sm lg:text-base"
                >
                  Tỷ lệ phê duyệt
                </p>
                <p class="mt-1 text-xs lg:text-sm text-black">
                  Đạt thẩm định ngay lần đầu
                </p>
              </div>

              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 lg:p-8 shadow-sm hover:shadow-lg transition-all text-center"
              >
                <span
                  class="relative flex justify-center p-fs-clamp-[40,56] font-bold text-primary leading-tight"
                >
                  <span class="counter" data-counter="30">30</span>+
                </span>
                <p
                  class="mt-2 font-semibold text-gray-900 text-sm lg:text-base"
                >
                  KCN &amp; Tỉnh thành
                </p>
                <p class="mt-1 text-xs lg:text-sm text-black">
                  Bắc - Trung - Nam
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- PROJECT FILTER & LIST GRID SECTION (3x3 TABS & FULL-WIDTH GRID) -->
        <section
          class="section relative pb-16 lg:pb-24"
          id="section-project-grid"
        >
          <div
            class="container px-3 mx-auto z-2 relative home-projects-filters"
            data-limit="9"
            data-title-tag="h3"
          >
            <!-- TOP HORIZONTAL TAB PILLS (NHƯ HÌNH ẢNH 2) -->
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
                  <a href="{{ route('projects.index') }}" class="{{ empty($categoryFilter) || $categoryFilter === '-1' || $categoryFilter === 'all' ? 'active' : '' }}" data-filter="-1">
                    Tất cả <span class="filter-count">({{ $totalProjects }})</span>
                  </a>
                </li>
                @foreach ($categories as $catKey => $catLabel)
                  <li>
                    <a href="{{ route('projects.index', ['category' => $catKey]) }}" class="{{ $categoryFilter === $catKey ? 'active' : '' }}" data-filter="{{ $catKey }}">
                      {{ $catLabel }} <span class="filter-count">({{ $categoryCounts[$catKey] ?? 0 }})</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>

            <!-- PROJECTS GRID (DỰ ÁN TIÊU BIỂU) -->
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
                        <span class="text-xs text-gray-400 font-medium"
                          >Hoàn thành {{ $proj->completed_at->format('Y') }}</span
                        >
                        @elseif($proj->client)
                        <span class="text-xs text-gray-400 font-medium truncate max-w-[140px]"
                          >{{ $proj->client }}</span
                        >
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
                      <span class="text-xs text-black font-medium truncate"
                        >Khách hàng: {{ $proj->client ?? 'Đối tác' }}</span
                      >
                      <a
                        href="{{ route('projects.show', $proj->slug) }}"
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
                @empty
                <div class="col-span-3 text-center py-12">
                  <p class="text-gray-500">Đang cập nhật danh sách dự án...</p>
                </div>
                @endforelse
              </div>

              @if($projects->hasPages())
              <div class="mt-10 flex justify-center">
                {{ $projects->links() }}
              </div>
              @endif
            </div>
          </div>
        </section>

        <!-- PROJECT WORKFLOW / PROCESS SECTION -->
        <section
          class="section relative py-16 lg:py-24 bg-white/60 glass-effect border-y border-black/5"
        >
          <div class="container px-3 mx-auto">
            <div class="max-w-3xl mx-auto text-center mb-12 lg:mb-16">
              <!-- Subtitle Badge chuẩn quy chuẩn -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Môi Trường Bảo Châu"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  QUY TRÌNH THỰC HIỆN DỰ ÁN
                </span>
              </div>

              <h2
                class="p-fs-clamp-[28,42] font-bold text-gray-900 leading-tight"
              >
                Quy Trình Triển Khai
                <span class="text-primary">Chuẩn 5 Bước</span>
              </h2>
              <p
                class="mt-3 text-gray-600 text-sm lg:text-base leading-relaxed"
              >
                Đảm bảo tiến độ thẩm định nhanh nhất, tối ưu chi phí và minh
                bạch tuyệt đối trong từng khâu xử lý.
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
              <!-- Step 1 -->
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center"
              >
                <div
                  class="size-12 rounded-2xl bg-emerald-100 text-primary font-bold text-xl flex items-center justify-center mb-4"
                >
                  01
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">
                  Khảo Sát &amp; Thu Thập
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Tiếp nhận thông tin dự án, khảo sát thực địa hiện trạng nhà
                  máy và phân tích dữ liệu đầu vào.
                </p>
              </div>

              <!-- Step 2 -->
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center"
              >
                <div
                  class="size-12 rounded-2xl bg-emerald-100 text-primary font-bold text-xl flex items-center justify-center mb-4"
                >
                  02
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">
                  Lập Phương Án &amp; Báo Giá
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Đề xuất giải pháp tối ưu pháp lý hoặc công nghệ, gửi kế hoạch
                  tiến độ và dự toán chi tiết.
                </p>
              </div>

              <!-- Step 3 -->
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center"
              >
                <div
                  class="size-12 rounded-2xl bg-emerald-100 text-primary font-bold text-xl flex items-center justify-center mb-4"
                >
                  03
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">
                  Biên Soạn &amp; Thi Công
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Xây dựng báo cáo chuyên sâu, thiết kế thi công trạm xử lý và
                  tổ chức lấy mẫu đo đạc hiện trường.
                </p>
              </div>

              <!-- Step 4 -->
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center"
              >
                <div
                  class="size-12 rounded-2xl bg-emerald-100 text-primary font-bold text-xl flex items-center justify-center mb-4"
                >
                  04
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">
                  Thẩm Định &amp; Bảo Vệ
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Đại diện chủ đầu tư làm việc với Hội đồng thẩm định Sở/Bộ
                  TN&amp;MT đến khi có quyết định phê duyệt.
                </p>
              </div>

              <!-- Step 5 -->
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm hover:shadow-md transition-all text-center flex flex-col items-center"
              >
                <div
                  class="size-12 rounded-2xl bg-emerald-100 text-primary font-bold text-xl flex items-center justify-center mb-4"
                >
                  05
                </div>
                <h3 class="font-bold text-gray-900 text-base mb-2">
                  Bàn Giao &amp; Đồng Hành
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                  Bàn giao hồ sơ gốc, hỗ trợ hướng dẫn vận hành và tư vấn kiểm
                  tra hậu kiểm môi trường định kỳ.
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- PARTNERS & CLIENTS MARQUEE SLIDER SECTION -->
        <section
          id="section-partners"
          class="section section-partners partners py-10 lg:py-20 bg-gray-50/70 border-t border-gray-100 overflow-hidden"
        >
          <div class="container px-3 mx-auto">
            <div class="flex flex-col items-center text-center mb-8 lg:mb-12">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Khách hàng tiêu biểu"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  Khách hàng tiêu biểu
                </span>
              </div>
              <h2
                class="font-bold text-2xl md:text-3xl lg:text-4xl text-gray-900 leading-tight"
              >
                Được Tin Chọn Bởi Hơn
                <span class="text-primary">300+ Doanh Nghiệp</span>
              </h2>
            </div>

            <!-- ROW 1 (RTL) -->
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

            <!-- ROW 2 (LTR) -->
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

        <!-- CTA SECTION CHUẨN QUY CHUẨN DỰ ÁN -->
        <section id="section-cta" class="section section-cta py-12 lg:py-20">
          <div class="container px-3 mx-auto">
            <div
              class="card-item relative glass-effect border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-8 sm:p-12 lg:p-16 shadow-sm hover:shadow-lg transition-all"
            >
              <div
                class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12"
              >
                <!-- Cột trái: Tiêu đề, Phụ đề & Nút bấm chuẩn theme -->
                <div class="max-w-2xl text-center lg:text-left">
                  <!-- Subtitle Badge chuẩn AGENTS.md 1.3 -->
                  <div
                    class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4"
                  >
                    <span class="icon-list-icon">
                      <img
                        src="{{ asset("assets/images/asterisk.png") }}"
                        class="size-5"
                        width="24"
                        height="24"
                        alt="Môi Trường Bảo Châu"
                      />
                    </span>
                    <span
                      class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                    >
                      ĐỒNG HÀNH CÙNG DOANH NGHIỆP
                    </span>
                  </div>

                  <h2
                    class="font-bold text-2xl md:text-3xl lg:text-4xl text-gray-900 leading-tight mb-4"
                  >
                    Bạn Đang Chuẩn Bị Triển Khai Dự Án Mới Hay
                    <span class="text-primary"
                      >Cần Hoàn Thiện Hồ Sơ Môi Trường?</span
                    >
                  </h2>

                  <p
                    class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6 lg:mb-8"
                  >
                    Liên hệ ngay với Môi Trường Bảo Châu để nhận tư vấn giải
                    pháp kỹ thuật toàn diện, bảng tiến độ và báo giá tối ưu nhất
                    cho nhà máy của bạn.
                  </p>

                  <div
                    class="flex flex-row flex-wrap gap-4 sm:gap-6 items-center justify-center lg:justify-start"
                  >
                    <a
                      class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80"
                      href="tel:0915549148"
                      title="Hotline: 0915 549 148"
                    >
                      <span>Hotline: 0915 549 148</span>
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

                    <a
                      class="btn btn-secondary-2 shadow-xl shadow-secondary/25 hover:shadow-lg hover:shadow-secondary/70"
                      href="{{ route("contact.index") }}"
                      title="Gửi yêu cầu báo giá"
                    >
                      <span>Gửi yêu cầu báo giá</span>
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

                <!-- Cột phải: Card Logo chuẩn tỷ lệ hài hòa -->
                <div class="flex-shrink-0 flex items-center justify-center">
                  <div
                    class="p-6 c-light-button glass-effect rounded-3xl border border-white shadow-sm flex items-center justify-center"
                    style="width: 210px; height: 210px"
                  >
                    <img
                      src="{{ asset("assets/images/logo-leave-png-min.png") }}"
                      alt="Môi Trường Bảo Châu"
                      style="width: 180px; height: 180px; object-fit: contain"
                      width="536"
                      height="522"
                      decoding="async"
                      loading="lazy"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection
