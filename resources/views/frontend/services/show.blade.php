@extends('frontend.layouts.app', ['bodyClass' => 'service-template-default single single-service'])

@section('content')
<!-- 2 BACKGROUND SHAPES BẮT BUỘC THEO AGENTS.md -->
        

        <!-- MAIN POST CONTENT SECTION (CHÍNH XÁC THEO CẤU TRÚC ẢNH MẪU USER) -->
        <section class="section singular section-post pt-24 md:pt-28 pb-8 lg:pb-16">
          <div class="container px-3 mx-auto">
            <div class="content-all w-full min-w-0">
                <!-- Post Title & Meta Header Block -->
                <div class="w-full m-auto mb-8 lg:mb-14">
                  <!-- Category Badge -->
                  <div class="all_category_time_post flex gap-3">
                    <div
                      class="terms-links links flex items-center flex-wrap gap-2"
                    >
                      <span
                        class="btn flex-0! btn-primary-2 border-primary/60! py-1.5! px-4! text-[13px]! font-bold shadow-md shadow-primary/20 hover:shadow-primary/60 rounded-full"
                        >{{ $service->category?->name ?? 'HỒ SƠ MÔI TRƯỜNG TRỌN GÓI' }}</span
                      >
                    </div>
                  </div>

                  <!-- H1 Main Heading -->
                  <h1
                    class="h2 font-bold text-foreground mb-5 mt-5"
                    itemprop="headline"
                  >
                    {{ $service->name }}
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
                        <span class="date">{{ $service->published_at?->format('d/m/Y') ?? $service->created_at->format('d/m/Y') }}</span>
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
                        <span class="views">{{ number_format($service->view_count) }} lượt xem</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Two-Column Layout: Sidebar TOC on Left & Article Content on Right -->
                <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 items-start">
                  <!-- LEFT: TOC SIDEBAR (w-75 / ~300px) -->
                  <div
                    class="sidebar-toc flex-none"
                    style="width: min(100%, 18rem)"
                    data-toc-spy
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
                          id="toc_list"
                          class="toc_list space-y-3 text-[16px] font-medium text-black"
                        >
                          {{-- TOC sẽ được tự động generate bằng JS từ nội dung bài viết --}}
                        </ul>
                      </div>
                    </div>
                  </div>

                  <!-- RIGHT: ARTICLE CONTENT -->
                  <div class="content flex-1 min-w-0">
                    <article
                      class="entry-content space-y-8 text-black"
                      data-toc-source
                      itemtype="https://schema.org/CreativeWork"
                      itemscope
                    >
                      @if(filled($service->content))
                        @if(filled($service->short_description))
                          <p class="text-base sm:text-lg leading-relaxed text-black">
                            <em><strong>{{ $service->short_description }}</strong></em>
                          </p>
                        @endif

                        {!! $service->content !!}
                      @else
                      <!-- Lead Paragraph -->
                      <p
                        class="text-base sm:text-lg leading-relaxed text-black"
                      >
                        <em
                          ><strong
                            >Doanh nghiệp có thể tiếp cận nhiều kênh thông tin
                            pháp lý môi trường, nhưng
                            <span class="text-primary font-bold"
                              >Giấy phép môi trường (GPMT)</span
                            >
                            là văn bản pháp lý tối quan trọng bắt buộc phải hoàn
                            thành trước khi cơ sở đi vào hoạt động chính thức.
                            Vì vậy,
                            <a
                              href="{{ route("home") }}"
                              class="text-secondary font-bold hover:underline"
                              >Môi Trường Bảo Châu</a
                            >
                            tập trung cung cấp giải pháp tư vấn kỹ thuật chuyên
                            sâu, thẩm định hồ sơ chính xác, đảm bảo 100% hồ sơ
                            được phê duyệt đúng tiến độ.</strong
                          ></em
                        >
                      </p>

                      <!-- Section 1 -->
                      <h2 class="text-xl sm:text-2xl font-bold text-black">
                        <span id="thiet-ke-website-ban-hang-la-gi">
                          Giấy phép môi trường là gì?
                        </span>
                      </h2>
                      <p class="text-black">
                        Theo quy định tại
                        <strong
                          >Khoản 8 Điều 3 Luật Bảo vệ Môi trường 2020</strong
                        >: Giấy phép môi trường là văn bản do cơ quan quản lý
                        nhà nước có thẩm quyền cấp cho tổ chức, cá nhân có hoạt
                        động sản xuất, kinh doanh, dịch vụ được phép xả chất
                        thải ra môi trường, quản lý chất thải, nhập khẩu phế
                        liệu từ nước ngoài làm nguyên liệu sản xuất kèm theo yêu
                        cầu, điều kiện về bảo vệ môi trường theo quy định của
                        pháp luật.
                      </p>
                      <p class="text-black">
                        Điểm mới đột phá của <strong>Luật BVMT 2020</strong> là
                        tích hợp
                        <strong>7 loại giấy phép môi trường thành phần</strong>
                        trước đây (như Giấy phép xả nước thải, Giấy xác nhận
                        hoàn thành công trình BVMT, Sổ chủ nguồn thải CTNH, Giấy
                        phép xả khí thải,...) thành
                        <strong>01 Giấy phép môi trường duy nhất</strong>.
                      </p>

                      <!-- Showcase Image -->
                      <figure
                        class="wp-caption aligncenter my-8 rounded-2xl overflow-hidden shadow-lg border border-black/5"
                      >
                        <img
                          decoding="async"
                          class="w-full h-auto object-cover"
                          src="{{ asset("assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-1024x576.png") }}"
                          alt="Giấy phép môi trường Luật 2020"
                          width="1024"
                          height="576"
                        />
                        <figcaption
                          class="wp-caption-text text-center text-xs text-black py-2 bg-gray-50 font-medium"
                        >
                          Hồ sơ đề nghị cấp Giấy phép môi trường theo Nghị định
                          08/2022/NĐ-CP
                        </figcaption>
                      </figure>

                      <!-- Section 2 -->
                      <h2 class="text-xl sm:text-2xl font-bold text-black">
                        <span
                          id="vi-sao-doanh-nghiep-can-thiet-ke-website-ban-hang"
                        >
                          Vì sao doanh nghiệp cần hoàn thiện Giấy phép môi
                          trường?
                        </span>
                      </h2>
                      <p class="text-black">
                        Giấy phép môi trường giúp doanh nghiệp xây dựng nền tảng
                        pháp lý vững chắc, an tâm sản xuất kinh doanh và đáp ứng
                        các tiêu chuẩn khắt khe từ chuỗi cung ứng toàn cầu.
                      </p>
                      <ul class="space-y-2 list-disc pl-5 text-black">
                        <li>
                          Hợp thức hóa hồ sơ pháp lý để nghiệm thu xây dựng và
                          đưa dự án vào vận hành chính thức.
                        </li>
                        <li>
                          Tránh bị xử phạt vi phạm hành chính (mức phạt có thể
                          lên đến 1.000.000.000 VNĐ theo Nghị định
                          45/2022/NĐ-CP).
                        </li>
                        <li>
                          Đáp ứng tiêu chuẩn đánh giá nhà máy từ các đối tác FDI
                          và khách hàng quốc tế.
                        </li>
                        <li>
                          Được chuyên gia tư vấn tối ưu hóa quy trình xử lý chất
                          thải, tiết kiệm chi phí năng lượng và bảo vệ môi
                          trường.
                        </li>
                      </ul>

                      <!-- Section 3 -->
                      <h2 class="text-xl sm:text-2xl font-bold text-black">
                        <span
                          id="thiet-ke-website-ban-hang-chuan-seo-can-dap-ung-dieu-gi"
                        >
                          Đối tượng bắt buộc phải có Giấy phép môi trường
                        </span>
                      </h2>
                      <p class="text-black">
                        Căn cứ <strong>Điều 39 Luật BVMT 2020</strong>, các đối
                        tượng sau bắt buộc phải có Giấy phép môi trường:
                      </p>
                      <div class="space-y-3 my-4 text-black">
                        <p>
                          <strong
                            >1. Dự án đầu tư Nhóm I, Nhóm II và Nhóm
                            III:</strong
                          >
                          Có phát sinh nước thải, bụi, khí thải xả ra môi trường
                          phải được xử lý hoặc có phát sinh chất thải nguy hại
                          phải được quản lý.
                        </p>
                        <p>
                          <strong
                            >2. Cơ sở sản xuất, kinh doanh, dịch vụ đang hoạt
                            động:</strong
                          >
                          Có tiêu chí về môi trường tương đương dự án Nhóm I,
                          Nhóm II và Nhóm III.
                        </p>
                      </div>

                      <!-- Section 4: Table -->
                      <h2 class="text-xl sm:text-2xl font-bold text-black">
                        <span
                          id="nhung-tinh-nang-can-co-khi-thiet-ke-website-ban-hang"
                        >
                          Thẩm quyền thẩm định &amp; cấp Giấy phép môi
                          trường
                        </span>
                      </h2>
                      <div
                        class="overflow-x-auto my-4 rounded-xl border border-gray-200"
                      >
                        <table
                          class="w-full text-left text-xs sm:text-sm border-collapse text-black"
                        >
                          <thead class="bg-gray-100 text-black font-bold">
                            <tr>
                              <th class="p-3 border border-gray-200">
                                Cơ Quan Cấp Phép
                              </th>
                              <th class="p-3 border border-gray-200">
                                Nhóm Dự Án Phụ Trách
                              </th>
                              <th class="p-3 border border-gray-200">
                                Thời Gian Thẩm Định
                              </th>
                            </tr>
                          </thead>
                          <tbody class="divide-y divide-gray-200 bg-white">
                            <tr>
                              <td
                                class="p-3 font-bold text-primary border border-gray-200"
                              >
                                Bộ TN&amp;MT
                              </td>
                              <td class="p-3 border border-gray-200 text-black">
                                Dự án Nhóm I nguy cơ cao, dự án liên tỉnh, dự án
                                cấp Bộ phê duyệt ĐTM
                              </td>
                              <td
                                class="p-3 font-semibold border border-gray-200 text-black"
                              >
                                45 ngày làm việc
                              </td>
                            </tr>
                            <tr>
                              <td
                                class="p-3 font-bold text-primary border border-gray-200"
                              >
                                UBND Cấp Tỉnh / Sở TN&amp;MT
                              </td>
                              <td class="p-3 border border-gray-200 text-black">
                                Dự án Nhóm II và Nhóm III nằm trên địa bàn 2
                                huyện trở lên
                              </td>
                              <td
                                class="p-3 font-semibold border border-gray-200 text-black"
                              >
                                30 ngày làm việc
                              </td>
                            </tr>
                            <tr>
                              <td
                                class="p-3 font-bold text-primary border border-gray-200"
                              >
                                UBND Cấp Huyện
                              </td>
                              <td class="p-3 border border-gray-200 text-black">
                                Dự án Nhóm III còn lại nằm trên địa bàn 1 huyện
                              </td>
                              <td
                                class="p-3 font-semibold border border-gray-200 text-black"
                              >
                                20 ngày làm việc
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

                      <!-- Section 5: Process -->
                      <h2 class="text-xl sm:text-2xl font-bold text-black">
                        <span id="quy-trinh-thiet-ke-website-ban-hang">
                          Quy trình tư vấn trọn gói tại Môi Trường Bảo Châu
                        </span>
                      </h2>
                      <div class="space-y-4 my-4 text-black">
                        <h3
                          id="khao-sat-muc-tieu-va-yeu-cau"
                          class="font-bold text-base text-black"
                        >
                          1. Khảo sát mục tiêu &amp; Đo đạc hiện trạng
                        </h3>
                        <p class="text-sm text-black">
                          Đội ngũ kỹ sư khảo sát thực tế, lấy mẫu phân tích các
                          nguồn thải nước thải, khí thải và kiểm tra hiện trạng
                          công trình BVMT.
                        </p>

                        <h3
                          id="xay-dung-cau-truc-website"
                          class="font-bold text-base text-black"
                        >
                          2. Lập báo cáo kỹ thuật đề xuất cấp phép
                        </h3>
                        <p class="text-sm text-black">
                          Tính toán tải lượng phát thải, hoàn thiện thuyết minh
                          báo cáo theo đúng mẫu chuẩn Phụ lục Nghị định
                          08/2022/NĐ-CP.
                        </p>

                        <h3
                          id="thiet-ke-giao-dien"
                          class="font-bold text-base text-black"
                        >
                          3. Tham vấn cộng đồng &amp; Nộp hồ sơ
                        </h3>
                        <p class="text-sm text-black">
                          Đăng tải tham vấn trên cổng thông tin điện tử, nộp hồ
                          sơ tại bộ phận một cửa của Cơ quan có thẩm quyền.
                        </p>

                        <h3
                          id="lap-trinh-va-kiem-thu"
                          class="font-bold text-base text-black"
                        >
                          4. Bảo vệ trước Hội đồng thẩm định
                        </h3>
                        <p class="text-sm text-black">
                          Đại diện chủ đầu tư thuyết minh kỹ thuật, cùng đoàn
                          kiểm tra thực tế nhà máy và giải trình bổ sung theo
                          biên bản họp.
                        </p>

                        <h3
                          id="ban-giao-va-huong-dan-quan-tri"
                          class="font-bold text-base text-black"
                        >
                          5. Bàn giao Giấy phép &amp; Hướng dẫn vận hành
                        </h3>
                        <p class="text-sm text-black">
                          Nhận Giấy phép môi trường gốc đóng dấu chính thức và
                          bàn giao tận tay khách hàng.
                        </p>
                      </div>
                      @endif

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
                                src="{{ asset(str_starts_with($websiteSettings['content_editor_logo'] ?? '', 'uploads/') ? 'storage/'.$websiteSettings['content_editor_logo'] : ($websiteSettings['content_editor_logo'] ?? 'assets/images/logo-leave-png-min.png')) }}"
                                class="object-contain p-2"
                                alt="{{ $websiteSettings['content_editor_name'] ?? 'Ban Biên Tập Kỹ Thuật Môi Trường Bảo Châu' }}"
                              />
                            </span>
                          </div>
                          <div class="author-info flex flex-col justify-around">
                            <p
                              class="name h4 font-bold text-base sm:text-lg text-black mb-0"
                            >
                              {{ $websiteSettings['content_editor_name'] ?? 'Ban Biên Tập Kỹ Thuật Môi Trường Bảo Châu' }}
                            </p>
                            <p class="text-xs sm:text-sm text-black mt-1">
                              {{ $websiteSettings['content_editor_bio'] ?? 'Đội ngũ Thạc sĩ, Kỹ sư Môi trường với hơn 10 năm kinh nghiệm trong tư vấn hồ sơ môi trường và giải pháp kỹ thuật tại Việt Nam.' }}
                            </p>
                          </div>
                        </div>
                      </section>
                      <x-frontend.content-tags :tags="$service->tags" :url="route('services.index')" />

                      <!-- SOCIAL SHARING & RATING FOOTER BAR -->
                      <div
                        class="pt-6 sm:pt-8 mt-10 flex flex-col sm:flex-row items-center justify-between gap-6 text-black"
                      >
                        @php
                          $shareUrl = url()->current();
                        @endphp
                        <!-- Left: Social Share Buttons -->
                        <div class="flex items-center gap-3.5 sm:gap-4 flex-wrap">
                          <span
                            class="font-extrabold text-base sm:text-lg uppercase tracking-wider text-black"
                            >CHIA SẺ:</span
                          >
                          <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                            <!-- Facebook -->
                            <a
                              href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
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
                              href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&amp;text={{ urlencode($service->name) }}"
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
                              href="mailto:?subject={{ urlencode($service->name) }}&amp;body={{ urlencode($shareUrl) }}"
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
                                navigator.clipboard.writeText('{{ $shareUrl }}');
                                alert('Đã sao chép liên kết bài viết: {{ $shareUrl }}');
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
                                    url: '{{ $shareUrl }}',
                                  });
                                } else {
                                  navigator.clipboard.writeText('{{ $shareUrl }}');
                                  alert('Đã sao chép liên kết: {{ $shareUrl }}');
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
                        <x-frontend.content-rating :average="$service->rating_average" :count="$service->rating_count" large />
                      </div>
                    </article>
                  </div>
                </div>
              </div>
            </div>
        </section>

        <!-- SECTION: DỊCH VỤ MÔI TRƯỜNG LIÊN QUAN (Xử lý giống chuẩn phần Dự án liên quan) -->
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
                      alt="DỊCH VỤ MÔI TRƯỜNG LIÊN QUAN"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs tracking-wider"
                  >
                    DỊCH VỤ MÔI TRƯỜNG LIÊN QUAN
                  </span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-black">
                  Các Dịch Vụ <span class="text-primary">Môi Trường Khác</span>
                </h2>
              </div>
              <a
                href="{{ route('services.index') }}"
                class="inline-flex items-center gap-1 text-sm font-bold text-primary hover:underline"
              >
                Xem tất cả dịch vụ
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

            <!-- Dynamic Related Services -->
            <div
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 xl:gap-8 w-full"
            >
              @forelse ($relatedServices as $related)
              <div
                class="item relative flex flex-col gap-4 bg-white/95 glass-effect border border-black/8 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 group"
              >
                <div
                  class="p-thumb c-cover overflow-hidden rounded-2xl relative aspect-16/10"
                >
                  <a
                    class="block w-full h-full c-scale-effect"
                    href="{{ route('services.show', $related->slug) }}"
                    aria-label="{{ $related->name }}"
                  >
                    <img
                      src="{{ $related->thumbnail_url }}"
                      class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                      width="1024"
                      height="683"
                      alt="{{ $related->name }}"
                      loading="lazy"
                    />
                  </a>
                  <span
                    class="absolute top-3 left-3 bg-white/90 backdrop-blur-xs text-xs font-bold text-emerald-800 py-1 px-3 rounded-full shadow-sm"
                  >
                    Môi Trường Bảo Châu
                  </span>
                </div>
                <div class="p-content flex flex-col flex-1 justify-between">
                  <div>
                    <div
                      class="terms mb-3 flex flex-row flex-wrap items-center gap-2"
                    >
                      <span
                        class="term btn btn-secondary-2 flex-0! py-1! px-3! text-[12px]! rounded-full"
                        >{{ $related->category?->name ?? 'Dịch vụ uy tín' }}</span
                      >
                      <span class="text-xs text-black font-medium"
                        >Tư vấn trọn gói</span
                      >
                    </div>
                    <a
                      class="c-hover block"
                      href="{{ route('services.show', $related->slug) }}"
                      title="{{ $related->name }}"
                    >
                      <h3
                        class="font-bold text-lg text-black group-hover:text-primary transition-colors leading-snug line-clamp-2"
                      >
                        {{ $related->name }}
                      </h3>
                    </a>
                    <p
                      class="mt-2 text-sm text-black line-clamp-2 leading-relaxed"
                    >
                      {{ $related->short_description }}
                    </p>
                  </div>
                  <div
                    class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between gap-2"
                  >
                    <span class="text-xs text-black font-medium truncate"
                      >Môi Trường Bảo Châu</span
                    >
                    <a
                      href="{{ route('services.show', $related->slug) }}"
                      class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline whitespace-nowrap shrink-0"
                    >
                      Chi tiết dịch vụ
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
              @empty
              @endforelse
            </div>
          </div>
        </section>
@endsection
