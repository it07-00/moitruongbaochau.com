<x-filament-panels::page>
    @assets
        <link rel="stylesheet" href="{{ asset('assets/css/bvmt-survey.css') }}?v={{ filemtime(public_path('assets/css/bvmt-survey.css')) }}">
    @endassets
    @php
        $survey = $this->record->loadMissing('files');
        $service = app(\App\Services\EnvironmentSurveyService::class);
        $completed = $service->completedSteps($survey);
        $missing = $service->missingDocuments($survey);
    @endphp
    <div class="bvmt-admin">
        <div class="bvmt-card"><h3>{{ $survey->company_name ?: 'Doanh nghiệp chưa khai báo' }}</h3><p>Mã phiếu: {{ $survey->reference }} · {{ \App\Support\EnvironmentSurveyDefinition::statuses()[$survey->status] }}</p><p>Tiến độ dữ liệu: {{ round(count($completed) / 6 * 100) }}% · {{ count($survey->files) }} tệp đính kèm</p><p>Ngày gửi: {{ $survey->submitted_at?->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') ?? 'Chưa gửi' }}</p><p>Link biểu mẫu: <a href="{{ route('bvmt.index') }}" style="overflow-wrap:anywhere">{{ route('bvmt.index') }}</a></p></div>
        <div class="bvmt-card"><h3>Hồ sơ chưa đính kèm</h3><ul>@forelse($missing as $label)<li>{{ $label }}</li>@empty<li>Đã đính kèm đầy đủ các nhóm hồ sơ.</li>@endforelse</ul></div>
        <x-bvmt-summary :survey="$survey" :admin="true" />
        <div class="bvmt-card"><h3>Lịch sử gửi và chỉnh sửa</h3><div class="bvmt-table-scroll"><table><thead><tr><th>Thời gian</th><th>Thao tác</th><th>Trạng thái</th><th>Ghi chú</th></tr></thead><tbody>@foreach(array_reverse($survey->history ?? []) as $event)<tr><td>{{ \Illuminate\Support\Carbon::parse($event['at'])->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</td><td>{{ ['save' => 'Lưu nháp', 'next' => 'Chuyển bước', 'back' => 'Quay lại', 'goto' => 'Chuyển mục', 'submit' => 'Gửi phiếu', 'created' => 'Tạo phiếu', 'status' => 'Cập nhật trạng thái', 'delete_file' => 'Xóa tệp'][$event['action']] ?? $event['action'] }} @if(isset($event['step'])) — Bước {{ $event['step'] }} @endif</td><td>{{ \App\Support\EnvironmentSurveyDefinition::statuses()[$event['status'] ?? ''] ?? '' }}</td><td>{{ $event['note'] ?? '' }}</td></tr>@endforeach</tbody></table></div></div>
    </div>
</x-filament-panels::page>
