@props(['title' => 'Khách hàng & Đối tác của MÔI TRƯỜNG BẢO CHÂU'])

@php
    $partnerLogos = [
        ['image' => 'BERICAP.jpg', 'name' => 'BERICAP'],
        ['image' => 'PEPSICO.jpg', 'name' => 'Suntory PepsiCo'],
        ['image' => 'CTY-TAN-TIEN-1024x640.png', 'name' => 'Bao bì Tân Tiến'],
        ['image' => 'mitsubishi-768x768.png', 'name' => 'Mitsubishi'],
        ['image' => 'bidrico.png', 'name' => 'Bidrico'],
        ['image' => 'breadtalkvietnam.png', 'name' => 'BreadTalk Việt Nam'],
        ['image' => 'logo-gocons-768x344.png', 'name' => 'Gocons'],
        ['image' => 'logo-hucons-768x344.webp', 'name' => 'Hucons'],
        ['image' => 'v-holdings.png', 'name' => 'V Holdings'],
        ['image' => 'bbracing.png', 'name' => 'BB Racing'],
    ];
@endphp

<section {{ $attributes->merge(['class' => 'section section-partners py-12 lg:py-20 relative overflow-hidden']) }}>
    <div class="container px-3 mx-auto">
        <div class="text-center mb-8 lg:mb-12">
            <x-theme.badge text="Đối tác tin cậy" class="justify-center" />
            <h2 class="font-bold leading-tight text-3xl sm:text-4xl lg:text-5xl text-gray-900">{{ $title }}</h2>
        </div>
    </div>
    <div class="logo-marquee space-y-5" aria-label="Danh sách khách hàng và đối tác">
        @foreach ([false, true] as $reverse)
            <div @class(['logo-marquee-row overflow-hidden', 'is-reverse' => $reverse])>
                <div class="logo-marquee-track flex items-center gap-5 sm:gap-7 min-w-max px-3">
                    @foreach ([...$partnerLogos, ...$partnerLogos] as $partner)
                        <div class="flex h-24 w-44 sm:h-28 sm:w-52 shrink-0 items-center justify-center rounded-2xl border border-black/8 bg-white p-5 shadow-sm">
                            <img src="{{ asset('assets/images/'.$partner['image']) }}" width="200" height="100" loading="lazy" decoding="async" alt="{{ $partner['name'] }}" class="max-h-full max-w-full object-contain">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>
