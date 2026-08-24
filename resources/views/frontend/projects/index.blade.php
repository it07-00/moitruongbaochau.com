@extends('frontend.layouts.app', ['bodyClass' => 'page-projects'])

@section('content')
<section class="section section-project-hero relative overflow-hidden py-8 lg:py-16">
    <div class="container px-3 mx-auto"><x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Dự án']]" /><div class="mx-auto max-w-4xl text-center"><x-theme.badge text="Năng lực thực tế" class="justify-center" /><h1 class="text-4xl font-extrabold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">Dự Án Môi Trường Tiêu Biểu</h1><p class="mt-5 text-lg leading-relaxed text-gray-600">Những dự án pháp lý, quan trắc, khí nhà kính và kỹ thuật môi trường đã được triển khai cho doanh nghiệp.</p></div></div>
</section>
<section class="section section-project-stats relative pb-12 lg:pb-16">
    <div class="container px-3 mx-auto"><div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">@foreach ([['500+', 'Khách hàng'], ['1.000+', 'Hồ sơ hoàn thành'], ['63', 'Tỉnh thành hỗ trợ'], ['98%', 'Đúng tiến độ']] as [$number, $label])<div class="rounded-3xl border border-black/8 bg-white p-6 text-center shadow-sm"><strong class="block text-4xl font-extrabold text-primary">{{ $number }}</strong><span class="mt-2 block font-semibold text-gray-600">{{ $label }}</span></div>@endforeach</div></div>
</section>
<section class="section section-project-list relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-8 flex flex-wrap justify-center gap-2"><span class="rounded-full bg-primary px-5 py-2 font-bold text-white">Tất cả dự án</span>@foreach ($projects->pluck('category')->filter()->unique() as $category)<span class="rounded-full border border-black/10 bg-white px-5 py-2 font-bold">{{ str($category)->replace('-', ' ')->title() }}</span>@endforeach</div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">@forelse ($projects as $project)<x-theme.card :title="$project->title" :url="route('projects.show', $project->slug)" :excerpt="$project->summary" :image="$project->thumbnail" :meta="collect([$project->client, $project->location])->filter()->join(' · ')" />@empty<p class="md:col-span-2 lg:col-span-3 text-center">Dự án đang được cập nhật.</p>@endforelse</div><div class="mt-10">{{ $projects->links() }}</div>
    </div>
</section>
<section class="section section-project-process relative overflow-hidden py-12 lg:py-20">
    <div class="container px-3 mx-auto"><div class="mb-10 text-center"><x-theme.badge text="Quy trình chuyên nghiệp" class="justify-center" /><h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">Quy Trình Triển Khai Chuẩn 5 Bước</h2></div><ol class="grid gap-5 md:grid-cols-2 lg:grid-cols-5">@foreach ([['01', 'Tiếp nhận nhu cầu'], ['02', 'Khảo sát hiện trạng'], ['03', 'Đề xuất giải pháp'], ['04', 'Triển khai hồ sơ'], ['05', 'Bàn giao & đồng hành']] as [$step, $label])<li class="rounded-3xl border border-black/8 bg-white p-6 text-center shadow-sm"><strong class="text-4xl text-primary">{{ $step }}</strong><h3 class="mt-4 font-bold text-gray-900">{{ $label }}</h3></li>@endforeach</ol></div>
</section>
<x-theme.partners title="Được Tin Chọn Bởi Hơn 300+ Doanh Nghiệp" />
<x-theme.cta title="Bạn Đang Chuẩn Bị Triển Khai Dự Án Mới Hay Cần Hoàn Thiện Hồ Sơ Môi Trường?" />
@endsection
