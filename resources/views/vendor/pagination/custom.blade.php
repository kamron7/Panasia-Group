@if ($paginator->hasPages())
    <nav class="pagination-wrapper" aria-label="Pagination">
        <div class="pagination-content">

            <ul class="pagination-list">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="pagination-item disabled" aria-disabled="true">
                        <span class="pagination-link pagination-arrow" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </span>
                    </li>
                @else
                    <li class="pagination-item">
                        <a class="pagination-link pagination-arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </a>
                    </li>
                @endif

                {{-- First Page Link --}}
                @if ($paginator->currentPage() > 3)
                    <li class="pagination-item">
                        <a class="pagination-link" href="{{ $paginator->url(1) }}">1</a>
                    </li>
                    @if ($paginator->currentPage() > 4)
                        <li class="pagination-item dots">
                            <span class="pagination-link">...</span>
                        </li>
                    @endif
                @endif

                {{-- Pagination Elements --}}
                @php
                    $start = max($paginator->currentPage() - 1, 1);
                    $end = min($paginator->currentPage() + 1, $paginator->lastPage());

                    if ($paginator->currentPage() <= 3) {
                        $end = min(5, $paginator->lastPage());
                    }
                    if ($paginator->currentPage() >= $paginator->lastPage() - 2) {
                        $start = max($paginator->lastPage() - 4, 1);
                    }
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination-item active" aria-current="page">
                            <span class="pagination-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="pagination-item">
                            <a class="pagination-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endfor

                {{-- Last Page Link --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                        <li class="pagination-item dots">
                            <span class="pagination-link">...</span>
                        </li>
                    @endif
                    <li class="pagination-item">
                        <a class="pagination-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="pagination-item">
                        <a class="pagination-link pagination-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                    </li>
                @else
                    <li class="pagination-item disabled" aria-disabled="true">
                        <span class="pagination-link pagination-arrow" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>

            @if($paginator->lastPage() > 5)
                <form class="pagination-jump" method="GET" action="{{ url()->current() }}">
                    @foreach(request()->except('page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label for="page-input">{{p_lang('go_to')}}:</label>
                    <div class="jump-input-group">
                        <input type="number"
                               id="page-input"
                               name="page"
                               min="1"
                               max="{{ $paginator->lastPage() }}"
                               value="{{ $paginator->currentPage() }}">
                        <button type="submit" class="pagination-jump-button">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </nav>
@endif

<style>
    /* Theme Variables */
    :root {
        --pag-gold: #d3a102;
        --pag-blue: #003366;
        --pag-text: #2d3748;
        --pag-border: #e2e8f0;
        --pag-hover-bg: #fffbf0; /* Very light gold tint */
    }

    /* Base Styles */
    .pagination-wrapper {
        margin: 40px 0;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .pagination-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    /* List Styles */
    .pagination-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-item {
        margin: 0;
    }

    .pagination-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 55px;
        height: 55px;
        padding: 0 10px;
        font-size: 16px;
        font-weight: 600;
        color: var(--pag-text);
        background-color: #fff;
        border: 1px solid var(--pag-border);
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    /* Active State (Gold) */
    .pagination-item.active .pagination-link {
        color: #fff;
        background-color: var(--pag-gold);
        border-color: var(--pag-gold);
        box-shadow: 0 4px 10px rgba(211, 161, 2, 0.4);
        transform: translateY(-2px);
    }

    /* Disabled State */
    .pagination-item.disabled .pagination-link {
        color: #cbd5e0;
        background-color: #f8fafc;
        border-color: var(--pag-border);
        cursor: not-allowed;
    }

    /* Hover State */
    .pagination-item:not(.disabled):not(.active):not(.dots) .pagination-link:hover {
        border-color: var(--pag-gold);
        color: var(--pag-gold);
        background-color: #fff;
    }

    /* Dots */
    .pagination-item.dots .pagination-link {
        background: transparent;
        border: none;
        min-width: auto;
        pointer-events: none;
        color: #a0aec0;
        letter-spacing: 2px;
    }

    /* Page Jump Form */
    .pagination-jump {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        padding: 8px 15px;
        border-radius: 8px;
        border: 1px solid var(--pag-border);
    }

    .pagination-jump label {
        font-size: 14px;
        color: #718096;
        font-weight: 500;
        margin: 0;
    }

    .jump-input-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pagination-jump input {
        width: 50px;
        height: 36px;
        padding: 0 5px;
        border: 1px solid var(--pag-border);
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        color: var(--pag-blue);
        outline: none;
        transition: border-color 0.2s;
    }

    .pagination-jump input:focus {
        border-color: var(--pag-gold);
        box-shadow: 0 0 0 2px rgba(211, 161, 2, 0.1);
    }

    /* Jump Button (Blue) */
    .pagination-jump-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        padding: 0;
        background-color: var(--pag-blue);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .pagination-jump-button:hover {
        background-color: #002244; /* Darker blue */
        box-shadow: 0 2px 5px rgba(0, 51, 102, 0.3);
    }

    /* Desktop Adjustments */
    @media (min-width: 640px) {
        .pagination-content {
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }

        /* Align jump to right on desktop */
        .pagination-jump {
            margin-left: auto;
        }
    }
</style>
