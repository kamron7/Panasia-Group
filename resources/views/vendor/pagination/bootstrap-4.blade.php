@if ($paginator->hasPages())
    <div class="pagination">
        <ul>
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                @if(($paginator->currentPage() - 2) > 1)
                    <li class="page">
                        <a href="{{ $paginator->toArray()['first_page_url'] }}" rel="first"
                           aria-label="@lang('pagination.first')">&laquo;</a>
                    </li>
                @endif
                <li class="page">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       aria-label="@lang('pagination.previous')">&larr;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            {{--            @foreach ($elements as $element)--}}
            {{--                --}}{{-- "Three Dots" Separator --}}
            {{--                @if (is_string($element))--}}
            {{--                    <li class="page disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
            {{--                @endif--}}

            {{--                --}}{{-- Array Of Links --}}
            {{--                @if (is_array($element))--}}
            {{--                    @foreach ($element as $page => $url)--}}
            {{--                        @if ($page == $paginator->currentPage())--}}
            {{--                            <li style="background-color: #335fa9 !important; color: white"><span> {{ $page }} </span>--}}
            {{--                            </li>--}}
            {{--                        @else--}}
            {{--                            <li class="page"><a class="" href="{{ $url }}">{{ $page }}</a></li>--}}
            {{--                        @endif--}}
            {{--                    @endforeach--}}
            {{--                @endif--}}
            {{--            @endforeach--}}

            @for($i = ($paginator->currentPage() - 2) == 0 ? 1 : $paginator->currentPage() - 2 ; $i < $paginator->currentPage() and $i >= 1 ; $i++)
                {{--            @for($i = 3 - 1; $i < 3 and $i >= 1 ; $i++)--}}
                <li class="page"><a class="" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endfor

            <li style="background-color: #335fa9 !important; color: white">
                <span> {{ $paginator->currentPage() }} </span></li>

            @for($i = $paginator->currentPage() + 1; $i < $paginator->currentPage() + 3 and $i <= $paginator->lastPage() ; $i++)
                <li class="page"><a class="" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       aria-label="@lang('pagination.next')"> &rarr;</a>
                </li>
                @if(($paginator->currentPage() + 2) < $paginator->lastPage())
                    <li class="page">
                        <a href="{{ $paginator->toArray()['last_page_url'] }}" rel="last"
                           aria-label="@lang('pagination.last')">&raquo;</a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
@endif

