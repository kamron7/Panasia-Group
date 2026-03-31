<x-public-layout>
    @include('includes.pages-breadcrumb')
    <link rel="stylesheet" href="{{ asset('assets/public/css/vacancy.css') }}">
    <section class="vac-page-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">

                    <div class="vac-filter-card">

                        <form action="{{ route('vacancy.index') }}" method="GET">
                            <div class="vac-filter-grid">

                                <div class="form-group vi-nopart">
                                    <label class="vac-label">{{ _t($p['vir_region']->title ?? '') }}</label>
                                    <div class="vac-select-wrapper">
                                        <select id="region_id" name="region_id" class="vac-select vi-nopart">
                                            <option value="" class="vi-nopart">{{ _t($p['vir_select']->title ?? '') }}</option>
                                            @foreach($region as $item)
                                                <option
                                                    value="{{ $item->old_id }}"
                                                    class="vi-nopart"
                                                    {{ request('region_id') == $item->old_id ? 'selected' : '' }}
                                                >
                                                    {{ _t($item->title) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-angle-down vac-arrow"></i>
                                    </div>
                                </div>

                                {{-- City (city.cat_id = region.old_id) --}}
                                <div class="form-group vi-nopart">
                                    <label class="vac-label">{{ _t($p['vir_city']->title ?? '') }}</label>
                                    <div class="vac-select-wrapper">
                                        <select id="city_id" name="city_id" class="vac-select vi-nopart">
                                            <option value="" class="vi-nopart">{{ _t($p['vir_select']->title ?? '') }}</option>
                                            @foreach($city as $item)
                                                <option
                                                    value="{{ $item->old_id }}"
                                                    class="hidden vi-nopart"
                                                    data-region_id="{{ $item->cat_id }}"
                                                    {{ request('city_id') == $item->old_id ? 'selected' : '' }}
                                                >
                                                    {{ _t($item->title) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-angle-down vac-arrow"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="vac-label">{{ _t($p['vir_structural']->title ?? '') }}</label>
                                    <div class="vac-select-wrapper">
                                        <select id="structural" name="cat_id2" class="vac-select">
                                            <option value="" class="vi-nopart">{{ _t($p['vir_select']->title ?? '') }}</option>
                                            @foreach($structural as $item)
                                                <option
                                                    value="{{ $item->id }}"
                                                    {{ request('cat_id2') == $item->id ? 'selected' : '' }}
                                                >
                                                    {{ _t($item->title) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-angle-down vac-arrow"></i>
                                    </div>
                                </div>

                                {{-- Vacancy category (vacancy.cat_id) --}}
                                <div class="form-group">
                                    <label class="vac-label">{{ _t($p['Occupation']->title ?? '') }}</label>
                                    <div class="vac-select-wrapper">
                                        <select id="vacancy" name="cat_id" class="vac-select">
                                            <option value="" class="vi-nopart">{{ _t($p['vir_select']->title ?? '') }}</option>
                                            @foreach($vacancy_category as $item)
                                                <option
                                                    value="{{ $item->id }}"
                                                    class="hidden vi-nopart"
                                                    {{ request('cat_id') == $item->id ? 'selected' : '' }}
                                                >
                                                    {{ _t($item->title) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa fa-angle-down vac-arrow"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="vac-filter-actions">
                                <div class="left-actions">
                                    <a href="{{ url('archive_vacancy') }}" class="vac-btn-outline">
                                        <i class="fa fa-archive"></i> {{ _t($p['archive_vacancy']->title ?? '') }}
                                    </a>
                                </div>
                                <div class="right-actions">
                                    <a href="{{ route('vacancy.index') }}" class="vac-btn-reset">
                                        <i class="fa fa-refresh"></i> {{ _t($p['reset']->title ?? '') ?? 'Reset' }}
                                    </a>

                                    <button class="vac-btn-search" type="submit">
                                        <i class="fa fa-search"></i> {{ _t($p['search']->title ?? '') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="col-md-12 mb-4 p-0">
                        <h2 class="vac-section-title">
                            {{ _t(getPosts(6296, 'title')) }}
                        </h2>
                    </div>

                    <div class="vac-grid-wrapper">
                        @if(isset($news) && $news->count() > 0)
                            <div class="row">
                                @foreach($news as $item)
                                    @php
                                        $news_date = \Carbon\Carbon::parse($item->created_at ?? $item->created_on);
                                        // Retrieve docs logic preserved
                                        $docs = \App\Models\Docs::query()
                                            ->where('group', 'docs')
                                            ->where('cat_id', $item->id)
                                            ->where('status', true)
                                            ->orderBy('created_at', 'desc')
                                            ->limit(500)
                                            ->get();
                                    @endphp

                                    <div class="col-lg-6 col-md-6 mb-4">
                                        <div class="vac-card">
                                            <a href="{{ url('vacancy/'.$item->alias) }}" class="vac-card-link">
                                                <div class="vac-card-body">
                                                    <h6 class="vac-title">{{ _t($item->title, LANG) }}</h6>
                                                    <p class="vac-desc">{{ \Illuminate\Support\Str::limit(strip_tags(_t($item->short_content, LANG)), 100) }}</p>
                                                </div>
                                            </a>

                                            @if($docs->isNotEmpty())
                                                <div class="vac-docs-area">
                                                    @foreach($docs as $doc)
                                                        @php
                                                            if (! _t($doc->title, LANG)) continue;
                                                            $col   = function_exists('getColName') ? getColName($doc) : null;
                                                            $files = $col ? collect($doc->$col ?? []) : collect();
                                                            $media = $files->firstWhere('is_main', 1) ?? $files->first();
                                                            if ($media) {
                                                                $group     = $media->category ?? ($doc->group ?? 'docs');
                                                                $url       = $media->url ?? $doc->url;
                                                                $file_type = $media->ext ?? $doc->file_type;
                                                            } else {
                                                                $group     = $doc->group ?? 'docs';
                                                                $url       = $doc->url;
                                                                $file_type = $doc->file_type;
                                                            }
                                                            $link =  url_u(). 'docs/'.$url;
                                                        @endphp

                                                        <a href="{{ $link }}" class="vac-doc-chip" download title="{{ _t($doc->title) }}">
                                                            <i class="fa fa-{{ fileTypes($file_type) }}"></i>
                                                            <span>{{ \Illuminate\Support\Str::limit(_t($doc->title), 20) }}</span>
                                                            <i class="fa fa-download download-icon"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="vac-card-footer">
                                                <div class="vac-meta">
                                                    <i class="fa fa-calendar"></i>
                                                    {{ $news_date->format('d.m.Y') }}

                                                    <i style="margin-left: 10px" class="fa fa-eye"></i> {{ $item->views ?? 0 }}
                                                </div>
                                                <a href="{{ url('vacancy/'.$item->alias) }}" class="vac-read-more">
                                                    {{ _t($p['read_more']->title ?? '') ?? 'More' }} <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="vac-empty-state">
                                <i class="fa fa-search"></i>
                                <h3>{{ _t($p['not_found_vacancy']->title ?? '') }}</h3>
                            </div>
                        @endif
                    </div>

                    <div class="pagination-main mt-4">
                        @if(isset($news) && $news instanceof \Illuminate\Contracts\Pagination\Paginator)
                            {{ $news->appends(request()->query())->links('vendor.pagination.custom') }}
                        @endif
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="vac-sidebar-sticky">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            // Comes from controller: structuralId -> [vacancyCatId...]
            const structVacMap = @json($structVacMap ?? []);

            function filterCities() {
                const region = $('#region_id').val();

                $('#city_id option').each(function () {
                    const $opt  = $(this);
                    const regId = $opt.data('region_id');

                    // skip placeholder (it has no data-region_id)
                    if (typeof regId === 'undefined') {
                        $opt.show(); // always show the "select" option
                        return;
                    }

                    if (region && String(region) === String(regId)) {
                        $opt.show();
                    } else {
                        if ($opt.is(':selected')) {
                            $opt.prop('selected', false);
                        }
                        $opt.hide();
                    }
                });
            }

            function filterVacancies() {
                const structural = $('#structural').val();
                let allowed = [];

                if (structural && structVacMap[structural]) {
                    allowed = structVacMap[structural].map(String);
                }

                $('#vacancy option').each(function () {
                    const $opt = $(this);
                    const vId  = $opt.val();

                    // always keep the first placeholder visible
                    if (!vId) {
                        $opt.show();
                        return;
                    }

                    // if no structural chosen → hide all real options
                    if (!structural) {
                        if ($opt.is(':selected')) {
                            $opt.prop('selected', false);
                        }
                        $opt.hide();
                        return;
                    }

                    // show only vacancy categories that belong to this structural
                    if (allowed.includes(String(vId))) {
                        $opt.show();
                    } else {
                        if ($opt.is(':selected')) {
                            $opt.prop('selected', false);
                        }
                        $opt.hide();
                    }
                });
            }

            $('#region_id').on('change', filterCities);
            $('#structural').on('change', filterVacancies);

            // initial state for preselected filters
            filterCities();
            filterVacancies();
        });
    </script>

</x-public-layout>
