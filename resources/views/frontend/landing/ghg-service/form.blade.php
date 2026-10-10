@php
    $submitted = old('form_id') === $formId;
    $successful = session('consultation_form_id') === $formId;
    $callback = $consultationType === 'callback';
@endphp
<form method="POST" action="{{ route('ghg-service.store') }}" id="{{ $formId }}" data-consultation-form>
    @csrf
    <input type="hidden" name="form_id" value="{{ $formId }}">
    <input type="hidden" name="consultation_type" value="{{ $consultationType }}">
    <input type="hidden" name="g-recaptcha-response" value="">
    <div aria-hidden="true" style="position:absolute;left:-10000px;width:1px;height:1px;overflow:hidden;">
        <label for="{{ $formId }}-website">Website</label>
        <input id="{{ $formId }}-website" type="text" name="website" value="" tabindex="-1" autocomplete="off">
    </div>
    <div class="mb-3" role="status" aria-live="polite" data-form-status>
        @if ($successful && session('consultation_success'))
            <p class="text-success">{{ session('consultation_success') }}</p>
        @elseif ($submitted && $errors->any())
            <p class="text-danger">Vui lòng kiểm tra thông tin bên dưới.</p>
        @endif
    </div>
    <div class="flex gap-2 mb-3">
        <div class="w-1/2">
            <label class="form-label text-sm" for="{{ $formId }}-name">Họ và tên <span class="text-danger">*</span></label>
            <input class="form-control w-full !border border-solid border-grey-100 !px-3 py-2.5 rounded-lg" id="{{ $formId }}-name" name="name" type="text" autocomplete="name" maxlength="120" required value="{{ $submitted ? old('name') : '' }}" placeholder="Người liên hệ" aria-describedby="{{ $formId }}-name-error">
            <small id="{{ $formId }}-name-error" class="text-danger" data-error-for="name">{{ $submitted ? $errors->first('name') : '' }}</small>
        </div>
        <div class="w-1/2">
            <label class="form-label text-sm" for="{{ $formId }}-company">Tên doanh nghiệp</label>
            <input class="form-control w-full !border border-solid border-grey-100 !px-3 py-2.5 rounded-lg" id="{{ $formId }}-company" name="company_name" type="text" autocomplete="organization" maxlength="180" value="{{ $submitted ? old('company_name') : '' }}" placeholder="Tên công ty" aria-describedby="{{ $formId }}-company-error">
            <small id="{{ $formId }}-company-error" class="text-danger" data-error-for="company_name">{{ $submitted ? $errors->first('company_name') : '' }}</small>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label text-sm" for="{{ $formId }}-phone">Số điện thoại liên hệ <span class="text-danger">*</span></label>
        <input class="form-control w-full !border border-solid border-grey-100 !px-3 py-2.5 rounded-lg" id="{{ $formId }}-phone" name="phone" type="tel" autocomplete="tel" maxlength="20" required value="{{ $submitted ? old('phone') : '' }}" placeholder="0915 549 148" aria-describedby="{{ $formId }}-phone-error">
        <small id="{{ $formId }}-phone-error" class="text-danger" data-error-for="phone">{{ $submitted ? $errors->first('phone') : '' }}</small>
    </div>
    <div class="mb-3">
        <label class="form-label text-sm" for="{{ $formId }}-email">Email doanh nghiệp</label>
        <input class="form-control w-full !border border-solid border-grey-100 !px-3 py-2.5 rounded-lg" id="{{ $formId }}-email" name="email" type="email" autocomplete="email" maxlength="255" value="{{ $submitted ? old('email') : '' }}" placeholder="info@congty.com" aria-describedby="{{ $formId }}-email-error">
        <small id="{{ $formId }}-email-error" class="text-danger" data-error-for="email">{{ $submitted ? $errors->first('email') : '' }}</small>
    </div>
    <div class="mb-3">
        <label class="form-label text-sm" for="{{ $formId }}-message">{{ $callback ? 'Thời gian thuận tiện để gọi lại / nội dung cần tư vấn' : 'Nội dung cần tư vấn' }}</label>
        <textarea class="form-control w-full !border border-solid border-grey-100 !px-3 py-2.5 rounded-lg" id="{{ $formId }}-message" name="message" rows="2" maxlength="4000" placeholder="Ngành nghề, nhu cầu kiểm kê hoặc báo giá…" aria-describedby="{{ $formId }}-message-error">{{ $submitted ? old('message') : '' }}</textarea>
        <small id="{{ $formId }}-message-error" class="text-danger" data-error-for="message">{{ $submitted ? $errors->first('message') : '' }}</small>
    </div>
    <small class="text-danger" data-error-for="g-recaptcha-response">{{ $submitted ? $errors->first('g-recaptcha-response') : '' }}</small>
    <button class="btn-form-register-trial w-full bg-gradient-to-t from-[#273586] to-[#1D71F2] text-white font-bold !py-3 !px-4 rounded-lg !mt-3 flex items-center justify-center space-x-3" type="submit">
        <img src="{{ asset('landing/ghg-service/images/free-badge.svg') }}" alt="" width="42" height="42">
        <span class="flex flex-col items-start text-left">
            <span>{{ $callback ? 'YÊU CẦU GỌI LẠI' : 'ĐĂNG KÝ TƯ VẤN NGAY' }}</span>
            <small class="font-normal text-xs">Tư vấn miễn phí · Bảo mật thông tin</small>
        </span>
    </button>
    <p class="text-xs text-muted mt-2">Bảo Châu chỉ sử dụng thông tin để liên hệ tư vấn dịch vụ bạn yêu cầu.</p>
</form>
