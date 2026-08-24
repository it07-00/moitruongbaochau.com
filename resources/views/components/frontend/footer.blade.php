<footer id="footer" class="site-footer has-contact-link relative overflow-hidden bg-gradient-to-b from-[#e8f8f0] via-[#d6f4e6] to-[#c3eed9]" itemscope itemtype="https://schema.org/WPFooter">
    <div class="container px-3 mx-auto py-12 lg:py-16">
        <div class="grid gap-8 lg:gap-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start">
            <section>
                <img src="{{ asset('assets/images/optimized/logo-bao-chau.webp') }}" width="76" height="76" alt="Môi Trường Bảo Châu" class="mb-4 size-20 object-contain">
                <h2 class="text-lg font-bold mb-4">{{ $websiteSettings['company_name'] ?? 'CÔNG TY TNHH DỊCH VỤ VÀ KỸ THUẬT MÔI TRƯỜNG BẢO CHÂU' }}</h2>
                <p>{{ $websiteSettings['address'] ?? '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh' }}</p>
                <p>MST: 0317615845</p>
                <p><a href="mailto:{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}">{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}</a></p>
            </section>
            <section>
                <h2 class="text-lg font-bold mb-4">Tổng đài hỗ trợ</h2>
                <ul class="space-y-2">
                    <li><a href="tel:0915219148">0915 219 148 - Ms. Nhật Quỳnh</a></li>
                    <li><a href="tel:0915549148">0915 549 148 - Ms. San San</a></li>
                    <li><a href="tel:0942241148">094 224 1148 - Ms. Thanh Thảo</a></li>
                    <li><a href="tel:0917283148">0917 283 148 - Ms. Tường Vy</a></li>
                    <li><a href="tel:0917297338">0917 297 338 - Ms. Mỹ Trân</a></li>
                </ul>
            </section>
            <section>
                <h2 class="text-lg font-bold mb-4">Dịch vụ môi trường</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('services.index') }}">Đánh giá tác động môi trường</a></li>
                    <li><a href="{{ route('services.index') }}">Giấy phép môi trường</a></li>
                    <li><a href="{{ route('services.index') }}">Kiểm kê khí nhà kính &amp; ESG</a></li>
                    <li><a href="{{ route('services.index') }}">Quan trắc môi trường lao động</a></li>
                    <li><a href="{{ route('projects.index') }}">Dự án tiêu biểu</a></li>
                </ul>
            </section>
        </div>
        <div class="mt-10 pt-6 border-t border-black/10 flex flex-col lg:flex-row justify-between gap-2 text-sm">
            <span>© 2019 - {{ now()->year }} Môi Trường Bảo Châu</span>
            <span>GPĐKKD: 0317615845 do Sở KH &amp; ĐT TP.HCM cấp</span>
        </div>
    </div>
</footer>
