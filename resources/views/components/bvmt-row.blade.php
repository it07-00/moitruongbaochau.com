@props(['key', 'table', 'index', 'row' => []])
<div class="bvmt-row" data-row>
    <div class="bvmt-row-top"><strong>{{ $table['fixed'] ? 'Loại nước thải' : 'Dòng dữ liệu' }} <span data-row-number>{{ is_numeric($index) ? $index + 1 : '' }}</span></strong>@unless($table['fixed'])<button type="button" class="bvmt-delete" data-remove-row aria-label="Xóa dòng dữ liệu">Xóa dòng</button>@endunless</div>
    <div class="bvmt-grid bvmt-row-fields">
        @foreach($table['fields'] as $name => $field)
            <x-bvmt-field :name="'data['.$key.']['.$index.']['.$name.']'" :field="$field" :value="$row[$name] ?? null" :suggestions="$name === 'unit' ? 'bvmt-units' : ($key === 'fuels' && $name === 'name' ? 'bvmt-fuels' : null)" />
        @endforeach
    </div>
</div>
