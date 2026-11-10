@if ($paginator->hasPages())
    <nav class="services-pagination mt-10 text-center" aria-label="Phân trang dịch vụ">
        @if ($paginator->count())
            <p class="mb-3 text-sm text-gray-600">Hiển thị {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} trong {{ $paginator->total() }} dịch vụ</p>
        @endif

        <div class="flex flex-wrap items-center justify-center gap-2">
            @if ($paginator->previousPageUrl())
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Trang trước">‹</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-hidden="true">{{ $element }}</span>
                @else
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <span aria-current="page" aria-label="Trang {{ $page }}">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" aria-label="Trang {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->nextPageUrl())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Trang sau">›</a>
            @endif
        </div>
    </nav>
@endif
