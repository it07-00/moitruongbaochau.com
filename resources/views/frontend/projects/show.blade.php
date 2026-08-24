@extends('frontend.layouts.app')

@section('content')
<section class="py-8 lg:py-16"><div class="container px-3 mx-auto max-w-5xl">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Dự án', 'url' => route('projects.index')], ['label' => $project->title]]" />
    <article class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-10">
        <h1 class="text-4xl lg:text-6xl font-bold mb-6">{{ $project->title }}</h1>
        <dl class="grid sm:grid-cols-3 gap-4 mb-8"><div><dt class="font-bold">Khách hàng</dt><dd>{{ $project->client ?: 'Đang cập nhật' }}</dd></div><div><dt class="font-bold">Địa điểm</dt><dd>{{ $project->location ?: 'Đang cập nhật' }}</dd></div><div><dt class="font-bold">Hạng mục</dt><dd>{{ $project->category ?: 'Tư vấn môi trường' }}</dd></div></dl>
        @if ($project->thumbnail)<img src="{{ asset('assets/images/'.$project->thumbnail) }}" width="1024" height="576" alt="{{ $project->title }}" class="w-full rounded-3xl mb-8">@endif
        <p class="text-lg font-medium mb-6">{{ $project->summary }}</p>
        <div class="text-lg leading-relaxed whitespace-pre-line">{{ $project->content }}</div>
    </article>
</div></section>
@if ($relatedProjects->isNotEmpty())<section class="pb-16 lg:pb-24"><div class="container px-3 mx-auto"><x-section-heading eyebrow="Cùng lĩnh vực" title="Dự án liên quan" /><div class="grid md:grid-cols-3 gap-6">@foreach ($relatedProjects as $related)<x-content-card :title="$related->title" :url="route('projects.show', $related->slug)" :excerpt="$related->summary" :image="$related->thumbnail" />@endforeach</div></div></section>@endif
@endsection
