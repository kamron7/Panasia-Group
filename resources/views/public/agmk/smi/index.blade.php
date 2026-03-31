<x-public-layout>
    @include('includes.pages-breadcrumb')

    <section class="news-inner section">
        <div class="container">
            <div class="news-inner__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="news-inner__main">
                            <div class="row">
                                @foreach($smi as $item)
                                    @php
                                        $created = $item->created_at ?? null;
                                        $smi_date = $created ? date_parse($created) : null;
                                    @endphp

                                    <div class="col-lg-4">
                                        <a href="{{ url($item->group . '/' . $item->alias) }}"
                                           class="news-inner__item custom-card-style">
                                            <div class="news-inner__item__image">
                                                <img src="{{ url_u() . 'smi/' . getImgMain($item) }}" alt="">
                                            </div>

                                            <div class="news-inner__item__info">
                                                <h6>{{ _t($item->title) }}</h6>
                                                <p>{{ removeTags(_t($item->short_content)) }}</p>
                                            </div>

                                            <div class="news-inner__item__date styled-meta">
                                                @if($smi_date)
                                                    <span class="meta-date">
                                                        <i class="fa fa-calendar-o"></i>
                                                        {{ $smi_date['day'] < 10 ? '0'.$smi_date['day'] : $smi_date['day'] }}
                                                        {{ getMonthName($created) }}
                                                        {{ $smi_date['year'] }}
                                                    </span>
                                                @endif

                                                <span class="meta-views">
                                                    <i class="icon-view"></i>
                                                    {{ $item->views ?? 0 }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        @include('includes.sidebar')
                    </div>
                </div>

                <div class="pagination-main">
                    {{ $smi->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>

    <style>

        .custom-card-style {
            display: flex !important;
            flex-direction: column;
            height: 100%;
            border: 1px solid #eaeaea;
        }

        .news-inner__item__info {
            flex-grow: 1;
            margin-bottom: 10px;
        }

        .styled-meta {
            margin-top: auto;
            padding-top: 12px;
            margin-top: 15px;
            border-top:1px solid rgba(2, 1, 5, 0.11);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #999;
            font-size: 13px;
        }

        .styled-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .styled-meta i {
            color: #ccc;
            font-size: 14px;
        }

        .custom-card-style:hover .styled-meta i {
            color: #bfa15f;
        }
    </style>
</x-public-layout>
