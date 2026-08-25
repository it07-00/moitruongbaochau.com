@extends('frontend.layouts.app', ['bodyClass' => 'blog archive'])

@section('content')
<!-- 2 Background shapes chuẩn AGENTS.md 1.2 -->
        

        <!-- BLOG SECTION (CHUẨN 100% BỐ CỤC TRANG CHỦ INDEX.HTML) -->
        <section class="section section-home section-blog recent_post pt-10 pb-8 lg:pt-14 lg:pb-16">
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

              <!-- Filter Tabs -->
              <ul class="flex flex-row flex-wrap items-center gap-2 sm:gap-3 lg:gap-4">
                <li class="shrink-0">
                  <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-bold whitespace-nowrap c-hover {{ !request('category') ? 'bg-primary text-white shadow-xs' : 'bg-black/8 hover:bg-primary text-black/80 hover:text-white font-semibold' }} transition-all">Tất cả</a>
                </li>
                @foreach ($postCategories as $cat)
                <li class="shrink-0">
                  <a class="inline-flex items-center justify-center px-4 sm:px-5 py-2 sm:py-2.5 rounded-full text-sm sm:text-base font-semibold whitespace-nowrap c-hover {{ request('category') === $cat->slug ? 'bg-primary text-white shadow-xs font-bold' : 'bg-black/8 hover:bg-primary text-black/80 hover:text-white' }} transition-all" href="{{ route('posts.index', ['category' => $cat->slug]) }}">{{ $cat->name }}</a>
                </li>
                @endforeach
              </ul>
            </div>
          </div>

          <!-- CONTAINER CHỨA GRID BÀI VIẾT (CHUẨN TRANG CHỦ) -->
          <div class="w-full 2xl:max-w-[95%] px-3 mx-auto">
            <div class="p-news-list">
              <div class="space-y-6 sm:space-y-8">
                @forelse ($posts->chunk(6) as $set)
                  @include('frontend.partials.news-grid-set', ['posts' => $set])
                @empty
                <div class="text-center py-16 text-gray-500 font-medium">
                  Chưa có bài viết nào trong danh mục này.
                </div>
                @endforelse
              </div>
            </div>

            <!-- PHÂN TRANG (PAGINATION) -->
            @if ($posts->hasPages())
            <div class="mt-12 lg:mt-16">
              {{ $posts->links() }}
            </div>
            @endif
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
