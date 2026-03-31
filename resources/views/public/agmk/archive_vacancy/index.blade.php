<x-public-layout>
    @include('includes.pages-breadcrumb')
    <link rel="stylesheet" href="{{ asset('assets/public/css/vacancy.css') }}">
    <section class="vac-page-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">

                    <div class="vac-grid-wrapper">
                        @if($vacancy->count() > 0)
                            <div class="row">
                                @foreach($vacancy as $item)
                                    @php
                                        $date = \Carbon\Carbon::parse($item->created_at ?? $item->created_on);

                                        $docs = \App\Models\Docs::query()
                                            ->where('group', 'archive_data')
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
                                                    <h6 class="vac-title">{{ _t($item->title) }}</h6>
                                                    <p class="vac-desc">
                                                        {{ \Illuminate\Support\Str::limit(strip_tags(_t($item->short_content)), 100) }}
                                                    </p>
                                                </div>
                                            </a>

                                            @if($docs->isNotEmpty())
                                                <div class="vac-docs-area">
                                                    @foreach($docs as $doc)
                                                        @php
                                                            if (! _t($doc->title)) continue;

                                                            $col = function_exists('getColName') ? getColName($doc) : null;
                                                            $files = $col ? collect($doc->$col ?? []) : collect();
                                                            $media = $files->firstWhere('is_main', 1) ?? $files->first();

                                                            if ($media) {
                                                                $group = $media->category ?? $doc->group ?? 'docs';
                                                                $url   = $media->url ?? $doc->url;
                                                                $ext   = $media->ext ?? $doc->file_type;
                                                            } else {
                                                                $group = $doc->group ?? 'docs';
                                                                $url   = $doc->url;
                                                                $ext   = $doc->file_type;
                                                            }

                                                            $link = url_u(). 'docs/'.$url;
                                                        @endphp

                                                        <a href="{{ $link }}" download class="vac-doc-chip" title="{{ _t($doc->title, LANG) }}">
                                                            <i class="fa fa-{{ fileTypes($ext) }}"></i>
                                                            <span>{{ \Illuminate\Support\Str::limit(_t($doc->title), 20) }}</span>
                                                            <i class="fa fa-download download-icon"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="vac-card-footer">
                                                <div class="vac-meta">
                                                    <i class="fa fa-calendar"></i>
                                                    {{ $date->format('d.m.Y') }}
                                                    <i style="margin-left:10px" class="fa fa-eye"></i>{{ $item->views ?? 0 }}
                                                </div>

                                                <a href="{{ url('archive_vacancy/'.$item->alias) }}" class="vac-read-more">
                                                    {{ _t($p['read_more']->title ?? '') ?? 'More' }} <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        @else
                            <div class="vac-empty-state">
                                <i class="fa fa-folder-open"></i>
                                <h3>{{ _t($p['not_found_vacancy']->title ?? '') }}</h3>
                            </div>
                        @endif
                    </div>

                    <div class="pagination-main mt-4">
                        {{ $vacancy->links('vendor.pagination.custom') }}
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
</x-public-layout>
