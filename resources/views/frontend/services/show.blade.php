@extends('frontend.layouts.app')

@section('content')
<section class="section singular section-post py-8 lg:py-16">
    <div class="container px-3 mx-auto max-w-5xl">
        <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Dịch vụ', 'url' => route('services.index')], ['label' => $service->name]]" />
        <article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10">
            <h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $service->name }}</h1>
            @if ($service->thumbnail)
                <img src="{{ asset('assets/images/'.$service->thumbnail) }}" width="1024" height="576" alt="{{ $service->name }}" class="w-full rounded-3xl mb-8">
            @endif
            <p class="text-lg font-medium mb-6">{{ $service->short_description }}</p>
            <div class="text-lg leading-relaxed whitespace-pre-line">{{ $service->content }}</div>
        </article>
    </div>
</section>
@if ($relatedServices->isNotEmpty())
<section class="pb-16 lg:pb-24"><div class="container px-3 mx-auto"><x-section-heading eyebrow="Dịch vụ liên quan" title="Giải pháp có thể bạn quan tâm" /><div class="grid md:grid-cols-3 gap-6">@foreach ($relatedServices as $related)<x-content-card :title="$related->name" :url="route('services.show', $related->slug)" :excerpt="$related->short_description" :image="$related->thumbnail" />@endforeach</div></div></section>
@endif
@endsection
