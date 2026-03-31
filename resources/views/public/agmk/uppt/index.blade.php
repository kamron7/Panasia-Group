<x-public-layout>

    @include('includes.pages-breadcrumb')

    <section class="news-inner section">
        <div class="container">
            <div class="news-inner__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="news-inner__main">
                            <div class="row">

                                @foreach ($uppt as $item)
                                    @php
                                        $img = getImgMain($item);
                                        $imgUrl = $img ? url_u() . 'uppt/' . $img : asset('assets/public/images/avatar.png');
                                    @endphp

                                    <div class="col-lg-4">
                                        <a href="{{ url('uppt/' . $item->alias) }}" class="news-inner__item new_min">

                                            <div class="news-inner__item__image">
                                                <img src="{{ $imgUrl }}" alt="{{ _t($item->title) }}">
                                            </div>

                                            <div class="news-inner__item__info">
                                                <h6>{{ _t($item->title) }}</h6>
                                                <p>{!!  _t($item->short_content)  !!}</p>
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
                    {{ $uppt->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </section>

</x-public-layout>
