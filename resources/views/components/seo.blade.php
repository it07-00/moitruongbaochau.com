@props(['seo' => []])
<title>{{ $seo['title'] ?? config('app.name') }}</title>
<meta name="description" content="{{ $seo['description'] ?? '' }}">
<meta name="robots" content="{{ $seo['robots'] ?? 'index,follow' }}">
<link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo['og_title'] ?? $seo['title'] ?? config('app.name') }}">
<meta property="og:description" content="{{ $seo['og_description'] ?? $seo['description'] ?? '' }}">
<meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
@if (filled($seo['og_image'] ?? null))
    <meta property="og:image" content="{{ $seo['og_image'] }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo['twitter_title'] ?? $seo['title'] ?? config('app.name') }}">
<meta name="twitter:description" content="{{ $seo['twitter_description'] ?? $seo['description'] ?? '' }}">
@if (filled($seo['twitter_image'] ?? null))
    <meta name="twitter:image" content="{{ $seo['twitter_image'] }}">
@endif
@foreach ($seo['schema'] ?? [] as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endforeach
