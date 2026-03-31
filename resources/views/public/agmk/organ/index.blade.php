<x-public-layout>
    @include('includes.pages-breadcrumb')
    <section class="leadership section">
        <div class="container">
            <div class="leadership__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="leadership__main new_leader_col">

                            <h3 style="padding-left:15px;">
                                {{ _t($p['organ']->title) }}
                            </h3>

                            <div class="row">
                                @foreach ($organ as $item)
                                    @php
                                        $i = 1
                                    @endphp

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                                        <div class="leadership__item new_leader">

                                            @if (!empty($item->files))
                                                @php
                                                    $imgUrl = url_u(). 'sovet/'. getImgMain($item)
                                                @endphp
                                                <div class="leadership__image">
                                                    <img src="{{ $imgUrl }}" alt="{{ _t($item->title) }}">
                                                </div>
                                            @else
                                                <div class="leadership__image">
                                                    <img src="{{ asset('assets/public/images/avatar.png') }}"
                                                         alt="{{ _t($item->title) }}">
                                                </div>
                                            @endif

                                            <div class="leadership__info">
                                                <h5>{{ _t($item->title) }}</h5>
                                                <p>{!!  _t($item->short_content)  !!}</p>
                                            </div>

                                        </div>
                                    </div>
                                    @php
                                        $i++
                                    @endphp
                                @endforeach
                            </div>

{{--                            <div class="new_new">--}}
{{--                                {!! _t($post->content) !!}--}}
{{--                            </div>--}}

                        </div>
                    </div>

                    <div class="col-lg-3">
                        @include('includes.sidebar')
                    </div>
                </div>

                <div class="pagination-main">
                    {{ $organ->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </section>

    <style>
        .new_new table {
            width: 100% !important;
        }

        .leadership__image {
            height: 177px;
        }

        .leadership__image img {
            object-fit: cover;
        }

        .new_leader .leadership__info p {
            height: 68px;
            -webkit-line-clamp: 4;
        }
    </style>

</x-public-layout>
