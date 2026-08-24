@extends('frontend.layouts.app')

@section('content')
<section class="py-10 lg:py-16"><div class="container px-3 mx-auto">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Liên hệ']]" />
    <div class="grid lg:grid-cols-2 gap-10 items-start">
        <div>
            <h1 class="text-4xl lg:text-6xl font-bold mb-6">Liên hệ tư vấn</h1>
            <p class="text-lg text-gray-700 mb-8">Chia sẻ nhu cầu của doanh nghiệp. Đội ngũ Bảo Châu sẽ phản hồi và đề xuất lộ trình phù hợp.</p>
            <div class="glass-effect rounded-3xl border border-black/8 p-6 space-y-4">
                <p><strong>Trụ sở:</strong> 180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh</p>
                <p><strong>Hotline:</strong> <a href="tel:0915549148">0915 549 148</a></p>
                <p><strong>Email:</strong> <a href="mailto:info@baochauenvir.com">info@baochauenvir.com</a></p>
            </div>
        </div>
        <form method="post" action="{{ route('contact.store') }}" class="glass-effect rounded-3xl border border-black/8 bg-white/95 p-6 lg:p-8 space-y-5">
            @csrf
            @if (session('success'))<div role="status" class="rounded-xl bg-secondary text-white p-4">{{ session('success') }}</div>@endif
            <div><label for="name" class="block font-bold mb-2">Họ và tên *</label><input id="name" name="name" value="{{ old('name') }}" required maxlength="120" autocomplete="name" class="w-full rounded-xl border border-gray-300 px-4 py-3">@error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div><label for="phone" class="block font-bold mb-2">Số điện thoại *</label><input id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" class="w-full rounded-xl border border-gray-300 px-4 py-3">@error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror</div>
                <div><label for="email" class="block font-bold mb-2">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" class="w-full rounded-xl border border-gray-300 px-4 py-3">@error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror</div>
            </div>
            <div><label for="topic" class="block font-bold mb-2">Nội dung cần tư vấn</label><input id="topic" name="topic" value="{{ old('topic') }}" maxlength="180" class="w-full rounded-xl border border-gray-300 px-4 py-3">@error('topic')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div><label for="message" class="block font-bold mb-2">Thông tin chi tiết *</label><textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000" class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('message') }}</textarea>@error('message')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror</div>
            <div class="absolute opacity-0 pointer-events-none" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" value="" tabindex="-1" autocomplete="off"></div>
            @error('website')<p class="text-red-600 text-sm">Không thể gửi biểu mẫu.</p>@enderror
            <button type="submit" class="c-button bg-primary text-white rounded-full px-7 py-3 font-bold">Gửi yêu cầu tư vấn</button>
        </form>
    </div>
</div></section>
@endsection
