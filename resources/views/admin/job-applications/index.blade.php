@extends('admin.layouts.app')
@section('title', 'Hồ sơ ứng tuyển')
@section('content')
<h1 class="text-3xl lg:text-4xl font-bold mb-8">Hồ sơ ứng tuyển ({ $applications->total() })</h1>
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-sm uppercase text-gray-700">
                <tr>
                    <th class="p-4">Ứng viên</th>
                    <th class="p-4">Vị trí ứng tuyển</th>
                    <th class="p-4">Điện thoại / Email</th>
                    <th class="p-4">CV</th>
                    <th class="p-4">Trạng thái</th>
                    <th class="p-4">Thời gian</th>
                    <th class="p-4 text-right">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50/60 transition-colors">
                    <td class="p-4">
                        <strong class="text-base text-gray-900">{{ $app->fullname }}</strong>
                    </td>
                    <td class="p-4 font-semibold text-secondary">
                        {{ $app->job_title ?? ($app->jobPosting?->title ?? 'Vị trí đã đóng') }}
                    </td>
                    <td class="p-4">
                        <a href="tel:{{ $app->phone }}" class="font-bold text-gray-900 hover:text-secondary block">{{ $app->phone }}</a>
                        <small class="text-gray-500">{{ $app->email }}</small>
                    </td>
                    <td class="p-4">
                        @if($app->cv_path)
                            <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-800 font-bold text-xs hover:bg-emerald-100 transition-colors">
                                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.5V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                Xem / Tải CV
                            </a>
                        @else
                            <span class="text-gray-400 text-xs">Không có file</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="inline-block px-2.5 py-1 text-xs font-bold rounded-full @if($app->status === 'new') bg-blue-100 text-blue-800 @elseif($app->status === 'reviewed') bg-yellow-100 text-yellow-800 @elseif($app->status === 'contacted') bg-emerald-100 text-emerald-800 @else bg-gray-100 text-gray-800 @endif">
                            {{ match($app->status) { 'new' => 'Mới nộp', 'reviewed' => 'Đã xem', 'contacted' => 'Đã liên hệ', 'rejected' => 'Không phù hợp', default => $app->status } }}
                        </span>
                    </td>
                    <td class="p-4 text-xs text-gray-500">
                        {{ $app->created_at?->format('d/m/Y H:i') }}
                    </td>
                    <td class="p-4 text-right whitespace-nowrap">
                        <a href="{{ route('admin.job-applications.show', $app) }}" class="font-bold text-secondary hover:underline mr-3">Chi tiết</a>
                        <form method="POST" action="{{ route('admin.job-applications.destroy', $app) }}" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hồ sơ này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs cursor-pointer">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">Chưa có hồ sơ ứng tuyển nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $applications->links() }}</div>
@endsection
