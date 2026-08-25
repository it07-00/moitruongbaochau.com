@extends('admin.layouts.app')
@section('title', 'Chi tiết hồ sơ ứng tuyển: ' . $jobApplication->fullname)
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.job-applications.index') }}" class="text-sm font-bold text-gray-600 hover:text-secondary inline-flex items-center gap-1">
            &larr; Quay lại danh sách ứng tuyển
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="border-b border-gray-100 pb-6 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $jobApplication->fullname }}</h1>
                <p class="text-secondary font-semibold mt-1">Ứng tuyển vị trí: {{ $jobApplication->job_title ?? ($jobApplication->jobPosting?->title ?? 'N/A') }}</p>
                <p class="text-xs text-gray-500 mt-1">Thời gian nộp: {{ $jobApplication->created_at?->format('d/m/Y H:i:s') }} (IP: {{ $jobApplication->ip_address }})</p>
            </div>

            <form method="POST" action="{{ route('admin.job-applications.update', $jobApplication) }}" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-xl border border-gray-300 px-3 py-2 text-sm font-semibold text-gray-800">
                    <option value="new" @selected($jobApplication->status === 'new')>Mới nộp</option>
                    <option value="reviewed" @selected($jobApplication->status === 'reviewed')>Đã xem</option>
                    <option value="contacted" @selected($jobApplication->status === 'contacted')>Đã liên hệ</option>
                    <option value="rejected" @selected($jobApplication->status === 'rejected')>Không phù hợp</option>
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl bg-secondary text-white font-bold text-sm hover:opacity-90 transition-opacity">Cập nhật</button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <p class="text-xs uppercase font-bold text-gray-400">Số điện thoại</p>
                <p class="text-lg font-bold text-gray-900 mt-1">
                    <a href="tel:{{ $jobApplication->phone }}" class="text-secondary hover:underline">{{ $jobApplication->phone }}</a>
                </p>
            </div>
            <div>
                <p class="text-xs uppercase font-bold text-gray-400">Email</p>
                <p class="text-lg font-bold text-gray-900 mt-1">
                    <a href="mailto:{{ $jobApplication->email }}" class="text-secondary hover:underline">{{ $jobApplication->email }}</a>
                </p>
            </div>
        </div>

        @if($jobApplication->cv_path)
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="size-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <div>
                    <p class="font-bold text-emerald-900 text-sm">Hồ sơ ứng viên (File CV)</p>
                    <p class="text-xs text-emerald-700">{{ basename($jobApplication->cv_path) }}</p>
                </div>
            </div>
            <a href="{{ asset('storage/' . $jobApplication->cv_path) }}" target="_blank" download class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 transition-colors inline-flex items-center gap-1.5">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.5V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                Tải xuống CV
            </a>
        </div>
        @endif

        <div>
            <p class="text-xs uppercase font-bold text-gray-400 mb-2">Lời nhắn / Giới thiệu từ ứng viên</p>
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 leading-relaxed whitespace-pre-line text-[15px]">
                {{ $jobApplication->message ?: 'Ứng viên không để lại lời nhắn.' }}
            </div>
        </div>
    </div>
</div>
@endsection
