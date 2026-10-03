@props(['name', 'field', 'value' => null, 'suggestions' => null])
@php
    $id = 'bvmt-'.substr(md5($name), 0, 12);
    $type = $field['type'];
    $placeholder = $field['placeholder'] ?? 'Nhập ghi chú hoặc thông tin bổ sung…';
    if ($type === 'boolean' && is_bool($value)) { $value = $value ? '1' : '0'; }
@endphp
<div class="bvmt-field" @if($field['condition']) data-condition="{{ $field['condition'] }}" @endif>
    @if($type === 'checkbox')
        <input type="hidden" name="{{ $name }}" value="0">
        <label class="bvmt-check" for="{{ $id }}"><input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="1" @checked($value)> <span>{{ $field['label'] }} <b class="bvmt-required">*</b></span></label>
    @else
        <label for="{{ $id }}">{{ $field['label'] }} @if($field['required'])<b class="bvmt-required">*</b>@endif</label>
        @if($type === 'textarea')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="3" maxlength="{{ $field['max'] }}" placeholder="{{ $placeholder }}">{{ $value }}</textarea>
        @elseif(in_array($type, ['select', 'month', 'boolean']))
            @if($type === 'boolean')
                <div class="bvmt-radios" role="group" aria-labelledby="{{ $id }}-label">
                    <span id="{{ $id }}-label" class="bvmt-sr-only">{{ $field['label'] }}</span>
                    @foreach($field['options'] as $option => $label)
                        <label><input id="{{ $id }}-{{ $option }}" type="radio" name="{{ $name }}" value="{{ $option }}" @checked($value !== null && $value !== '' && (string) $value === (string) $option)> {{ $label }}</label>
                    @endforeach
                </div>
            @else
                <select id="{{ $id }}" name="{{ $name }}">
                    <option value="">Chọn {{ mb_strtolower($field['label']) }}</option>
                    @foreach($type === 'month' ? array_combine(range(1,12), range(1,12)) : $field['options'] as $option => $label)
                        <option value="{{ $option }}" @selected((string) $value === (string) $option)>{{ $type === 'month' ? 'Tháng '.$label : $label }}</option>
                    @endforeach
                </select>
            @endif
        @else
            <input id="{{ $id }}" type="{{ in_array($type, ['integer', 'decimal']) ? 'number' : $type }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" @if(in_array($type, ['integer', 'decimal'])) min="0" max="{{ $type === 'integer' ? '1000000000' : '1000000000000' }}" step="{{ $type === 'integer' ? '1' : 'any' }}" inputmode="decimal" @else maxlength="{{ $field['max'] }}" @endif @if($suggestions) list="{{ $suggestions }}" @endif>
        @endif
    @endif
</div>
