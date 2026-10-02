@props(['section', 'key', 'index', 'rowData' => []])
<fieldset class="ghg-data-row" data-ghg-row>
  <legend>{{ $section['monthly'] ? 'Tháng '.($rowData['month'] ?? ((int) $index + 1)) : 'Dòng dữ liệu' }}</legend>
  <div class="ghg-fields-grid">
    @foreach($section['fields'] as $name => $field)
      @if($name === 'month' && $section['monthly'])
        <input type="hidden" name="data[{{ $key }}][{{ $index }}][month]" value="{{ $rowData['month'] ?? ((int) $index + 1) }}">
      @else
        <x-ghg-survey-field :field="$field" :name="'data['.$key.']['.$index.']['.$name.']'" :value="$rowData[$name] ?? ''" :error-key="'data.'.$key.'.'.$index.'.'.$name" :id="'ghg-'.$key.'-'.$index.'-'.$name" />
      @endif
    @endforeach
  </div>
  @unless($section['monthly'])<button type="button" class="ghg-remove-row" data-ghg-remove>Xóa dòng này</button>@endunless
</fieldset>
