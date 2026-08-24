@extends('frontend.layouts.app', ['bodyClass' => 'project-template-default single single-project'])

@section('content')
<!-- BACKGROUND SHAPES CHUẨN QUY CHUẨN AGENTS.md 1.2 -->
        

        <!-- BREADCRUMBS -->
        <div class="container px-3 mx-auto pt-6">
          <ul
            id="breadcrumbs"
            class="breadcrumbs flex flex-row flex-wrap items-center space-x-2 text-sm text-black"
            aria-label="Breadcrumbs"
          >
            <li>
              <a
                class="home hover:text-primary transition-colors"
                href="{{ route("home") }}"
                >Trang chủ</a
              >
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li>
              <a
                class="hover:text-primary transition-colors"
                href="{{ route("projects.index") }}"
                >Dự án tiêu biểu</a
              >
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li class="current text-primary font-semibold truncate max-w-xs sm:max-w-md">{{ $project->title }}</li>
          </ul>
        </div>

        <!-- PROJECT DETAIL HERO HEADER -->
        <section
          class="section relative pt-8 pb-8 lg:pt-12 lg:pb-12 overflow-hidden"
        >
          <div class="container px-3 mx-auto">
            <div class="max-w-4xl mx-auto text-center">
              <!-- Subtitle Badge chuẩn quy chuẩn AGENTS.md 1.3 -->
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
                  CHI TIẾT DỰ ÁN TIÊU BIỂU
                </span>
              </div>

              <h1
                class="entry-title p-fs-clamp-[28,46] font-extrabold tracking-tight text-gray-900 leading-[1.25] mb-5 lg:mb-6"
              >
                {{ $project->title }}
              </h1>

              <div
                class="flex flex-wrap items-center justify-center gap-3 sm:gap-5 text-xs sm:text-sm text-gray-600 mb-8"
              >
                <span
                  class="term btn btn-secondary-2 flex-0! py-1! px-3.5! text-[12px]! rounded-full font-bold"
                >
                  {{ $project->category ?? 'Giấy phép Môi trường' }}
                </span>
                <span
                  class="inline-flex items-center gap-1.5 text-black font-medium"
                >
                  <svg
                    class="size-4 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                    />
                  </svg>
                  {{ $project->location ?? 'KCN Toàn Quốc' }}
                </span>
                <span
                  class="inline-flex items-center gap-1.5 text-black font-medium"
                >
                  <svg
                    class="size-4 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5"
                    />
                  </svg>
                  Năm thực hiện: {{ $project->completed_at ? $project->completed_at->format('Y') : '2024' }}
                </span>
              </div>
            </div>

            <!-- FEATURED HERO IMAGE -->
            <div class="mb-10 lg:mb-16 flex justify-center relative">
              <div
                class="w-full rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl shadow-black/10 border border-gray-100"
              >
                <img
                  width="1200"
                  height="600"
                  src="{{ str_starts_with($project->thumbnail ?? '', 'http') ? $project->thumbnail : (str_starts_with($project->thumbnail ?? '', 'uploads/') ? asset('storage/' . $project->thumbnail) : asset('assets/images/' . ($project->thumbnail ?: 'BERICAP.jpg'))) }}"
                  class="w-full h-auto block object-cover max-h-[580px]"
                  alt="{{ $project->title }}"
                  loading="eager"
                  fetchpriority="high"
                  decoding="async"
                />
              </div>
            </div>
          </div>
        </section>

        <!-- STATISTICS / PROJECT SPECS SECTION -->
        <section class="section relative pb-12 lg:pb-16">
          <div class="container px-3 mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 w-full">
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 lg:p-6 shadow-sm text-center"
              >
                <p
                  class="text-xs text-black font-medium uppercase tracking-wider"
                >
                  Chủ Đầu Tư
                </p>
                <p class="text-base sm:text-lg font-bold text-gray-900 mt-1">
                  {{ $project->client ?? 'Doanh nghiệp FDI' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 lg:p-6 shadow-sm text-center"
              >
                <p
                  class="text-xs text-black font-medium uppercase tracking-wider"
                >
                  Địa Điểm Thực Hiện
                </p>
                <p class="text-base sm:text-lg font-bold text-primary mt-1">
                  {{ $project->location ?? 'Toàn Quốc' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 lg:p-6 shadow-sm text-center"
              >
                <p
                  class="text-xs text-black font-medium uppercase tracking-wider"
                >
                  Hạng Mục
                </p>
                <p class="text-base sm:text-lg font-bold text-gray-900 mt-1">
                  {{ $project->category ?? 'Giấy phép MT' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 lg:p-6 shadow-sm text-center"
              >
                <p
                  class="text-xs text-black font-medium uppercase tracking-wider"
                >
                  Trạng Thái Dự Án
                </p>
                <p class="text-base sm:text-lg font-bold text-secondary mt-1">
                  Đã Hoàn Thành 100%
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- MAIN ARTICLE CONTENT & SIDEBAR SECTION -->
        <section class="section relative pb-16 lg:pb-24">
          <div class="container px-3 mx-auto">
            <div
              class="grid grid-cols-1 lg:grid-cols-3 gap-8 xl:gap-14 items-start w-full"
            >
              <!-- LEFT: ARTICLE CONTENT & SHOWCASE & SHARING (col-span-2) -->
              <div class="lg:col-span-2">
                <article class="entry-content space-y-12" itemscope>
                  @if($project->summary)
                  <p class="text-base sm:text-lg leading-relaxed text-black font-semibold italic text-gray-800 p-5 bg-emerald-50/60 rounded-2xl border-l-4 border-primary">
                    {{ $project->summary }}
                  </p>
                  @endif

                  <div class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-4">
                    {!! str_contains($project->content, '<p>') || str_contains($project->content, '<h') || str_contains($project->content, '<div>') ? $project->content : nl2br(e($project->content)) !!}
                  </div>

                  <!-- Project Showcase Image (Khoảng cách rõ ràng giữa ảnh và text) -->
                  @if($project->thumbnail)
                  <div
                    class="my-10 lg:my-14 rounded-3xl overflow-hidden shadow-xl border border-black/5"
                  >
                    <img
                      width="1024"
                      height="572"
                      src="{{ str_starts_with($project->thumbnail ?? '', 'http') ? $project->thumbnail : (str_starts_with($project->thumbnail ?? '', 'uploads/') ? asset('storage/' . $project->thumbnail) : asset('assets/images/' . ($project->thumbnail ?: 'BERICAP.jpg'))) }}"
                      class="w-full h-auto object-cover"
                      alt="{{ $project->title }}"
                      loading="lazy"
                      decoding="async"
                    />
                  </div>
                  @endif

                  <!-- 3. Giải pháp kỹ thuật -->
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl font-bold text-primary mb-4 tracking-tight"
                    >
                      Giải Pháp Kỹ Thuật Của Môi Trường Bảo Châu
                    </h2>
                    <div
                      class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-4"
                    >
                      <p>
                        Đội ngũ chuyên gia và kỹ sư môi trường Bảo Châu đã trực
                        tiếp khảo sát thực địa, tiến hành lấy mẫu quan trắc hiện
                        trạng và ứng dụng các mô hình tính toán tải lượng phát
                        tán ô nhiễm để thiết lập phương án bảo vệ môi trường tối
                        ưu:
                      </p>
                      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                        <div
                          class="p-5 rounded-2xl bg-white/80 border border-gray-200/80 shadow-xs"
                        >
                          <p class="font-bold text-primary text-base mb-1">
                            1. Khảo sát &amp; Đo đạc thực địa
                          </p>
                          <p class="text-sm text-gray-600">
                            Đo đạc hiện trạng khí thải, nước thải và mức độ rung
                            ồn tại các vị trí xưởng sản xuất.
                          </p>
                        </div>
                        <div
                          class="p-5 rounded-2xl bg-white/80 border border-gray-200/80 shadow-xs"
                        >
                          <p class="font-bold text-primary text-base mb-1">
                            2. Tính toán &amp; Mô hình hóa tải lượng
                          </p>
                          <p class="text-sm text-gray-600">
                            Mô hình hóa khả năng phát tán khí thải và kiểm soát
                            nồng độ VOCs trong giới hạn an toàn.
                          </p>
                        </div>
                        <div
                          class="p-5 rounded-2xl bg-white/80 border border-gray-200/80 shadow-xs"
                        >
                          <p class="font-bold text-primary text-base mb-1">
                            3. Hoàn thiện báo cáo kỹ thuật
                          </p>
                          <p class="text-sm text-gray-600">
                            Lập báo cáo đề xuất cấp GPMT theo đúng biểu mẫu Nghị
                            định 08/2022/NĐ-CP.
                          </p>
                        </div>
                        <div
                          class="p-5 rounded-2xl bg-white/80 border border-gray-200/80 shadow-xs"
                        >
                          <p class="font-bold text-primary text-base mb-1">
                            4. Bảo vệ trước Hội đồng thẩm định
                          </p>
                          <p class="text-sm text-gray-600">
                            Đại diện chủ đầu tư thuyết minh kỹ thuật và giải
                            trình trước đoàn thẩm định Bộ TN&amp;MT.
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- 4. Kết quả đạt được -->
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl font-bold text-primary mb-4 tracking-tight"
                    >
                      Kết Quả Đạt Được &amp; Giá Trị Cho Doanh Nghiệp
                    </h2>
                    <div
                      class="text-gray-700 text-sm sm:text-base leading-relaxed space-y-4"
                    >
                      <p>
                        Nhờ sự phối hợp chặt chẽ giữa ban quản lý dự án BERICAP
                        và đội ngũ kỹ thuật Môi Trường Bảo Châu, hồ sơ đề nghị
                        cấp Giấy phép môi trường đã được Hội đồng thẩm định Bộ
                        TN&amp;MT đánh giá cao về tính chuẩn xác và phê duyệt
                        100% đúng tiến độ.
                      </p>
                      <div
                        class="p-6 rounded-2xl bg-emerald-50/70 border border-emerald-200/80 my-4"
                      >
                        <ul
                          class="space-y-3.5 text-sm sm:text-base text-gray-800"
                        >
                          <li class="flex items-center gap-2.5">
                            <svg
                              class="size-5 text-secondary shrink-0"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd"
                              />
                            </svg>
                            <span
                              ><strong class="text-gray-900"
                                >100% Phê duyệt đúng hạn:</strong
                              >
                              Giấy phép Môi trường được cấp chính thức, đúng lộ
                              trình khai trương nhà máy.</span
                            >
                          </li>
                          <li class="flex items-center gap-2.5">
                            <svg
                              class="size-5 text-secondary shrink-0"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd"
                              />
                            </svg>
                            <span
                              ><strong class="text-gray-900"
                                >Tối ưu chi phí xử lý:</strong
                              >
                              Đề xuất phương án tuần hoàn nước làm mát giúp tiết
                              kiệm 20% lượng nước tiêu thụ.</span
                            >
                          </li>
                          <li class="flex items-center gap-2.5">
                            <svg
                              class="size-5 text-secondary shrink-0"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd"
                              />
                            </svg>
                            <span
                              ><strong class="text-gray-900"
                                >Đồng hành định kỳ:</strong
                              >
                              Tiếp tục hỗ trợ BERICAP quan trắc môi trường và
                              lập báo cáo công tác BVMT hàng năm.</span
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <!-- Project Hashtags -->
                  <div class="entry-tags mt-8 flex flex-wrap items-center gap-2 sm:gap-2.5">
                    <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-black mr-1">
                      <svg class="size-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                      </svg>
                      Tags:
                    </span>
                    <a href="{{ route("projects.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                      #DuAnBaoChau
                    </a>
                    <a href="{{ route("projects.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                      #GiayPhepMoiTruong
                    </a>
                    <a href="{{ route("projects.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                      #BericapVietNam
                    </a>
                    <a href="{{ route("projects.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                      #NhaMayBaoBi
                    </a>
                    <a href="{{ route("projects.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                      #MoiTruongBaoChau
                    </a>
                  </div>

                  <!-- SOCIAL SHARING & RATING FOOTER BAR -->
                  <div
                    class="pt-6 mt-10 flex flex-col sm:flex-row items-center justify-between gap-5 text-gray-900"
                  >
                    <!-- Left: Social Share Buttons -->
                    <div class="flex items-center gap-3.5 flex-wrap">
                      <span
                        class="font-extrabold text-sm sm:text-base uppercase tracking-wider text-gray-900"
                        >CHIA SẺ:</span
                      >
                      <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                        <!-- Facebook -->
                        <a
                          href="https://www.facebook.com/sharer/sharer.php?u=https://moitruongbaochau.vn/project-detail.html"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90"
                          title="Chia sẻ lên Facebook"
                        >
                          <svg
                            class="fill-current size-6 sm:size-7"
                            viewBox="0 0 24 24"
                          >
                            <path
                              d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                            />
                          </svg>
                        </a>
                        <!-- X (Twitter) -->
                        <a
                          href="https://twitter.com/intent/tweet?url=https://moitruongbaochau.vn/project-detail.html"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90"
                          title="Chia sẻ lên X"
                        >
                          <svg
                            class="fill-current size-6 sm:size-7"
                            viewBox="0 0 24 24"
                          >
                            <path
                              d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                            />
                          </svg>
                        </a>
                        <!-- Print -->
                        <button
                          onclick="window.print()"
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90 cursor-pointer"
                          title="In trang này"
                        >
                          <svg
                            class="size-6 sm:size-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"
                            />
                          </svg>
                        </button>
                        <!-- Email -->
                        <a
                          href="mailto:?subject=Dự Án Giấy Phép Môi Trường BERICAP&amp;body=https://moitruongbaochau.vn/project-detail.html"
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90"
                          title="Gửi qua Email"
                        >
                          <svg
                            class="size-6 sm:size-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                            />
                          </svg>
                        </a>
                        <!-- Copy Link -->
                        <button
                          onclick="
                            navigator.clipboard.writeText(window.location.href);
                            alert('Đã sao chép liên kết bài viết!');
                          "
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90 cursor-pointer"
                          title="Sao chép liên kết"
                        >
                          <svg
                            class="size-6 sm:size-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"
                            />
                          </svg>
                        </button>
                        <!-- Share -->
                        <button
                          onclick="
                            if (navigator.share) {
                              navigator.share({
                                title: document.title,
                                url: window.location.href,
                              });
                            } else {
                              navigator.clipboard.writeText(
                                window.location.href,
                              );
                              alert('Đã sao chép liên kết!');
                            }
                          "
                          class="p-2 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90 cursor-pointer"
                          title="Chia sẻ"
                        >
                          <svg
                            class="size-6 sm:size-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"
                            />
                          </svg>
                        </button>
                      </div>
                    </div>

                    <!-- Right: Star Rating -->
                    <div class="flex items-center gap-2.5">
                      <div
                        class="flex items-center text-amber-500 gap-1"
                        style="color: #f59e0b"
                      >
                        <svg
                          class="fill-current"
                          style="width: 18px; height: 18px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 18px; height: 18px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 18px; height: 18px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 18px; height: 18px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 18px; height: 18px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                      </div>
                      <span class="text-sm font-bold text-gray-900"
                        >5/5 - (1 bình chọn)</span
                      >
                    </div>
                  </div>
                </article>
              </div>

              <!-- RIGHT: STICKY CONSULTATION SIDEBAR (col-span-1) -->
              <aside
                class="lg:col-span-1 space-y-6"
                style="
                  position: sticky;
                  top: 110px;
                  z-index: 30;
                  align-self: flex-start;
                "
              >
                <!-- Consultation Form Card -->
                <div
                  class="card-item relative glass-effect border border-red-200/80 bg-white/95 rounded-3xl p-6 sm:p-7 shadow-xl"
                >
                  <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">
                    Nhận tư vấn dự án
                  </h3>
                  <p class="text-xs sm:text-sm text-black mb-6">
                    Để lại thông tin, chuyên viên sẽ liên hệ tư vấn chi tiết.
                  </p>

                  <form class="space-y-4">
                    <div>
                      <input
                        required
                        name="fullname"
                        class="font-normal w-full border border-gray-300 rounded-xl h-12 px-4 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                        placeholder="Họ và tên *"
                        type="text"
                      />
                    </div>
                    <div>
                      <input
                        required
                        name="contact_phone"
                        class="font-normal w-full border border-gray-300 rounded-xl h-12 px-4 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                        placeholder="Số điện thoại *"
                        type="tel"
                      />
                    </div>
                    <div>
                      <input
                        name="contact_email"
                        class="font-normal w-full border border-gray-300 rounded-xl h-12 px-4 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
                        placeholder="Email"
                        type="email"
                      />
                    </div>
                    <div>
                      <textarea
                        rows="3"
                        name="message"
                        class="font-normal w-full border border-gray-300 rounded-xl p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"
                        placeholder="Yêu cầu cụ thể..."
                      ></textarea>
                    </div>
                    <button
                      type="submit"
                      class="btn btn-primary-1 w-full py-3.5 font-bold text-sm rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/80 inline-flex items-center justify-center gap-2 text-white transition-all cursor-pointer"
                    >
                      <span>Gửi yêu cầu ngay</span>
                      <svg
                        class="size-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2.2"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"
                        />
                      </svg>
                    </button>
                  </form>
                </div>

                <!-- Hotline Fast Support Card -->
                <div
                  class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 shadow-sm flex items-center gap-4"
                >
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0"
                    style="
                      width: 52px;
                      height: 52px;
                      min-width: 52px;
                      min-height: 52px;
                    "
                  >
                    <svg
                      style="
                        width: 26px;
                        height: 26px;
                        min-width: 26px;
                        min-height: 26px;
                      "
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.8"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"
                      />
                    </svg>
                  </div>
                  <div>
                    <p class="text-xs text-black font-medium">
                      Hotline Tư Vấn Nhanh
                    </p>
                    <a
                      href="tel:0915549148"
                      class="text-base sm:text-lg font-bold text-gray-900 hover:text-primary transition-colors"
                      >0915 549 148</a
                    >
                  </div>
                </div>
              </aside>
            </div>
          </div>
        </section>

        <!-- RELATED PROJECTS SECTION -->
        <section
          class="section relative py-12 lg:py-18 bg-white/40 glass-effect border-t border-black/5"
        >
          <div class="container px-3 mx-auto">
            <div
              class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 lg:mb-12 gap-4"
            >
              <div>
                <!-- Subtitle Badge chuẩn quy chuẩn -->
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-2">
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
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs tracking-wider"
                  >
                    DỰ ÁN LIÊN QUAN
                  </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">
                  Các Dự Án <span class="text-primary">Tiêu Biểu Khác</span>
                </h2>
              </div>
              <a
                href="{{ route("projects.index") }}"
                class="inline-flex items-center gap-1 text-sm font-bold text-primary hover:underline"
              >
                Xem tất cả dự án
                <svg
                  class="size-4"
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

            <div
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8 w-full"
            >
              @foreach($relatedProjects as $relProj)
              <div
                class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
              >
                <div
                  class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                >
                  <a
                    class="block w-full h-full c-scale-effect"
                    href="{{ route('projects.show', $relProj->slug) }}"
                    aria-label="{{ $relProj->title }}"
                  >
                    <img
                      src="{{ str_starts_with($relProj->thumbnail ?? '', 'http') ? $relProj->thumbnail : (str_starts_with($relProj->thumbnail ?? '', 'uploads/') ? asset('storage/' . $relProj->thumbnail) : asset('assets/images/' . ($relProj->thumbnail ?: 'BERICAP.jpg'))) }}"
                      class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      width="1024"
                      height="683"
                      alt="{{ $relProj->title }}"
                      loading="lazy"
                    />
                  </a>
                  <span
                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                  >
                    {{ $relProj->client ?? 'Dự án tiêu biểu' }}
                  </span>
                </div>
                <div class="p-content flex flex-col flex-1 justify-between">
                  <div>
                    <div
                      class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                    >
                      <span
                        class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                        >{{ $relProj->category ?? 'Hồ sơ pháp lý' }}</span
                      >
                    </div>
                    <a
                      class="c-hover block"
                      href="{{ route('projects.show', $relProj->slug) }}"
                      title="{{ $relProj->title }}"
                    >
                      <h3
                        class="font-bold text-lg text-gray-900 group-hover:text-primary transition-colors leading-snug line-clamp-2"
                      >
                        {{ $relProj->title }}
                      </h3>
                    </a>
                    <p
                      class="mt-2 text-sm text-gray-600 line-clamp-2 leading-relaxed"
                    >
                      {{ $relProj->summary }}
                    </p>
                  </div>
                  <div
                    class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                  >
                    <span class="text-xs text-black font-medium truncate"
                      >{{ $relProj->client ?? 'Đối tác' }}</span
                    >
                    <a
                      href="{{ route('projects.show', $relProj->slug) }}"
                      class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                    >
                      Chi tiết dự án
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
                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
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
