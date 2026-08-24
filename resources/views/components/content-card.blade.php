@props(['title', 'url', 'excerpt' => null, 'image' => null, 'meta' => null])
<article {{ $attributes->merge(['class' => 'card-item relative glass-effect group border border-black/8 bg-white/95 hover:bg-white rounded-3xl p-5 lg:p-6 shadow-sm hover:shadow-lg transition-all']) }}>
    @if (filled($image))
        <a href="{{ $url }}" class="block rounded-2xl overflow-hidden mb-5">
            <img src="{{ str_starts_with($image, 'http') ? $image : asset('assets/images/'.ltrim($image, '/')) }}" width="768" height="427" loading="lazy" decoding="async" alt="{{ $title }}" class="w-full aspect-[16/9] object-cover group-hover:scale-105 transition-transform">
        </a>
    @endif
    @if (filled($meta))
        <p class="text-sm text-gray-500 mb-2">{{ $meta }}</p>
    @endif
    <h2 class="text-xl lg:text-2xl font-bold mb-3"><a href="{{ $url }}" class="hover:text-primary">{{ $title }}</a></h2>
    @if (filled($excerpt))
        <p class="text-gray-600 mb-4">{{ $excerpt }}</p>
    @endif
    <a href="{{ $url }}" class="font-bold text-secondary">Xem chi tiết →</a>
</article>
