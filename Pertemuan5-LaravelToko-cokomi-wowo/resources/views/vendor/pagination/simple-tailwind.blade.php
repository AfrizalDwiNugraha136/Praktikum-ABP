@if ($paginator->hasPages())
<nav class="flex items-center gap-1" aria-label="Pagination">
    @if ($paginator->onFirstPage())
        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 bg-gray-50">‹ Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-amber-50 hover:text-amber-700 transition-colors">‹ Prev</a>
    @endif

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 hover:bg-amber-50 hover:text-amber-700 transition-colors">Next ›</a>
    @else
        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 bg-gray-50">Next ›</span>
    @endif
</nav>
@endif
