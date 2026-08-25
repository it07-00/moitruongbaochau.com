@extends('frontend.layouts.app', ['bodyClass' => 'page-template-default page contact-page'])

@section('content')
        <!-- SECTION: LIÊN HỆ TƯ VẤN (Theo đúng layout chuẩn thiết kế) -->
        <section
          class="section-contact-main pt-10 pb-8 lg:pt-16 lg:pb-16 relative overflow-hidden"
        >
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <!-- Header Section: Subtitle badge & Main Heading -->
            <div class="mb-8 lg:mb-12">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="BẠN ĐANG CẦN GIẢI PHÁP PHÙ HỢP?"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  BẠN ĐANG CẦN GIẢI PHÁP PHÙ HỢP?
                </span>
              </div>
              <h1
                class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight leading-tight"
              >
                Liên hệ tư vấn ngay
              </h1>
            </div>

            <!-- LIVEWIRE FORM GỬI THÔNG TIN LIÊN HỆ TƯ VẤN (REAL-TIME VALIDATION & INSTANT SUBMIT) -->
            <livewire:frontend.contact-form />

            <!-- 3 CONSULTATION CARDS -->
            <div
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
            >
              <!-- Card 1: Tư vấn Hồ sơ & Giấy phép Môi trường -->
              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
              >
                <div>
                  <!-- Icon Box -->
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="
                      width: 52px;
                      height: 52px;
                      min-width: 52px;
                      min-height: 52px;
                    "
                  >
                    <svg
                      width="26"
                      height="26"
                      style="
                        width: 26px;
                        height: 26px;
                        min-width: 26px;
                        min-height: 26px;
                      "
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.8"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"
                      />
                    </svg>
                  </div>

                  <h2
                    class="text-2xl font-bold text-gray-900 mb-3.5 group-hover:text-primary transition-colors"
                  >
                    Tư vấn hồ sơ &amp; Giấy phép MT
                  </h2>

                  <p class="text-[16px] text-gray-700 leading-relaxed mb-4">
                    Bạn cần lập hồ sơ môi trường chuẩn Luật BVMT 2020: Báo cáo
                    ĐTM, Giấy phép môi trường (GPMT), Đăng ký môi trường và tối
                    ưu hồ sơ pháp lý?
                  </p>
                  <p class="text-[16px] text-gray-700 leading-relaxed">
                    Môi Trường Bảo Châu tư vấn giải pháp phù hợp với từng quy mô
                    dự án, giúp doanh nghiệp hoàn thiện pháp lý nhanh chóng, an
                    tâm vận hành dài lâu.
                  </p>
                </div>
              </div>

              <!-- Card 2: Kiểm kê Khí nhà kính – ESG – CBAM -->
              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
              >
                <div>
                  <!-- Icon Box -->
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="
                      width: 52px;
                      height: 52px;
                      min-width: 52px;
                      min-height: 52px;
                    "
                  >
                    <svg
                      width="26"
                      height="26"
                      style="
                        width: 26px;
                        height: 26px;
                        min-width: 26px;
                        min-height: 26px;
                      "
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.8"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"
                      />
                    </svg>
                  </div>

                  <h2
                    class="text-2xl font-bold text-gray-900 mb-3.5 group-hover:text-primary transition-colors"
                  >
                    Kiểm kê KNK – ESG – CBAM
                  </h2>

                  <p class="text-[16px] text-gray-700 leading-relaxed mb-4">
                    Bạn muốn đo lường dấu chân carbon, xuất khẩu hàng sang EU
                    theo cơ chế CBAM hay lập Báo cáo phát triển bền vững ESG
                    chuẩn quốc tế?
                  </p>
                  <p class="text-[16px] text-gray-700 leading-relaxed">
                    Chúng tôi cung cấp giải pháp kiểm kê khí nhà kính trọn gói
                    (ISO 14064), báo cáo CBAM và lộ trình giảm phát thải giúp
                    thương hiệu nâng cao vị thế và mở rộng thị trường.
                  </p>
                </div>
              </div>

              <!-- Card 3: Hỗ trợ Kỹ thuật & Xử lý Nước thải -->
              <div
                class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
              >
                <div>
                  <!-- Icon Box -->
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 mb-6 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="
                      width: 52px;
                      height: 52px;
                      min-width: 52px;
                      min-height: 52px;
                    "
                  >
                    <svg
                      width="26"
                      height="26"
                      style="
                        width: 26px;
                        height: 26px;
                        min-width: 26px;
                        min-height: 26px;
                      "
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.8"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"
                      />
                    </svg>
                  </div>

                  <h2
                    class="text-2xl font-bold text-gray-900 mb-3.5 group-hover:text-primary transition-colors"
                  >
                    Hỗ trợ kỹ thuật &amp; Xử lý NT
                  </h2>

                  <p class="text-[16px] text-gray-700 leading-relaxed mb-4">
                    Hệ thống xử lý nước thải, khí thải gặp sự cố, chất lượng
                    nước sau xử lý chưa đạt QCVN hoặc cần bảo trì, cải tạo nâng
                    công suất?
                  </p>
                  <p class="text-[16px] text-gray-700 leading-relaxed">
                    Đội ngũ kỹ sư môi trường Bảo Châu luôn sẵn sàng hỗ trợ nhanh
                    chóng, cung cấp vi sinh hóa chất, đảm bảo hệ thống vận hành
                    ổn định, an toàn và tối ưu hiệu suất.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION: THÔNG TIN TRỤ SỞ & BẢN ĐỒ GOOGLE MAPS -->
        <section
          class="section-map-info py-12 lg:py-20 bg-gray-50/70 border-t border-b border-gray-100 relative"
        >
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <!-- Section Header Badge & Heading -->
            <div class="mb-8 lg:mb-12">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="{{ $websiteSettings['office_badge'] ?? 'TRỤ SỞ & VĂN PHÒNG' }}"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  {{ $websiteSettings['office_badge'] ?? 'TRỤ SỞ & VĂN PHÒNG' }}
                </span>
              </div>
              <h2
                class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 tracking-tight"
              >
                {{ $websiteSettings['office_title'] ?? 'Hệ thống văn phòng & Bản đồ chỉ đường' }}
              </h2>
            </div>

            <div
              class="flex flex-col lg:flex-row gap-8 lg:gap-10 items-stretch"
            >
              <!-- CỘT TRÁI: THẺ THÔNG TIN DOANH NGHIỆP BẢO CHÂU -->
              <div class="w-full lg:w-[48%] xl:w-[45%] flex flex-col">
                <div
                  class="card-item relative glass-effect bg-white/95 hover:bg-white rounded-3xl border border-black/8 shadow-md p-6 sm:p-8 h-full flex flex-col justify-between"
                >
                  <div>
                    <!-- Header Card: Logo & Tên Công Ty -->
                    <div
                      class="flex items-center gap-4 pb-6 mb-6 border-b border-gray-100"
                    >
                      <img
                        src="{{ asset("assets/images/logo-leave-png-min.png") }}"
                        alt="{{ $websiteSettings['company_name'] ?? 'Môi Trường Bảo Châu' }}"
                        width="64"
                        height="64"
                        class="size-14 sm:size-16 object-contain shrink-0"
                      />
                      <div class="flex flex-col">
                        <span
                          class="text-[11px] font-bold uppercase tracking-wider text-primary"
                          >Trụ sở chính</span
                        >
                        <h3
                          class="text-base sm:text-lg font-bold text-[#064e3b] uppercase leading-tight tracking-tight mt-0.5"
                        >
                          {{ $websiteSettings['company_short_name'] ?? ($websiteSettings['company_name'] ?? 'Môi Trường Bảo Châu') }}
                        </h3>
                        <span class="text-xs text-gray-500 font-medium mt-0.5">GPĐKKD / MST: {{ $websiteSettings['tax_id'] ?? ($websiteSettings['company_tax_id'] ?? '0317615845') }}</span>
                      </div>
                    </div>

                    <!-- 4 Hàng thông tin chi tiết -->
                    <div
                      class="space-y-5 divide-y divide-gray-100 text-gray-700"
                    >
                      <!-- 1. Địa chỉ -->
                      <div class="flex items-start gap-4">
                        <div
                          class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 size-12 min-w-12"
                        >
                          <svg
                            width="24"
                            height="24"
                            class="size-6"
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
                        </div>
                        <div class="flex-1 min-w-0">
                          <p
                            class="font-bold text-xs uppercase tracking-wider text-primary mb-1"
                          >
                            Địa chỉ trụ sở
                          </p>
                          <p
                            class="text-[15px] sm:text-[16px] font-medium text-gray-800 leading-relaxed"
                          >
                            {{ $websiteSettings['address'] ?? ($websiteSettings['company_address'] ?? '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh') }}
                          </p>
                        </div>
                      </div>

                      <!-- 2. Hotline -->
                      <div class="flex items-start gap-4 pt-5">
                        <div
                          class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 size-12 min-w-12"
                        >
                          <svg
                            width="24"
                            height="24"
                            class="size-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25z"
                            />
                          </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                          <p
                            class="font-bold text-xs uppercase tracking-wider text-primary mb-1"
                          >
                            Hotline tư vấn 24/7
                          </p>
                          <p
                            class="text-xl sm:text-2xl font-extrabold text-gray-900 flex flex-wrap gap-2 items-center"
                          >
                            <a
                              href="tel:{{ preg_replace('/[^0-9+]/', '', $websiteSettings['phone'] ?? ($websiteSettings['company_phone'] ?? '0915549148')) }}"
                              class="text-primary hover:underline"
                            >{{ $websiteSettings['phone'] ?? ($websiteSettings['company_phone'] ?? '0915 549 148') }}</a>
                            <span class="text-gray-300 font-normal">|</span>
                            <a
                              href="tel:{{ preg_replace('/[^0-9+]/', '', $websiteSettings['phone_2'] ?? ($websiteSettings['company_phone_2'] ?? '0915219148')) }}"
                              class="text-primary hover:underline"
                            >{{ $websiteSettings['phone_2'] ?? ($websiteSettings['company_phone_2'] ?? '0915 219 148') }}</a>
                          </p>
                        </div>
                      </div>

                      <!-- 3. Email -->
                      <div class="flex items-start gap-4 pt-5">
                        <div
                          class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 size-12 min-w-12"
                        >
                          <svg
                            width="24"
                            height="24"
                            class="size-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"
                            />
                          </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                          <p
                            class="font-bold text-xs uppercase tracking-wider text-primary mb-1"
                          >
                            Email tiếp nhận hồ sơ
                          </p>
                          <p
                            class="text-[15px] sm:text-[16px] font-bold text-gray-800"
                          >
                            <a
                              href="mailto:{{ $websiteSettings['email'] ?? ($websiteSettings['company_email'] ?? 'info@baochauenvir.com') }}"
                              class="hover:text-primary transition-colors"
                            >{{ $websiteSettings['email'] ?? ($websiteSettings['company_email'] ?? 'info@baochauenvir.com') }}</a>
                          </p>
                        </div>
                      </div>

                      <!-- 4. Giờ làm việc -->
                      <div class="flex items-start gap-4 pt-5">
                        <div
                          class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl shrink-0 size-12 min-w-12"
                        >
                          <svg
                            width="24"
                            height="24"
                            class="size-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                          </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                          <p
                            class="font-bold text-xs uppercase tracking-wider text-primary mb-1"
                          >
                            Giờ làm việc
                          </p>
                          <p
                            class="text-[15px] sm:text-[16px] font-medium text-gray-800 leading-relaxed"
                          >
                            {{ $websiteSettings['working_hours'] ?? ($websiteSettings['company_working_hours'] ?? 'Thứ 2 - Thứ 7: 08:00 - 17:00 (Hỗ trợ tư vấn kỹ thuật 24/7)') }}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Nút hành động trực tiếp -->
                  <div
                    class="pt-6 mt-6 border-t border-gray-100 flex flex-col sm:flex-row gap-3"
                  >
                    <a
                      href="{{ $websiteSettings['google_maps_url'] ?? ($websiteSettings['company_google_maps_url'] ?? 'https://www.google.com/maps/dir/?api=1&destination=10.7940334,106.7188971') }}"
                      target="_blank"
                      rel="noopener noreferrer nofollow"
                      class="flex-1 btn btn-secondary-2 py-3 px-4 rounded-2xl text-center text-sm font-bold flex items-center justify-center gap-2 shadow-sm"
                    >
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
                          d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"
                        />
                      </svg>
                      <span>Chỉ đường trên Google Maps</span>
                    </a>
                    <a
                      href="{{ filled($websiteSettings['zalo'] ?? ($websiteSettings['company_zalo'] ?? null)) ? (str_starts_with($websiteSettings['zalo'] ?? $websiteSettings['company_zalo'], 'http') ? ($websiteSettings['zalo'] ?? $websiteSettings['company_zalo']) : 'https://zalo.me/' . preg_replace('/[^0-9]/', '', $websiteSettings['zalo'] ?? $websiteSettings['company_zalo'])) : 'https://zalo.me/0915549148' }}"
                      target="_blank"
                      rel="noopener noreferrer nofollow"
                      class="flex-1 btn btn-primary-1 py-3 px-4 rounded-2xl text-center text-sm font-bold text-white flex items-center justify-center gap-2 shadow-md shadow-primary/25"
                    >
                      <span>Chat Zalo Tư Vấn</span>
                    </a>
                  </div>
                </div>
              </div>

              <!-- CỘT PHẢI: BẢN ĐỒ GOOGLE MAPS NHÚNG CHÍNH XÁC VỊ TRÍ CÔNG TY -->
              <div class="w-full lg:w-[52%] xl:w-[55%] flex flex-col">
                <div
                  class="rounded-3xl overflow-hidden shadow-xl border border-gray-200 bg-white relative w-full h-[550px] min-h-[550px] flex-1"
                >
                  <iframe
                    title="Bản đồ vị trí {{ $websiteSettings['company_name'] ?? 'CÔNG TY TNHH DỊCH VỤ VÀ KỸ THUẬT MÔI TRƯỜNG BẢO CHÂU' }}"
                    src="{{ $websiteSettings['google_maps_iframe'] ?? ($websiteSettings['company_google_maps_iframe'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1959.6196925392598!2d106.71760829835205!3d10.794033399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175298e1a0f4393%3A0x55592287d981db47!2zQ8OUTkcgVFkgVE5ISCBE4buKQ0ggVuG7pCBWw4AgS-G7uCBUSFXhuqxUIE3DlEkgVFLGr-G7nE5HIELhuqJPIENIw4JV!5e0!3m2!1svi!2s!4v1714000000000!5m2!1svi!2s') }}"
                    width="100%"
                    height="550"
                    style="
                      min-height: 550px;
                      height: 550px;
                      width: 100%;
                      border: 0;
                    "
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-full min-h-[550px] border-0 block object-cover"
                  ></iframe>
                </div>
              </div>
            </div>
          </div>
        </section>
@endsection
