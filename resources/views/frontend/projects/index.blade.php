@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16"><div class="container px-3 mx-auto">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Dự án']]" />
    <h1 class="text-4xl lg:text-6xl font-bold mb-4">Dự án tiêu biểu</h1>
    <p class="text-lg text-gray-600 max-w-3xl mb-10">Kinh nghiệm thực tế trong tư vấn pháp lý, quan trắc và giải pháp kỹ thuật môi trường.</p>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($projects as $project)<x-content-card :title="$project->title" :url="route('projects.show', $project->slug)" :excerpt="$project->summary" :image="$project->thumbnail" :meta="$project->client" />@endforeach
    </div>
    <div class="mt-10">{{ $projects->links() }}</div>
</div></section>
@endsection
