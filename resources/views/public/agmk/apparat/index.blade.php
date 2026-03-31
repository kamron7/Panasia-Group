<x-public-layout>
@include('includes.pages-breadcrumb')
    <section class="news-inner section">
        <div class="container">
            <div class="news-inner__wrapper">
                <div class="row">

                    <div class="col-lg-9">
                        <div class="news-inner__main">
                            <div class="row">

                                @foreach ($apparat as $item)
                                    @php($news_date = date_parse($item->created_at))

                                    <div class="col-lg-4">
                                        <a href="{{ url($item->group.'/'.$item->alias) }}"
                                           class="news-inner__item news_doc new_ns_a">

                                            <div class="news-inner__item__info ns new_ns">
                                                <h6>{{ _t($item->title) }}</h6>
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
                    {{ $apparat->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
