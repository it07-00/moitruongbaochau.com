@props(['survey', 'editable' => false, 'admin' => false])
@php
    $definition = \App\Support\EnvironmentSurveyDefinition::class;
    $values = $survey?->data ?? [];
    $format = static function ($value, $field) {
        if ($value === null || $value === '') { return 'Chưa khai báo'; }
        if (in_array($field['type'], ['boolean', 'checkbox'])) { return $value ? 'Có' : 'Không'; }
        return $field['options'][$value] ?? $value;
    };
@endphp
<div class="bvmt-summary">
    @foreach(range(1, 6) as $number)
        <details class="bvmt-card" open>
            <summary>{{ $definition::steps()[$number] }}</summary>
            @if($editable)<button class="bvmt-button bvmt-button-small" type="submit" name="action" value="goto" form="bvmt-form" data-goto="{{ $number }}">Chỉnh sửa bước {{ $number }}</button>@endif
            <dl class="bvmt-summary-fields">
                @foreach($definition::fields($number) as $key => $field)
                    @if($definition::visible($field, $values))<div><dt>{{ $field['label'] }}</dt><dd>{{ $format($values[$key] ?? null, $field) }}</dd></div>@endif
                @endforeach
            </dl>
            @foreach($definition::tables($number) as $key => $table)
                <h4>{{ $table['label'] }}</h4>
                @php($columns = array_filter($table['fields'], fn ($field) => $definition::visible($field, $values)))
                <div class="bvmt-table-scroll"><table><thead><tr>@foreach($columns as $field)<th>{{ $field['label'] }}</th>@endforeach</tr></thead><tbody>
                    @forelse($values[$key] ?? [] as $row)<tr>@foreach($columns as $name => $field)<td data-label="{{ $field['label'] }}">{{ $format($row[$name] ?? null, $field) }}</td>@endforeach</tr>@empty<tr><td colspan="{{ count($columns) }}">Không khai báo phát sinh.</td></tr>@endforelse
                </tbody></table></div>
            @endforeach
            @if($number === 6)
                @foreach($definition::documents() as $category => $label)
                    <div class="bvmt-document-summary"><strong>{{ $label }}</strong><span>{{ ['available' => 'Có', 'not_available' => 'Không có', 'pending' => 'Đang bổ sung'][$values['documents'][$category]['status'] ?? ''] ?? 'Chưa khai báo' }}</span>
                    @if($values['documents'][$category]['note'] ?? '')<p>{{ $values['documents'][$category]['note'] }}</p>@endif
                    <ul>@foreach($survey?->files->where('category', $category) ?? [] as $file)<li><a href="{{ $admin ? route('bvmt.admin.file', ['survey' => $survey, 'file' => $file]) : route('bvmt.file', ['file' => $file]) }}">{{ $file->original_name }}</a></li>@endforeach</ul></div>
                @endforeach
            @endif
            @if($number === 4)
                @foreach(['wastewater' => 'Hồ sơ công trình nước thải', 'air' => 'Hồ sơ công trình khí thải'] as $category => $label)
                    <h4>{{ $label }}</h4><ul>@foreach($survey?->files->where('category', $category) ?? [] as $file)<li><a href="{{ $admin ? route('bvmt.admin.file', ['survey' => $survey, 'file' => $file]) : route('bvmt.file', ['file' => $file]) }}">{{ $file->original_name }}</a></li>@endforeach</ul>
                @endforeach
            @endif
        </details>
    @endforeach
    @if($values['submit_note'] ?? '')<div class="bvmt-card"><h3>Ghi chú khi gửi</h3><p>{{ $values['submit_note'] }}</p></div>@endif
</div>
