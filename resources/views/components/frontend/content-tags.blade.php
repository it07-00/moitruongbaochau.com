@props(['tags' => [], 'url', 'large' => false])

@if (filled($tags))
    <div {{ $attributes->merge(['class' => 'entry-tags mt-8 flex flex-wrap items-center gap-2 sm:gap-2.5']) }}>
        <span class="inline-flex items-center gap-1.5 font-extrabold uppercase tracking-wider text-black mr-1 {{ $large ? 'text-sm sm:text-base' : 'text-xs sm:text-sm' }}">
            <svg class="size-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5-3.9 19.5m-2.1-19.5-3.9 19.5" />
            </svg>
            Tags:
        </span>
        @foreach ($tags as $tag)
            <a href="{{ $url }}" class="inline-flex items-center rounded-full font-semibold bg-gray-100/90 text-black hover:bg-primary hover:text-white transition-all duration-200 {{ $large ? 'px-4 py-2 text-sm sm:text-base' : 'px-3.5 py-1.5 text-xs sm:text-sm' }}">
                #{{ ltrim($tag, '#') }}
            </a>
        @endforeach
    </div>
@endif
