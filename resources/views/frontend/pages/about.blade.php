@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16 relative overflow-hidden">
    <div class="container px-3 mx-auto">
        <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => $page->title]]" />
        <div class="grid lg:grid-cols-2 gap-10 items-center">
            <div>
                <div class="inline-flex items-center gap-2 mb-4"><img src="{{ asset('assets/images/asterisk.png') }}" width="24" height="24" alt=""><span class="font-bold uppercase text-sm">Giới thiệu năng lực</span></div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $page->title }}</h1>
                <p class="text-lg text-gray-700 whitespace-pre-line">{{ $page->content }}</p>
            </div>
            <img src="{{ asset('assets/images/optimized/doi-ngu-moi-truong-bao-chau.webp') }}" width="1200" height="706" loading="eager" decoding="async" alt="Đội ngũ Môi Trường Bảo Châu" class="rounded-3xl shadow-lg">
        </div>
    </div>
</section>
@endsection
