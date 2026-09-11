@props([
    'title' => 'Bạn đang cần tư vấn giải pháp môi trường?',
    'description' => 'Đội ngũ Bảo Châu sẵn sàng khảo sát nhu cầu và đề xuất lộ trình phù hợp cho doanh nghiệp.',
    'phone' => null,
])

<section id="section-cta" {{ $attributes->merge(['class' => 'section section-cta py-12 lg:py-20']) }}>
    <div class="container px-3 mx-auto">
        <div class="grid items-center gap-8 rounded-[2rem] border border-black/8 bg-white/80 p-7 shadow-lg backdrop-blur-md lg:grid-cols-[1fr_280px] lg:p-12">
            <div>
                <x-theme.badge text="Tư vấn cùng chuyên gia" />
                <h2 class="max-w-4xl text-3xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl">{{ $title }}</h2>
                <p class="mt-5 max-w-3xl text-base leading-relaxed text-gray-600 sm:text-lg">{{ $description }}</p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact.index') }}" class="c-button rounded-full bg-primary px-6 py-3 font-bold text-white">Nhận tư vấn ngay</a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone ?? ($websiteSettings['hotline'] ?? '0915549148')) }}" class="c-light-button glass-effect rounded-full border border-black/10 px-6 py-3 font-bold">{{ $phone ?? ($websiteSettings['hotline'] ?? '0915 549 148') }}</a>
                </div>
            </div>
            <div class="flex justify-center rounded-3xl bg-white p-6 shadow-sm">
                <img src="{{ asset('assets/images/optimized/logo-bao-chau.webp') }}" width="220" height="220" loading="lazy" decoding="async" alt="Môi Trường Bảo Châu" class="size-44 object-contain lg:size-52">
            </div>
        </div>
    </div>
</section>
