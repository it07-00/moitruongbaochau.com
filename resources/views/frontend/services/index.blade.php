@extends('frontend.layouts.app', ['bodyClass' => 'page-services'])

@section('content')
<section class="section section-services-hero relative overflow-hidden py-8 lg:py-16">
    <div class="container px-3 mx-auto">
        <div class="mx-auto max-w-4xl text-center">
            <x-theme.badge :text="$page?->metadata['services_badge'] ?? 'Giải pháp toàn diện'" class="justify-center" />
            <h1 class="text-4xl font-extrabold leading-tight text-gray-900 sm:text-5xl lg:text-6xl mt-4">
                {{ $page?->title ?? 'Dịch vụ môi trường doanh nghiệp' }}
            </h1>
            <p class="mt-5 text-lg leading-relaxed text-gray-600 max-w-3xl mx-auto">
                {{ $page?->excerpt ?? 'Từ pháp lý, quan trắc đến chuyển đổi xanh và kỹ thuật xử lý môi trường.' }}
            </p>
        </div>
    </div>
</section>

<section class="section section-services-list relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-8 flex flex-wrap justify-center gap-2">
            <span class="rounded-full bg-primary px-5 py-2 font-bold text-white shadow-sm">Tất cả dịch vụ</span>
            @foreach ($services->pluck('category.name')->filter()->unique() as $category)
                <span class="rounded-full border border-black/10 bg-white px-5 py-2 font-bold text-gray-700 hover:border-primary hover:text-primary transition-colors cursor-pointer">{{ $category }}</span>
            @endforeach
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse ($services as $service)
                <x-theme.card
                    :title="$service->name"
                    :url="route('services.show', $service->slug)"
                    :excerpt="$service->short_description"
                    :image="$service->thumbnail"
                    :meta="$service->category?->name"
                />
            @empty
                <p class="sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center text-gray-500 py-12">
                    Dịch vụ đang được cập nhật.
                </p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $services->links() }}
        </div>
    </div>
</section>

<x-theme.cta
    :title="$page?->metadata['cta_title'] ?? 'Cần tư vấn giải pháp môi trường tối ưu cho doanh nghiệp?'"
    :description="$page?->metadata['cta_desc'] ?? 'Đội ngũ kỹ sư và chuyên gia pháp lý của Môi Trường Bảo Châu luôn sẵn sàng đồng hành, khảo sát và đưa ra phương án phù hợp nhất.'"
    :buttonText="$page?->metadata['cta_button_text'] ?? 'Liên hệ tư vấn ngay'"
    :phone="$page?->metadata['cta_phone'] ?? '0915 549 148'"
/>
@endsection
