@extends('admin.layouts.app')
@section('title', str($resource)->headline())
@section('content')
<div class="flex items-center justify-between gap-4 mb-8"><h1 class="text-3xl lg:text-4xl font-bold">{{ str($resource)->headline() }}</h1><a href="{{ route('admin.content.create', $resource) }}" class="bg-primary text-white rounded-full px-5 py-2.5 font-bold">Thêm mới</a></div>
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden"><div class="overflow-x-auto"><table class="w-full text-left"><thead class="bg-gray-50"><tr><th class="p-4">Tiêu đề</th><th class="p-4">Trạng thái</th><th class="p-4">Cập nhật</th><th class="p-4 text-right">Thao tác</th></tr></thead><tbody>
@forelse($items as $item)<tr class="border-t border-gray-100"><td class="p-4 font-semibold">{{ $item->title ?? $item->name }}</td><td class="p-4">{{ $item->status?->value ?? $item->status }}</td><td class="p-4">{{ $item->updated_at->format('d/m/Y H:i') }}</td><td class="p-4"><div class="flex justify-end gap-3"><a href="{{ route('admin.content.edit', [$resource, $item->id]) }}" class="text-secondary font-bold">Sửa</a><form method="post" action="{{ route('admin.content.destroy', [$resource, $item->id]) }}">@csrf @method('delete')<button type="submit" class="text-red-600 font-bold">Xóa</button></form></div></td></tr>@empty<tr><td colspan="4" class="p-8 text-center text-gray-500">Chưa có dữ liệu.</td></tr>@endforelse
</tbody></table></div></div><div class="mt-6">{{ $items->links() }}</div>
@endsection
