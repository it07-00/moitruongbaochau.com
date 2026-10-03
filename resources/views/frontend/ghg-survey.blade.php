@extends('frontend.layouts.app', ['bodyClass' => 'ghg-survey-page'])

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/ghg-survey.css') }}?v={{ hash_file('sha256', public_path('assets/css/ghg-survey.css')) }}">
@endpush
@push('scripts')
  <script src="{{ asset('assets/js/ghg-survey.js') }}?v={{ hash_file('sha256', public_path('assets/js/ghg-survey.js')) }}" defer></script>
@endpush

@section('content')
<section class="ghg-survey-shell container px-3 mx-auto">
  <header class="ghg-survey-heading">
    <a href="{{ route('declarations.greenhouse-gas-2026') }}" class="ghg-back-link mb-3 inline-block">← Khai báo kiểm kê khí nhà kính 2026</a>
    <div>
      <x-theme.badge text="PHIẾU THU THẬP DỮ LIỆU" class="mb-2 mt-2" />
    </div>
    <h1>Khai báo kiểm kê khí nhà kính</h1>
    <p>Điền dữ liệu theo từng bước. Bản nháp được lưu khi bạn bấm lưu hoặc tiếp tục; có thể mở lại trong cùng trình duyệt.</p>
  </header>

  @if($declaration?->status === 'submitted')
    <div class="ghg-card ghg-success" role="status">
      <span class="ghg-success-icon" aria-hidden="true">✓</span>
      <h2>Đã nhận phiếu khai báo của bạn</h2>
      <p>Mã phiếu: <strong>{{ $declaration->reference }}</strong></p>
      <p>Nộp lúc {{ $declaration->submitted_at->format('H:i d/m/Y') }}. Bảo Châu sẽ liên hệ qua thông tin bạn đã cung cấp.</p>
      <p>Phiếu đã nộp được khóa chỉnh sửa.</p>
    </div>
    <x-ghg-survey-summary :declaration="$declaration" />
  @else
    <div class="ghg-wizard-layout">
      <nav class="ghg-step-nav" aria-label="Các bước khai báo">
        <ol>
          @foreach($steps as $number => $label)
            <li class="{{ $number === $step ? 'is-current' : '' }} {{ isset($declaration?->data[$number]) ? 'is-complete' : '' }}">
              @if($number <= min(7, max(array_keys($declaration?->data ?? [0 => []])) + 1))
                <a href="{{ route('ghg-form.step', $number) }}" @if($number === $step) aria-current="step" @endif><span>{{ $number }}</span>{{ $label }}</a>
              @else
                <span class="ghg-step-disabled"><span>{{ $number }}</span>{{ $label }}</span>
              @endif
            </li>
          @endforeach
        </ol>
      </nav>
      <div class="ghg-form-content">
        <div class="ghg-step-heading"><span>Bước {{ $step }} / 7</span><h2>{{ $steps[$step] }}</h2></div>
        @if(!empty($guide))
          <aside class="ghg-guide-card" aria-label="Hướng dẫn điền biểu mẫu bước {{ $step }}">
            <div class="ghg-guide-header">
              <h3 class="ghg-guide-heading">💡 Hướng dẫn &amp; gợi ý nhập liệu</h3>
              <p class="ghg-guide-title">{{ $guide['title'] }}</p>
            </div>
            <p class="ghg-guide-summary">{{ $guide['summary'] }}</p>
            <ul class="ghg-guide-list">
              @foreach($guide['items'] as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
            @if(!empty($guide['example']))
              <div class="ghg-guide-example">
                <strong>Ví dụ thực tế:</strong>
                <span>{{ $guide['example'] }}</span>
              </div>
            @endif
          </aside>
        @endif
        @if(session('ghg_saved'))<p class="ghg-saved" role="status">{{ session('ghg_saved') }}</p>@endif
        @if($errors->any())
          <div class="ghg-error-summary" role="alert"><strong>Vui lòng kiểm tra lại thông tin:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            @if($step === 7)<p>Vui lòng chọn lại các tệp chưa được lưu sau khi sửa lỗi.</p>@endif
          </div>
        @endif
        <form method="post" action="{{ route('ghg-form.save', $step) }}" enctype="multipart/form-data" data-ghg-form>
          @csrf
          <div class="ghg-honeypot" aria-hidden="true"><label for="ghg-website">Website</label><input id="ghg-website" type="text" name="website" tabindex="-1" autocomplete="off"></div>
          @if($step === 1)
            <div class="ghg-card"><h3>Thông tin doanh nghiệp và người liên hệ</h3><div class="ghg-fields-grid">
              @foreach($fields as $key => $field)
                <x-ghg-survey-field :field="$field" :name="'data['.$key.']'" :value="$data[$key] ?? ''" :error-key="'data.'.$key" :id="'ghg-'.$key" />
              @endforeach
            </div></div>
          @elseif($step < 7)
            <p class="ghg-step-note">Nhập dữ liệu của năm {{ $declaration->data[1]['inventory_year'] }}. Với bảng theo tháng, giá trị 0 thể hiện không phát sinh; hãy kiểm tra đủ 12 tháng trước khi tiếp tục. Với nhiên liệu và thiết bị, không thêm dòng nếu không phát sinh.</p>
            @foreach($sections as $key => $section)
              <section class="ghg-card" data-ghg-section="{{ $key }}" @if(in_array($key, ['stationary_fuels', 'mobile_fuels'])) data-ghg-fuel-group="{{ $key === 'stationary_fuels' ? 'purpose' : 'equipment_type' }}" @endif>
                <h3 @class(['ghg-wastewater-title' => in_array($key, ['domestic_wastewater', 'industrial_wastewater'])])>{{ $section['label'] }}</h3>
                @if($key === 'fire_extinguishers')
                  <p class="ghg-field-hint">Mỗi loại bình nhập một nhóm. Số lượng tính theo bình; khối lượng mới và lượng nạp lại là tổng kg trong năm. Không phát sinh nhập 0.</p>
                @endif
                @if($key === 'equipment')
                  <p class="ghg-field-hint">Thêm từng thiết bị hoặc nhóm thiết bị có cùng thông số. Ghi công suất kèm đơn vị, năng lượng sử dụng và khu vực lắp đặt. Thông tin môi chất lạnh được khai báo riêng ở bảng Thiết bị làm lạnh bên dưới.</p>
                @endif
                @if($key === 'trees')
                  <p class="ghg-field-hint">Thêm từng nhóm cây có cùng tên, loại, tỷ lệ tăng trưởng và tuổi. Tuổi tính theo năm, số lượng tính theo cây. Nếu không có cây xanh, để bảng trống.</p>
                @endif
                @if(in_array($key, ['electricity', 'steam']))
                  <p class="ghg-field-hint">Nhập số liệu theo hóa đơn của từng tháng; tháng không phát sinh nhập 0. {{ $key === 'electricity' ? 'Đơn vị: kWh.' : 'Chọn đơn vị đúng với hóa đơn cung cấp nhiệt hơi.' }}</p>
                @endif
                @if(isset($section['fields']['treatment_type']))
                  <div class="ghg-water-picker" data-ghg-water-picker>
                    <div class="ghg-field">
                      <label for="ghg-{{ $key }}-shared-treatment">Hệ thống xử lý</label>
                      <select id="ghg-{{ $key }}-shared-treatment" data-ghg-water-treatment>
                        <option value="">— Chọn hệ thống xử lý —</option>
                        @foreach($section['fields']['treatment_type']['options'] as $option => $label)
                          <option value="{{ $option }}">{{ $label }}</option>
                        @endforeach
                      </select>
                    </div>
                    <p class="ghg-field-hint">Chọn hệ thống xử lý để tự hiện bảng 12 tháng. Hệ thống được áp dụng chung cho cả năm; tháng không phát sinh nhập 0.</p>
                  </div>
                @endif
                @if(in_array($key, ['stationary_fuels', 'mobile_fuels']))
                  <div data-ghg-fuel-picker>
                    <div class="ghg-fields-grid">
                    @foreach(['fuel_type', $key === 'stationary_fuels' ? 'purpose' : 'equipment_type', 'unit'] as $fieldName)
                      <div class="ghg-field">
                        <label for="ghg-{{ $key }}-new-{{ $fieldName }}">{{ $section['fields'][$fieldName]['label'] }}</label>
                        <select id="ghg-{{ $key }}-new-{{ $fieldName }}" data-ghg-group-field="{{ $fieldName }}">
                          <option value="">— Chọn {{ mb_strtolower($section['fields'][$fieldName]['label']) }} —</option>
                          @foreach($section['fields'][$fieldName]['options'] as $option => $label)
                            <option value="{{ $option }}">{{ $label }}</option>
                          @endforeach
                        </select>
                      </div>
                    @endforeach
                    </div>
                    <p class="ghg-field-hint">Chọn đủ nhiên liệu, {{ $key === 'stationary_fuels' ? 'mục đích sử dụng' : 'loại phương tiện' }} và đơn vị, bảng 12 tháng sẽ tự xuất hiện. Tháng không phát sinh nhập 0.</p>
                  </div>
                @endif
                <div data-ghg-rows @class(['ghg-energy-months' => in_array($key, ['electricity', 'steam'])])>
                  @foreach((array) ($data[$key] ?? []) as $index => $rowData)
                    <x-ghg-survey-row :section="$section" :key="$key" :index="$index" :row-data="is_array($rowData) ? $rowData : []" />
                  @endforeach
                </div>
                @if(isset($section['fields']['treatment_type']))
                  <template data-ghg-template><x-ghg-survey-row :section="$section" :key="$key" index="__INDEX__" /></template>
                  <button type="button" class="ghg-secondary-button" data-ghg-new-water>+ Thêm hệ thống xử lý khác</button>
                @endif
                @unless($section['monthly'])
                  <template data-ghg-template><x-ghg-survey-row :section="$section" :key="$key" index="__INDEX__" /></template>
                  @if(in_array($key, ['stationary_fuels', 'mobile_fuels']))
                    <button type="button" class="ghg-secondary-button" data-ghg-new-fuel>+ Thêm nhiên liệu khác</button>
                  @else
                    <button type="button" class="ghg-secondary-button" data-ghg-add>{{ match ($key) { 'trees' => '+ Thêm nhóm cây', 'equipment' => '+ Thêm thiết bị', default => '+ Thêm dòng dữ liệu' } }}</button>
                  @endif
                @endunless
              </section>
            @endforeach
          @else
            <div class="ghg-card"><h3>Kiểm tra dữ liệu trước khi nộp</h3><p>Mở từng phần bên dưới để kiểm tra. Bạn có thể quay lại các bước trước để chỉnh sửa.</p><x-ghg-survey-summary :declaration="$declaration" /></div>
            <div class="ghg-card">
              <h3>Chứng từ và hóa đơn</h3>
              <p>PDF, JPG, PNG, XLSX, DOCX; tối đa 10 tệp mỗi phiếu, 10MB mỗi tệp.</p>
              @if($declaration->evidence)
                <ul class="ghg-evidence-list">@foreach($declaration->evidence as $file)<li>{{ $file['name'] }} — đã lưu</li>@endforeach</ul>
              @endif
              <div class="ghg-fields-grid">
                <div class="ghg-field">
                  <label for="ghg-evidence">Tải chứng từ</label>
                  <input type="file" id="ghg-evidence" name="evidence[]" multiple accept=".pdf,.jpg,.jpeg,.png,.xlsx,.docx">
                  <p class="ghg-field-hint">Chọn tối đa 10 tệp scan/ảnh: Hóa đơn điện EVN, hóa đơn dầu DO/FO, kết quả quan trắc...</p>
                </div>
                <div class="ghg-field">
                  <label for="ghg-evidence-category">Nhóm chứng từ</label>
                  <select id="ghg-evidence-category" name="evidence_category">
                    <option value="">— Chọn nhóm chứng từ —</option>
                    @foreach($steps as $number => $label)
                      @if($number > 1 && $number < 7)
                        <option value="{{ $label }}" @selected(old('evidence_category') === $label)>{{ $label }}</option>
                      @endif
                    @endforeach
                  </select>
                  <p class="ghg-field-hint">Phân loại theo bước khai báo để kỹ sư Bảo Châu đối chiếu nhanh hơn</p>
                </div>
                <div class="ghg-field">
                  <label for="ghg-evidence-note">Ghi chú chứng từ</label>
                  <input type="text" id="ghg-evidence-note" name="evidence_note" value="{{ old('evidence_note') }}" maxlength="500" placeholder="VD: Hóa đơn tiền điện EVN 12 tháng năm 2026, hóa đơn mua dầu DO...">
                  <p class="ghg-field-hint">Mô tả tóm tắt nội dung file đính kèm (không bắt buộc)</p>
                </div>
              </div>
              <label class="ghg-confirmation"><input type="checkbox" name="confirmation" value="1" @checked(old('confirmation'))><span>Tôi xác nhận dữ liệu đã nhập là chính xác và đồng ý gửi phiếu cho Môi Trường Bảo Châu để tiếp nhận, xử lý yêu cầu kiểm kê.</span></label>
            </div>
          @endif
          <div class="ghg-form-navigation">
            @if($step > 1)<a href="{{ route('ghg-form.step', $step - 1) }}" class="ghg-back-link">← Quay lại</a>@else<span></span>@endif
            <div class="ghg-form-buttons">
              <button type="submit" name="action" value="save" class="ghg-secondary-button">Lưu nháp</button>
              <button type="submit" name="action" value="{{ $step === 7 ? 'submit' : 'next' }}" class="ghg-primary-button">{{ $step === 7 ? 'Xác nhận và nộp phiếu' : 'Lưu và tiếp tục →' }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  @endif
</section>
@endsection
