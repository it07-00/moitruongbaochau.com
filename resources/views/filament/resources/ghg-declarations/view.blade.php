<x-filament-panels::page>
  @assets
    <link rel="stylesheet" href="{{ asset('assets/css/ghg-survey.css') }}?v={{ filemtime(public_path('assets/css/ghg-survey.css')) }}">
  @endassets
  <div class="ghg-card ghg-admin-detail">
    <h3>{{ $this->record->company_name }}</h3>
    <p>Mã phiếu: {{ $this->record->reference }} — {{ $this->record->status === 'submitted' ? 'Đã nộp' : 'Bản nháp' }}</p>
    @if($this->record->submitted_at)<p>Nộp lúc {{ $this->record->submitted_at->format('H:i d/m/Y') }}</p>@endif
    <x-ghg-survey-summary :declaration="$this->record" />
    <h3>Chứng từ đính kèm</h3>
    <ul class="ghg-evidence-list">
      @forelse($this->record->evidence ?? [] as $index => $file)
        <li><a class="ghg-back-link" href="{{ route('ghg-form.evidence', ['declaration' => $this->record, 'evidence' => $index]) }}">{{ $file['name'] }}</a> — {{ $file['category'] }} @if($file['note']) — {{ $file['note'] }} @endif</li>
      @empty
        <li>Chưa có chứng từ.</li>
      @endforelse
    </ul>
  </div>
</x-filament-panels::page>
