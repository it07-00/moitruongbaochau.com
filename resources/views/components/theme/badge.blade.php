@props(['text' => null])
<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 lg:gap-3 mb-3 lg:mb-4']) }}>
    <span class="icon-list-icon">
        <img src="{{ asset('assets/images/asterisk.png') }}" class="size-5" width="24" height="24" alt="" aria-hidden="true">
    </span>
    <span class="icon-list-text c-text-linear font-bold uppercase text-xs sm:text-sm tracking-wider">
        {{ $text ?? $slot }}
    </span>
</div>

