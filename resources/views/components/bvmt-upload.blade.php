@props(['category', 'label', 'survey' => null])
<div class="bvmt-upload">
    <label for="upload-{{ $category }}">{{ $label }}</label>
    <p class="bvmt-hint">PDF, JPG, PNG, DOC, DOCX, XLS, XLSX · tối đa 20 MB/tệp · 10 tệp/nhóm.</p>
    <input id="upload-{{ $category }}" type="file" name="uploads[{{ $category }}][]" multiple accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" data-upload-category="{{ $category }}" data-stored-count="{{ $survey?->files->where('category', $category)->count() ?? 0 }}">
    <ul class="bvmt-file-list">
        @foreach($survey?->files->where('category', $category) ?? [] as $file)
            <li data-file><a href="{{ route('bvmt.file', ['file' => $file]) }}">{{ $file->original_name }}</a><span>{{ number_format($file->size / 1024, 1) }} KB</span><button class="bvmt-delete" type="button" data-delete-file="{{ route('bvmt.file.delete', ['file' => $file]) }}" data-category="{{ $category }}">Xóa tệp</button></li>
        @endforeach
    </ul>
</div>
