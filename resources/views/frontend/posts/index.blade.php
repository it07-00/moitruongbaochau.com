@extends('frontend.layouts.app', ['bodyClass' => 'blog archive'])

@section('content')
<!-- 2 Background shapes chuẩn AGENTS.md 1.2 -->
        

        <!-- BREADCRUMBS -->
        <div class="container px-3 mx-auto pt-6 pb-2">
          <ul id="breadcrumbs" class="breadcrumbs flex flex-row flex-wrap items-center space-x-2 text-sm text-black" aria-label="Breadcrumbs">
            <li><a class="home hover:text-primary transition-colors font-medium text-gray-700" href="{{ route("home") }}">Trang chủ</a></li>
            <li><span class="text-gray-400">/</span></li>
            <li class="current text-primary font-semibold"><a href="{{ route("posts.index") }}">Kiến thức &amp; Tin tức môi trường</a></li>
          </ul>
        </div>

        <!-- BLOG SECTION (CHUẨN 100% BỐ CỤC TRANG CHỦ INDEX.HTML) -->
        <section class="section section-home section-blog recent_post py-8 lg:py-16">
          <div class="container px-3 mx-auto">
            <div class="all_title_recent_post flex flex-row flex-wrap items-center justify-between gap-6 mb-8 lg:mb-12">
              <div class="title_top">
                <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
                  <span class="icon-list-icon">
                    <img src="{{ asset("assets/images/asterisk.png") }}" class="size-5" width="24" height="24" alt="Tin tức" />
                  </span>
                  <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">
                    BẢN TIN BẢO CHÂU
                  </span>
                </div>
                <h1 class="font-bold leading-tight text-3xl sm:text-4xl lg:text-5xl text-gray-900">
                  <span class="text-1">Kiến thức &amp; Tin tức</span> mới cập nhật
                </h1>
              </div>

              <!-- Filter Tabs Chuẩn Trang Chủ -->
              <ul class="filter-ul filter-ul-news flex flex-row flex-wrap items-center gap-2 sm:gap-3 lg:gap-4" data-active-class="bg-primary text-white" data-inactive-class="bg-black/8 hover:bg-primary text-black/80 hover:text-white">
                <li class="shrink-0">
                  <a href="#" class="active inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-bold whitespace-nowrap c-hover bg-primary text-white shadow-xs transition-all" data-filter="-1">Tất cả</a>
                </li>
                <li class="shrink-0">
                  <a class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold whitespace-nowrap c-hover bg-black/8 hover:bg-primary text-black/80 hover:text-white transition-all" href="#" data-filter="phap-luat">Pháp luật &amp; Giấy phép MT</a>
                </li>
                <li class="shrink-0">
                  <a class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold whitespace-nowrap c-hover bg-black/8 hover:bg-primary text-black/80 hover:text-white transition-all" href="#" data-filter="khi-nha-kinh">Kiểm kê Khí nhà kính &amp; ESG</a>
                </li>
                <li class="shrink-0">
                  <a class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold whitespace-nowrap c-hover bg-black/8 hover:bg-primary text-black/80 hover:text-white transition-all" href="#" data-filter="xu-ly-nuoc-thai">Kỹ thuật Xử lý Nước thải</a>
                </li>
              </ul>
            </div>
          </div>

          <!-- CONTAINER CHỨA GRID BÀI VIẾT (CHUẨN TRANG CHỦ) -->
          <div class="w-full 2xl:max-w-[95%] px-3 mx-auto">
            <div class="p-news-list">
              <div class="filter-content-news space-y-6 sm:space-y-8">

                <!-- ==================================================== -->
                <!-- GRID SET 1: 2 NHỎ 1 LỚN (TRÁI) & 1 LỚN 2 NHỎ (PHẢI) -->
                <!-- ==================================================== -->
                <div class="filter-grid filter-grid-news grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-6 items-stretch">
                  
                  <!-- CỘT TRÁI: 2 bài nhỏ trên + 1 bài lớn dưới -->
                  <div class="group-items group-items-0 grid gap-3 sm:gap-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                      <!-- Item nhỏ 1 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Hướng Dẫn Lập Báo Cáo ĐTM & Cấp Giấy Phép Môi Trường Theo Luật BVMT 2020">
                            <img src="{{ asset("assets/images/Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Hướng Dẫn Lập Báo Cáo ĐTM & Cấp Giấy Phép Môi Trường Theo Luật BVMT 2020" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Pháp luật Môi trường">Pháp luật Môi trường</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Hướng Dẫn Lập Báo Cáo ĐTM & Cấp Giấy Phép Môi Trường Theo Luật BVMT 2020">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Hướng Dẫn Lập Báo Cáo ĐTM &amp; Cấp Giấy Phép Môi Trường Theo Luật BVMT 2020
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>

                      <!-- Item nhỏ 2 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Quy Định Bắt Buộc Kiểm Kê Khí Nhà Kính Cho Doanh Nghiệp Phát Thải Lớn">
                            <img src="{{ asset("assets/images/Lich-thang-8-768x432.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Quy Định Bắt Buộc Kiểm Kê Khí Nhà Kính Cho Doanh Nghiệp Phát Thải Lớn" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Khí Nhà Kính">Khí Nhà Kính</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Quy Định Bắt Buộc Kiểm Kê Khí Nhà Kính Cho Doanh Nghiệp Phát Thải Lớn">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Quy Định Bắt Buộc Kiểm Kê Khí Nhà Kính Cho Doanh Nghiệp Phát Thải Lớn
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>

                    <!-- Item lớn 1 (dưới cột trái) -->
                    <div class="item flex flex-col group relative">
                      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                        <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Cơ Chế Điều Chỉnh Biên Giới Carbon (CBAM) Của EU & Lời Khuyên Cho Doanh Nghiệp">
                          <img src="{{ asset("assets/images/6-768x429.png") }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="Cơ Chế Điều Chỉnh Biên Giới Carbon (CBAM) Của EU & Lời Khuyên Cho Doanh Nghiệp" decoding="async" loading="lazy" />
                        </a>
                      </div>
                      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Tư Vấn ESG">Tư Vấn ESG</a>
                        </div>
                        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Cơ Chế Điều Chỉnh Biên Giới Carbon (CBAM) Của EU & Lời Khuyên Cho Doanh Nghiệp">
                          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
                            Cơ Chế Điều Chỉnh Biên Giới Carbon (CBAM) Của EU &amp; Lời Khuyên Cho Doanh Nghiệp
                          </p>
                          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- CỘT PHẢI: 1 bài lớn trên + 2 bài nhỏ dưới -->
                  <div class="group-items group-items-1 grid gap-3 sm:gap-6">
                    <!-- Item lớn 2 (trên cột phải) -->
                    <div class="item flex flex-col group relative">
                      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                        <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Quy Trình Quan Trắc & Đo Kiểm Môi Trường Lao Động Định Kỳ Tại Nhà Máy">
                          <img src="{{ asset("assets/images/Hinh-1-768x512.jpg") }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="Quy Trình Quan Trắc & Đo Kiểm Môi Trường Lao Động Định Kỳ Tại Nhà Máy" decoding="async" loading="lazy" />
                        </a>
                      </div>
                      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Quan Trắc Môi Trường">Quan Trắc Môi Trường</a>
                        </div>
                        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Quy Trình Quan Trắc & Đo Kiểm Môi Trường Lao Động Định Kỳ Tại Nhà Máy">
                          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
                            Quy Trình Quan Trắc &amp; Đo Kiểm Môi Trường Lao Động Định Kỳ Tại Nhà Máy
                          </p>
                          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                      <!-- Item nhỏ 3 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Các Công Nghệ Xử Lý Nước Thải Tiên Tiến Giúp Tiết Kiệm Chi Phí Vận Hành">
                            <img src="{{ asset("assets/images/Thiet-ke-chua-co-ten-2-768x429.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Các Công Nghệ Xử Lý Nước Thải Tiên Tiến Giúp Tiết Kiệm Chi Phí Vận Hành" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Xử Lý Nước Thải">Xử Lý Nước Thải</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Các Công Nghệ Xử Lý Nước Thải Tiên Tiến Giúp Tiết Kiệm Chi Phí Vận Hành">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Các Công Nghệ Xử Lý Nước Thải Tiên Tiến Giúp Tiết Kiệm Chi Phí Vận Hành
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>

                      <!-- Item nhỏ 4 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Tổng Hợp Các Mức Phạt Vi Phạm Hành Chính Về Bảo Vệ Môi Trường Mới Nhất">
                            <img src="{{ asset("assets/images/118-1-768x429.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Tổng Hợp Các Mức Phạt Vi Phạm Hành Chính Về Bảo Vệ Môi Trường Mới Nhất" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Pháp Luật Môi Trường">Pháp Luật Môi Trường</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Tổng Hợp Các Mức Phạt Vi Phạm Hành Chính Về Bảo Vệ Môi Trường Mới Nhất">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Tổng Hợp Các Mức Phạt Vi Phạm Hành Chính Về Bảo Vệ Môi Trường Mới Nhất
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ==================================================== -->
                <!-- GRID SET 2: 2 NHỎ 1 LỚN (TRÁI) & 1 LỚN 2 NHỎ (PHẢI) -->
                <!-- ==================================================== -->
                <div class="filter-grid filter-grid-news grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-6 items-stretch">
                  
                  <!-- CỘT TRÁI: 2 bài nhỏ trên + 1 bài lớn dưới -->
                  <div class="group-items group-items-0 grid gap-3 sm:gap-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                      <!-- Item nhỏ 5 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho Doanh Nghiệp Xuất Khẩu">
                            <img src="{{ asset("assets/images/Bai-Dang-Bao-Chau-1024x572.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho Doanh Nghiệp Xuất Khẩu" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="ESG & Khí Nhà Kính">ESG &amp; Khí Nhà Kính</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho Doanh Nghiệp Xuất Khẩu">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Kiểm Kê Khí Nhà Kính Chuẩn ISO 14064-1 Cho Doanh Nghiệp Xuất Khẩu
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>

                      <!-- Item nhỏ 6 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Quy Trình Lập Báo Cáo ĐTM Dự Án Nhóm I & II">
                            <img src="{{ asset("assets/images/1-768x427.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Quy Trình Lập Báo Cáo ĐTM Dự Án Nhóm I & II" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Pháp Luật MT">Pháp Luật MT</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Quy Trình Lập Báo Cáo ĐTM Dự Án Nhóm I & II">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Quy Trình Lập Báo Cáo ĐTM Dự Án Nhóm I &amp; II
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>

                    <!-- Item lớn 3 (dưới cột trái) -->
                    <div class="item flex flex-col group relative">
                      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                        <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Đánh Giá Vòng Đời Sản Phẩm (LCA): Chìa Khóa Đạt Chứng Chỉ Xanh Xuất Khẩu Thị Trường EU & Mỹ">
                          <img src="{{ asset("assets/images/5.-ceragem-1024x683.jpg") }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="Đánh Giá Vòng Đời Sản Phẩm (LCA): Chìa Khóa Đạt Chứng Chỉ Xanh Xuất Khẩu Thị Trường EU & Mỹ" decoding="async" loading="lazy" />
                        </a>
                      </div>
                      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Phát Triển Bền Vững">Phát Triển Bền Vững</a>
                        </div>
                        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Đánh Giá Vòng Đời Sản Phẩm (LCA): Chìa Khóa Đạt Chứng Chỉ Xanh Xuất Khẩu Thị Trường EU & Mỹ">
                          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
                            Đánh Giá Vòng Đời Sản Phẩm (LCA): Chìa Khóa Đạt Chứng Chỉ Xanh Xuất Khẩu Thị Trường EU &amp; Mỹ
                          </p>
                          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>
                    </div>
                  </div>

                  <!-- CỘT PHẢI: 1 bài lớn trên + 2 bài nhỏ dưới -->
                  <div class="group-items group-items-1 grid gap-3 sm:gap-6">
                    <!-- Item lớn 4 (trên cột phải) -->
                    <div class="item flex flex-col group relative">
                      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                        <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Lộ Trình Chuyển Đổi Năng Lượng & Kiểm Toán Năng Lượng Cho Nhà Máy Hướng Đến Net Zero 2050">
                          <img src="{{ asset("assets/images/moi-truong-bao-chau-1024x603.jpg") }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="Lộ Trình Chuyển Đổi Năng Lượng & Kiểm Toán Năng Lượng Cho Nhà Máy Hướng Đến Net Zero 2050" decoding="async" loading="lazy" />
                        </a>
                      </div>
                      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Tư Vấn Chiến Lược">Tư Vấn Chiến Lược</a>
                        </div>
                        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Lộ Trình Chuyển Đổi Năng Lượng & Kiểm Toán Năng Lượng Cho Nhà Máy Hướng Đến Net Zero 2050">
                          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
                            Lộ Trình Chuyển Đổi Năng Lượng &amp; Kiểm Toán Năng Lượng Cho Nhà Máy Hướng Đến Net Zero 2050
                          </p>
                          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                          </svg>
                        </a>
                      </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                      <!-- Item nhỏ 7 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Ứng Dụng Công Nghệ Màng MBR Trong Xử Lý Nước Thải Dệt Nhuộm">
                            <img src="{{ asset("assets/images/CTY-TAN-TIEN-1024x640.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Ứng Dụng Công Nghệ Màng MBR Trong Xử Lý Nước Thải Dệt Nhuộm" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Công Nghệ XLNT">Công Nghệ XLNT</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Ứng Dụng Công Nghệ Màng MBR Trong Xử Lý Nước Thải Dệt Nhuộm">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Ứng Dụng Công Nghệ Màng MBR Trong Xử Lý Nước Thải Dệt Nhuộm
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>

                      <!-- Item nhỏ 8 -->
                      <div class="item flex flex-col group relative">
                        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
                          <a class="block w-full c-scale-effect" href="{{ route("posts.index") }}" aria-label="Bảo Châu Nghiệm Thu Hệ Thống Xử Lý Nước Thải 1.200 m³/ngày Cho Nhà Máy Thực Phẩm">
                            <img src="{{ asset("assets/images/4-768x427.png") }}" class="w-full object-cover as-16-9" width="768" height="512" alt="Bảo Châu Nghiệm Thu Hệ Thống Xử Lý Nước Thải 1.200 m³/ngày Cho Nhà Máy Thực Phẩm" decoding="async" loading="lazy" />
                          </a>
                        </div>
                        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
                          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
                            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route("posts.index") }}" title="Dự Án Tiêu Biểu">Dự Án Tiêu Biểu</a>
                          </div>
                          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route("posts.index") }}" title="Bảo Châu Nghiệm Thu Hệ Thống Xử Lý Nước Thải 1.200 m³/ngày Cho Nhà Máy Thực Phẩm">
                            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
                              Bảo Châu Nghiệm Thu Hệ Thống Xử Lý Nước Thải 1.200 m³/ngày
                            </p>
                            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
                              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
                            </svg>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <!-- PHÂN TRANG (PAGINATION) -->
            <nav class="nav-pagination" aria-label="Pagination">
              <ul class="pagination flex items-center justify-center flex-row flex-wrap gap-2.5 sm:gap-3.5 mt-12 lg:mt-16">
                <li class="size-11 sm:size-12 md:size-13">
                  <span aria-current="page" class="current size-11 sm:size-12 md:size-13 rounded-full bg-primary text-white font-bold text-base sm:text-lg flex items-center justify-center shadow-lg shadow-primary/30 transition-transform">1</span>
                </li>
                <li class="size-11 sm:size-12 md:size-13">
                  <a href="#" class="size-11 sm:size-12 md:size-13 rounded-full bg-white hover:bg-primary hover:text-white border border-gray-200/90 text-gray-700 font-bold text-base sm:text-lg flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md active:scale-95">2</a>
                </li>
                <li class="size-11 sm:size-12 md:size-13">
                  <a href="#" class="size-11 sm:size-12 md:size-13 rounded-full bg-white hover:bg-primary hover:text-white border border-gray-200/90 text-gray-700 font-bold text-base sm:text-lg flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md active:scale-95">3</a>
                </li>
                <li class="size-11 sm:size-12 md:size-13 flex items-center justify-center">
                  <span class="dots ellipsis size-11 sm:size-12 md:size-13 flex items-center justify-center text-gray-400 font-bold tracking-widest">
                    <svg class="size-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                      <circle cx="4" cy="12" r="2.2"/>
                      <circle cx="12" cy="12" r="2.2"/>
                      <circle cx="20" cy="12" r="2.2"/>
                    </svg>
                  </span>
                </li>
                <li class="size-11 sm:size-12 md:size-13">
                  <a href="#" class="size-11 sm:size-12 md:size-13 rounded-full bg-white hover:bg-primary hover:text-white border border-gray-200/90 text-gray-700 font-bold text-base sm:text-lg flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md active:scale-95">12</a>
                </li>
                <li class="size-11 sm:size-12 md:size-13">
                  <a class="next size-11 sm:size-12 md:size-13 rounded-full bg-white hover:bg-primary hover:text-white border border-gray-200/90 text-gray-700 font-bold text-base sm:text-lg flex items-center justify-center transition-all duration-200 shadow-xs hover:shadow-md active:scale-95" href="#" aria-label="Trang tiếp">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 sm:size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </section>

        <!-- NEWSLETTER SUBSCRIPTION SECTION -->
        <section class="section relative pb-16 lg:pb-24">
          <div class="container px-3 mx-auto">
            <div
              class="card-item relative glass-effect border border-black/8 bg-white/95 rounded-3xl p-8 lg:p-12 shadow-sm text-center max-w-4xl mx-auto overflow-hidden"
            >
              <div class="inline-flex items-center gap-2 mb-3">
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
                  class="icon-list-text text-primary font-bold uppercase text-xs sm:text-sm tracking-wider"
                >
                  BẢN TIN PHÁP LUẬT MÔI TRƯỜNG
                </span>
              </div>
              <h3
                class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3"
              >
                Nhận Cẩm Nang &amp; Bản Tin Môi Trường Hàng Tuần
              </h3>
              <p
                class="text-gray-600 text-sm sm:text-base max-w-xl mx-auto mb-6"
              >
                Đăng ký email để nhận ngay các thông tư, nghị định mới nhất và tài
                liệu hướng dẫn kiểm kê khí nhà kính độc quyền từ Môi Trường Bảo
                Châu.
              </p>
              <form
                action="#"
                class="flex flex-col sm:flex-row items-center gap-3 max-w-lg mx-auto"
              >
                <input
                  type="email"
                  required
                  placeholder="Nhập địa chỉ email của bạn..."
                  class="w-full sm:flex-1 bg-gray-50 border border-gray-200 text-sm rounded-full px-5 py-3.5 text-gray-800 focus:outline-none focus:border-primary focus:bg-white transition-all shadow-xs"
                />
                <button
                  type="submit"
                  class="w-full sm:w-auto btn btn-primary-1 py-3.5 px-7 rounded-full shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-primary/30 transition-all font-bold text-sm shrink-0 cursor-pointer"
                >
                  <span>Đăng ký ngay</span>
                </button>
              </form>
            </div>
          </div>
        </section>
@endsection
