@props(['average' => null, 'count' => 0, 'large' => false])

@if (filled($average) && $count > 0)
    <div {{ $attributes->merge(['class' => 'flex items-center gap-2.5']) }}>
        <div class="flex items-center gap-1" aria-hidden="true">
            @for ($star = 1; $star <= 5; $star++)
                <svg class="fill-current {{ $star <= round((float) $average) ? 'text-amber-500' : 'text-gray-300' }} {{ $large ? 'size-5 sm:size-6' : 'size-4.5 sm:size-5' }}" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            @endfor
        </div>
        <span class="font-bold text-gray-900 {{ $large ? 'text-base sm:text-lg' : 'text-sm sm:text-base' }}">
            {{ number_format((float) $average, 1) }}/5 <span class="font-medium text-gray-700">({{ number_format((int) $count) }} bình chọn)</span>
        </span>
    </div>
@endif
