@extends('frontend.layouts.app', ['bodyClass' => 'post-template-default single single-post'])

@section('content')
<!-- 2 Background shapes chuẩn AGENTS.md 1.2 -->
        

        <!-- BREADCRUMBS -->
        <div class="container px-3 mx-auto pt-6 pb-2">
          <ul
            id="breadcrumbs"
            class="breadcrumbs flex flex-row flex-wrap items-center space-x-2 text-xs sm:text-sm text-black"
            aria-label="Breadcrumbs"
          >
            <li>
              <a class="home hover:text-primary font-medium text-gray-700" href="{{ route("home") }}">Trang chủ</a>
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li>
              <a href="{{ route("posts.index") }}" class="hover:text-primary font-medium text-gray-700"
                >Kiến Thức &amp; Tin Tức</a
              >
            </li>
            <li><span class="text-gray-400">/</span></li>
            <li class="current current-title text-primary font-semibold truncate max-w-xs sm:max-w-md">
              {{ $post->title }}
            </li>
          </ul>
        </div>

        <!-- MAIN POST CONTENT SECTION (CHÍNH XÁC 100% THEO SERVICE-DETAIL.HTML) -->
        <section class="section singular section-post py-6 lg:py-12">
          <div class="container px-3 mx-auto">
            <div class="content-all w-full min-w-0">
              <!-- Post Title & Meta Header Block -->
              <div class="w-full m-auto mb-6 lg:mb-10">
                <!-- Category Badge -->
                <div class="all_category_time_post flex gap-3">
                  <div
                    class="terms-links links flex items-center flex-wrap gap-2"
                  >
                    <span
                      class="btn flex-0! btn-primary-2 border-primary/60! py-1.5! px-4! text-[13px]! font-bold shadow-md shadow-primary/20 hover:shadow-primary/60 rounded-full"
                      >{{ $post->category?->name ?? 'PHÁP LUẬT MÔI TRƯỜNG' }}</span
                    >
                  </div>
                </div>

                <!-- H1 Main Heading -->
                <h1
                  class="h2 font-bold text-foreground mb-5 mt-5"
                  itemprop="headline"
                >
                  {{ $post->title }}
                </h1>

                <!-- Post Meta: Time & Views -->
                <div
                  class="all_meta_post flex items-center gap-6 justify-between text-sm text-black pb-4 border-b border-gray-200/80"
                >
                  <div
                    class="meta flex items-center gap-4 text-xs sm:text-sm text-black"
                  >
                    <div
                      class="flex items-center gap-1.5 views-svg"
                      itemprop="datePublished"
                    >
                      <svg
                        class="size-4"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4l3 3M3.223 14A9 9 0 1 0 12 3a9 9 0 0 0-8.294 5.5M7 9H3V5"
                        />
                      </svg>
                      <span class="date">{{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="flex items-center gap-1.5 views-svg">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        class="size-4"
                      >
                        <path
                          fill="none"
                          stroke="currentColor"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0m11 0c-2.4 4-5.4 6-9 6c-3.6 0-6.6-2-9-6c2.4-4 5.4-6 9-6c3.6 0 6.6 2 9 6"
                        />
                      </svg>
                      <span class="views">3,420 lượt xem</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Two-Column Layout: Sidebar TOC on Left & Article Content on Right -->
              <div class="flex flex-x gap-6 lg:gap-10 items-start">
                <!-- LEFT: TOC SIDEBAR (w-72 xl:w-80) -->
                <div
                  class="sidebar-toc flex-none w-72 xl:w-80 hidden lg:block"
                  data-toc-spy
                  style="position: sticky; top: 90px; align-self: flex-start"
                >
                  <div class="sidebar-inner">
                    <div
                      id="toc_container"
                      role="navigation"
                      aria-label="Table of Contents"
                      class="no_bullets toc_title_center card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-5 sm:p-6 shadow-md"
                    >
                      <div
                        class="flex items-center justify-between font-bold text-black mb-4 pb-3 border-b border-gray-100"
                      >
                        <p class="toc_title font-bold text-[17px] text-black m-0 leading-none">
                          Mục lục
                        </p>
                        <button
                          id="toc-toggle-btn"
                          type="button"
                          class="size-7 rounded-full bg-primary text-white flex items-center justify-center cursor-pointer shadow-xs hover:bg-primary/90 transition-all"
                          aria-label="Thu gọn/mở rộng mục lục"
                        >
                          <svg
                            class="size-3.5 transition-transform"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="3"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 15l7-7 7 7"
                            />
                          </svg>
                        </button>
                      </div>
                      <ul
                        class="toc_list space-y-3 text-[16px] font-medium text-black"
                      >
                        <li>
                          <a
                            href="#giay-phep-moi-truong-la-gi"
                            class="text-primary font-bold hover:underline block leading-snug"
                            >• Giấy phép môi trường là gì?</a
                          >
                        </li>
                        <li>
                          <a
                            href="#vi-sao-doanh-nghiep-can-giay-phep-moi-truong"
                            class="hover:text-primary block leading-snug transition-colors text-black"
                            >• Vì sao doanh nghiệp cần có Giấy phép MT?</a
                          >
                        </li>
                        <li>
                          <a
                            href="#doi-tuong-bat-buoc-phai-co-giay-phep-moi-truong"
                            class="hover:text-primary block leading-snug transition-colors text-black"
                            >• Đối tượng bắt buộc phải có Giấy phép MT</a
                          >
                        </li>
                        <li>
                          <a
                            href="#tham-quyen-tham-dinh-cap-giay-phep-moi-truong"
                            class="hover:text-primary block leading-snug transition-colors text-black"
                            >• Thẩm quyền thẩm định &amp; phê duyệt</a
                          >
                        </li>
                        <li>
                          <a
                            href="#quy-trinh-tu-van-tron-goi-tai-bao-chau"
                            class="hover:text-primary block leading-snug transition-colors font-semibold text-black"
                            >• Quy trình tư vấn trọn gói tại Bảo Châu</a
                          >
                          <ul
                            class="pl-4 mt-2 space-y-2 text-[14px] text-black font-normal border-l-2 border-primary/20 ml-2"
                          >
                            <li>
                              <a href="#khao-sat-muc-tieu-va-yeu-cau" class="hover:text-primary block transition-colors text-black"
                                >1. Khảo sát mục tiêu &amp; Đo đạc hiện trạng</a
                              >
                            </li>
                            <li>
                              <a href="#xay-dung-bao-cao-ky-thuat" class="hover:text-primary block transition-colors text-black"
                                >2. Lập báo cáo kỹ thuật đề xuất cấp phép</a
                              >
                            </li>
                            <li>
                              <a href="#tham-van-cong-dong-nop-ho-so" class="hover:text-primary block transition-colors text-black"
                                >3. Tham vấn cộng đồng &amp; Nộp hồ sơ</a
                              >
                            </li>
                            <li>
                              <a href="#bao-ve-hoi-dong-tham-dinh" class="hover:text-primary block transition-colors text-black"
                                >4. Bảo vệ trước Hội đồng thẩm định</a
                              >
                            </li>
                            <li>
                              <a href="#ban-giao-giay-phep-huong-dan" class="hover:text-primary block transition-colors"
                                >5. Bàn giao Giấy phép &amp; Hướng dẫn vận hành</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li>
                          <a
                            href="#muc-xu-phat-khi-vi-pham"
                            class="hover:text-primary block leading-snug transition-colors"
                            >• Mức xử phạt nếu không có Giấy phép MT</a
                          >
                        </li>
                        <li>
                          <a
                            href="#vi-sao-chon-moi-truong-bao-chau"
                            class="hover:text-primary block leading-snug transition-colors"
                            >• Vì sao chọn Môi Trường Bảo Châu?</a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <!-- RIGHT: ARTICLE CONTENT -->
                <div class="content flex-1 min-w-0">
                  <article
                    class="entry-content space-y-8 text-black"
                    itemtype="https://schema.org/CreativeWork"
                    itemscope
                  >
                    @if($post->excerpt)
                    <!-- Lead Paragraph -->
                    <p
                      class="text-base sm:text-lg leading-relaxed text-black"
                    >
                      <em><strong>{{ $post->excerpt }}</strong></em>
                    </p>
                    @endif

                    {!! $post->content !!}

                    <!-- Author Box -->
                    <section
                      class="section section-author mt-10 pt-6"
                    >
                      <div
                        class="flex flex-row gap-6 lg:gap-8 author-meta items-center"
                      >
                        <div class="w-24 sm:w-28 shrink-0 author-avatar">
                          <span
                            class="aspect-square rounded-2xl u-flex-center c-light-button overflow-hidden border border-black/8 shadow-sm"
                          >
                            <img
                              width="536"
                              height="522"
                              src="{{ asset("assets/images/logo-leave-png-min.png") }}"
                              class="object-contain p-2"
                              alt="Môi Trường Bảo Châu"
                            />
                          </span>
                        </div>
                        <div class="author-info flex flex-col justify-around">
                          <p
                            class="name h4 font-bold text-base sm:text-lg text-black mb-0"
                          >
                            Ban Biên Tập Kỹ Thuật Môi Trường Bảo Châu
                          </p>
                          <p class="text-xs sm:text-sm text-black mt-1">
                            Đội ngũ Thạc sĩ, Kỹ sư Môi trường với hơn 10 năm
                            kinh nghiệm trong tư vấn hồ sơ môi trường và giải
                            pháp kỹ thuật tại Việt Nam.
                          </p>
                        </div>
                      </div>
                    </section>

                    <!-- Article Hashtags -->
                    <div class="entry-tags mt-8 flex flex-wrap items-center gap-2 sm:gap-2.5">
                      <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-black mr-1">
                        <svg class="size-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
                        </svg>
                        Tags:
                      </span>
                      <a href="{{ route("posts.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                        #GiayPhepMoiTruong
                      </a>
                      <a href="{{ route("posts.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                        #LuatBVMT2020
                      </a>
                      <a href="{{ route("posts.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                        #NghiDinh08
                      </a>
                      <a href="{{ route("posts.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                        #HoSoMoiTruong
                      </a>
                      <a href="{{ route("posts.index") }}" class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200">
                        #MoiTruongBaoChau
                      </a>
                    </div>

                    <!-- SOCIAL SHARING & RATING FOOTER BAR -->
                    <div
                      class="pt-6 sm:pt-8 mt-10 flex flex-col sm:flex-row items-center justify-between gap-6 text-black"
                    >
                      <!-- Left: Social Share Buttons -->
                      <div class="flex items-center gap-3.5 sm:gap-4 flex-wrap">
                        <span
                          class="font-extrabold text-base sm:text-lg uppercase tracking-wider text-black"
                          >CHIA SẺ:</span
                        >
                        <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                          <!-- Facebook -->
                          <a
                            href="https://www.facebook.com/sharer/sharer.php?u=https://moitruongbaochau.vn/news-detail.html"
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
                            href="https://twitter.com/intent/tweet?url=https://moitruongbaochau.vn/news-detail.html"
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
                            href="mailto:?subject=Kiến Thức &amp; Tin Tức Môi Trường Bảo Châu&amp;body=https://moitruongbaochau.vn/news-detail.html"
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
                          <!-- Native Share -->
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
                      <div class="flex items-center gap-3 sm:gap-4">
                        <div
                          class="flex items-center text-amber-500 gap-1 sm:gap-1.5"
                          style="color: #f59e0b"
                        >
                          <svg
                            class="fill-current size-5.5 sm:size-6.5"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                          </svg>
                          <svg
                            class="fill-current size-5.5 sm:size-6.5"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                          </svg>
                          <svg
                            class="fill-current size-5.5 sm:size-6.5"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                          </svg>
                          <svg
                            class="fill-current size-5.5 sm:size-6.5"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                          </svg>
                          <svg
                            class="fill-current size-5.5 sm:size-6.5"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                          </svg>
                        </div>
                        <span
                          class="text-base sm:text-lg font-extrabold text-black"
                          >5/5 <span class="font-medium text-gray-700 text-sm sm:text-base">(24 bình chọn)</span></span
                        >
                      </div>
                    </div>
                  </article>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION: BÀI VIẾT LIÊN QUAN (CHUẨN 100% CẤU TRÚC SERVICE-DETAIL) -->
        <section
          class="section section-related py-10 lg:py-16 relative overflow-hidden"
        >
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <!-- Header Section -->
            <div
              class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 lg:mb-12 gap-4"
            >
              <div>
                <!-- Subtitle Badge chuẩn quy chuẩn AGENTS.md -->
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-2">
                  <span class="icon-list-icon">
                    <img
                      src="{{ asset("assets/images/asterisk.png") }}"
                      class="size-5"
                      width="24"
                      height="24"
                      alt="BÀI VIẾT LIÊN QUAN"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs tracking-wider"
                  >
                    BÀI VIẾT LIÊN QUAN
                  </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-black">
                  Kiến Thức <span class="text-primary">Môi Trường Khác</span>
                </h2>
              </div>
              <a
                href="{{ route("posts.index") }}"
                class="inline-flex items-center gap-1 text-sm font-bold text-primary hover:underline"
              >
                Xem tất cả bài viết
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

            <!-- Related Post Cards -->
            <div
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8 w-full"
            >
              @foreach($relatedPosts as $relPost)
              <div
                class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
              >
                <div
                  class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                >
                  <a
                    class="block w-full h-full c-scale-effect"
                    href="{{ route('posts.show', $relPost->slug) }}"
                    aria-label="{{ $relPost->title }}"
                  >
                    <img
                      src="{{ str_starts_with($relPost->thumbnail ?? '', 'http') ? $relPost->thumbnail : (str_starts_with($relPost->thumbnail ?? '', 'uploads/') ? asset('storage/' . $relPost->thumbnail) : asset('assets/images/' . ($relPost->thumbnail ?: '1-768x427.png'))) }}"
                      class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      width="1024"
                      height="683"
                      alt="{{ $relPost->title }}"
                      loading="lazy"
                    />
                  </a>
                  <span
                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                  >
                    {{ $relPost->category?->name ?? 'Luật BVMT 2020' }}
                  </span>
                </div>
                <div class="p-content flex flex-col flex-1 justify-between">
                  <div>
                    <div
                      class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                    >
                      <span
                        class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                        >{{ $relPost->category?->name ?? 'Hồ sơ pháp lý' }}</span
                      >
                    </div>
                    <a
                      class="c-hover block"
                      href="{{ route('posts.show', $relPost->slug) }}"
                      title="{{ $relPost->title }}"
                    >
                      <h3
                        class="font-bold text-lg text-black group-hover:text-primary transition-colors leading-snug line-clamp-2"
                      >
                        {{ $relPost->title }}
                      </h3>
                    </a>
                    <p
                      class="mt-2 text-sm text-black line-clamp-2 leading-relaxed"
                    >
                      {{ $relPost->excerpt }}
                    </p>
                  </div>
                  <div
                    class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                  >
                    <span class="text-xs text-black font-medium truncate"
                      >{{ $relPost->published_at ? $relPost->published_at->format('d/m/Y') : '' }}</span
                    >
                    <a
                      href="{{ route('posts.show', $relPost->slug) }}"
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
@endsection
