<x-public-layout>
    @include('includes.pages-breadcrumb')
    <link rel="stylesheet" href="{{ asset('assets/public/css/opendata.css') }}">
    @php
        $locale = app()->getLocale();

        switch ($locale) {
            case 'uz': $dataNameKey = 'uzbKrText'; $orgNameKey = 'uzbKrText'; $sphereNameKey = 'uzbKrText'; break;
            case 'oz': $dataNameKey = 'uzbText'; $orgNameKey = 'uzbText'; $sphereNameKey = 'uzbText'; break;
            case 'ru': $dataNameKey = 'rusText'; $orgNameKey = 'rusText'; $sphereNameKey = 'rusText'; break;
            default:   $dataNameKey = 'engText'; $orgNameKey = 'engText'; $sphereNameKey = 'engText'; break;
        }

        $dataName   = $dataset['dataName'][$dataNameKey]    ?? '';
        $orgName    = $dataset['orgName'][$orgNameKey]      ?? '';
        $sphere     = $dataset['sphereName'][$sphereNameKey]?? '';
        $fullCount  = $dataset['fullCount']                 ?? 0;
        $structId   = $dataset['structId']                  ?? null;
        $lastUpdate = $dataset['lastUpdate']                ?? null;

        $lastUpdateFormatted = null;
        if ($lastUpdate) {
            try {
                $lastUpdateFormatted = \Carbon\Carbon::parse($lastUpdate)->format('d.m.Y');
            } catch (\Throwable $e) {
                $lastUpdateFormatted = $lastUpdate;
            }
        }

        $arrNumber0 = ['4-019-0008', '4-019-0009', '4-019-0018', '4-019-0021'];
        // -------------------------------
    @endphp

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <section class="od-page-wrapper">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">

                    <div class="od-header-card">
                        <div class="od-header-top">
                            <span class="od-badge-id">{{ $alias }}</span>
                            <span class="od-badge-date"><i class="fa fa-clock-o"></i> {{ $lastUpdateFormatted }}</span>
                        </div>
                        <h1 class="od-main-heading">{{ $dataName }}</h1>
                        <div class="od-header-meta">
                            <span><i class="fa fa-building-o"></i> {{ $orgName }}</span>
                            <span class="od-separator">•</span>
                            <span><i class="fa fa-folder-o"></i> {{ $sphere }}</span>
                        </div>
                    </div>

                    <div class="od-content-card">

                        <div class="od-tabs-container">
                            <ul class="nav nav-tabs od-nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab1">
                                        {{ _t($p['Table']->title ?? '') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab2">
                                        {{ _t($p['Dataset_passport']->title ?? '') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab3">
                                        {{ _t($p['Interpretations']->title ?? '') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content od-tab-body">

                            <div class="tab-pane fade show active" id="tab1">

                                <div class="od-toolbar">
                                    <div class="od-record-count">
                                        {{ _t($p['data_count']->title ?? '') }} <strong>{{ $fullCount }}</strong>
                                    </div>

                                    @if($structId)
                                        <div class="od-export-buttons">
                                            @php $baseFileUrl = "https://data.egov.uz/apiData/MainData/GetByFile?id={$structId}&tableType=2&lang=1&fileType="; @endphp
                                            <span class="od-export-label">{{ _t($p['download']->title ?? '') }}:</span>
                                            <a href="{{ $baseFileUrl }}2" class="od-btn-export xml" download>XML</a>
                                            <a href="{{ $baseFileUrl }}4" class="od-btn-export csv" download>CSV</a>
                                            <a href="{{ $baseFileUrl }}1" class="od-btn-export json" download>JSON</a>
                                            <a href="{{ $baseFileUrl }}3" class="od-btn-export xls" download>XLS</a>
                                        </div>
                                    @endif
                                </div>

                                <div class="od-table-responsive">
                                    <table class="od-table">
                                        <thead>
                                        <tr>
                                            @foreach($th as $col)
                                                <th>{{ _t($col->title) ?: $col->options }}</th>
                                            @endforeach
                                            @if($geo)
                                                <th class="text-center" style="width: 80px;">Map</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rows as $row)
                                            <tr>
                                                @foreach($th as $col)
                                                    <td>
                                                        @php $value = $row[$col->options] ?? ''; @endphp
                                                        @if(in_array($alias, $arrNumber0))
                                                            {{ $value !== '0' ? $value : '*' }}
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                @endforeach

                                                @if($geo)
                                                    <td class="text-center">
                                                        @php
                                                            $lat = $row['latitude']  ?? null;
                                                            $lng = $row['longitude'] ?? null;
                                                        @endphp
                                                        @if($lat && $lng)
                                                            <button type="button"
                                                                    class="od-btn-map"
                                                                    data-toggle="modal"
                                                                    data-target="#locationModal"
                                                                    data-latitude="{{ $lat }}"
                                                                    data-longitude="{{ $lng }}">
                                                                <i class="fa fa-map-marker"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="pagination-main mt-4">
                                    {{ $rows->links('vendor.pagination.custom') }}
                                </div>
                            </div>

                            {{-- TAB 2: PASSPORT (REDESIGNED) --}}
                            <div class="tab-pane fade" id="tab2">
                                <div class="od-passport-grid">

                                    <div class="od-info-group">
                                        <label>{{ _t($p['codes_title']->title ?? '') }}</label>
                                        <div class="value">{{ $alias }}</div>
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['codes_complect']->title ?? '') }}</label>
                                        <div class="value">{{ $dataName }}</div>
                                    </div>

                                    <div class="od-info-group">
                                        <label>{{ _t($p['First_date']->title ?? '') }}</label>
                                        <div class="value">
                                            @php
                                                $firstDate = null;
                                                if ($alias < '4-019-0014') {
                                                    $firstDate = '11.08.2021';
                                                } elseif (in_array($alias, ['4-019-0014', '4-019-0015'], true)) {
                                                    $firstDate = '14.04.2022';
                                                } elseif (in_array($alias, ['4-019-0016', '4-019-0017', '4-019-0018'], true)) {
                                                    $firstDate = '19.07.2022';
                                                } elseif (in_array($alias, ['4-019-0021', '4-019-0022'], true)) {
                                                    $firstDate = '02.02.2023';
                                                }
                                            @endphp
                                            {{ $firstDate ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="od-info-group">
                                        <label>{{ _t($p['last_date']->title ?? '') }}</label>
                                        <div class="value">{{ $lastUpdateFormatted }}</div>
                                    </div>

                                    <div class="od-info-box full">
                                        <label class="box-label">
                                            <i class="fa fa-address-card-o"></i> {{ _t($p['codes_contact']->title ?? '') }}
                                        </label>
                                        <div class="box-content">
                                            <span><i class="fa fa-phone"></i> +(998) 70 619-60-15</span>
                                            <span><i class="fa fa-envelope"></i> s.avazova@agmk.uz</span>
                                        </div>
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['codes_other']->title ?? '') }}</label>
                                        @php
                                            switch ($alias) {
                                                case '4-019-0022':
                                                    $link1 = url($locale.'/sovet');
                                                    break;
                                                case '4-019-0021':
                                                    $link1 = url($locale.'/menu/viplata-dividendov');
                                                    break;
                                                case '4-019-0013':
                                                    $link1 = url($locale.'/menu/investment-projects');
                                                    break;
                                                case '4-019-0004':
                                                    $link1 = url($locale.'/menu/appeals-of-citizens');
                                                    break;
                                                case '4-019-0010':
                                                case '4-019-0006':
                                                case '4-019-0001':
                                                    $link1 = url($locale.'/opendata');
                                                    break;
                                                default:
                                                    $link1 = url($locale.'/menu/open-data-agmk');
                                                    break;
                                            }
                                        @endphp
                                        <a href="{{ $link1 }}" class="od-link">{{ $link1 }}</a>
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['Reference_form']->title ?? '') }}</label>
                                        @if($structId)
                                            <div class="od-download-chips">
                                                @php
                                                    $baseFileUrl2 = "https://data.egov.uz/apiData/MainData/GetByFile?id={$structId}&tableType=2&lang=1&fileType=";
                                                @endphp
                                                <a href="{{ $baseFileUrl2 }}2" class="od-chip" download>XML</a>
                                                <a href="{{ $baseFileUrl2 }}4" class="od-chip" download>CSV</a>
                                                <a href="{{ $baseFileUrl2 }}1" class="od-chip" download>JSON</a>
                                                <a href="{{ $baseFileUrl2 }}3" class="od-chip" download>XLS</a>
                                                <a href="{{ $baseFileUrl2 }}5" class="od-chip" download>RDF</a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['corresponding']->title ?? '') }}</label>
                                        <div class="od-tags">
                                            <span>Olmaliq</span><span>AGMK</span><span>OKMK</span>
                                        </div>
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['Rate_dataset']->title ?? '') }}</label>

                                        <div class="od-rating-wrapper">
                                            <input type="hidden" id="dataset_name" value="{{ $alias }}">
                                            <input type="hidden" id="user_ip" value="{{ request()->ip() }}">

                                            <div class="od-rating-stars">
                                                <span class="star" data-rating="1">&#9733;</span>
                                                <span class="star" data-rating="2">&#9733;</span>
                                                <span class="star" data-rating="3">&#9733;</span>
                                                <span class="star" data-rating="4">&#9733;</span>
                                                <span class="star" data-rating="5">&#9733;</span>
                                            </div>

                                            <p class="od-rating-count">
                                                ( {{ ($count_star ?? 0) > 0 ? ($count_star.' '._t($p['votes']->title ?? '')) : _t($p['no_vote']->title ?? '') }} )
                                            </p>
                                        </div>
                                    </div>

                                    <div class="od-info-group full">
                                        <label>{{ _t($p['blog_comments']->title ?? '') }}</label>

                                        <form id="commentForm" method="post" action="{{ route('rate.submitComment') }}">
                                        @csrf
                                            <input type="hidden" name="name" value="{{ $alias }}">

                                            <textarea name="comment"
                                                      id="comment"
                                                      placeholder="{{ _t($p['fikr']->title ?? '') }}"
                                                      class="od-comment-textarea"></textarea>

                                            <button type="submit" class="site-btn pink">
                                                {{ _t($p['send']->title ?? '') }}
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>


                            {{-- TAB 3: INTERPRETATIONS --}}
                            <div class="tab-pane fade" id="tab3">
                                @if(isset($docs) && $docs->isNotEmpty())
                                    <div class="od-docs-list">
                                        @foreach($docs as $doc)
                                            @php
                                                $docTitle = _t($doc->title ?? null);
                                                if (!$docTitle) { continue; }

                                                $col   = function_exists('getColName') ? getColName($doc) : null;
                                                $files = $col ? collect($doc->$col ?? []) : collect();
                                                $media = $files->firstWhere('is_main', 1) ?? $files->first();

                                                if ($media) {
                                                    $group   = $media->category ?? ($doc->group ?? 'archive_data');
                                                    $urlFile = $media->url ?? ($doc->url ?? null);
                                                    $ext     = strtolower($media->ext ?? pathinfo($urlFile ?? '', PATHINFO_EXTENSION));
                                                } else {
                                                    $group   = $doc->group ?? 'archive_data';
                                                    $urlFile = $doc->url ?? null;
                                                    $ext     = strtolower(pathinfo($urlFile ?? '', PATHINFO_EXTENSION));
                                                }

                                                $isFile = !empty($urlFile);

                                                if ($isFile) {
                                                    $href = url_u() . $group . '/' . ltrim($urlFile, '/');
                                                } else {
                                                    $href = url_p() . '/menu/' . ($doc->alias ?? '');
                                                }

                                                // Clean Icons
                                                $icon = 'fa-file-text-o';
                                                if($ext == 'pdf') $icon = 'fa-file-pdf-o';
                                                if(in_array($ext, ['xls', 'xlsx'])) $icon = 'fa-file-excel-o';
                                                if(in_array($ext, ['doc', 'docx'])) $icon = 'fa-file-word-o';
                                            @endphp

                                            <a href="{{ $href }}" class="od-doc-row" target="_blank" @if($isFile) download @endif>
                                                <div class="od-doc-icon"><i class="fa {{ $icon }}"></i></div>
                                                <div class="od-doc-title">{{ $docTitle }}</div>
                                                <div class="od-doc-action"><i class="fa fa-download"></i></div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="od-sidebar-wrap">
                        @include('includes.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">{{ _t($p['close']->title ?? '') ?? 'Close' }}</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --od-blue: #003366;
            --od-gold: #d3a102;
            --od-bg: #f5f6fa;
            --od-border: #eaeaea;
            --od-text: #2c3e50;
        }

        /* --- STYLES FOR TAB 2 (PASSPORT) --- */
        .od-passport-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .od-info-group {
            display: flex;
            flex-direction: column;
        }

        .od-info-group.full { grid-column: span 2; }

        .od-info-group label {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #999;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .od-info-group .value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }

        /* Contact Box in Tab 2 */
        .od-info-box {
            background: #f7f9fc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eef2f7;
        }
        .od-info-box.full { grid-column: span 2; }

        .box-label {
            color: var(--od-blue);
            font-weight: 700;
            display: block;
            margin-bottom: 10px;
        }

        .box-content span {
            display: inline-block;
            margin-right: 20px;
            color: #555;
            font-weight: 500;
        }

        .od-link {
            color: var(--od-blue);
            text-decoration: underline;
        }

        /* Tags and Download Chips in Tab 2 */
        .od-tags span, .od-chip {
            display: inline-block;
            background: #f0f0f0;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 8px;
            color: #555;
        }
        .od-rating-wrapper {
            display: inline-flex;
            flex-direction: column;
            gap: 8px;
        }

        .od-rating-stars {
            font-size: 30px;
            cursor: pointer;
        }

        .od-rating-stars .star {
            color: #ccc;
            margin-right: 4px;
        }

        .od-rating-stars .star:hover,
        .od-rating-stars .star.active {
            color: #ffcc00;
        }

        .od-rating-count {
            font-size: 0.9rem;
            color: #555;
        }
        .site-btn.pink {
            background-color: #d3a102;
            color: #fff;
            border-radius: 4px;
            border: 1px solid #d3a102;
            padding: 7px 20px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(211, 161, 2, 0.3);
            transition: all 0.3s ease;
        }

        .site-btn.pink:hover {
            color: white;
            box-shadow: 0 5px 15px rgba(211, 161, 2, 0.4);
            border: 1px solid #ff5858;
        }
        .od-comment-textarea {
            width: 100%;
            min-height: 120px;
            margin: 10px 0 20px;
            letter-spacing: .004em;
            color: #222;
            background: #fff;
            border: 1px solid rgba(34, 34, 34, .2);
            border-radius: 4px;
            padding: 12px;
            font-family: "FiraSans-Regular", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 150%;
        }
        .od-chip {
            text-decoration: none !important;
            font-weight: 600;
            background: #fff;
            border: 1px solid #ddd;
            transition: all 0.2s;
        }

        .od-chip:hover {
            background: var(--od-gold);
            color: #fff;
            border-color: var(--od-gold);
        }

        /* --- GLOBAL LAYOUT STYLES --- */
        .od-header-card {
            background: #fff;
            padding: 30px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border-left: 5px solid var(--od-gold);
        }

        .od-header-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            color: #888;
        }

        .od-badge-id {
            background: #f0f0f0;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            color: var(--od-blue);
        }

        .od-main-heading {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--od-blue);
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .od-header-meta {
            display: flex;
            gap: 10px;
            font-weight: 600;
            font-size: 1rem;
            color:var(--od-blue);
            flex-wrap: wrap;
        }

        .od-separator { color: #ccc; }

        .od-content-card {
            background: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow: hidden;
            min-height: 400px;
        }

        /* TABS */
        .od-tabs-container {
            border-bottom: 1px solid var(--od-border);
            padding: 0 20px;
            background: #fff;
        }

        .od-nav-tabs {
            border: none;
        }

        .od-nav-tabs .nav-link {
            border: none;
            padding: 20px 25px;
            font-size: 1rem;
            font-weight: 500;
            color: #666;
            position: relative;
            background: transparent;
            transition: color 0.3s;
        }

        .od-nav-tabs .nav-link.active {
            color: var(--od-blue);
            font-weight: 700;
            background: transparent;
        }

        .od-nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--od-gold);
        }

        .od-tab-body {
            padding: 30px;
        }

        /* TOOLBAR */
        .od-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
            background: #fafafa;
            padding: 15px;
            border-radius: 8px;
        }

        .od-record-count {
            font-size: 1rem;
            color: var(--od-blue);
        }

        .od-export-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 8px;
            color: #555;
        }

        .od-btn-export {
            display: inline-block;
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #fff;
            border-radius: 4px;
            margin-right: 4px;
            text-decoration: none !important;
            transition: opacity 0.2s;
        }
        .od-btn-export:hover { opacity: 0.9; color: #fff; }
        .od-btn-export.xml { background-color: #ff9f43; }
        .od-btn-export.csv { background-color: #28c76f; }
        .od-btn-export.json { background-color: #00cfe8; }
        .od-btn-export.xls { background-color: #2e86de; }

        /* TABLE */
        .od-table-responsive {
            overflow-x: auto;
            border: 1px solid var(--od-border);
        }

        .od-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .od-table thead th {
            background-color: #fbba2ee8;
            color: #000000;
            font-weight: 600;
            padding: 14px 16px;
            white-space: nowrap;
        }

        .od-table tbody td {
            padding: 12px 16px;
            color: #333;
        }

        .od-table tbody tr:hover {
            background-color: #fcfcfc;
        }

        .od-btn-map {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--od-gold);
            background: #fff;
            color: var(--od-gold);
            cursor: pointer;
            transition: all 0.2s;
        }

        .od-btn-map:hover {
            background: var(--od-gold);
            color: #fff;
        }

        /* DOCS LIST */
        .od-doc-row {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid var(--od-border);
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 12px;
            text-decoration: none !important;
            transition: all 0.2s;
        }

        .od-doc-row:hover {
            border-color: var(--od-gold);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transform: translateX(5px);
        }

        .od-doc-icon {
            font-size: 1.5rem;
            color: var(--od-gold);
            margin-right: 20px;
        }

        .od-doc-title {
            flex-grow: 1;
            font-weight: 500;
            color: #333;
            font-size: 1rem;
        }

        .od-doc-action {
            color: #ccc;
        }

        .od-doc-row:hover .od-doc-action {
            color: var(--od-gold);
        }

        @media (max-width: 768px) {
            .od-passport-grid { grid-template-columns: 1fr; }
            .od-info-group.full { grid-column: span 1; }
            .od-nav-tabs .nav-link { padding: 15px; font-size: 0.9rem; }
            .od-toolbar { flex-direction: column; align-items: flex-start; }
        }
    </style>
    <script>
        $(document).ready(function () {
            const $stars      = $('.od-rating-stars .star');
            const $countLabel = $('.od-rating-count');

            $stars.on('click', function () {
                const name   = $('#dataset_name').val();
                const ip     = $('#user_ip').val();
                const rating = $(this).data('rating');

                $.ajax({
                    url: '{{ route('rate.submit') }}',
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        name: name,
                        ip: ip,
                        rating: rating
                    },
                    success: function (response) {
                        if (response.success) {
                            $stars.removeClass('active');
                            $stars.each(function () {
                                if ($(this).data('rating') <= rating) {
                                    $(this).addClass('active');
                                }
                            });

                            if (response.count !== undefined) {
                                const votesText = response.count > 0
                                    ? response.count + ' {{ _t($p['votes']->title ?? '') }}'
                                    : '{{ _t($p['no_vote']->title ?? '') }}';

                                $countLabel.text('( ' + votesText + ' )');
                            }

                            alert("{{ _t($p['accept']->title ?? '') }}");
                        } else {
                            alert('Failed to submit rating.');
                        }
                    },
                    error: function () {
                        alert('Error in submitting rating.');
                    }
                });
            });

            $('#commentForm').submit(function (e) {
                e.preventDefault();

                const form = $(this);
                const formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: formData,
                    success: function (response) {
                        alert("{{ _t($p['accept']->title ?? '') }}");
                        form[0].reset();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        let mapInstance = null;

        function initMap(latitude, longitude) {
            const lat = parseFloat(latitude);
            const lng = parseFloat(longitude);
            if (isNaN(lat) || isNaN(lng)) return;

            if (!mapInstance) {
                mapInstance = L.map('map', {
                    minZoom: 2,
                    maxZoom: 19,
                    zoomSnap: 0
                }).setView([lat, lng], 17);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {})
                    .addTo(mapInstance);
            } else {
                mapInstance.setView([lat, lng], 17, {animate: true});
                mapInstance.invalidateSize();
            }

            mapInstance.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    mapInstance.removeLayer(layer);
                }
            });

            L.marker([lat, lng]).addTo(mapInstance);
        }

        $('#locationModal').on('shown.bs.modal', function () {
            if (mapInstance) {
                setTimeout(() => mapInstance.invalidateSize(), 100);
            }
        });

        document.addEventListener('click', function (e) {
            const target = e.target.closest('[data-toggle="modal"][data-target="#locationModal"]');
            if (!target) return;

            const lat = target.dataset.latitude;
            const lng = target.dataset.longitude;
            setTimeout(() => initMap(lat, lng), 200);
        });
    </script>
</x-public-layout>
