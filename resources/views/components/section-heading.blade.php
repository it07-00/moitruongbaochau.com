@props(['eyebrow', 'title'])
<div {{ $attributes->merge(['class' => 'text-center max-w-3xl mx-auto mb-8 lg:mb-12']) }}>
    <div class="inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4">
        <span class="icon-list-icon"><img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt=""></span>
        <span class="icon-list-text bg-linear-to-r from-(--text-color) to-gra-light bg-clip-text text-transparent font-bold uppercase text-xs sm:text-sm tracking-wider">{{ $eyebrow }}</span>
    </div>
    <h2 class="font-bold leading-tight text-3xl sm:text-4xl lg:text-5xl">{{ $title }}</h2>
</div>
