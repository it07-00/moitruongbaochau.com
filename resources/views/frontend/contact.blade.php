@extends('frontend.layouts.app', ['bodyClass' => 'page-contact'])

@section('content')
<div class="container px-3 mx-auto pt-5 lg:pt-8">
    <x-breadcrumb :items="[['label' => 'Trang chủ', 'url' => route('home')], ['label' => 'Liên hệ']]" />
</div>

<section class="section section-contact-consultation relative overflow-hidden py-8 lg:py-16">
    <div class="container px-3 mx-auto">
        <div class="mx-auto mb-10 max-w-4xl text-center"><x-theme.badge text="Kết nối cùng chuyên gia" class="justify-center" /><h1 class="text-4xl font-extrabold leading-tight text-gray-900 sm:text-5xl lg:text-6xl">Liên hệ tư vấn ngay</h1><p class="mt-5 text-lg leading-relaxed text-gray-600">Gửi thông tin nhu cầu để đội ngũ Bảo Châu hỗ trợ đúng chuyên môn và phản hồi sớm nhất.</p></div>
        <div class="grid gap-8 lg:grid-cols-[1.15fr_.85fr]">
            <div class="rounded-[2rem] border border-black/8 bg-white p-6 shadow-lg sm:p-8">
                @if (session('success'))<div class="mb-6 rounded-2xl bg-emerald-50 p-4 font-semibold text-emerald-800" role="status">{{ session('success') }}</div>@endif
                @if ($errors->any())<div class="mb-6 rounded-2xl bg-red-50 p-4 text-red-700" role="alert">Vui lòng kiểm tra lại các trường được đánh dấu.</div>@endif
                <form action="{{ route('contact.store') }}" method="post" class="grid gap-5 sm:grid-cols-2">
                    @csrf
                    <div class="hidden" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" type="text" tabindex="-1" autocomplete="off"></div>
                    <div><label for="name" class="mb-2 block font-bold">Họ và tên <span class="text-red-600">*</span></label><input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none">@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label for="email" class="mb-2 block font-bold">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none">@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label for="phone" class="mb-2 block font-bold">Số điện thoại <span class="text-red-600">*</span></label><input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none">@error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div><label for="topic" class="mb-2 block font-bold">Chủ đề / Dịch vụ</label><input id="topic" name="topic" value="{{ old('topic') }}" class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none">@error('topic')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div class="sm:col-span-2"><label for="message" class="mb-2 block font-bold">Nội dung chi tiết <span class="text-red-600">*</span></label><textarea id="message" name="message" rows="6" required class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-primary focus:outline-none">{{ old('message') }}</textarea>@error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                    <div class="sm:col-span-2"><button type="submit" class="w-full rounded-full bg-primary px-6 py-3.5 font-bold text-white sm:w-auto">Gửi thông tin</button></div>
                </form>
            </div>
            <div class="grid gap-5">
                @foreach ([['Tư vấn hồ sơ & Giấy phép MT', 'ĐTM, giấy phép môi trường, đăng ký môi trường và báo cáo định kỳ.'], ['Kiểm kê KNK – ESG – CBAM', 'Kiểm kê phát thải, báo cáo ESG và chuẩn bị dữ liệu CBAM.'], ['Hỗ trợ kỹ thuật & Xử lý NT', 'Tư vấn, thiết kế và tối ưu hệ thống xử lý nước thải, khí thải.']] as [$title, $description])
                    <article class="rounded-3xl border border-black/8 bg-white p-6 shadow-sm"><span class="mb-4 flex size-12 items-center justify-center rounded-2xl bg-emerald-100 text-xl text-primary">✓</span><h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2><p class="mt-3 leading-relaxed text-gray-600">{{ $description }}</p><a href="tel:0915549148" class="mt-4 inline-flex font-bold text-secondary">Gọi tư vấn: 0915 549 148</a></article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section section-office-map relative overflow-hidden bg-gray-50/70 py-12 lg:py-20">
    <div class="container px-3 mx-auto">
        <div class="mb-10 text-center"><x-theme.badge text="Thông tin doanh nghiệp" class="justify-center" /><h2 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">Hệ thống văn phòng & Bản đồ chỉ đường</h2></div>
        <div class="grid gap-7 lg:grid-cols-2">
            <article class="rounded-[2rem] border border-black/8 bg-white p-7 shadow-sm sm:p-9"><div class="mb-7 flex items-center gap-4"><img src="{{ asset('assets/images/optimized/logo-bao-chau.webp') }}" width="72" height="72" alt="Môi Trường Bảo Châu" class="size-18 object-contain"><h3 class="text-xl font-bold text-secondary">{{ $websiteSettings['company_name'] ?? 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu' }}</h3></div><dl class="grid gap-5"><div><dt class="font-bold text-gray-900">Địa chỉ</dt><dd class="mt-1 text-gray-600">{{ $websiteSettings['address'] ?? '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh' }}</dd></div><div><dt class="font-bold text-gray-900">Hotline</dt><dd class="mt-1"><a href="tel:0915549148" class="text-primary">{{ $websiteSettings['phone'] ?? '0915 549 148' }}</a></dd></div><div><dt class="font-bold text-gray-900">Email</dt><dd class="mt-1"><a href="mailto:{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}" class="text-primary">{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}</a></dd></div><div><dt class="font-bold text-gray-900">Giờ làm việc</dt><dd class="mt-1 text-gray-600">Thứ Hai – Thứ Bảy, 08:00 – 17:00</dd></div></dl><div class="mt-7 flex flex-wrap gap-3"><a href="tel:0915549148" class="rounded-full bg-primary px-5 py-3 font-bold text-white">Gọi ngay</a><a href="https://www.google.com/maps/dir/?api=1&destination=10.7940334,106.7188971" target="_blank" rel="noopener noreferrer" class="rounded-full border border-black/10 px-5 py-3 font-bold">Chỉ đường</a></div></article>
            <div class="min-h-[420px] overflow-hidden rounded-[2rem] border border-black/8 bg-gray-200 shadow-sm"><iframe title="Bản đồ Môi Trường Bảo Châu" src="https://www.google.com/maps?q=10.7940334,106.7188971&z=16&output=embed" width="100%" height="100%" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="min-h-[420px] w-full border-0"></iframe></div>
        </div>
    </div>
</section>
@endsection
