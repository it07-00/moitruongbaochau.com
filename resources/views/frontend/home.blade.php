@extends('frontend.layouts.app', ['bodyClass' => 'home'])

@section('content')
<section class="relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <div class="inline-flex items-center gap-2 mb-4"><img src="{{ asset('assets/images/asterisk.png') }}" width="24" height="24" alt=""><span class="font-bold uppercase text-sm">Giải pháp môi trường doanh nghiệp</span></div>
            <h1 class="font-bold leading-tight text-4xl sm:text-5xl lg:text-6xl mb-6">Đồng hành cùng doanh nghiệp phát triển bền vững</h1>
            <p class="text-lg text-gray-700 mb-8">Tư vấn pháp lý, quan trắc, kiểm kê khí nhà kính và giải pháp xử lý môi trường đúng quy định, đúng tiến độ.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('services.index') }}" class="c-button bg-primary text-white rounded-full px-6 py-3 font-bold">Khám phá dịch vụ</a>
                <a href="{{ route('contact.index') }}" class="c-light-button glass-effect rounded-full border border-black/10 px-6 py-3 font-bold">Nhận tư vấn</a>
            </div>
        </div>
        <img src="{{ asset('assets/images/optimized/hero-moi-truong-bao-chau.webp') }}" width="1200" height="445" fetchpriority="high" decoding="async" alt="Giải pháp môi trường Môi Trường Bảo Châu" class="w-full rounded-3xl shadow-lg">
    </div>
</section>

<section class="py-12 lg:py-20 bg-gray-50/60">
    <div class="container px-3 mx-auto">
        <x-section-heading eyebrow="Dịch vụ nổi bật" title="Giải pháp thực tế cho từng nhu cầu môi trường" />
        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            @forelse ($services as $service)
                <x-content-card :title="$service->name" :url="route('services.show', $service->slug)" :excerpt="$service->short_description" :image="$service->thumbnail" />
            @empty
                <p class="md:col-span-2 xl:col-span-4 text-center">Nội dung dịch vụ đang được cập nhật.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <x-section-heading eyebrow="Năng lực thực hiện" title="Dự án tiêu biểu" />
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projects as $project)
                <x-content-card :title="$project->title" :url="route('projects.show', $project->slug)" :excerpt="$project->summary" :image="$project->thumbnail" :meta="$project->client" />
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center">Dự án đang được cập nhật.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-12 lg:py-20 bg-gray-50/60">
    <div class="container px-3 mx-auto">
        <x-section-heading eyebrow="Kiến thức chuyên ngành" title="Tin tức và cẩm nang môi trường" />
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($posts as $post)
                <x-content-card :title="$post->title" :url="route('posts.show', $post->slug)" :excerpt="$post->excerpt" :image="$post->thumbnail" :meta="$post->published_at?->format('d/m/Y')" />
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center">Bài viết đang được cập nhật.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="section section-cta py-16 lg:py-20">
    <div class="container px-3 mx-auto text-center">
        <div class="glass-effect rounded-3xl p-8 lg:p-12 border border-black/8">
            <h2 class="text-3xl lg:text-5xl font-bold mb-5">Bạn cần tư vấn hồ sơ môi trường?</h2>
            <p class="text-lg mb-7">Đội ngũ Bảo Châu sẵn sàng khảo sát nhu cầu và đề xuất lộ trình phù hợp.</p>
            <a href="{{ route('contact.index') }}" class="c-button bg-primary text-white rounded-full px-7 py-3 font-bold">Liên hệ ngay</a>
        </div>
    </div>
</section>
@endsection
