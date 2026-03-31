<x-public-layout>

@include('includes.pages-breadcrumb')

    <section class="leadership section">
        <div class="container">
            <div class="leadership__wrapper">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="leadership__main">
                            <div class="row">

                                @php($i = 1)
                                @foreach ($leadership as $item)
                                    <div class="col-lg-12">
                                        <div class="leadership__item">
                                            <div class="flex_leader">

                                                @if (!empty($item->files))
                                                    <a href="{{ url_u(). 'leadership/'. getImgMain($item) }}"
                                                       class="leadership__image"
                                                       data-fancybox="">
                                                        <img src="{{ url_u(). 'leadership/'. getImgMain($item) }}"
                                                             loading="lazy"
                                                             alt="{{ _t($item->title) }}">
                                                    </a>
                                                @else
                                                    <a class="leadership__image">
                                                        <img src="{{ asset('assets/public/images/avatar.png') }}"
                                                             loading="lazy"
                                                             alt="{{ _t($item->title) }}">
                                                    </a>
                                                @endif

                                                <div class="leadership__info">
                                                    <h5>{{ _t($item->title) }}</h5>
                                                    <p>{!! _t($item->content_2)  !!}</p>
                                                    <ul>
                                                        <li>
                                                            <span>{{ _t($p['phone']->title ?? '') }}:</span>
                                                            <a href="tel:{{ $item->options2 }}"> {{ $item->options2 }}</a>
                                                        </li>
                                                        <li>
                                                            <span>{{ _t($p['email']->title ?? '') }}:</span>
                                                            <a href="mailto:{{ $item->options }}"> {{ $item->options }}</a>
                                                        </li>
                                                        <li>
                                                            <span>{{ _t($p['dni_priema']->title ?? '') }}:</span>
                                                            <a href="#">
                                                                {!! _t($item->content)  !!}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="leadership__btn">
                                                        <a href="{{ url($item->group . '/' . $item->alias) }}"
                                                           class="btn">
                                                            {{ _t($p['more_inf']->title ?? '') }}
                                                            <i class="icon-arrow-side"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php($i++)
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        @include('includes.sidebar')
                    </div>
                </div>

                <div class="pagination-main">
                    {{ $leadership->links('vendor.pagination.custom') }}
                </div>

            </div>
        </div>
    </section>

    <style>
        .leadership__main .row {
            flex-direction: column-reverse;
        }
    </style>

</x-public-layout>
