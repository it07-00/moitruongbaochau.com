<footer id="footer" class="site-footer has-contact-link relative overflow-hidden bg-gradient-to-b from-[#e8f8f0] via-[#d6f4e6] to-[#c3eed9]" itemtype="https://schema.org/WPFooter" itemscope="">
    <div class="bg-absolute-footer hidden">
        <img src="{{ asset('assets/images/footer-2-bg-1920x960.png') }}" class="object-cover object-left" width="1920" height="960" alt="" decoding="async" loading="lazy" />
    </div>
    <div id="footer-columns" class="footer-columns relative">
        <div class="container px-3 mx-auto">
            <div class="grid gap-8 lg:gap-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start">
                <!-- CỘT 1: THÔNG TIN DOANH NGHIỆP -->
                <div class="footer-col-1">
                    <p class="footer-title text-[#064e3b] text-xl lg:text-2xl font-bold mb-6">Thông Tin Doanh Nghiệp</p>
                    <div class="space-y-4">
                        <p class="text-[#047857] font-bold text-[16px] uppercase tracking-wide leading-snug">
                            {{ $websiteSettings['company_name'] ?? 'CÔNG TY TNHH DỊCH VỤ VÀ KỸ THUẬT MÔI TRƯỜNG BẢO CHÂU' }}
                        </p>
                        <ul class="space-y-5 text-[#374151] text-[16px] leading-relaxed">
                            <li class="flex items-start gap-3">
                                <svg class="text-[#059669] size-5 w-5 h-5 shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5z"></path>
                                </svg>
                                <span>
                                    <strong class="font-bold text-[#064e3b]">Trụ sở chính:</strong>
                                    {{ $websiteSettings['address'] ?? '180/40 Nguyễn Hữu Cảnh, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh' }}
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-[#059669] size-5 w-5 h-5 shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"></path>
                                </svg>
                                <span>
                                    <strong class="font-bold text-[#064e3b]">GPĐKKD / MST:</strong>
                                    {{ $websiteSettings['tax_code'] ?? '0317615845 do Sở KH & ĐT TP.HCM cấp' }}
                                </span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="text-[#059669] size-5 w-5 h-5 shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5l-8-5V6l8 5l8-5v2z"></path>
                                </svg>
                                <div>
                                    <strong class="font-bold text-[#064e3b]">Email tiếp nhận:</strong>
                                    <a class="text-[#374151] hover:text-[#059669] transition-colors block text-[16px] mt-1" href="mailto:{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}">{{ $websiteSettings['email'] ?? 'info@baochauenvir.com' }}</a>
                                    @if(filled($websiteSettings['email_secondary'] ?? null))
                                        <a class="text-[#374151] hover:text-[#059669] transition-colors block text-[16px] mt-1" href="mailto:{{ $websiteSettings['email_secondary'] }}">{{ $websiteSettings['email_secondary'] }}</a>
                                    @endif
                                </div>
                            </li>
                        </ul>
                        <div class="social-links mt-6 pt-1">
                            <p class="text-[15px] font-bold text-[#064e3b] mb-3">Kết nối với chúng tôi:</p>
                            <ul class="menu social-menu flex flex-row flex-wrap gap-3">
                                <li>
                                    <a class="facebook text-[#064e3b] hover:text-[#059669] bg-white border border-[#a7f3d0] rounded p-2 inline-block transition-colors shadow-xs" href="{{ $websiteSettings['facebook'] ?? 'https://www.facebook.com/moitruongbaochau' }}" title="Facebook" target="_blank" rel="noopener noreferrer nofollow">
                                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="18" height="18">
                                            <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"></path>
                                        </svg>
                                        <span class="sr-only">Facebook</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="zalo text-[#064e3b] hover:text-[#059669] bg-white border border-[#a7f3d0] rounded p-2 inline-block transition-colors shadow-xs" href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $websiteSettings['hotline'] ?? '0915549148') }}" title="Zalo" target="_blank" rel="noopener noreferrer nofollow">
                                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="18" height="18">
                                            <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
                                        </svg>
                                        <span class="sr-only">Zalo</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="youtube text-[#064e3b] hover:text-[#059669] bg-white border border-[#a7f3d0] rounded p-2 inline-block transition-colors shadow-xs" href="{{ $websiteSettings['youtube'] ?? 'https://www.youtube.com/@moitruongbaochau' }}" title="Youtube" target="_blank" rel="noopener noreferrer nofollow">
                                        <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" height="18">
                                            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                                        </svg>
                                        <span class="sr-only">Youtube</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CỘT 2: TỔNG ĐÀI HỖ TRỢ -->
                <div class="footer-col-2">
                    <p class="footer-title text-[#064e3b] text-xl lg:text-2xl font-bold mb-6">Tổng Đài Hỗ Trợ</p>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[#047857] font-bold text-[14px] uppercase tracking-wider mb-3.5">KINH DOANH (08:00 - 17:00 MỖI NGÀY)</p>
                            <ul class="space-y-3.5 text-[16px] text-[#374151]">
                                <li class="flex items-center gap-2">
                                    <a href="tel:0915219148" class="text-[#059669] font-bold text-[17px] lining-nums hover:underline">0915 219 148</a>
                                    <span class="text-[#374151]"> - Ms. Nhật Quỳnh</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <a href="tel:0915549148" class="text-[#059669] font-bold text-[17px] lining-nums hover:underline">0915 549 148</a>
                                    <span class="text-[#374151]"> - Ms. San San</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <a href="tel:0942241148" class="text-[#059669] font-bold text-[17px] lining-nums hover:underline">094 224 1148</a>
                                    <span class="text-[#374151]"> - Ms. Thanh Thảo</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <a href="tel:0917283148" class="text-[#059669] font-bold text-[17px] lining-nums hover:underline">0917 283 148</a>
                                    <span class="text-[#374151]"> - Ms. Tường Vy</span>
                                </li>
                            </ul>
                            <p class="text-[13.5px] text-[#6b7280] italic mt-3">Tất cả các ngày trong tuần (Trừ chủ nhật, ngày Lễ, tết Âm Lịch)</p>
                        </div>

                        <div class="pt-5">
                            <p class="text-[#047857] font-bold text-[14px] uppercase tracking-wider mb-3.5">NV. TƯ VẤN (08:00 - 17:00 MỖI NGÀY)</p>
                            <ul class="space-y-3.5 text-[16px] text-[#374151]">
                                <li class="flex items-center gap-2">
                                    <a href="tel:0917297338" class="text-[#059669] font-bold text-[17px] lining-nums hover:underline">0917 297 338</a>
                                    <span class="text-[#374151]"> - Ms. Mỹ Trân</span>
                                </li>
                            </ul>
                            <p class="text-[13.5px] text-[#6b7280] italic mt-3">Từ Thứ 2 đến Thứ 7 (Trừ chủ nhật, ngày Lễ, tết Âm Lịch)</p>
                        </div>
                    </div>
                </div>

                <!-- CỘT 3: DỊCH VỤ TRỌNG TÂM -->
                <div class="footer-col-3">
                    <p class="footer-title text-[#064e3b] text-xl lg:text-2xl font-bold mb-6">Dịch Vụ Môi Trường</p>
                    <ul class="menu menu-drop text-[16px] space-y-3.5">
                        <li><a href="{{ route('services.show', 'bao-cao-danh-gia-tac-dong-moi-truong') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Báo Cáo Đánh Giá Tác Động MT (ĐTM)</a></li>
                        <li><a href="{{ route('services.show', 'giay-phep-moi-truong') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Cấp Giấy Phép Môi Trường 2020</a></li>
                        <li><a href="{{ route('services.show', 'kiem-ke-khi-nha-kinh') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Kiểm Kê Khí Nhà Kính &amp; Báo Cáo ESG</a></li>
                        <li><a href="{{ route('services.show', 'tu-van-cbam-esg-lca') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Tư Vấn Cơ Chế CBAM &amp; Vòng Đời LCA</a></li>
                        <li><a href="{{ route('services.show', 'quan-trac-moi-truong-lao-dong') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Quan Trắc Môi Trường Lao Động</a></li>
                        <li><a href="{{ route('services.show', 'xu-ly-nuoc-thai') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Xử Lý Nước Thải &amp; Khí Thải Công Nghiệp</a></li>
                        <li><a href="{{ route('projects.index') }}" class="text-[#374151] hover:text-[#059669] hover:translate-x-1 transition-all block font-medium">Dự Án Tiêu Biểu &amp; Năng Lực Thực Hiện</a></li>
                    </ul>
                </div>
            </div>

            <!-- LOGO TRÒN FOOTER -->
            <div class="footer-logo flex justify-center items-center my-5 md:my-6">
                <a title="MÔI TRƯỜNG BẢO CHÂU" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo-leave-png-min.png') }}" class="default-logo w-36 sm:w-40 h-auto" width="1045" height="344" alt="MÔI TRƯỜNG BẢO CHÂU" loading="lazy" decoding="async" />
                </a>
            </div>
        </div>
    </div>
    <div id="footer-credit" class="pt-2">
        <div class="container px-3 mx-auto text-[14px] text-[#4b5563]">
            <div class="grid grid-cols-1 lg:grid-cols-3 items-center mx-auto gap-2 md:gap-4 py-3">
                <div class="text-center lg:text-left w-full text-[#4b5563]">
                    © <span class="copyright-year text-[#064e3b] font-semibold">{{ now()->year }}</span> {{ $websiteSettings['company_name'] ?? 'Công ty TNHH Dịch vụ và Kỹ thuật Môi trường Bảo Châu.' }}
                </div>
                <div class="flex gap-1.25 justify-center items-center w-full text-[#4b5563]">
                    Đồng hành
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 w-5 h-5 fill-[#059669] text-[#059669]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"></path>
                    </svg>
                    cùng
                    <span class="font-bold text-[#064e3b]">MÔI TRƯỜNG BẢO CHÂU</span>
                </div>
                <div class="link-elm w-full flex items-center justify-center lg:justify-end text-[#4b5563]">
                    GPĐKKD: {{ $websiteSettings['tax_code'] ?? '0317615845 do Sở KH & ĐT TP.HCM cấp' }}
                </div>
            </div>
        </div>
    </div>
</footer>

