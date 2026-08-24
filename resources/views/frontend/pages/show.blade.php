@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16"><div class="container px-3 mx-auto max-w-5xl"><x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => $page->title]]" /><article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10"><h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $page->title }}</h1><p class="text-lg leading-relaxed whitespace-pre-line">{{ $page->content }}</p></article></div></section>
@endsection
