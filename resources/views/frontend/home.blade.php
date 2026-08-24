@extends('frontend.layouts.app', ['bodyClass' => 'home'])

@section('content')
<section id="section-hero" class="section section-home section-hero relative overflow-hidden py-6 lg:py-10">
    <div class="container px-3 mx-auto">
        <div class="swiper hero-slider overflow-hidden rounded-[2rem]" data-fx-swiper="hero">
            <div class="swiper-wrapper">
                @foreach ([
                    ['image' => 'slide-1.png', 'eyebrow' => 'Pháp lý môi trường', 'title' => 'Đồng hành cùng doanh nghiệp phát triển bền vững', 'description' => 'Tư vấn hồ sơ, giấy phép và lộ trình tuân thủ phù hợp với từng cơ sở sản xuất.'],
                    ['image' => 'slide-2.jpg', 'eyebrow' => 'Quan trắc & kỹ thuật', 'title' => 'Giải pháp môi trường đúng quy định, đúng tiến độ', 'description' => 'Khảo sát thực tế, triển khai minh bạch và hỗ trợ doanh nghiệp trong suốt quá trình vận hành.'],
                    ['image' => 'slide-3.png', 'eyebrow' => 'Khí nhà kính & ESG', 'title' => 'Sẵn sàng cho hành trình chuyển đổi xanh', 'description' => 'Kiểm kê phát thải, CBAM, ESG và lộ trình giảm phát thải có thể đo lường.'],
                    ['image' => 'slide-4.png', 'eyebrow' => 'Xử lý môi trường', 'title' => 'Tối ưu hệ thống xử lý nước thải và khí thải', 'description' => 'Giải pháp kỹ thuật phù hợp công suất, an toàn và dễ vận hành lâu dài.'],
                ] as $slide)
                    <div class="swiper-slide relative min-h-[460px] sm:min-h-[520px] lg:min-h-[620px]">
                        <img src="{{ asset('assets/images/'.$slide['image']) }}" width="1920" height="1080" @if ($loop->first) fetchpriority="high" loading="eager" @else loading="lazy" @endif decoding="async" alt="{{ $slide['title'] }}" class="absolute inset-0 size-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/10"></div>
                        <div class="relative z-10 flex min-h-[460px] sm:min-h-[520px] lg:min-h-[620px] items-center px-6 py-14 sm:px-10 lg:px-16">
                            <div class="max-w-3xl text-white">
                                <p class="mb-4 text-sm font-bold uppercase tracking-[.18em] text-emerald-200">{{ $slide['eyebrow'] }}</p>
                                @if ($loop->first)
                                    <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">{{ $slide['title'] }}</h1>
                                @else
                                    <h2 class="text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">{{ $slide['title'] }}</h2>
                                @endif
                                <p class="mt-6 max-w-2xl text-base leading-relaxed text-white/90 sm:text-lg">{{ $slide['description'] }}</p>
                                <div class="mt-8 flex flex-wrap gap-3">
                                    <a href="{{ route('services.index') }}" class="c-button rounded-full bg-primary px-6 py-3 font-bold text-white">Khám phá dịch vụ</a>
                                    <a href="{{ route('contact.index') }}" class="rounded-full border border-white/50 bg-white/10 px-6 py-3 font-bold text-white backdrop-blur">Nhận tư vấn</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="swiper-button-prev" type="button" aria-label="Slide trước"></button>
            <button class="swiper-button-next" type="button" aria-label="Slide sau"></button>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<section id="section-db7ea4e65d" class="section section-about relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
        <div class="relative">
            <img src="{{ asset('assets/images/optimized/doi-ngu-moi-truong-bao-chau.webp') }}" width="1024" height="603" loading="lazy" decoding="async" alt="Đội ngũ Môi Trường Bảo Châu" class="w-full rounded-[2rem] object-cover shadow-xl">
            <div class="absolute -bottom-6 right-4 rounded-2xl border border-white/50 bg-white/90 px-6 py-4 shadow-lg backdrop-blur sm:right-8"><strong class="block text-3xl text-primary">10+ năm</strong><span class="text-sm font-medium text-gray-600">Kinh nghiệm chuyên ngành</span></div>
        </div>
        <div>
            <x-theme.badge text="Về chúng tôi" />
            <h2 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">MÔI TRƯỜNG BẢO CHÂU với sứ mệnh</h2>
            <p class="mt-6 text-lg leading-relaxed text-gray-700">Cung cấp giải pháp pháp lý và kỹ thuật môi trường toàn diện, giúp doanh nghiệp tuân thủ quy định và phát triển bền vững.</p>
            <ul class="mt-7 grid gap-4 sm:grid-cols-2">
                @foreach (['Đúng quy định pháp luật', 'Tiến độ minh bạch', 'Giải pháp sát thực tế', 'Đồng hành dài hạn'] as $value)
                    <li class="flex items-center gap-3 rounded-2xl bg-white/80 p-4 shadow-sm"><span class="flex size-8 items-center justify-center rounded-full bg-primary text-white">✓</span><strong>{{ $value }}</strong></li>
                @endforeach
            </ul>
            <a href="{{ route('about') }}" class="mt-8 inline-flex rounded-full bg-secondary px-6 py-3 font-bold text-white">Tìm hiểu về Bảo Châu</a>
        </div>
    </div>
