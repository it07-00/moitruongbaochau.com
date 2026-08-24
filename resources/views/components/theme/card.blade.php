@props(['title', 'url', 'excerpt' => null, 'image' => null, 'meta' => null, 'heading' => 'h3'])

<article {{ $attributes->merge(['class' => 'group h-full rounded-3xl border border-black/8 bg-white overflow-hidden shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl']) }}>
    @if (filled($image))
        <a href="{{ $url }}" class="block overflow-hidden aspect-[16/10] bg-gray-100">
            <img src="{{ str_starts_with($image, 'http') ? $image : asset('assets/images/'.ltrim($image, '/')) }}" width="768" height="480" loading="lazy" decoding="async" alt="{{ $title }}" class="size-full object-cover transition-transform duration-500 group-hover:scale-105">
        </a>
    @endif
    <div class="p-5 sm:p-6">
        @if (filled($meta))
            <p class="mb-2 text-xs sm:text-sm font-semibold uppercase tracking-wide text-primary">{{ $meta }}</p>
        @endif
        <{{ $heading }} class="text-lg sm:text-xl font-bold leading-snug text-gray-900">
            <a href="{{ $url }}" class="transition-colors hover:text-primary">{{ $title }}</a>
        </{{ $heading }}>
        @if (filled($excerpt))
            <p class="mt-3 line-clamp-3 text-sm sm:text-base leading-relaxed text-gray-600">{{ $excerpt }}</p>
        @endif
        <a href="{{ $url }}" class="mt-5 inline-flex items-center gap-2 font-bold text-secondary transition-colors hover:text-primary">Xem chi tiết <span aria-hidden="true">→</span></a>
    </div>
</article>
