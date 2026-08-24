@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16"><div class="container px-3 mx-auto">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tuyển dụng']]" />
    <h1 class="text-4xl lg:text-6xl font-bold mb-4">Tuyển dụng nhân tài</h1>
    <p class="text-lg text-gray-600 max-w-3xl mb-10">Cùng Bảo Châu tạo ra tác động tích cực cho môi trường và cộng đồng doanh nghiệp.</p>
    <div class="grid md:grid-cols-2 gap-6">
        @forelse ($jobs as $job)<x-content-card :title="$job->title" :url="route('recruitment.show', $job->slug)" :excerpt="$job->summary" :meta="collect([$job->location, $job->employment_type])->filter()->join(' · ')" />@empty<p>Hiện chưa có vị trí tuyển dụng.</p>@endforelse
    </div>
    <div class="mt-10">{{ $jobs->links() }}</div>
</div></section>
@endsection
