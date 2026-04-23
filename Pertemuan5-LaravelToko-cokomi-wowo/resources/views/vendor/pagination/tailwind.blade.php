@if ($paginator->hasPages())
<nav class="flex items-center gap-1" aria-label="Pagination">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 bg-gray-50">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-amber-50 hover:text-amber-700 transition-colors">‹</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="px-2 py-1.5 text-xs text-gray-400">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-3 py-1.5 rounded-lg text-xs bg-amber-500 text-white font-semibold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}"
                       class="px-3 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-amber-50 hover:text-amber-700 transition-colors">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-amber-50 hover:text-amber-700 transition-colors">›</a>
    @else
        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 bg-gray-50">›</span>
    @endif
</nav>
@endif
