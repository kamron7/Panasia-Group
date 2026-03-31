<x-public-layout>
    @include('includes.pages-breadcrumb')

    <section class="od-wrapper-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9 mb-5">
                    <div class="od-listings-grid">

                        @php
                            $locale = app()->getLocale();
                        @endphp

                        @foreach($datasets as $index => $item)
                            @php
                                $name       = $item['name']       ?? '';
                                $lastUpdate = $item['lastUpdate'] ?? null;
                                $structId   = $item['structId']   ?? null;
                                $dataName   = $item['dataName']   ?? [];
                                $orgName    = $item['orgName']    ?? [];
                                $sphereName = $item['sphereName'] ?? [];

                                switch ($locale) {
                                    case 'uz':
                                        $titleText  = $dataName['uzbKrText']  ?? '';
                                        $orgText    = $orgName['uzbKrText']   ?? '';
                                        $sphereText = $sphereName['uzbKrText']?? '';
                                        break;
                                    case 'oz':
                                        $titleText  = $dataName['uzbText']    ?? '';
                                        $orgText    = $orgName['uzbText']     ?? '';
                                        $sphereText = $sphereName['uzbText']  ?? '';
                                        break;
                                    case 'ru':
                                        $titleText  = $dataName['rusText']    ?? '';
                                        $orgText    = $orgName['rusText']     ?? '';
                                        $sphereText = $sphereName['rusText']  ?? '';
                                        break;
                                    default: // en
                                        $titleText  = $dataName['engText']    ?? '';
                                        $orgText    = $orgName['engText']     ?? '';
                                        $sphereText = $sphereName['engText']  ?? '';
                                        break;
                                }

                                $dateStr = null;
                                if ($lastUpdate) {
                                    try {
                                        $dt = \Carbon\Carbon::parse($lastUpdate);
                                        $dateStr = $dt->format('d.m.Y');
                                    } catch (\Throwable $e) {
                                        $dateStr = $lastUpdate;
                                    }
                                }
                                $downloadCount = $downloadCounts[$name] ?? 0;

                                $baseFileUrl = $structId
                                    ? "https://data.egov.uz/apiData/MainData/GetByFile?id={$structId}&tableType=2&fileType="
                                    : null;
                            @endphp

                            <div class="od-card">
                                <div class="od-card-header">
                                    <span class="od-badge-date">
                                        <i class="fa fa-calendar-o"></i> {{ $dateStr }}
                                    </span>
                                    <span class="od-badge-downloads">
                                        <i class="fa fa-cloud-download"></i> {{ $downloadCount }}
                                    </span>
                                </div>

                                <div class="od-card-body">
                                    <a href="{{ url($locale . '/opendata/' . $name) }}" class="od-title-link">
                                        <h2 class="od-main-title">{{ $titleText }}</h2>
                                    </a>
                                    <div class="od-meta-info">
                                        <p class="od-org-name"><i class="fa fa-building-o"></i> {{ $orgText }}</p>
                                        <span class="od-id-tag">{{ $name }}</span>
                                    </div>
                                </div>

                                <div class="od-card-footer">
                                    <div class="od-category">
                                        <i class="fa fa-folder-open-o"></i> {{ $sphereText }}
                                    </div>

                                    <div class="od-files-wrapper">
                                        @if($baseFileUrl)
                                            <a href="{{ $baseFileUrl }}2" class="od-file-btn file-xml" data-dataset="{{ $name }}" data-type="xml" download>
                                                <span>XML</span>
                                            </a>
                                            <a href="{{ $baseFileUrl }}4" class="od-file-btn file-csv" data-dataset="{{ $name }}" data-type="csv" download>
                                                <span>CSV</span>
                                            </a>
                                            <a href="{{ $baseFileUrl }}1" class="od-file-btn file-json" data-dataset="{{ $name }}" data-type="json" download>
                                                <span>JSON</span>
                                            </a>
                                            <a href="{{ $baseFileUrl }}3" class="od-file-btn file-xls" data-dataset="{{ $name }}" data-type="xls" download>
                                                <span>XLS</span>
                                            </a>
                                            <a href="{{ $baseFileUrl }}5" class="od-file-btn file-rdf" data-dataset="{{ $name }}" data-type="rdf" download>
                                                <span>RDF</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="od-pagination-wrapper">
                            {{ $datasets->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="od-sidebar-sticky">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>



    @if(Route::has('opendata.download_hit'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.od-file-btn').forEach(function (link) {
                    link.addEventListener('click', function () {
                        const dataset = this.dataset.dataset;
                        if (!dataset) return;

                        fetch('{{ route('opendata.download_hit') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({alias: dataset})
                        }).catch(() => {
                        });
                    });
                });
            });
        </script>
    @endif
</x-public-layout>
