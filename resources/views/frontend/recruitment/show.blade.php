@extends('frontend.layouts.app', ['bodyClass' => 'recruitment-template-default single single-recruitment'])

@section('content')
        <!-- HERO SECTION: JOB HEADER & FEATURED IMAGE -->
        <section class="section section-hero pt-24 sm:pt-28 pb-8 lg:pb-12 relative z-10">
          <div class="container px-3 mx-auto">
            <div class="max-w-4xl mx-auto text-center mb-8 lg:mb-12">
              <!-- Subtitle Badge Chuẩn AGENTS.md -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Thông tin tuyển dụng"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  THÔNG TIN TUYỂN DỤNG CHI TIẾT
                </span>
              </div>

              <h1
                class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-[1.25] mb-5"
              >
                {{ $job->title }}
              </h1>

              <div
                class="flex flex-wrap items-center justify-center gap-4 sm:gap-7 text-sm sm:text-base lg:text-lg text-gray-700 pt-3"
              >
                <span
                  class="term btn btn-secondary-2 flex-0! py-1.5! px-4! text-sm! sm:text-base! rounded-full font-bold shadow-xs"
                >
                  {{ $job->employment_type ?? 'Toàn thời gian' }}
                </span>
                <span
                  class="inline-flex items-center gap-2 text-black font-semibold text-sm sm:text-base lg:text-lg"
                >
                  <svg
                    class="size-5 text-gray-500 shrink-0"
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
                  Địa điểm: {{ $job->location ?? 'TP. Hồ Chí Minh' }}
                </span>
                <span
                  class="inline-flex items-center gap-2 text-black font-semibold text-sm sm:text-base lg:text-lg"
                >
                  <svg
                    class="size-5 text-gray-500 shrink-0"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"
                    />
                  </svg>
                  Hạn nộp: {{ $job->expires_at ? $job->expires_at->format('d/m/Y') : 'Đang nhận hồ sơ' }}
                </span>
              </div>
            </div>
          </div>
        </section>

        <!-- STATISTICS / JOB SPECS SECTION -->
        <section class="section relative pb-12 lg:pb-16">
          <div class="container px-3 mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 w-full">
              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 lg:p-7 shadow-sm text-center"
              >
                <p
                  class="text-xs sm:text-sm text-gray-600 font-bold uppercase tracking-wider"
                >
                  Hình Thức
                </p>
                <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-gray-900 mt-2">
                  {{ $job->employment_type ?? 'Toàn thời gian' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 lg:p-7 shadow-sm text-center"
              >
                <p
                  class="text-xs sm:text-sm text-gray-600 font-bold uppercase tracking-wider"
                >
                  Địa Điểm
                </p>
                <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-primary mt-2">
                  {{ $job->location ?? 'TP. Hồ Chí Minh' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 lg:p-7 shadow-sm text-center"
              >
                <p
                  class="text-xs sm:text-sm text-gray-600 font-bold uppercase tracking-wider"
                >
                  Hạn Nộp Hồ Sơ
                </p>
                <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-gray-900 mt-2">
                  {{ $job->expires_at ? $job->expires_at->format('d/m/Y') : 'Đang nhận' }}
                </p>
              </div>

              <div
                class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 lg:p-7 shadow-sm text-center"
              >
                <p
                  class="text-xs sm:text-sm text-gray-600 font-bold uppercase tracking-wider"
                >
                  Trạng Thái
                </p>
                <p class="text-lg sm:text-xl lg:text-2xl font-extrabold text-secondary mt-2">
                  {{ $job->expires_at && $job->expires_at->isPast() ? 'Đã hết hạn' : 'Đang Nhận Hồ Sơ' }}
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
                  <!-- 1. Tổng quan vị trí -->
                  @if($job->summary)
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary mb-5 tracking-tight"
                    >
                      Tổng Quan Vị Trí Tuyển Dụng
                    </h2>
                    <div
                      class="text-gray-700 text-base sm:text-lg lg:text-xl leading-relaxed space-y-5"
                    >
                      <p>
                        {!! nl2br(e($job->summary)) !!}
                      </p>
                    </div>
                  </div>
                  @endif

                  <!-- Job Showcase Image -->
                  <div
                    class="my-10 lg:my-14 rounded-3xl overflow-hidden shadow-xl border border-black/5"
                  >
                    <img
                      width="1024"
                      height="572"
                      src="{{ str_starts_with($job->thumbnail ?? '', 'http') ? $job->thumbnail : (str_starts_with($job->thumbnail ?? '', 'uploads/') ? asset('storage/'.$job->thumbnail) : asset('assets/images/'.($job->thumbnail ?: 'Bai-Dang-Bao-Chau-1024x572.png'))) }}"
                      class="w-full h-auto object-cover"
                      alt="{{ $job->title }}"
                      loading="lazy"
                      decoding="async"
                    />
                  </div>

                  <!-- 2. Mô tả công việc chi tiết -->
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary mb-5 tracking-tight"
                    >
                      Mô Tả Công Việc Chi Tiết (Job Description)
                    </h2>
                    <div
                      class="text-gray-700 text-base sm:text-lg leading-relaxed space-y-5"
                    >
                      {!! $job->content !!}
                    </div>
                  </div>

                  <!-- 3. Yêu cầu năng lực ứng viên -->
                  @if($job->requirements)
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary mb-5 tracking-tight"
                    >
                      Yêu Cầu Năng Lực &amp; Kỹ Năng Chuyên Môn
                    </h2>
                    <div
                      class="text-gray-700 text-base sm:text-lg leading-relaxed space-y-5"
                    >
                      {!! $job->requirements !!}
                    </div>
                  </div>
                  @endif

                  <!-- 4. Quyền lợi & Chế độ đãi ngộ -->
                  @if($job->benefits)
                  <div>
                    <h2
                      class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary mb-5 tracking-tight"
                    >
                      Quyền Lợi &amp; Chế Độ Đãi Ngộ Vượt Trội
                    </h2>
                    <div
                      class="text-gray-700 text-base sm:text-lg leading-relaxed space-y-5"
                    >
                      <div class="p-6 rounded-3xl bg-emerald-50/60 my-5">
                        {!! $job->benefits !!}
                      </div>
                    </div>
                  </div>
                  @endif

                  <!-- Job Hashtags (CHUẨN NHƯ PROJECT-DETAIL.HTML) -->
                  <div
                    class="entry-tags mt-8 flex flex-wrap items-center gap-2.5 sm:gap-3"
                  >
                    <span
                      class="inline-flex items-center gap-2 text-sm sm:text-base font-extrabold uppercase tracking-wider text-black mr-1"
                    >
                      <svg
                        class="size-4.5 text-primary"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5"
                        />
                      </svg>
                      Tags:
                    </span>
                    <a
                      href="{{ route("recruitment.index") }}"
                      class="inline-flex items-center px-4 py-2 rounded-full text-sm sm:text-base font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200"
                    >
                      #TuyenDungBaoChau
                    </a>
                    <a
                      href="{{ route("recruitment.index") }}"
                      class="inline-flex items-center px-4 py-2 rounded-full text-sm sm:text-base font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200"
                    >
                      #KySuMoiTruong
                    </a>
                    <a
                      href="{{ route("recruitment.index") }}"
                      class="inline-flex items-center px-4 py-2 rounded-full text-sm sm:text-base font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200"
                    >
                      #BaoCaoDTM
                    </a>
                    <a
                      href="{{ route("recruitment.index") }}"
                      class="inline-flex items-center px-4 py-2 rounded-full text-sm sm:text-base font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200"
                    >
                      #GiayPhepMoiTruong
                    </a>
                    <a
                      href="{{ route("recruitment.index") }}"
                      class="inline-flex items-center px-4 py-2 rounded-full text-sm sm:text-base font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200"
                    >
                      #ViecLamTPHCM
                    </a>
                  </div>

                  <!-- SOCIAL SHARING & RATING FOOTER BAR (CHUẨN NHƯ PROJECT-DETAIL.HTML) -->
                  <div
                    class="pt-4 mt-6 flex flex-col sm:flex-row items-center justify-between gap-5 text-gray-900"
                  >
                    <!-- Left: Social Share Buttons -->
                    <div class="flex items-center gap-3.5 flex-wrap">
                      <span
                        class="font-extrabold text-sm sm:text-base uppercase tracking-wider text-gray-900"
                        >CHIA SẺ:</span
                      >
                      <div class="flex items-center gap-2 sm:gap-2.5 flex-wrap">
                        <!-- Facebook -->
                        <a
                          href="https://www.facebook.com/sharer/sharer.php?u=https://moitruongbaochau.com/recruitment-detail.html"
                          target="_blank"
                          rel="noopener noreferrer"
                          class="p-2.5 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90"
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
                        <!-- Print -->
                        <button
                          onclick="window.print()"
                          class="p-2.5 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90 cursor-pointer"
                          title="In thông tin tuyển dụng"
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
                        <!-- Copy Link -->
                        <button
                          onclick="
                            navigator.clipboard.writeText(window.location.href);
                            alert('Đã sao chép liên kết tuyển dụng!');
                          "
                          class="p-2.5 rounded-xl text-black hover:text-primary hover:bg-primary/10 flex items-center justify-center transition-all duration-200 active:scale-90 cursor-pointer"
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
                          style="width: 20px; height: 20px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 20px; height: 20px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 20px; height: 20px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 20px; height: 20px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                        <svg
                          class="fill-current"
                          style="width: 20px; height: 20px"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          />
                        </svg>
                      </div>
                      <span class="text-base font-bold text-gray-900"
                        >5/5 - (Tuyệt vời)</span
                      >
                    </div>
                  </div>
                </article>
              </div>

              <!-- RIGHT: STICKY APPLICATION & CONSULTATION SIDEBAR (col-span-1) (CHUẨN NHƯ PROJECT-DETAIL.HTML) -->
              <aside
                class="lg:col-span-1 space-y-6"
                style="
                  position: sticky;
                  top: 110px;
                  z-index: 30;
                  align-self: flex-start;
                "
              >
                <!-- Application Form Card -->
                <!-- Application Form Card (Livewire Real-time Validation & File Upload) -->
                <div
                  id="form-ung-tuyen"
                  class="card-item relative glass-effect border border-red-200/80 bg-white/95 rounded-3xl p-6 sm:p-8 shadow-xl"
                >
                  <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-2">
                    Ứng tuyển vị trí này
                  </h3>
                  <p class="text-sm sm:text-base text-gray-600 mb-6">
                    Để lại thông tin và CV, HR sẽ liên hệ bạn trong vòng 24h.
                  </p>

                  <livewire:frontend.job-application-form :preselected-job-id="$job->id" />
                </div>

                <!-- Hotline HR Fast Support Card (CHUẨN NHƯ PROJECT-DETAIL.HTML) -->
                <div
                  class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 shadow-sm flex items-center gap-4"
                >
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0"
                    style="
                      width: 54px;
                      height: 54px;
                      min-width: 54px;
                      min-height: 54px;
                    "
                  >
                    <svg
                      style="
                        width: 28px;
                        height: 28px;
                        min-width: 28px;
                        min-height: 28px;
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
                    <p class="text-xs sm:text-sm text-black font-semibold">
                      Hotline Tuyển Dụng (Ms. San San)
                    </p>
                    <a
                      href="tel:{{ preg_replace('/[^0-9+]/', '', $websiteSettings['phone'] ?? ($websiteSettings['company_phone'] ?? '0915549148')) }}"
                      class="text-lg sm:text-xl font-extrabold text-gray-900 hover:text-primary transition-colors"
                    >{{ $websiteSettings['phone'] ?? ($websiteSettings['company_phone'] ?? '0915 549 148') }}</a>
                  </div>
                </div>

                <!-- Related Job List Card -->
                @if(isset($relatedJobs) && $relatedJobs->isNotEmpty())
                <div
                  class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 sm:p-7 shadow-sm space-y-4"
                >
                  <p
                    class="text-base sm:text-lg font-bold text-gray-900 pb-3 border-b border-gray-100"
                  >
                    Vị Trí Đang Tuyển Dụng Khác
                  </p>
                  <div class="divide-y divide-gray-100 text-base">
                    @foreach($relatedJobs as $rJob)
                    <a
                      href="{{ route('recruitment.show', $rJob->slug) }}"
                      class="py-3 block group"
                    >
                      <p
                        class="font-bold text-gray-900 group-hover:text-primary transition-colors text-base"
                      >
                        {{ $rJob->title }}
                      </p>
                      <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        {{ $rJob->employment_type ?? 'Toàn thời gian' }} • {{ $rJob->location ?? 'TP. Hồ Chí Minh' }}
                      </p>
                    </a>
                    @endforeach
                  </div>
                </div>
                @endif
              </aside>
            </div>
          </div>
        </section>

        <!-- CTA SECTION CHUẨN QUY CHUẨN DỰ ÁN (GIỐNG PROJECT-DETAIL.HTML) -->
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
                      GIA NHẬP ĐỘI NGŨ BẢO CHÂU
                    </span>
                  </div>

                  <h2
                    class="font-bold text-2xl md:text-3xl lg:text-4xl text-gray-900 leading-tight mb-4"
                  >
                    Sẵn Sàng Phát Triển Sự Nghiệp Cùng
                    <span class="text-primary">Môi Trường Bảo Châu?</span>
                  </h2>

                  <p
                    class="text-gray-600 text-sm sm:text-base leading-relaxed mb-6 lg:mb-8"
                  >
                    Chúng tôi luôn chào đón các kỹ sư và chuyên gia môi trường
                    tài năng. Gửi CV ngay hôm nay để nhận cơ hội phỏng vấn sớm
                    nhất cùng chế độ đãi ngộ vượt trội!
                  </p>

                  <div
                    class="flex flex-row flex-wrap gap-4 sm:gap-6 items-center justify-center lg:justify-start"
                  >
                    <a
                      class="btn btn-primary-1 shadow-xl shadow-primary/30 hover:shadow-lg hover:shadow-primary/80"
                      href="#form-ung-tuyen"
                      title="Ứng tuyển ngay"
                    >
                      <span>Ứng tuyển ngay</span>
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
                      href="tel:0915549148"
                      title="Hotline HR: 0915 549 148"
                    >
                      <span>Hotline HR: 0915 549 148</span>
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
                          d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25Z"
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
