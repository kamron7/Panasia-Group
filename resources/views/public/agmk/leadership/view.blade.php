<x-public-layout>

    @include('includes.pages-breadcrumb')
    <section class="leadership section">
        <div class="container">
            <div class="leadership__wrapper">
                <div class="row">
                    <div class="col-lg-9">

                        <div class="leadership__main">
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="leadership__item">
                                        <div class="flex_leader">

                                            @if (!empty($leadership->files))
                                                @php
                                                    $imgUrl =  url_u(). 'leadership/'. getImgMain($leadership);
                                                @endphp

                                                <a href="{{ $imgUrl }}"
                                                   class="leadership__image"
                                                   data-fancybox="">
                                                    <img src="{{ $imgUrl }}"
                                                         loading="lazy"
                                                         alt="{{ _t($leadership->title) }}">
                                                </a>

                                            @else
                                                <a class="leadership__image">
                                                    <img src="{{ asset('assets/public/images/avatar.png') }}"
                                                         loading="lazy"
                                                         alt="{{ _t($leadership->title) }}">
                                                </a>
                                            @endif

                                            <div class="leadership__info">
                                                <h5>{{ _t($leadership->title) }}</h5>
                                                <p>{!! _t($leadership->content_2)  !!}</p>

                                                <ul>
                                                    <li>
                                                        <span>{{ _t($p['phone']->title ?? '') }}:</span>
                                                        <a href="tel:{{ $leadership->options2 }}">
                                                            {{ $leadership->options2 }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <span>{{ _t($p['email']->title ?? '') }}:</span>
                                                        <a href="mailto:{{ $leadership->options }}">
                                                            {{ $leadership->options }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <span>{{ _t($p['dni_priema']->title ?? '') }}:</span>
                                                        <a href="#">
                                                            {!!  _t($leadership->content)  !!}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                        <div class="news-view__info">
                                            {!! _t($leadership->short_content) !!}
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-3">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