</section>

<section id="section-4bdc829f17" class="section section-services relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-9 flex flex-col justify-between gap-5 lg:mb-12 lg:flex-row lg:items-end">
            <div class="max-w-3xl"><x-theme.badge text="Lĩnh vực hoạt động" /><h2 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Các dịch vụ cốt lõi</h2></div>
            <a href="{{ route('services.index') }}" class="font-bold text-secondary">Xem tất cả dịch vụ →</a>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @forelse ($services as $service)
                <x-theme.card :title="$service->name" :url="route('services.show', $service->slug)" :excerpt="$service->short_description" :image="$service->thumbnail" />
            @empty
                <p class="sm:col-span-2 xl:col-span-4 text-center">Nội dung dịch vụ đang được cập nhật.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="section-projects" class="section section-projects relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-8 text-center lg:mb-12"><x-theme.badge text="Năng lực triển khai" class="justify-center" /><h2 class="project-title font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Dự án tiêu biểu</h2></div>
        <div class="mb-8 flex flex-wrap justify-center gap-2" role="list" aria-label="Nhóm dự án">
            @foreach (['Tất cả', 'Giấy phép môi trường', 'ĐTM', 'Khí nhà kính', 'Quan trắc'] as $tab)
                <span class="rounded-full border border-black/10 bg-white px-5 py-2 text-sm font-bold first:bg-primary first:text-white">{{ $tab }}</span>
            @endforeach
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($projects as $project)
                <x-theme.card :title="$project->title" :url="route('projects.show', $project->slug)" :excerpt="$project->summary" :image="$project->thumbnail" :meta="$project->client" />
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center">Dự án đang được cập nhật.</p>
            @endforelse
        </div>
        <div class="mt-9 text-center"><a href="{{ route('projects.index') }}" class="inline-flex rounded-full bg-secondary px-7 py-3 font-bold text-white">Xem tất cả dự án</a></div>
    </div>
</section>

<section id="section-blog" class="section section-home section-blog recent_post relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-9 flex flex-col justify-between gap-5 lg:mb-12 lg:flex-row lg:items-end">
            <div><x-theme.badge text="Kiến thức chuyên ngành" /><h2 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Bài viết mới cập nhật</h2></div>
            <a href="{{ route('posts.index') }}" class="font-bold text-secondary">Xem tất cả bài viết →</a>
        </div>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <x-theme.card :title="$post->title" :url="route('posts.show', $post->slug)" :excerpt="$post->excerpt" :image="$post->thumbnail" :meta="$post->published_at?->format('d/m/Y')" />
            @empty
                <p class="md:col-span-2 lg:col-span-3 text-center">Bài viết đang được cập nhật.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="section-testimonials" class="section section-testimonials relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-9 text-center"><x-theme.badge text="Phản hồi khách hàng" class="justify-center" /><h2 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Khách hàng nói gì về chúng tôi</h2></div>
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach ([['BERICAP Việt Nam', 'Hồ sơ được triển khai rõ ràng, đúng tiến độ và đội ngũ hỗ trợ rất sát thực tế.'], ['Suntory PepsiCo', 'Bảo Châu phối hợp chuyên nghiệp trong quá trình khảo sát và hoàn thiện báo cáo.'], ['Bao bì Tân Tiến', 'Giải pháp tư vấn dễ áp dụng, giúp doanh nghiệp chủ động hơn trong công tác môi trường.']] as [$customer, $quote])
                <blockquote class="rounded-3xl border border-black/8 bg-white p-7 shadow-sm"><div class="mb-4 text-xl text-amber-400" aria-label="5 sao">★★★★★</div><p class="text-lg leading-relaxed text-gray-700">“{{ $quote }}”</p><footer class="mt-5 font-bold text-secondary">{{ $customer }}</footer></blockquote>
            @endforeach
        </div>
    </div>
</section>

<x-theme.partners />

<section id="section-press" class="section section-press relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-9 text-center"><x-theme.badge text="Truyền thông" class="justify-center" /><h2 class="font-bold leading-tight text-3xl text-gray-900 sm:text-4xl lg:text-5xl">Báo chí nói gì về MÔI TRƯỜNG BẢO CHÂU</h2></div>
        <div class="grid items-center gap-5 sm:grid-cols-3">
            @foreach ([['bao-gia-lai.png', 'Báo Gia Lai'], ['bao-kinh-te-xanh.png', 'Kinh Tế Xanh'], ['bao-moi.png', 'Báo Mới']] as [$image, $name])
                <div class="flex h-36 items-center justify-center rounded-3xl border border-black/8 bg-white p-7 shadow-sm"><img src="{{ asset('assets/images/'.$image) }}" width="240" height="120" loading="lazy" decoding="async" alt="{{ $name }}" class="max-h-full max-w-full object-contain"></div>
            @endforeach
        </div>
    </div>
</section>

<x-theme.cta title="Bạn cần hoàn thiện hồ sơ hay triển khai giải pháp môi trường?" />
@endsection
