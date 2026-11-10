@extends('frontend.layouts.app')

@section('content')
<section class="section py-12 lg:py-20" aria-labelledby="capability-profile-title">
    <div class="container px-3 mx-auto">
        <nav class="text-sm text-gray-600 mb-6" aria-label="Đường dẫn trang">
            <a href="{{ route('home') }}">Trang chủ</a>
            <span aria-hidden="true"> / </span>
            <a href="{{ route('about') }}">Giới thiệu</a>
            <span aria-hidden="true"> / </span>
            <span aria-current="page">Hồ sơ năng lực</span>
        </nav>
        <h1 id="capability-profile-title" class="font-bold text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight">{{ $page->title }}</h1>
        @if (filled($page->excerpt))
            <p class="mt-5 max-w-3xl text-gray-600 leading-relaxed">{{ $page->excerpt }}</p>
        @endif
    </div>
</section>

<section class="capability-profile-section" aria-labelledby="capability-profile-overview">
    <div class="container px-3 mx-auto">
        <div class="capability-profile-layout">
            <div>
                <p class="capability-profile-label">Hồ sơ năng lực</p>
                <h2 id="capability-profile-overview">Giới thiệu năng lực Bảo Châu</h2>
                <div class="capability-profile-content">
                    @if (filled($page->content))
                        {!! app(\App\Support\OptimizedImage::class)->html($page->content) !!}
                    @else
                        <p>Hồ sơ năng lực giới thiệu đội ngũ, các lĩnh vực hoạt động và kinh nghiệm triển khai dự án của Môi Trường Bảo Châu.</p>
                    @endif
                </div>

                @if ($hasPdf)
                    <div class="capability-profile-actions">
                        <a href="{{ route('capability-profile.pdf') }}" target="_blank" rel="noopener noreferrer">Xem trực tuyến <span aria-hidden="true">↗</span></a>
                        <a href="{{ route('capability-profile.pdf', ['download' => 1]) }}" download="ho-so-nang-luc-bao-chau.pdf">Tải bản PDF <span aria-hidden="true">↓</span></a>
                    </div>
                @else
                    <p class="mt-5">Hồ sơ năng lực đang được cập nhật. Vui lòng liên hệ để nhận bản mới nhất.</p>
                    <div class="capability-profile-actions">
                        <a href="{{ route('contact.index') }}">Liên hệ nhận hồ sơ năng lực</a>
                    </div>
                @endif
            </div>

            <div class="capability-profile-highlights">
                <article>
                    <h3>Hồ sơ pháp lý môi trường</h3>
                    <p>Tư vấn báo cáo đánh giá tác động môi trường, giấy phép và đăng ký môi trường.</p>
                </article>
                <article>
                    <h3>Đội ngũ chuyên môn</h3>
                    <p>Chuyên gia và kỹ sư môi trường đồng hành từ khảo sát đến triển khai.</p>
                </article>
                <article>
                    <h3>Dịch vụ kỹ thuật</h3>
                    <p>Quan trắc môi trường, thiết kế và triển khai hệ thống xử lý nước thải, khí thải.</p>
                </article>
                <article>
                    <h3>Chuyển đổi xanh</h3>
                    <p>Kiểm kê khí nhà kính, báo cáo ESG, CBAM và đánh giá vòng đời sản phẩm.</p>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
