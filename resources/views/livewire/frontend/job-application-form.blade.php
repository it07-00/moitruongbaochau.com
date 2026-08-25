<div>
  <form wire:submit="submit" class="space-y-4">
    <!-- Họ và tên -->
    <div>
      <input
        type="text"
        wire:model.blur="fullname"
        placeholder="Họ và tên ứng viên *"
        class="font-normal w-full border @error('fullname') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror rounded-xl h-13 px-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
      />
      @error('fullname')
        <p class="mt-1 text-xs text-red-600 font-medium pl-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Số điện thoại -->
    <div>
      <input
        type="tel"
        wire:model.blur="contact_phone"
        placeholder="Số điện thoại liên hệ *"
        class="font-normal w-full border @error('contact_phone') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror rounded-xl h-13 px-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
      />
      @error('contact_phone')
        <p class="mt-1 text-xs text-red-600 font-medium pl-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Email -->
    <div>
      <input
        type="email"
        wire:model.blur="contact_email"
        placeholder="Email *"
        class="font-normal w-full border @error('contact_email') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror rounded-xl h-13 px-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
      />
      @error('contact_email')
        <p class="mt-1 text-xs text-red-600 font-medium pl-1">{{ $message }}</p>
      @enderror
    </div>

    @if(!$preselectedJobId)
    <!-- Vị trí ứng tuyển (Nếu là form chung) -->
    <div>
      <select
        wire:model.blur="job_posting_id"
        class="font-normal w-full border @error('job_posting_id') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror rounded-xl h-13 px-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white"
      >
        <option value="">-- Chọn vị trí tuyển dụng --</option>
        @foreach($jobPostings as $jobItem)
          <option value="{{ $jobItem->id }}">{{ $jobItem->title }}</option>
        @endforeach
        <option value="other">Vị trí khác / Ứng tuyển dự bị</option>
      </select>
      @error('job_posting_id')
        <p class="mt-1 text-xs text-red-600 font-medium pl-1">{{ $message }}</p>
      @enderror
    </div>

    @if($job_posting_id === 'other')
    <div>
      <input
        type="text"
        wire:model.blur="custom_position"
        placeholder="Nhập tên vị trí mong muốn ứng tuyển..."
        class="font-normal w-full border border-gray-300 rounded-xl h-13 px-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all"
      />
    </div>
    @endif
    @endif

    <!-- Upload File CV Dropzone (100% Centered & Reliable) -->
    <div
      x-data="{ isUploading: false, progress: 0 }"
      x-on:livewire-upload-start="isUploading = true; progress = 0"
      x-on:livewire-upload-finish="isUploading = false"
      x-on:livewire-upload-error="isUploading = false"
      x-on:livewire-upload-progress="progress = $event.detail.progress"
      style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;"
    >
      <label
        for="cv_file_input"
        style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; min-height: 130px; padding: 22px 16px; border: 2px dashed #cbd5e1; background: #f8fafc; border-radius: 16px; cursor: pointer; text-align: center; position: relative; transition: all 0.2s ease-in-out; box-sizing: border-box;"
        onmouseover="this.style.borderColor='#ff4d38'; this.style.backgroundColor='#ffffff';"
        onmouseout="this.style.borderColor='#cbd5e1'; this.style.backgroundColor='#f8fafc';"
      >
        <!-- Trạng thái Đang tải lên (Progress bar) -->
        <div x-show="isUploading" style="display: none; width: 100%; max-width: 280px; margin: 0 auto; text-align: center;">
          <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; color: #ff4d38; margin-bottom: 6px;">
            <span>Đang tải file lên...</span>
            <span x-text="`${progress}%`"></span>
          </div>
          <div style="width: 100%; background: #e2e8f0; height: 8px; border-radius: 9999px; overflow: hidden; margin: 0 auto;">
            <div style="background: #ff4d38; height: 8px; border-radius: 9999px; transition: width 0.2s;" :style="`width: ${progress}%`"></div>
          </div>
        </div>

        <!-- Trạng thái Bình thường / Đã chọn file -->
        <div x-show="!isUploading" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; margin: 0 auto;">
          @if($cv_file)
            <!-- ĐÃ CHỌN FILE -->
            <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; border-radius: 50%; background: rgba(5, 150, 105, 0.12); color: #059669; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto;">
              <svg style="width: 24px; height: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div style="width: 100%; max-width: 360px; margin: 0 auto; text-align: center; padding: 0 8px; box-sizing: border-box;">
              <p style="font-size: 15px; font-weight: 700; color: #059669; margin: 0 auto 4px auto; text-align: center; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 100%; display: block;">
                ✓ {{ $this->display_file_name }}
              </p>
              <p style="font-size: 12px; color: #64748b; margin: 0 auto; text-align: center; font-weight: 500;">
                Nhấp để thay đổi file khác
              </p>
            </div>
          @else
            <!-- CHƯA CHỌN FILE -->
            <div style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; border-radius: 50%; background: rgba(255, 77, 56, 0.1); color: #ff4d38; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto;">
              <svg style="width: 22px; height: 22px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.5V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
              </svg>
            </div>
            <div style="width: 100%; margin: 0 auto; text-align: center;">
              <p style="font-size: 14px; font-weight: 700; color: #1e293b; margin: 0 auto 4px auto; text-align: center;">
                <span style="color: #ff4d38;">Nhấp để tải lên CV</span> hoặc kéo thả file vào đây
              </p>
              <p style="font-size: 12px; color: #64748b; margin: 0 auto; text-align: center;">
                Định dạng hỗ trợ: PDF, DOC, DOCX (Dưới 10MB)
              </p>
            </div>
          @endif
        </div>

        <input
          id="cv_file_input"
          type="file"
          wire:model="cv_file"
          accept=".pdf,.doc,.docx"
          style="display: none;"
        />
      </label>

      @error('cv_file')
        <p style="margin-top: 6px; font-size: 12px; color: #dc2626; font-weight: 600; padding-left: 4px; text-align: center;">{{ $message }}</p>
      @enderror
    </div>

    <!-- Lời nhắn / Giới thiệu -->
    <div>
      <textarea
        rows="3"
        wire:model.blur="message"
        class="font-normal w-full border @error('message') border-red-500 ring-2 ring-red-200 @else border-gray-300 @enderror rounded-xl p-4 text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none"
        placeholder="Giới thiệu ngắn gọn kinh nghiệm hoặc lời nhắn..."
      ></textarea>
      @error('message')
        <p class="mt-1 text-xs text-red-600 font-medium pl-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Nút Nộp hồ sơ -->
    <div>
      <button
        type="submit"
        wire:loading.attr="disabled"
        class="font-bold w-full rounded-xl h-14 text-white text-base sm:text-lg bg-primary hover:bg-[#e03e2f] shadow-lg shadow-primary/25 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer active:scale-98 disabled:opacity-75 disabled:cursor-not-allowed"
      >
        <span wire:loading.remove wire:target="submit">Gửi Hồ Sơ Ứng Tuyển</span>
        <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
          <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Đang gửi hồ sơ...
        </span>
        <svg
          wire:loading.remove
          wire:target="submit"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2.2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
          />
        </svg>
      </button>
    </div>
  </form>
</div>
