@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
<h1 class="text-3xl lg:text-4xl font-bold mb-8">Dashboard</h1>
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
    @foreach ($counts as $key => $count)
        <div class="bg-white rounded-2xl border border-gray-200 p-6"><p class="text-sm uppercase text-gray-500">{{ str($key)->replace('_', ' ')->headline() }}</p><p class="text-4xl font-bold mt-2">{{ $count }}</p></div>
    @endforeach
</div>
@endsection
