<div class="max-w-5xl mx-auto mb-12 lg:mb-16">
  <form
    id="contact-consult-form"
    wire:submit="submit"
    class="space-y-4 sm:space-y-5"
  >
    <!-- HONEYPOT ANTI-SPAM FIELD -->
    <div class="hidden" aria-hidden="true" style="display:none !important;">
      <label for="contact-website-trap">Website</label>
      <input
        type="text"
        id="contact-website-trap"
        wire:model="website"
        tabindex="-1"
        autocomplete="off"
      />
    </div>

    <!-- Row 1: Họ và tên & Email -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
      <div>
        <label for="contact-fullname" class="sr-only">Họ và tên</label>
        <input
          type="text"
          id="contact-fullname"
          wire:model.blur="name"
          placeholder="Họ và tên *"
          class="w-full bg-white border @error('name') border-red-500 ring-2 ring-red-200 @else border-gray-300/80 hover:border-gray-400 @enderror focus:border-primary focus:ring-2 focus:ring-primary/15 rounded-2xl px-5 py-4 text-[16px] text-gray-800 placeholder-gray-400 transition-all shadow-xs outline-none"
        />
        @error('name')
          <p class="mt-1.5 text-xs text-red-600 font-medium pl-2">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label for="contact-email-field" class="sr-only">Email</label>
        <input
          type="email"
          id="contact-email-field"
          wire:model.blur="email"
          placeholder="Email (không bắt buộc)"
          class="w-full bg-white border @error('email') border-red-500 ring-2 ring-red-200 @else border-gray-300/80 hover:border-gray-400 @enderror focus:border-primary focus:ring-2 focus:ring-primary/15 rounded-2xl px-5 py-4 text-[16px] text-gray-800 placeholder-gray-400 transition-all shadow-xs outline-none"
        />
        @error('email')
          <p class="mt-1.5 text-xs text-red-600 font-medium pl-2">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <!-- Row 2: Số điện thoại & Chủ đề / Dịch vụ -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
      <div>
        <label for="contact-phone-field" class="sr-only">Số điện thoại</label>
        <input
          type="tel"
          id="contact-phone-field"
          wire:model.blur="phone"
          placeholder="Số điện thoại *"
          class="w-full bg-white border @error('phone') border-red-500 ring-2 ring-red-200 @else border-gray-300/80 hover:border-gray-400 @enderror focus:border-primary focus:ring-2 focus:ring-primary/15 rounded-2xl px-5 py-4 text-[16px] text-gray-800 placeholder-gray-400 transition-all shadow-xs outline-none"
        />
        @error('phone')
          <p class="mt-1.5 text-xs text-red-600 font-medium pl-2">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label for="contact-topic-field" class="sr-only">Chủ đề</label>
        <input
          type="text"
          id="contact-topic-field"
          wire:model.blur="topic"
          placeholder="Chủ đề / Dịch vụ cần tư vấn"
          class="w-full bg-white border @error('topic') border-red-500 ring-2 ring-red-200 @else border-gray-300/80 hover:border-gray-400 @enderror focus:border-primary focus:ring-2 focus:ring-primary/15 rounded-2xl px-5 py-4 text-[16px] text-gray-800 placeholder-gray-400 transition-all shadow-xs outline-none"
        />
        @error('topic')
          <p class="mt-1.5 text-xs text-red-600 font-medium pl-2">{{ $message }}</p>
        @enderror
      </div>
    </div>

    <!-- Row 3: Nội dung chi tiết -->
    <div>
      <label for="contact-message-field" class="sr-only">Nội dung</label>
      <textarea
        id="contact-message-field"
        wire:model.blur="message"
        rows="4"
        placeholder="Nội dung chi tiết yêu cầu tư vấn (tối thiểu 10 ký tự)..."
        class="w-full bg-white border @error('message') border-red-500 ring-2 ring-red-200 @else border-gray-300/80 hover:border-gray-400 @enderror focus:border-primary focus:ring-2 focus:ring-primary/15 rounded-2xl px-5 py-4 text-[16px] text-gray-800 placeholder-gray-400 transition-all shadow-xs outline-none resize-y"
      ></textarea>
      @error('message')
        <p class="mt-1.5 text-xs text-red-600 font-medium pl-2">{{ $message }}</p>
      @enderror
    </div>

    <!-- Row 4: Nút Gửi thông tin -->
    <div class="pt-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <button
        type="submit"
        id="btn-submit-contact"
        wire:loading.attr="disabled"
        class="inline-flex items-center justify-center gap-3 font-bold text-white bg-primary hover:bg-[#e03e2f] rounded-2xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/50 transition-all duration-200 cursor-pointer active:scale-95 text-[17px] whitespace-nowrap shrink-0 px-10 py-3.5 disabled:opacity-75 disabled:cursor-not-allowed"
      >
        <span wire:loading.remove wire:target="submit">Gửi thông tin</span>
        <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
          <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Đang gửi...
        </span>
        <svg wire:loading.remove wire:target="submit" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
        </svg>
      </button>
      <p class="text-[13.5px] text-gray-500 italic">
        * Thông tin của bạn được bảo mật tuyệt đối theo chính sách quyền riêng tư của Bảo Châu.
      </p>
    </div>
  </form>
</div>
