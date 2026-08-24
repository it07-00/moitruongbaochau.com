@props(['text'])
<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 mb-4']) }}>
    <img src="{{ asset('assets/images/asterisk.png') }}" width="24" height="24" alt="" aria-hidden="true" class="size-5 sm:size-6 object-contain">
    <span class="font-bold uppercase tracking-wide text-xs sm:text-sm text-gray-800">{{ $text }}</span>
</div>
