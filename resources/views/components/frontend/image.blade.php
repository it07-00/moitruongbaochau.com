@props(['src', 'sizes' => '100vw'])
@php($image = app(\App\Support\OptimizedImage::class)->attributes($src))
<img src="{{ $image['src'] }}"
    @if(isset($image['srcset'])) srcset="{{ $image['srcset'] }}" sizes="{{ $sizes }}" @endif
    {{ $attributes->except(isset($image['width']) ? ['width', 'height'] : [])->merge(array_intersect_key($image, array_flip(['width', 'height']))) }}>
