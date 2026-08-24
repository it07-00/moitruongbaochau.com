@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16"><div class="container px-3 mx-auto">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tin tức']]" />
    <h1 class="text-4xl lg:text-6xl font-bold mb-4">Tin tức môi trường</h1>
    <p class="text-lg text-gray-600 max-w-3xl mb-10">Cập nhật pháp luật, cẩm nang triển khai hồ sơ, kiểm kê khí nhà kính và ESG.</p>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($posts as $post)
            <x-content-card :title="$post->title" :url="route('posts.show', $post->slug)" :excerpt="$post->excerpt" :image="$post->thumbnail" :meta="$post->published_at?->format('d/m/Y')" />
        @endforeach
    </div>
    <div class="mt-10">{{ $posts->links() }}</div>
</div></section>
@endsection
