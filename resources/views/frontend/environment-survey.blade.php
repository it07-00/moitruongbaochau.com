@extends('frontend.layouts.app', ['bodyClass' => 'bvmt-survey-page'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/bvmt-survey.css') }}?v={{ filemtime(public_path('assets/css/bvmt-survey.css')) }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/js/bvmt-survey.js') }}?v={{ filemtime(public_path('assets/js/bvmt-survey.js')) }}" defer></script>
@endpush
@section('content')
@php($definition = \App\Support\EnvironmentSurveyDefinition::class)
<section class="bvmt-shell" data-has-report="{{ (int) ($data['has_environment_report_2025'] ?? false) }}">
    <header class="bvmt-heading">
        <x-theme.badge text="PHIẾU KHẢO SÁT THÔNG TIN" />
        <h1>Báo cáo công tác<br>bảo vệ môi trường <span>2026</span></h1>
        <p>Cung cấp thông tin, số liệu và hồ sơ của doanh nghiệp. Dữ liệu được lưu khi chuyển bước; bạn có thể lưu nháp để tiếp tục sau.</p>
    </header>
    @if($survey && ! $survey->isEditable())
        <div class="bvmt-notice bvmt-success" role="status"><h2>Đã nhận phiếu khảo sát của bạn</h2><p>Mã phiếu: <strong>{{ $survey->reference }}</strong> · {{ $definition::statuses()[$survey->status] }}</p><p>Gửi lúc {{ $survey->submitted_at?->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}. Phiếu đã khóa chỉnh sửa; Bảo Châu sẽ liên hệ theo thông tin đã cung cấp.</p></div>
        <x-bvmt-summary :survey="$survey" />
    @else
        @if($survey?->status === 'revision_required')<div class="bvmt-notice"><strong>Phiếu được mở lại để bổ sung.</strong><p>{{ collect($survey->history)->where('action', 'status')->where('status', 'revision_required')->last()['note'] ?? 'Vui lòng rà soát và gửi lại phiếu sau khi cập nhật.' }}</p></div>@endif
        @if(session('bvmt_saved'))<div class="bvmt-notice bvmt-success" role="status">{{ session('bvmt_saved') }}</div>@endif
        @if($errors->any())<div class="bvmt-notice bvmt-errors" role="alert" tabindex="-1"><strong>Vui lòng kiểm tra thông tin:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul><p>Nội dung nhập đã được giữ lại. Các tệp chưa lưu cần chọn lại.</p></div>@endif
        @if($survey)
            <div class="bvmt-resume"><strong>Link riêng của doanh nghiệp</strong><p>Lưu link này để tiếp tục trên thiết bị khác. Chỉ chia sẻ với người phụ trách hồ sơ.</p><div><input aria-label="Link tiếp tục khảo sát" readonly value="{{ route('bvmt.show', ['survey' => $survey->token]) }}"><button type="button" class="bvmt-button" data-copy-link>Sao chép link</button></div></div>
        @endif
        <form id="bvmt-form" method="post" action="{{ $survey ? route('bvmt.save', ['survey' => $survey->token, 'step' => $step]) : route('bvmt.start') }}" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="target_step" id="bvmt-target-step" value="{{ $step }}">
            <div class="bvmt-honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
            <div class="bvmt-layout">
                <aside class="bvmt-sidebar">
                    <div class="bvmt-progress-label"><strong>Tiến độ hoàn thành</strong><span>{{ round(count($completed) / 6 * 100) }}%</span></div>
                    <progress max="6" value="{{ count($completed) }}" aria-label="Tiến độ hoàn thành"></progress>
                    <nav aria-label="Các bước khảo sát"><ol>@foreach($definition::steps() as $number => $label)
                        <li><button type="submit" name="action" value="goto" data-goto="{{ $number }}" aria-label="Bước {{ $number }}: {{ $label }}" @class(['bvmt-step', 'is-current' => $step === $number, 'is-complete' => in_array($number, $completed)]) @if($step === $number) aria-current="step" @endif><span>{{ in_array($number, $completed) ? '✓' : $number }}</span><strong>{{ $label }}</strong></button></li>
                    @endforeach</ol></nav>
                    <p class="bvmt-hint">Dấu <b class="bvmt-required">*</b> là thông tin cần có trước khi gửi. Có thể lưu nháp khi chưa điền đủ.</p>
                </aside>
                <div class="bvmt-main">
                    <div class="bvmt-step-heading"><span>BƯỚC {{ $step }} / 7</span><h2>{{ $definition::steps()[$step] }}</h2></div>
                    @if(in_array($step, [2,3,4,5]) && ($data['has_environment_report_2025'] ?? false))<div class="bvmt-notice">Số liệu năm 2025 được lấy từ báo cáo đã cung cấp. Bạn chỉ cần nhập số liệu năm 2026.</div>@endif
                    @if($definition::fields($step) && $step !== 7)
                        <section class="bvmt-card"><div class="bvmt-grid">
                            @foreach($definition::fields($step) as $key => $field)<x-bvmt-field :name="'data['.$key.']'" :field="$field" :value="$data[$key] ?? null" />@endforeach
                        </div>
                        @if($step === 1)<div data-condition="report"><x-bvmt-upload category="environment_report_2025" label="Tải Báo cáo công tác BVMT năm 2025 *" :survey="$survey" /><p class="bvmt-hint">Có báo cáo 2025: không cần nhập lại số liệu năm 2025 ở các bước sau.</p></div>@endif
                        @if($step === 4)
                            <div data-condition="wastewater"><x-bvmt-upload category="wastewater" label="Thuyết minh, sơ đồ, hình ảnh công trình nước thải" :survey="$survey" /></div>
                            <div data-condition="air"><x-bvmt-upload category="air" label="Thuyết minh, sơ đồ, hình ảnh công trình khí thải" :survey="$survey" /></div>
                        @endif
                        </section>
                    @endif
                    @foreach($definition::tables($step) as $key => $table)
                        <section class="bvmt-card" data-table="{{ $key }}"><div class="bvmt-card-heading"><h3>{{ $table['label'] }}</h3>@unless($table['fixed'])<button type="button" class="bvmt-button" data-add-row>+ Thêm dòng</button>@endunless</div>
                            <p class="bvmt-hint">{{ $table['fixed'] ? 'Ghi theo giấy phép và số liệu thực tế. Chưa có số liệu có thể để trống lưu nháp.' : 'Thêm từng loại phát sinh. Nếu không có hoạt động hoặc không phát sinh, để bảng trống. Số liệu cho phép số thập phân, không âm.' }}</p>
                            @if($key === 'fuels')<p class="bvmt-hint">Gợi ý: Điện, Dầu DO, Dầu FO, LPG, Xăng, Than, Biomass, Khí tự nhiên.</p>@endif
                            <div data-rows>@foreach($data[$key] ?? [] as $index => $row)<x-bvmt-row :key="$key" :table="$table" :index="$index" :row="$row" />@endforeach</div>
                            @unless($table['fixed'])<p class="bvmt-empty" data-empty @if(count($data[$key] ?? [])) hidden @endif>Chưa có dòng dữ liệu. Bấm “+ Thêm dòng” để khai báo.</p><template data-row-template><x-bvmt-row :key="$key" :table="$table" index="__INDEX__" /></template>@endunless
                        </section>
                    @endforeach
                    @if($step === 6)
                        <div class="bvmt-notice">Chọn trạng thái cho từng nhóm. Chọn “Có” cần tải ít nhất một tệp. Chọn “Không có” hoặc “Đang bổ sung” nếu hồ sơ chưa sẵn có. Mỗi lần lưu chọn tối đa 20 tệp trên toàn form.</div>
                        @foreach($definition::documents() as $category => $label)
                            <section class="bvmt-card bvmt-document" data-document="{{ $category }}"><h3>{{ $label }}</h3>
                                @if($category === 'environment_report_2025' && ($data['has_environment_report_2025'] ?? false) && $survey?->files->where('category', $category)->count())<p class="bvmt-provided">✓ Đã cung cấp ở bước 1. Không cần tải lại.</p>@endif
                                <div class="bvmt-grid"><x-bvmt-field :name="'data[documents]['.$category.'][status]'" :field="['label' => 'Trạng thái hồ sơ', 'type' => 'select', 'required' => true, 'condition' => '', 'max' => 255, 'options' => ['available' => 'Có', 'not_available' => 'Không có', 'pending' => 'Đang bổ sung']]" :value="$data['documents'][$category]['status'] ?? null" />
                                <x-bvmt-field :name="'data[documents]['.$category.'][note]'" :field="['label' => 'Ghi chú', 'type' => 'textarea', 'required' => false, 'condition' => '', 'max' => 2000, 'options' => []]" :value="$data['documents'][$category]['note'] ?? null" /></div>
                                <x-bvmt-upload :category="$category" label="Tệp hồ sơ" :survey="$survey" />
                            </section>
                        @endforeach
                    @endif
                    @if($step === 7)
                        <div class="bvmt-notice">Kiểm tra các mục bên dưới trước khi gửi. Các bước chưa hoàn thành cần được bổ sung; có thể quay lại chỉnh sửa bất kỳ mục nào.</div>
                        <x-bvmt-summary :survey="$survey" :editable="true" />
                        <section class="bvmt-card"><h3>Hồ sơ chưa đính kèm</h3><p class="bvmt-hint">Hồ sơ không áp dụng có thể chọn “Không có”. Danh sách này giúp Bảo Châu theo dõi việc bổ sung.</p><ul>@forelse($missing as $label)<li>{{ $label }}</li>@empty<li>Đã đính kèm đầy đủ các nhóm hồ sơ.</li>@endforelse</ul></section>
                        <section class="bvmt-card">@foreach($definition::fields(7) as $key => $field)<x-bvmt-field :name="'data['.$key.']'" :field="$field" :value="$data[$key] ?? null" />@endforeach</section>
                    @endif
                    <div class="bvmt-actions">
                        @if($step > 1)<button type="submit" name="action" value="back" class="bvmt-button">← Quay lại</button>@endif
                        <button type="submit" name="action" value="save" class="bvmt-button">Lưu nháp</button>
                        <button type="submit" name="action" value="{{ $step === 7 ? 'submit' : 'next' }}" class="bvmt-button bvmt-primary">{{ $step === 7 ? 'Gửi phiếu khảo sát' : 'Lưu & tiếp tục →' }}</button>
                    </div>
                    <p class="bvmt-hint" id="bvmt-client-status" role="status" aria-live="polite"></p>
                </div>
            </div>
        </form>
        <datalist id="bvmt-units">@foreach(['Tấn','kg','m³','lít','cái','bộ','sản phẩm','kWh','m³/ngày'] as $unit)<option value="{{ $unit }}">@endforeach</datalist>
        <datalist id="bvmt-fuels">@foreach(['Điện','Dầu DO','Dầu FO','LPG','Xăng','Than','Biomass','Khí tự nhiên','Khác'] as $fuel)<option value="{{ $fuel }}">@endforeach</datalist>
    @endif
</section>
@endsection
