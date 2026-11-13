@props([
    'model' => null,
    'type' => 'post',
    'key' => null,
    'hint' => null,
])

@php
    $resolvedKey = trim((string) ($key ?? $model?->resource_password ?? ''));
    $resolvedLabel = trim((string) ($hint ?? $model?->resource_password_hint ?? '')) ?: 'Key / Mật khẩu:';
@endphp

@if($resolvedKey !== '')
    <div
        data-resource-key-bar
        class="mt-8 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 px-4 py-3 text-sm text-left"
    >
        <div class="flex flex-wrap items-center gap-2 text-slate-700">
            <span class="font-medium text-emerald-900">{{ $resolvedLabel }}</span>
            <code class="rounded-md border border-emerald-200 bg-white px-2.5 py-1 font-mono text-sm font-semibold text-emerald-800 select-all">{{ $resolvedKey }}</code>
        </div>

        <button
            type="button"
            onclick="const btn = this; const text = @js($resolvedKey); if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(text).then(() => { const label = btn.querySelector('[data-copy-label]'); if (label) { label.textContent = 'Đã sao chép'; setTimeout(() => { label.textContent = 'Sao chép'; }, 2000); } }); }"
            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-emerald-300 bg-white px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100"
        >
            <span data-copy-label>Sao chép</span>
        </button>
    </div>
@endif
