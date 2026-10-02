@props(['field', 'name', 'value' => '', 'errorKey', 'id'])
@php($value = is_scalar($value) ? $value : '')
<div class="ghg-field">
  <label for="{{ $id }}">{{ $field['label'] }} @if($field['required'])<span aria-hidden="true">*</span>@endif</label>
  @if($field['type'] === 'select')
    <select id="{{ $id }}" name="{{ $name }}" @required($field['required']) @if($errors->has($errorKey)) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif>
      <option value="">— Chọn —</option>
      @foreach($field['options'] as $option => $label)
        <option value="{{ $option }}" @selected((string) $value === (string) $option)>{{ $label }}</option>
      @endforeach
    </select>
  @else
    <input id="{{ $id }}" name="{{ $name }}" value="{{ is_scalar($value) ? $value : '' }}" type="{{ $field['type'] === 'decimal' ? 'number' : $field['type'] }}" @required($field['required'])
      @if(in_array($field['type'], ['number', 'decimal'])) min="{{ $field['min'] }}" max="{{ $field['max'] }}" step="{{ $field['type'] === 'decimal' ? 'any' : '1' }}" @else maxlength="255" @endif
      @if($errors->has($errorKey)) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif>
  @endif
  @error($errorKey)<p id="{{ $id }}-error" class="ghg-error">{{ $message }}</p>@enderror
</div>
