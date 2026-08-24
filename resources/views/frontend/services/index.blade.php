@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16">
    <div class="container px-3 mx-auto">
        <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Dịch vụ']]" />
        <h1 class="text-4xl lg:text-6xl font-bold mb-4">Dịch vụ môi trường</h1>
        <p class="text-lg text-gray-600 max-w-3xl mb-10">Giải pháp pháp lý và kỹ thuật môi trường được thiết kế theo ngành nghề, quy mô và tiến độ của từng doanh nghiệp.</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <x-content-card :title="$service->name" :url="route('services.show', $service->slug)" :excerpt="$service->short_description" :image="$service->thumbnail" :meta="$service->category?->name" />
            @endforeach
        </div>
        <div class="mt-10">{{ $services->links() }}</div>
    </div>
</section>
@endsection
