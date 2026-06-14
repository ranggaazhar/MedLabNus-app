@if ($paginator->hasPages())
    <div class="flex flex-col md:flex-row justify-between items-center w-full py-3">
        
        {{-- Show Result Info --}}
        <div class="text-gray-500 text-sm font-medium py-2">
            @if($paginator->total() > 0)
                <span class="text-sm tracking-wide">
                    Showing 
                    <span class="font-bold text-gray-700">{{ $paginator->firstItem() }}</span>
                    -
                    <span class="font-bold text-gray-700">{{ $paginator->lastItem() }}</span> 
                    of 
                    <span class="font-bold text-gray-700">{{ $paginator->total() }}</span> 
                    results
                </span>
            @else
                <span class="text-sm tracking-wide text-gray-400">0 results found</span>
            @endif
        </div>

        {{-- Pagination Buttons --}}
        <div class="flex items-center gap-2 mb-4 md:mb-0">
            
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 opacity-30 cursor-not-allowed border-gray-200 bg-gray-50 text-sm shadow-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm border-gray-300 bg-white hover:bg-gray-50 hover:border-red-700 hover:text-red-700"
                   title="Previous"
                   rel="prev">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-10 h-10 flex items-center justify-center border rounded-lg text-gray-400 border-gray-200 bg-white text-sm shadow-sm cursor-default">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 flex items-center justify-center border rounded-lg font-bold transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm bg-red-700 text-white border-red-700 scale-110 z-10">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="w-10 h-10 flex items-center justify-center border rounded-lg font-bold transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm bg-white border-gray-300 text-gray-600 hover:bg-gray-50 hover:border-red-700 hover:text-red-700">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 transition-all duration-300 hover:scale-110 active:scale-95 text-sm shadow-sm border-gray-300 bg-white hover:bg-gray-50 hover:border-red-700 hover:text-red-700"
                   title="Next"
                   rel="next">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center border rounded-lg text-gray-600 opacity-30 cursor-not-allowed border-gray-200 bg-gray-50 text-sm shadow-sm">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </span>
            @endif
        </div>
    </div>
@endif
