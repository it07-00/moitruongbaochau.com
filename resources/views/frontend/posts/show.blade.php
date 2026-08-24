@extends('frontend.layouts.app')

@section('content')
<section class="section singular section-post py-8 lg:py-16"><div class="container px-3 mx-auto max-w-5xl">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tin tức', 'url' => route('posts.index')], ['label' => $post->title]]" />
    <article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10">
        <p class="text-sm text-gray-500 mb-3">{{ $post->published_at?->format('d/m/Y') }} @if($post->author) · {{ $post->author->name }} @endif</p>
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $post->title }}</h1>
        @if ($post->thumbnail)<img src="{{ asset('assets/images/'.$post->thumbnail) }}" width="1024" height="576" alt="{{ $post->title }}" class="w-full rounded-3xl mb-8">@endif
        <p class="text-lg font-medium mb-6">{{ $post->excerpt }}</p>
        <div class="text-lg leading-relaxed whitespace-pre-line">{{ $post->content }}</div>
    </article>
</div></section>
@if ($relatedPosts->isNotEmpty())<section class="pb-16 lg:pb-24"><div class="container px-3 mx-auto"><x-section-heading eyebrow="Đọc thêm" title="Bài viết liên quan" /><div class="grid md:grid-cols-3 gap-6">@foreach ($relatedPosts as $related)<x-content-card :title="$related->title" :url="route('posts.show', $related->slug)" :excerpt="$related->excerpt" :image="$related->thumbnail" />@endforeach</div></div></section>@endif
@endsection
