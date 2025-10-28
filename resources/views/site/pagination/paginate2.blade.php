
@if ($paginator->hasPages())

    <div
        class="pagination pagination-primary lg:pagination-center pagination-center pagination-circle pagination-xl w-full mt-48p">

        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item pagination-prev">
                <i class="ti ti-chevron-left"></i>
            </a>
        @endif


        <div class="pagination-list">

            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a href="#" class="pagination-item pagination-circle active">
                                <span class="pagination-link">{{ $page }}</span>
                            </a>
                        @else
                            <a href="{{ $url }}" class="pagination-item pagination-circle">
                                <span class="pagination-link">{{ $page }}</span>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item pagination-next">
                    <i class="ti ti-chevron-right"></i>
                </a>
            @endif

    </div>
@endif

