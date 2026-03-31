<x-public-layout>
    @include('includes.pages-breadcrumb')

    <section class="news-inner section">
        <div class="container">
            <div class="news-inner__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="news-inner__main">
                            <div class="row">

                                @foreach ($analitik as $item)
                                    @php
                                        $news_date = date_parse($item->created_at ?? '');
                                        $docs = $docsByPost[$item->id] ?? collect();
                                    @endphp

                                    <div class="col-lg-12 mb-3">
                                        <div class="news-inner__item news_doc1 custom-card-wrapper">

                                            <a href="{{ url($item->group . '/' . $item->alias) }}"
                                               class="card-content-link">
                                                <div class="news-inner__item__info">
                                                    <h6>{{ _t($item->title) }}</h6>
                                                    <p>{!! _t($item->short_content) !!}</p>
                                                </div>
                                            </a>

                                            @if(isset($docs) && $docs->isNotEmpty())
                                                <div class="card-footer-actions">
                                                    @foreach($docs as $doc)
                                                        @php
                                                            $docTitle = _t($doc->title ?? null);
                                                            if (!$docTitle) { continue; }

                                                            $group = $doc->group ?? 'docs';

                                                            $col   = getColName($doc);
                                                            $files = $col ? collect($doc->$col ?? []) : collect();

                                                            $media = $files->firstWhere('is_main', 1) ?? $files->first();

                                                            $fileName = getImgMain($doc);

                                                            if (empty($fileName) && $media) {
                                                                $fileName = $media->url ?? null;
                                                            }

                                                            if (empty($fileName)) {
                                                                $fileName = $doc->url ?? null;
                                                            }

                                                            $isFile = !empty($fileName);


                                                            if ($isFile) {

                                                                $href = url_u()  . 'docs/' . ltrim($fileName, '/');
                                                            } else {
                                                                $href = url_p() . '/menu/' . ($doc->alias ?? '');
                                                            }

                                                            $ext = strtolower($media->ext ?? pathinfo($fileName, PATHINFO_EXTENSION));
                                                            $fileTypeClass = function_exists('fileTypes') ? fileTypes($ext) : $ext;
                                                        @endphp

                                                        <a href="{{ $href }}"
                                                           class="dl-btn-minimal"
                                                           target="_blank"
                                                           @if($isFile) download @endif>
                                                            <i class="fa fa-file-pdf-o dl-icon"></i>
                                                            <span class="dl-text">{{_t($doc->title)}}</span>
                                                            <i class="fa fa-cloud-download dl-icon"></i>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="pagination-main">
                            {{ $analitik->links('vendor.pagination.custom') }}
                        </div>
                    </div>

                    <div class="col-lg-3">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .custom-card-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            height: 100%;
        }

        .card-content-link {
            text-decoration: none !important;
            color: inherit;
            display: block;
            flex-grow: 1;
        }

        .card-content-link:hover h6 {
            color: #D3A102;
        }

        .card-footer-actions {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #d7d7d7;
            display: flex;
            justify-content: flex-end;
        }

        .dl-btn-minimal {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none !important;
            font-weight: 600;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
            padding: 5px 0;
        }

        .dl-icon {
            font-size: 18px;
            color: #D3A102;
        }

        .dl-btn-minimal:hover {
            color: #D3A102;
        }

    </style>
</x-public-layout>
