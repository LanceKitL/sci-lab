@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-2 mt-10 w-full px-4 sm:px-0">
        
        {{-- Previous Page Link --}}
        <div class="flex-shrink-0">
            @if ($paginator->onFirstPage())
                <span class="px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-300 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed flex items-center shadow-sm">
                    <span class="mr-1">&larr;</span> <span class="hidden xs:inline">Prev</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition font-bold flex items-center shadow-sm">
                    <span class="mr-1">&larr;</span> <span class="hidden xs:inline">Prev</span>
                </a>
            @endif
        </div>

        {{-- Pagination Elements (Hidden on Mobile) --}}
        <div class="hidden sm:flex gap-1.5 flex-1 justify-center max-w-lg">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 text-gray-400 border border-transparent rounded-lg cursor-default">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="px-4 py-2 text-white bg-blue-600 border border-blue-600 rounded-lg shadow-md font-bold">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Current Page Indicator (Mobile Only) --}}
        <div class="flex sm:hidden items-center px-3 py-2 text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded-lg">
            <span class="font-medium">{{ $paginator->currentPage() }}</span>
            <span class="mx-1 text-gray-400">/</span>
            <span class="text-gray-500">{{ $paginator->lastPage() }}</span>
        </div>

        {{-- Next Page Link --}}
        <div class="flex-shrink-0">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-blue-600 transition font-bold flex items-center shadow-sm">
                    <span class="hidden xs:inline">Next</span> <span class="ml-1">&rarr;</span>
                </a>
            @else
                <span class="px-3 sm:px-4 py-2 sm:py-2.5 text-sm sm:text-base text-gray-300 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed flex items-center shadow-sm">
                    <span class="hidden xs:inline">Next</span> <span class="ml-1">&rarr;</span>
                </span>
            @endif
        </div>
    </nav>
@endif