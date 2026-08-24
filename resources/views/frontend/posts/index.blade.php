@extends('frontend.layouts.app', ['bodyClass' => 'page-news'])

@section('content')
<div class="container px-3 mx-auto pt-5 lg:pt-8"><x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tin tức']]" /></div>
<section class="section section-home section-blog recent_post py-8 lg:py-16">
    <div class="container px-3 mx-auto">
        <div class="mb-9 text-center lg:mb-12"><x-theme.badge text="Tin tức & pháp luật" class="justify-center" /><h1 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Kiến thức & Tin tức mới cập nhật</h1><p class="mx-auto mt-5 max-w-3xl text-lg text-gray-600">Cập nhật quy định, kinh nghiệm triển khai và xu hướng phát triển bền vững dành cho doanh nghiệp.</p></div>
        <div class="mb-8 flex flex-wrap justify-center gap-2"><span class="rounded-full bg-primary px-5 py-2 font-bold text-white">Tất cả</span><span class="rounded-full border border-black/10 bg-white px-5 py-2 font-bold">Pháp luật môi trường</span><span class="rounded-full border border-black/10 bg-white px-5 py-2 font-bold">Khí nhà kính & ESG</span><span class="rounded-full border border-black/10 bg-white px-5 py-2 font-bold">Hoạt động Bảo Châu</span></div>
        <div class="grid auto-rows-fr gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <x-theme.card :title="$post->title" :url="route('posts.show', $post->slug)" :excerpt="$post->excerpt" :image="$post->thumbnail" :meta="collect([$post->category?->name, $post->published_at?->format('d/m/Y')])->filter()->join(' · ')" @class(['lg:row-span-2' => in_array($loop->index % 6, [2, 3], true)]) />
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center">Bài viết đang được cập nhật.</p>
            @endforelse
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    </div>
</section>
<section class="section section-newsletter relative pb-16 lg:pb-24">
    <div class="container px-3 mx-auto"><div class="grid items-center gap-7 rounded-[2rem] bg-secondary p-7 text-white lg:grid-cols-[1fr_420px] lg:p-10"><div><x-theme.badge text="Bản tin chuyên ngành" class="text-white" /><h2 class="text-3xl font-bold sm:text-4xl">Nhận thông tin pháp luật môi trường mới</h2><p class="mt-3 text-white/80">Theo dõi Bảo Châu để không bỏ lỡ những thay đổi quan trọng đối với doanh nghiệp.</p></div><a href="{{ route('contact.index') }}" class="rounded-full bg-white px-6 py-3 text-center font-bold text-secondary">Đăng ký nhận tư vấn</a></div></div>
</section>
@endsection
