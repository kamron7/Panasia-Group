<x-public-layout>
    @include('includes.pages-breadcrumb')
    <script src="{{ asset('assets/public/js/printThis.js') }}"></script>

    @php
        $news_date  = date_parse($press_conference->created_at ?? '');
        $all_images = getAllImages($press_conference, true);
    @endphp

    <section class="news-view section">
        <div class="container">
            <div class="news-view__wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="news-view__main" id="newsPrint">
                            <div class="news-view__title">
                                <h3>{{ _t($press_conference->title) }}</h3>

                                <div class="news-inner__item__date">
                                    <span>
                                        {{ ($news_date['day'] < 10 ? '0'.$news_date['day'] : $news_date['day']) }}
                                        {{ getMonthName($press_conference->created_at) }}
                                        {{ $news_date['year'] }},
                                        {{ str_pad($news_date['hour'], 2, '0', STR_PAD_LEFT) }}:{{ str_pad($news_date['minute'], 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span>
                                        <i class="icon-view"></i>{{ $press_conference->views }}
                                    </span>
                                </div>
                            </div>

                            @if (!empty($all_images))
                                <div class="news-view__image">
                                    <div class="owl-carousel owl-theme" id="news-carousel">
                                        @foreach ($all_images as $file)
                                            @php
                                                $imgUrl = url_u() . 'press-conference/' . ltrim($file->url, '/');
                                            @endphp
                                            <div class="item">
                                                <div class="news-view__image">
                                                    <a href="{{ $imgUrl }}" data-fancybox="gallery">
                                                        <img src="{{ $imgUrl }}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="news-view__info">
                                {!! _t($press_conference->content) !!}
                            </div>

                            <div class="news-view__bottom">
                                <div class="news-view__left">
                                    <span>{{ _t($p['share_your']->title ?? '') }}:</span>
                                    <script src="{{ asset('assets/public/js/share.js') }}"></script>
                                    <div class="ya-share2"
                                         data-curtain
                                         data-shape="round"
                                         data-services="telegram,facebook"></div>
                                </div>
                                <div class="news-view__right">
                                    <a href="#" id="btnPrint">
                                        <i class="icon-print"></i>
                                        {{ _t($p['printer']->title ?? '') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!empty($all_images))
        <script>
            $(document).ready(function () {
                $("#news-carousel").owlCarousel({
                    items: 1,
                    slideSpeed: 300,
                    paginationSpeed: 400,
                    loop: {{ count($all_images) > 1 ? 'true' : 'false' }},
                    nav: false,
                    dots: true,
                    autoplay: true,
                    autoplayTimeout: 7500,
                    smartSpeed: 800,
                    navText: [
                        '<i class="icon-angle-left"></i>',
                        '<i class="icon-angle-right"></i>'
                    ],
                });
            });
        </script>
    @endif

    <script>
        jQuery(document).ready(function ($) {
            $('#btnPrint').on('click', function (e) {
                e.preventDefault();
                $('#newsPrint').printThis({
                    debug: false,
                    importCSS: false,
                    importStyle: false,
                    printContainer: true,
                    loadCSS: "{{ asset('assets/public/css/print.css?v=' . time()) }}",
                    pageTitle: "",
                    removeInline: false,
                    printDelay: 333,
                    header: null,
                    footer: null,
                    base: false,
                    formValues: true,
                    canvas: false,
                    doctypeString: "",
                    removeScripts: false
                });
            });
        });
    </script>

</x-public-layout>
