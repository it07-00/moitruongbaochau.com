@extends('admin.layouts.app')
@section('title', $item ? 'Chỉnh sửa' : 'Thêm mới')
@section('content')
@php($titleField = $resource === 'services' ? 'name' : 'title')
<h1 class="text-3xl lg:text-4xl font-bold mb-8">{{ $item ? 'Chỉnh sửa' : 'Thêm mới' }} {{ str($resource)->headline() }}</h1>
<form method="post" action="{{ $item ? route('admin.content.update', [$resource, $item->id]) : route('admin.content.store', $resource) }}" class="bg-white rounded-2xl border border-gray-200 p-6 space-y-6">@csrf @if($item)@method('put')@endif
<div><label for="title" class="block font-bold mb-2">Tiêu đề *</label><input id="title" name="{{ $titleField }}" value="{{ old($titleField, $item?->{$titleField}) }}" required maxlength="255" class="w-full rounded-xl border border-gray-300 px-4 py-3">@error($titleField)<p class="text-red-600 text-sm">{{ $message }}</p>@enderror</div>
<div><label for="slug" class="block font-bold mb-2">Slug</label><input id="slug" name="slug" value="{{ old('slug', $item?->slug) }}" maxlength="255" class="w-full rounded-xl border border-gray-300 px-4 py-3"></div>
<div><label for="summary" class="block font-bold mb-2">Mô tả ngắn</label><textarea id="summary" name="{{ match($resource){'services'=>'short_description','posts'=>'excerpt',default=>'summary'} }}" rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old(match($resource){'services'=>'short_description','posts'=>'excerpt',default=>'summary'}, $item?->{match($resource){'services'=>'short_description','posts'=>'excerpt',default=>'summary'}}) }}</textarea></div>
<div><label for="content" class="block font-bold mb-2">Nội dung</label><textarea id="content" name="content" rows="14" class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('content', $item?->content) }}</textarea></div>
<div class="grid md:grid-cols-2 gap-5"><div><label for="status" class="block font-bold mb-2">Trạng thái</label><select id="status" name="status" class="w-full rounded-xl border border-gray-300 px-4 py-3">@foreach(\App\ContentStatus::cases() as $status)<option value="{{ $status->value }}" @selected(old('status', $item?->status?->value ?? 'draft') === $status->value)>{{ str($status->value)->headline() }}</option>@endforeach</select></div><div><label for="published_at" class="block font-bold mb-2">Ngày xuất bản</label><input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $item?->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-xl border border-gray-300 px-4 py-3"></div></div>
@if(in_array($resource, ['services','posts','projects'], true))<label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item?->is_featured))> Hiển thị nổi bật</label>@endif
<fieldset class="border border-gray-200 rounded-2xl p-5">
    <legend class="font-bold px-2 text-primary">Tối ưu hóa SEO Meta (Tự động)</legend>
    <div class="space-y-5">
        <div>
            <label for="meta_title" class="block font-bold mb-2">Meta title</label>
            <input id="meta_title" name="meta_title" value="{{ old('meta_title', $item?->meta_title) }}" maxlength="255" placeholder="Tự động lấy theo tiêu đề nếu để trống..." class="w-full rounded-xl border border-gray-300 px-4 py-3">
            <p class="text-xs text-gray-500 mt-1">Tự động đồng bộ theo tiêu đề. Khuyến nghị: 50 - 60 ký tự.</p>
        </div>
        <div>
            <label for="meta_description" class="block font-bold mb-2">Meta description</label>
            <textarea id="meta_description" name="meta_description" maxlength="320" rows="3" placeholder="Tự động trích xuất từ tóm tắt hoặc nội dung nếu để trống..." class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('meta_description', $item?->meta_description) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Tự động trích xuất từ mô tả/nội dung. Khuyến nghị: 120 - 160 ký tự.</p>
        </div>
        <div>
            <label for="robots" class="block font-bold mb-2">Robots Tag</label>
            <select id="robots" name="robots" class="w-full rounded-xl border border-gray-300 px-4 py-3">
                @foreach(['index,follow' => 'index,follow (Mặc định - Cho phép Google index)', 'noindex,follow' => 'noindex,follow', 'noindex,nofollow' => 'noindex,nofollow'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('robots', $item?->robots ?? 'index,follow') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>
<div class="flex gap-3">
    <button type="submit" class="bg-primary text-white rounded-full px-6 py-3 font-bold">Lưu nội dung</button>
    <a href="{{ route('admin.content.index', $resource) }}" class="rounded-full px-6 py-3 font-bold border border-gray-300">Hủy</a>
</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const metaTitleInput = document.getElementById('meta_title');
    const summaryInput = document.getElementById('summary');
    const contentInput = document.getElementById('content');
    const metaDescInput = document.getElementById('meta_description');

    if (titleInput && metaTitleInput) {
        titleInput.addEventListener('input', function () {
            if (!metaTitleInput.value || metaTitleInput.dataset.autoFilled === 'true') {
                metaTitleInput.value = titleInput.value;
                metaTitleInput.dataset.autoFilled = 'true';
            }
        });
        metaTitleInput.addEventListener('input', function () {
            metaTitleInput.dataset.autoFilled = 'false';
        });
    }

    if (summaryInput && metaDescInput) {
        summaryInput.addEventListener('input', function () {
            if (!metaDescInput.value || metaDescInput.dataset.autoFilled === 'true') {
                metaDescInput.value = summaryInput.value.slice(0, 160);
                metaDescInput.dataset.autoFilled = 'true';
            }
        });
        metaDescInput.addEventListener('input', function () {
            metaDescInput.dataset.autoFilled = 'false';
        });
    }
});
</script>
@endsection
