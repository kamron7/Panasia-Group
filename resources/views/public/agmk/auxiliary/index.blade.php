<x-public-layout>

    @include('includes.pages-breadcrumb')

    <section class="news-inner section">
        <div class="container">
            <div class="news-inner__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="news-inner__main">
                            <div class="row">

                                @foreach ($auxiliary as $item)
                                    @php
                                        $img = getImgMain($item);
                                        $imgUrl = $img ? url_u() . 'auxiliary/' . $img : asset('assets/public/images/avatar.png');
                                    @endphp

                                    <div class="col-lg-4">
                                        <a href="{{ url('auxiliary/' . $item->alias) }}" class="news-inner__item new_min">

                                            <div class="news-inner__item__image">
                                                <img src="{{ $imgUrl }}" alt="{{ _t($item->title) }}">
                                            </div>

                                            <div class="news-inner__item__info">
                                                <h6>{{ _t($item->title) }}</h6>
                                                <p>{{ \Illuminate\Support\Str::words(strip_tags(_t($item->short_content)), 90, '…') }}</p>

                                            </div>

                                            <p class="read_more">{{ _t($p['read_more']->title ?? '') }}</p>
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
                    {{ $auxiliary->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </section>

</x-public-layout>
