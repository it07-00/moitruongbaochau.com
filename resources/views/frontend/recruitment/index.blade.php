@extends('frontend.layouts.app', ['bodyClass' => 'archive post-type-archive post-type-archive-recruitment'])

@section('content')
        <!-- HERO SECTION: CƠ HỘI NGHỀ NGHIỆP -->
        <section class="section section-recruitment-hero py-8 sm:py-12 relative overflow-hidden">
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <div class="max-w-4xl mx-auto text-center">
              <!-- Subtitle Badge Chuẩn AGENTS.md -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Cơ hội nghề nghiệp"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  CƠ HỘI NGHỀ NGHIỆP TẠI BẢO CHÂU
                </span>
              </div>
              <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-black leading-tight mb-4 sm:mb-6">
                Gia Nhập Đội Ngũ Chuyên Gia <span class="text-primary">Môi Trường Bảo Châu</span>
              </h1>
              <p class="text-base sm:text-lg text-black leading-relaxed mb-8 max-w-3xl mx-auto">
                Đồng hành cùng Bảo Châu kiến tạo các giải pháp bảo vệ môi trường và phát triển bền vững (ESG - Net Zero). Chúng tôi chào đón những nhân sự tài năng, nhiệt huyết và có đam mê cống hiến cho môi trường Việt Nam.
              </p>
              <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                <a
                  href="#vi-tri-tuyen-dung"
                  class="btn btn-primary-1 py-3 sm:py-3.5 px-6 sm:px-8 rounded-full font-bold text-sm sm:text-base text-white shadow-lg shadow-primary/25 hover:shadow-primary/80 transition-all inline-flex items-center gap-2"
                >
                  <span>Xem vị trí tuyển dụng</span>
                  <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                  </svg>
                </a>
                <a
                  href="#form-ung-tuyen"
                  class="btn btn-secondary-2 py-3 sm:py-3.5 px-6 sm:px-8 rounded-full font-bold text-sm sm:text-base text-black bg-white/90 hover:bg-white border border-black/10 shadow-sm transition-all inline-flex items-center gap-2"
                >
                  <span>Nộp hồ sơ ngay</span>
                </a>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION 1: TẠI SAO CHỌN MÔI TRƯỜNG BẢO CHÂU (WHY JOIN US) -->
        <section class="section section-benefits py-10 lg:py-16 relative overflow-hidden">
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-10 lg:mb-14">
              <!-- Subtitle Badge Chuẩn AGENTS.md -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Phúc lợi vượt trội"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  VĂN HÓA &amp; PHÚC LỢI VƯỢT TRỘI
                </span>
              </div>
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-black leading-tight">
                Vì Sao Bạn Nên Chọn Đồng Hành Cùng Bảo Châu?
              </h2>
              <p class="text-sm sm:text-base text-black mt-3">
                Chúng tôi tin rằng con người là tài sản quý giá nhất. Tại Bảo Châu, bạn được trao quyền tự chủ, ghi nhận xứng đáng và tạo mọi điều kiện để bứt phá giới hạn bản thân.
              </p>
            </div>

            <!-- 4 Card Benefits Chuẩn AGENTS.md -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <!-- Benefit 1 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6 shrink-0 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; max-width: 52px; max-height: 52px;"
                  >
                    <svg
                      width="26"
                      height="26"
                      style="width: 26px; height: 26px; min-width: 26px; min-height: 26px;"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                  </div>
                  <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Thu Nhập &amp; Thưởng Hấp Dẫn</h3>
                  <p class="text-sm text-black leading-relaxed">
                    Lương cứng cạnh tranh theo năng lực + Thưởng % hoa hồng dự án theo KPI + Lương tháng 13, 14 và các khoản thưởng nóng khi hoàn thành xuất sắc.
                  </p>
                </div>
              </div>

              <!-- Benefit 2 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6 shrink-0 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; max-width: 52px; max-height: 52px;"
                  >
                    <svg
                      width="26"
                      height="26"
                      style="width: 26px; height: 26px; min-width: 26px; min-height: 26px;"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                    </svg>
                  </div>
                  <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Lộ Trình Thăng Tiến Rõ Ràng</h3>
                  <p class="text-sm text-black leading-relaxed">
                    Đánh giá hiệu suất định kỳ 6 tháng/lần. Được đài thọ 100% chi phí các khóa đào tạo nâng cao chứng chỉ kiểm kê KNK, CBAM, ESG quốc tế.
                  </p>
                </div>
              </div>

              <!-- Benefit 3 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6 shrink-0 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; max-width: 52px; max-height: 52px;"
                  >
                    <svg
                      width="26"
                      height="26"
                      style="width: 26px; height: 26px; min-width: 26px; min-height: 26px;"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                  </div>
                  <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Môi Trường Chuyên Nghiệp</h3>
                  <p class="text-sm text-black leading-relaxed">
                    Văn phòng tiện nghi, không gian mở năng động, đồng nghiệp thân thiện, tôn trọng sự khác biệt và luôn hỗ trợ nhau giải quyết vấn đề kỹ thuật.
                  </p>
                </div>
              </div>

              <!-- Benefit 4 -->
              <div class="card-item relative glass-effect group focus:outline-none border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-6 xl:p-8 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                <div>
                  <div
                    class="flex items-center justify-center bg-primary/10 text-primary rounded-2xl mb-6 shrink-0 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300"
                    style="width: 52px; height: 52px; min-width: 52px; min-height: 52px; max-width: 52px; max-height: 52px;"
                  >
                    <svg
                      width="26"
                      height="26"
                      style="width: 26px; height: 26px; min-width: 26px; min-height: 26px;"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 0 1-1.5 1.5H4.5a1.5 1.5 0 0 1-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 1 0 9.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1 1 14.625 7.5H12m0 0V21m-8.625-9.75h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                  </div>
                  <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Phúc Lợi Toàn Diện</h3>
                  <p class="text-sm text-black leading-relaxed">
                    Đầy đủ chế độ BHXH, BHYT, BHTN; khám sức khỏe tổng quát định kỳ hàng năm; du lịch nghỉ dưỡng 1-2 lần/năm; quà tặng sinh nhật và lễ tết chu đáo.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION 2: VỊ TRÍ ĐANG TUYỂN DỤNG (JOB OPENINGS TABLE LIST) -->
        <section id="vi-tri-tuyen-dung" class="section section-jobs py-12 lg:py-20 relative overflow-hidden bg-gray-50/30">
          <div class="container px-3 sm:px-4 mx-auto relative z-10 max-w-7xl">
            <!-- Header Title Chuẩn AGENTS.md -->
            <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Vị trí tuyển dụng"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  CƠ HỘI NGHỀ NGHIỆP
                </span>
              </div>
              <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-black leading-tight">
                Các vị trí <span class="text-primary">tuyển dụng</span>
              </h2>
            </div>

            <!-- Minimalist Jobs Table With Spaced Cards -->
            <div class="w-full overflow-x-auto pb-4">
              <table class="w-full text-left" style="min-width: 960px; width: 100%; border-collapse: separate; border-spacing: 0 16px;">
                <thead>
                  <tr class="text-black text-base lg:text-lg font-extrabold uppercase tracking-wider">
                    <th class="py-3 px-6 sm:px-8 font-extrabold text-left" style="width: 38%;">Vị trí</th>
                    <th class="py-3 px-6 font-extrabold text-center" style="width: 16%;">Hình thức</th>
                    <th class="py-3 px-6 font-extrabold text-center" style="width: 18%;">Địa điểm làm việc</th>
                    <th class="py-3 px-6 font-extrabold text-center" style="width: 14%;">Hạn nộp</th>
                    <th class="py-3 px-6 sm:px-8 font-extrabold text-right" style="width: 14%;">Ứng tuyển</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($jobs as $job)
                  <tr class="card-row bg-white hover:bg-emerald-50/40 transition-all shadow-xs hover:shadow-md">
                    <td class="py-5 sm:py-6 px-6 sm:px-8 font-bold text-lg sm:text-xl text-black rounded-l-2xl border-y border-l border-black/10">
                      <a href="{{ route('recruitment.show', $job->slug) }}" class="hover:text-primary transition-colors inline-block">
                        {{ $job->title }}
                      </a>
                    </td>
                    <td class="py-5 sm:py-6 px-6 text-center text-base sm:text-lg font-medium text-black border-y border-black/10">
                      {{ $job->employment_type ?? 'Toàn thời gian' }}
                    </td>
                    <td class="py-5 sm:py-6 px-6 text-center text-base sm:text-lg text-black border-y border-black/10">
                      <div class="inline-flex items-center gap-2 justify-center">
                        <svg width="18" height="18" style="width: 18px; height: 18px; min-width: 18px; min-height: 18px;" class="text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span class="font-medium">{{ $job->location ?? 'TP. HCM' }}</span>
                      </div>
                    </td>
                    <td class="py-5 sm:py-6 px-6 text-center text-base sm:text-lg font-medium text-black border-y border-black/10">
                      {{ $job->expires_at ? $job->expires_at->format('d/m/Y') : 'Đang nhận hồ sơ' }}
                    </td>
                    <td class="py-5 sm:py-6 px-6 sm:px-8 text-right rounded-r-2xl border-y border-r border-black/10">
                      <a
                        href="{{ route('recruitment.show', $job->slug) }}"
                        class="inline-flex items-center justify-center border-2 border-primary text-primary hover:bg-primary hover:text-white rounded-2xl px-6 sm:px-8 py-2 sm:py-2.5 text-sm sm:text-base font-bold transition-all whitespace-nowrap shadow-xs hover:shadow-md"
                      >
                        Ứng tuyển
                      </a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="py-12 text-center text-gray-500 font-medium bg-white rounded-2xl border border-black/10">
                      Hiện tại đang cập nhật các vị trí tuyển dụng mới. Quý ứng viên vui lòng quay lại sau!
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>

              @if($jobs->hasPages())
              <div class="mt-8 flex justify-center">
                {{ $jobs->links() }}
              </div>
              @endif
            </div>
          </div>
        </section>

        <!-- SECTION 3: QUY TRÌNH TUYỂN DỤNG (RECRUITMENT PROCESS) -->
        <section class="section section-process py-10 lg:py-16 relative overflow-hidden">
          <div class="container px-3 sm:px-4 mx-auto relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-10 lg:mb-14">
              <!-- Subtitle Badge Chuẩn AGENTS.md -->
              <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                <span class="icon-list-icon">
                  <img
                    src="{{ asset("assets/images/asterisk.png") }}"
                    class="size-5"
                    width="24"
                    height="24"
                    alt="Quy trình tuyển dụng"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  QUY TRÌNH TUYỂN DỤNG 4 BƯỚC
                </span>
              </div>
              <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-black leading-tight">
                Hành Trình Gia Nhập Bảo Châu
              </h2>
              <p class="text-sm sm:text-base text-black mt-3">
                Quy trình ứng tuyển nhanh chóng, minh bạch và tôn trọng trải nghiệm của từng ứng viên.
              </p>
            </div>

            <div class="cards grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-8 max-w-7xl mx-auto">
              <!-- Step 1 -->
              <div class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 xl:p-8 text-center shadow-sm hover:shadow-lg transition-all flex flex-col items-center">
                <div
                  class="rounded-full bg-primary text-white font-extrabold text-xl flex items-center justify-center mb-4 shadow-md shadow-primary/30 shrink-0"
                  style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;"
                >
                  1
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Nộp Hồ Sơ</h3>
                <p class="text-xs sm:text-sm text-black leading-relaxed">
                  Gửi CV qua Form trực tuyến hoặc Email tuyển dụng <strong class="text-primary">hr@baochauenvir.com</strong>.
                </p>
              </div>

              <!-- Step 2 -->
              <div class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 xl:p-8 text-center shadow-sm hover:shadow-lg transition-all flex flex-col items-center">
                <div
                  class="rounded-full bg-primary text-white font-extrabold text-xl flex items-center justify-center mb-4 shadow-md shadow-primary/30 shrink-0"
                  style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;"
                >
                  2
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Sàng Lọc &amp; Phỏng Vấn</h3>
                <p class="text-xs sm:text-sm text-black leading-relaxed">
                  Phòng Nhân sự liên hệ phản hồi trong 24h và sắp xếp lịch phỏng vấn chuyên môn cùng Trưởng bộ phận.
                </p>
              </div>

              <!-- Step 3 -->
              <div class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 xl:p-8 text-center shadow-sm hover:shadow-lg transition-all flex flex-col items-center">
                <div
                  class="rounded-full bg-primary text-white font-extrabold text-xl flex items-center justify-center mb-4 shadow-md shadow-primary/30 shrink-0"
                  style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;"
                >
                  3
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Thư Mời Nhận Việc</h3>
                <p class="text-xs sm:text-sm text-black leading-relaxed">
                  Gửi Thư mời làm việc (Offer Letter) chính thức với mức lương, thưởng và chế độ đãi ngộ minh bạch.
                </p>
              </div>

              <!-- Step 4 -->
              <div class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 xl:p-8 text-center shadow-sm hover:shadow-lg transition-all flex flex-col items-center">
                <div
                  class="rounded-full bg-primary text-white font-extrabold text-xl flex items-center justify-center mb-4 shadow-md shadow-primary/30 shrink-0"
                  style="width: 48px; height: 48px; min-width: 48px; min-height: 48px;"
                >
                  4
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-black mb-2">Onboarding &amp; Nhận Việc</h3>
                <p class="text-xs sm:text-sm text-black leading-relaxed">
                  Chào đón thành viên mới, tham gia khóa đào tạo hội nhập văn hóa và bắt đầu sự nghiệp cùng Bảo Châu.
                </p>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION 4: FORM ỨNG TUYỂN & LIÊN HỆ PHÒNG NHÂN SỰ -->
        <section id="form-ung-tuyen" class="section section-apply py-12 lg:py-20 relative overflow-hidden bg-gray-50/70">
          <div class="container px-3 sm:px-4 mx-auto relative z-10 max-w-7xl">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start w-full">
              <!-- Left Info Column -->
              <div class="w-full lg:w-5/12 space-y-6 shrink-0">
                <!-- Subtitle Badge Chuẩn AGENTS.md -->
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-2">
                  <span class="icon-list-icon">
                    <img
                      src="{{ asset("assets/images/asterisk.png") }}"
                      class="size-5"
                      width="24"
                      height="24"
                      alt="Nộp hồ sơ"
                    />
                  </span>
                  <span
                    class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                  >
                    PHÒNG TUYỂN DỤNG &amp; NHÂN SỰ
                  </span>
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-black leading-tight">
                  Sẵn Sàng Cho Bước Ngoặt Sự Nghiệp?
                </h2>
                <p class="text-sm sm:text-base text-black leading-relaxed">
                  Hãy gửi thông tin của bạn hoặc liên hệ trực tiếp với Bộ phận Tuyển dụng để được hỗ trợ và giải đáp mọi thắc mắc về các vị trí đang tuyển.
                </p>

                <!-- HR Contact Details -->
                <div class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-6 sm:p-7 space-y-4 shadow-sm">
                  <div class="flex items-start gap-4">
                    <div
                      class="rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0"
                      style="width: 44px; height: 44px; min-width: 44px; min-height: 44px;"
                    >
                      <svg
                        width="20"
                        height="20"
                        style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs font-bold uppercase tracking-wider text-primary">Hotline Tuyển dụng (Zalo)</p>
                      <p class="text-base font-bold text-black">0915 549 148 <span class="text-xs font-normal text-black/70">(Ms. San San - HR Manager)</span></p>
                    </div>
                  </div>

                  <div class="flex items-start gap-4">
                    <div
                      class="rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0"
                      style="width: 44px; height: 44px; min-width: 44px; min-height: 44px;"
                    >
                      <svg
                        width="20"
                        height="20"
                        style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs font-bold uppercase tracking-wider text-primary">Email Tiếp nhận CV</p>
                      <p class="text-base font-bold text-black">hr@baochauenvir.com</p>
                      <p class="text-xs text-black/70">Tiêu đề: [Vị trí ứng tuyển] - Họ và tên</p>
                    </div>
                  </div>

                  <div class="flex items-start gap-4">
                    <div
                      class="rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0"
                      style="width: 44px; height: 44px; min-width: 44px; min-height: 44px;"
                    >
                      <svg
                        width="20"
                        height="20"
                        style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                      </svg>
                    </div>
                    <div>
                      <p class="text-xs font-bold uppercase tracking-wider text-primary">Địa điểm làm việc</p>
                      <p class="text-sm font-semibold text-black">180/40 Nguyễn Hữu Cảnh, P. Thạnh Mỹ Tây, TP. Hồ Chí Minh</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Apply Form Column (Livewire Real-time Validation & File Upload) -->
              <div class="w-full lg:w-7/12 flex-1">
                <div class="card-item relative glass-effect border border-black/8 bg-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-lg">
                  <h3 class="text-xl sm:text-2xl font-bold text-black mb-1">
                    Gửi Hồ Sơ Ứng Tuyển Trực Tuyến
                  </h3>
                  <p class="text-xs sm:text-sm text-black mb-6">
                    Điền thông tin bên dưới, chuyên viên nhân sự Bảo Châu sẽ phản hồi bạn trong vòng 24 giờ.
                  </p>

                  <livewire:frontend.job-application-form />
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- SECTION 5: SLIDER ĐỐI TÁC KHÁCH HÀNG (CHUẨN AGENTS.MD 2 HÀNG LOGO CHẠY VÔ TẬN) -->
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
                    alt="Đối tác tiêu biểu"
                  />
                </span>
                <span
                  class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  ĐỐI TÁC &amp; KHÁCH HÀNG TIÊU BIỂU
                </span>
              </div>
              <h2
                class="font-bold text-2xl md:text-3xl lg:text-4xl text-gray-900 leading-tight"
              >
                Môi Trường Bảo Châu – Đồng Hành Cùng Hơn
                <span class="text-primary">500+ Doanh Nghiệp</span>
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
                        alt="The Gioi In An Logo"
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
@endsection
