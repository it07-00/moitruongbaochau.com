@extends('frontend.layouts.app')

@section('content')
<section class="py-8 lg:py-16"><div class="container px-3 mx-auto max-w-5xl">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Tuyển dụng', 'url' => route('recruitment.index')], ['label' => $job->title]]" />
    <article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10">
        <p class="text-secondary font-bold mb-3">{{ collect([$job->location, $job->employment_type])->filter()->join(' · ') }}</p>
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $job->title }}</h1>
        <p class="text-lg font-medium mb-8">{{ $job->summary }}</p>
        <h2 class="text-2xl font-bold mb-3">Mô tả công việc</h2><div class="whitespace-pre-line mb-8">{{ $job->content }}</div>
        <h2 class="text-2xl font-bold mb-3">Yêu cầu</h2><div class="whitespace-pre-line mb-8">{{ $job->requirements }}</div>
        <h2 class="text-2xl font-bold mb-3">Quyền lợi</h2><div class="whitespace-pre-line mb-8">{{ $job->benefits }}</div>
        <a href="mailto:info@baochauenvir.com?subject={{ rawurlencode('Ứng tuyển '.$job->title) }}" class="c-button bg-primary text-white rounded-full px-7 py-3 font-bold">Gửi hồ sơ ứng tuyển</a>
    </article>
</div></section>
@endsection
