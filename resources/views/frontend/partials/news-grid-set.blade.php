@props(['posts'])

@php
  $p0 = $posts->get(0);
  $p1 = $posts->get(1);
  $p2 = $posts->get(2);
  $p3 = $posts->get(3);
  $p4 = $posts->get(4);
  $p5 = $posts->get(5);
@endphp

<div class="filter-grid filter-grid-news grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-6 items-stretch">
  <!-- Cột trái: 2 bài nhỏ trên + 1 bài lớn dưới -->
  <div class="group-items group-items-0 grid gap-3 sm:gap-6">
    @if ($p0 || $p1)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
      @if ($p0)
      @php
        $catSlug = $p0->category?->slug ?? '';
        $catName = $p0->category?->name ?? 'Tin tức';
        $imgSrc = str_starts_with($p0->thumbnail ?? '', 'http') ? $p0->thumbnail : (str_starts_with($p0->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p0->thumbnail) : asset('assets/images/' . ($p0->thumbnail ?: 'Huong-Dan-Thuc-Hien-Dang-Ky-Moi-Truong-768x432.png')));
      @endphp
      <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
          <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p0->slug) }}" aria-label="{{ $p0->title }}">
            <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="768" height="512" alt="{{ $p0->title }}" decoding="async" loading="lazy" />
          </a>
        </div>
        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p0->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
          </div>
          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p0->slug) }}" title="{{ $p0->title }}">
            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
              {{ $p0->title }}
            </p>
            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
            </svg>
          </a>
        </div>
      </div>
      @endif

      @if ($p1)
      @php
        $catSlug = $p1->category?->slug ?? '';
        $catName = $p1->category?->name ?? 'Tin tức';
        $imgSrc = str_starts_with($p1->thumbnail ?? '', 'http') ? $p1->thumbnail : (str_starts_with($p1->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p1->thumbnail) : asset('assets/images/' . ($p1->thumbnail ?: 'Lich-thang-8-768x432.png')));
      @endphp
      <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
          <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p1->slug) }}" aria-label="{{ $p1->title }}">
            <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="768" height="512" alt="{{ $p1->title }}" decoding="async" loading="lazy" />
          </a>
        </div>
        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p1->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
          </div>
          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p1->slug) }}" title="{{ $p1->title }}">
            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
              {{ $p1->title }}
            </p>
            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
            </svg>
          </a>
        </div>
      </div>
      @endif
    </div>
    @endif

    @if ($p2)
    @php
      $catSlug = $p2->category?->slug ?? '';
      $catName = $p2->category?->name ?? 'Tin tức';
      $imgSrc = str_starts_with($p2->thumbnail ?? '', 'http') ? $p2->thumbnail : (str_starts_with($p2->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p2->thumbnail) : asset('assets/images/' . ($p2->thumbnail ?: '6-768x429.png')));
    @endphp
    <!-- Item lớn 1 (dưới cột trái) -->
    <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
        <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p2->slug) }}" aria-label="{{ $p2->title }}">
          <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="{{ $p2->title }}" decoding="async" loading="lazy" />
        </a>
      </div>
      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p2->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
        </div>
        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p2->slug) }}" title="{{ $p2->title }}">
          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
            {{ $p2->title }}
          </p>
          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
          </svg>
        </a>
      </div>
    </div>
    @endif
  </div>

  <!-- Cột phải: 1 bài lớn trên + 2 bài nhỏ dưới -->
  <div class="group-items group-items-1 grid gap-3 sm:gap-6">
    @if ($p3)
    @php
      $catSlug = $p3->category?->slug ?? '';
      $catName = $p3->category?->name ?? 'Tin tức';
      $imgSrc = str_starts_with($p3->thumbnail ?? '', 'http') ? $p3->thumbnail : (str_starts_with($p3->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p3->thumbnail) : asset('assets/images/' . ($p3->thumbnail ?: 'Hinh-1-768x512.jpg')));
    @endphp
    <!-- Item lớn 2 (trên cột phải) -->
    <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
      <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
        <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p3->slug) }}" aria-label="{{ $p3->title }}">
          <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="1024" height="683" alt="{{ $p3->title }}" decoding="async" loading="lazy" />
        </a>
      </div>
      <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
        <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
          <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p3->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
        </div>
        <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p3->slug) }}" title="{{ $p3->title }}">
          <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title item-large text-lg sm:text-xl">
            {{ $p3->title }}
          </p>
          <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
            <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
          </svg>
        </a>
      </div>
    </div>
    @endif

    @if ($p4 || $p5)
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
      @if ($p4)
      @php
        $catSlug = $p4->category?->slug ?? '';
        $catName = $p4->category?->name ?? 'Tin tức';
        $imgSrc = str_starts_with($p4->thumbnail ?? '', 'http') ? $p4->thumbnail : (str_starts_with($p4->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p4->thumbnail) : asset('assets/images/' . ($p4->thumbnail ?: 'Thiet-ke-chua-co-ten-2-768x429.png')));
      @endphp
      <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
          <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p4->slug) }}" aria-label="{{ $p4->title }}">
            <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="768" height="512" alt="{{ $p4->title }}" decoding="async" loading="lazy" />
          </a>
        </div>
        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p4->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
          </div>
          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p4->slug) }}" title="{{ $p4->title }}">
            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
              {{ $p4->title }}
            </p>
            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
            </svg>
          </a>
        </div>
      </div>
      @endif

      @if ($p5)
      @php
        $catSlug = $p5->category?->slug ?? '';
        $catName = $p5->category?->name ?? 'Tin tức';
        $imgSrc = str_starts_with($p5->thumbnail ?? '', 'http') ? $p5->thumbnail : (str_starts_with($p5->thumbnail ?? '', 'uploads/') ? asset('storage/' . $p5->thumbnail) : asset('assets/images/' . ($p5->thumbnail ?: '118-1-768x429.png')));
      @endphp
      <div class="item flex flex-col group relative" data-category="{{ $catSlug }}">
        <div class="c-cover rounded-xl md:rounded-2xl overflow-hidden">
          <a class="block w-full c-scale-effect" href="{{ route('posts.show', $p5->slug) }}" aria-label="{{ $p5->title }}">
            <img src="{{ $imgSrc }}" class="w-full object-cover as-16-9" width="768" height="512" alt="{{ $p5->title }}" decoding="async" loading="lazy" />
          </a>
        </div>
        <div class="c-content pointer-events-none flex flex-col gap-3 absolute left-0 bottom-0 w-full px-4 pb-4 pt-8 rounded-xl md:rounded-2xl">
          <div class="c-terms flex flex-wrap items-center gap-2 pointer-events-auto">
            <a class="w-fit rounded-full inline-flex items-center px-3 py-1 text-white bg-primary/20 backdrop-blur-xs text-sm font-normal" href="{{ route('posts.show', $p5->slug) }}" title="{{ $catName }}">{{ $catName }}</a>
          </div>
          <a class="flex items-center w-full justify-between gap-3 pointer-events-auto" href="{{ route('posts.show', $p5->slug) }}" title="{{ $p5->title }}">
            <p class="text-white text-shadow-white/20 font-bold line-clamp-2 c-content-title">
              {{ $p5->title }}
            </p>
            <svg class="size-4 text-white flex-none opacity-0 group-hover:opacity-100 transition-opacity" xmlns="http://www.w3.org/2000/svg" width="18" height="12" viewBox="0 0 18 12" fill="none">
              <path d="M16.9014 6.05377C17.1943 5.76088 17.1943 5.286 16.9014 4.99311L12.1285 0.220138C11.8356 -0.0727557 11.3607 -0.0727558 11.0678 0.220138C10.7749 0.513031 10.7749 0.987905 11.0678 1.2808L15.3104 5.52344L11.0678 9.76608C10.7749 10.059 10.7749 10.5338 11.0678 10.8267C11.3607 11.1196 11.8356 11.1196 12.1285 10.8267L16.9014 6.05377ZM0 5.52344L-6.55671e-08 6.27344L16.3711 6.27344L16.3711 5.52344L16.3711 4.77344L6.55671e-08 4.77344L0 5.52344Z" fill="currentColor"></path>
            </svg>
          </a>
        </div>
      </div>
      @endif
    </div>
    @endif
  </div>
</div>
