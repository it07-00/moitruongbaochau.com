@props(['seo' => []])
<title>{{ $seo['title'] ?? config('app.name') }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
<meta name="robots" content="{{ $seo['robots'] ?? 'index,follow' }}">
<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
<link rel="alternate" hreflang="vi-VN" href="{{ $seo['alternate'] ?? $seo['canonical'] ?? url()->current() }}">
<link rel="alternate" hreflang="x-default" href="{{ $seo['alternate'] ?? $seo['canonical'] ?? url()->current() }}">
@if (filled($seo['prev'] ?? null))
    <link rel="prev" href="{{ $seo['prev'] }}">
@endif
@if (filled($seo['next'] ?? null))
    <link rel="next" href="{{ $seo['next'] }}">
@endif
<meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
<meta property="og:locale" content="{{ $seo['og_locale'] ?? 'vi_VN' }}">
<meta property="og:site_name" content="{{ $seo['site_name'] ?? config('app.name') }}">
<meta property="og:title" content="{{ $seo['og_title'] ?? $seo['title'] ?? config('app.name') }}">
<meta property="og:description" content="{{ $seo['og_description'] ?? $seo['description'] ?? '' }}">
<meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
@if (filled($seo['og_image'] ?? null))
    <meta property="og:image" content="{{ $seo['og_image'] }}">
    <meta property="og:image:alt" content="{{ $seo['og_image_alt'] ?? $seo['og_title'] ?? $seo['title'] ?? config('app.name') }}">
@endif
@if (filled($seo['article_published_time'] ?? null))
    <meta property="article:published_time" content="{{ $seo['article_published_time'] }}">
@endif
@if (filled($seo['article_modified_time'] ?? null))
    <meta property="article:modified_time" content="{{ $seo['article_modified_time'] }}">
@endif
<meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">
@if (filled($seo['twitter_site'] ?? null))
    <meta name="twitter:site" content="{{ $seo['twitter_site'] }}">
@endif
<meta name="twitter:title" content="{{ $seo['twitter_title'] ?? $seo['title'] ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $seo['twitter_description'] ?? $seo['description'] ?? '' }}">
@if (filled($seo['twitter_image'] ?? null))
    <meta name="twitter:image" content="{{ $seo['twitter_image'] }}">
    <meta name="twitter:image:alt" content="{{ $seo['twitter_image_alt'] ?? $seo['twitter_title'] ?? $seo['title'] ?? config('app.name') }}">
@endif
@foreach ($seo['schema'] ?? [] as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endforeach