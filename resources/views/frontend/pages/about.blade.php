@extends('frontend.layouts.app', ['bodyClass' => 'page-about'])

@section('content')
<div class="container px-3 mx-auto pt-5 lg:pt-8">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Giới thiệu']]" />
</div>

<section class="section section-hero py-8 lg:py-16 relative overflow-hidden">
    <div class="container px-3 mx-auto grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
        <div>
            <x-theme.badge text="Về chúng tôi" />
            <h1 class="text-4xl font-extrabold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">{{ $page->title }}</h1>
            <p class="mt-6 text-lg leading-relaxed text-gray-700">{{ $page->excerpt }}</p>
            <div class="mt-8 flex flex-wrap gap-3"><a href="{{ route('contact.index') }}" class="rounded-full bg-primary px-6 py-3 font-bold text-white">Nhận tư vấn</a><a href="{{ route('projects.index') }}" class="glass-effect rounded-full border border-black/10 px-6 py-3 font-bold">Xem năng lực</a></div>
        </div>
        <img src="{{ asset('assets/images/optimized/doi-ngu-moi-truong-bao-chau.webp') }}" width="1024" height="603" fetchpriority="high" decoding="async" alt="Đội ngũ Môi Trường Bảo Châu" class="w-full rounded-[2rem] object-cover shadow-xl">
    </div>
</section>

<section class="section section-statistics pb-10 lg:pb-20 overflow-hidden">
    <div class="container px-3 mx-auto">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([['10+', 'Năm kinh nghiệm'], ['500+', 'Khách hàng đồng hành'], ['1.000+', 'Hồ sơ & dự án'], ['20+', 'Chuyên gia kỹ thuật']] as [$number, $label])
                <div class="rounded-3xl border border-black/8 bg-white p-6 text-center shadow-sm"><strong class="block text-4xl font-extrabold text-primary lg:text-5xl">{{ $number }}</strong><span class="mt-2 block font-semibold text-gray-600">{{ $label }}</span></div>
            @endforeach
        </div>
    </div>
</section>

<section class="section section-vision-mission relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mx-auto mb-10 max-w-4xl text-center"><x-theme.badge text="Tầm nhìn & sứ mệnh" class="justify-center" /><h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">MÔI TRƯỜNG BẢO CHÂU Kiến tạo biểu tượng phát triển bền vững</h2><p class="mt-5 whitespace-pre-line text-lg leading-relaxed text-gray-700">{{ $page->content }}</p></div>
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            @foreach ([['Khách hàng', 'Cung cấp giải pháp đúng nhu cầu và đồng hành trong suốt quá trình vận hành.'], ['Đối tác', 'Xây dựng quan hệ minh bạch, chuyên nghiệp và cùng tạo giá trị bền vững.'], ['Nhân viên', 'Tạo môi trường phát triển chuyên môn, trách nhiệm và tinh thần sáng tạo.'], ['Cộng đồng', 'Góp phần bảo vệ môi trường và lan tỏa thực hành kinh doanh có trách nhiệm.']] as [$title, $description])
                <article class="rounded-3xl border border-black/8 bg-white p-6 shadow-sm"><span class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl text-primary">✓</span><h3 class="text-xl font-bold">{{ $title }}</h3><p class="mt-3 leading-relaxed text-gray-600">{{ $description }}</p></article>
            @endforeach
        </div>
    </div>
</section>

<section class="section section-organization relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-10 text-center"><x-theme.badge text="Bộ máy vận hành" class="justify-center" /><h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">CƠ CẤU TỔ CHỨC</h2></div>
        <div class="mx-auto max-w-5xl">
            <div class="mx-auto max-w-sm rounded-3xl bg-secondary p-6 text-center text-white shadow-lg"><strong class="text-xl">GIÁM ĐỐC</strong><span class="mt-1 block text-sm text-white/80">Điều hành & chiến lược</span></div>
            <div class="mx-auto h-10 w-px bg-primary/40"></div>
            <div class="grid gap-5 lg:grid-cols-3">
                @foreach ([['PHÒNG KỸ THUẬT', ['Bộ phận Quan trắc', 'Bộ phận Tư vấn']], ['PHÒNG KINH DOANH', ['Bộ phận Kinh doanh', 'Chăm sóc khách hàng']], ['PHÒNG TỔNG HỢP', ['Hành chính – Nhân sự', 'Tài chính – Kế toán']]] as [$department, $units])
                    <article class="rounded-3xl border border-emerald-200 bg-white p-6 text-center shadow-sm"><h3 class="font-bold text-secondary">{{ $department }}</h3><ul class="mt-5 grid gap-3">@foreach ($units as $unit)<li class="rounded-2xl bg-emerald-50 px-4 py-3 font-semibold text-gray-700">{{ $unit }}</li>@endforeach</ul></article>
                @endforeach
            </div>
        </div>
        <div class="mt-16 border-t border-black/10 pt-12">
            <div class="mb-8 text-center"><x-theme.badge text="Dấu mốc phát triển" class="justify-center" /><h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Lịch sử hình thành & phát triển</h2></div>
            <ol class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                @foreach ([['2019', 'Thành lập doanh nghiệp và xây dựng đội ngũ tư vấn nền tảng.'], ['2021', 'Mở rộng dịch vụ quan trắc và kỹ thuật xử lý môi trường.'], ['2023', 'Phát triển năng lực kiểm kê khí nhà kính, ESG và CBAM.'], ['Hiện nay', 'Đồng hành cùng doanh nghiệp trên nhiều tỉnh thành trong cả nước.']] as [$year, $description])
                    <li class="rounded-3xl bg-gray-50 p-6"><strong class="text-2xl text-primary">{{ $year }}</strong><p class="mt-3 leading-relaxed text-gray-600">{{ $description }}</p></li>
                @endforeach
            </ol>
        </div>
    </div>
</section>

<x-theme.partners title="Đối tác tin cậy đồng hành cùng Bảo Châu" />
@endsection
