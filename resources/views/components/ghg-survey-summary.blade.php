@props(['declaration'])
<div class="ghg-summary">
  @foreach(\App\Support\GhgSurveyDefinition::steps() as $step => $label)
    @if($step < 7 && isset($declaration->data[$step]))
      <details class="ghg-summary-section" @if($step === 1) open @endif>
        <summary>{{ $step }}. {{ $label }}</summary>
        @if($step === 1)
          <dl class="ghg-summary-general">
            @foreach(\App\Support\GhgSurveyDefinition::generalFields() as $key => $field)
              <div><dt>{{ $field['label'] }}</dt><dd>{{ $declaration->data[1][$key] ?? '—' }}</dd></div>
            @endforeach
          </dl>
        @else
          @foreach(\App\Support\GhgSurveyDefinition::sections($step) as $key => $section)
            <h3>{{ $section['label'] }}</h3>
            @if(empty($declaration->data[$step][$key]))
              <p>{{ match ($key) {
                'trees' => array_key_exists($key, $declaration->data[$step]) ? 'Không có cây xanh.' : 'Chưa khai báo cây xanh.',
                'equipment' => array_key_exists($key, $declaration->data[$step]) ? 'Không có thiết bị.' : 'Chưa khai báo danh sách thiết bị.',
                default => 'Không phát sinh.',
              } }}</p>
            @else
              <div class="ghg-table-scroll" tabindex="0" role="region" aria-label="{{ $section['label'] }}">
                <table><thead><tr>@foreach($section['fields'] as $field)<th>{{ $field['label'] }}</th>@endforeach</tr></thead>
                  <tbody>@foreach($declaration->data[$step][$key] as $row)<tr>@foreach($section['fields'] as $name => $field)<td>{{ $field['options'][$row[$name] ?? ''] ?? ($row[$name] ?? '—') }}</td>@endforeach</tr>@endforeach</tbody>
                </table>
              </div>
            @endif
          @endforeach
        @endif
      </details>
    @endif
  @endforeach
</div>
