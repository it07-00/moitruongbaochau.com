@props(['eyebrow', 'title'])
<div {{ $attributes->merge(['class' => 'text-center max-w-3xl mx-auto mb-8 lg:mb-12']) }}>
    <x-theme.badge :text="$eyebrow" class="justify-center" />
    <h2 class="font-bold leading-tight text-3xl sm:text-4xl lg:text-5xl">{{ $title }}</h2>
</div>

