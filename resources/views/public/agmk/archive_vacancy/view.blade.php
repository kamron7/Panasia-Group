<x-public-layout>
    @include('includes.pages-breadcrumb')

    @php
        $newsDate = \Carbon\Carbon::parse($arxiv_vacancy->created_at ?? $arxiv_vacancy->created_on);
    @endphp

    <script src="{{ asset('assets/public/js/printThis.js') }}"></script>

    <section class="news-view section">
        <div class="container">
            <div class="news-view__wrapper">
                <div class="row">

                    <div class="col-lg-4">
                        <div class="mySide">
                            <h5>{{ _t($p['main_comp']->title ?? '') }}</h5>

                            <div class="label">
                                <h6>{{ _t($p['full_comp']->title ?? '') }}</h6>
                                <p>{{ _t($p['compans']->title ?? '') }}</p>
                            </div>

                            <div class="label">
                                <h6>{{ _t($p['legal']->title ?? '') }}</h6>
                                <p>{{ _t($p['AJ']->title ?? '') }}</p>
                            </div>

                            <div class="label">
                                <h6>{{ _t($p['webSite']->title ?? '') }}</h6>
                                <a href="https://www.agmk.uz" target="_blank">https://www.agmk.uz</a>
                            </div>

                            <div class="label">
                                <a href="https://ahds.agmk.uz:8443/ords/hr_resumes/r/hr-send-resume/login"
                                   target="_blank"
                                   class="online_platform">
                                    {{ _t($p['online_platform']->title ?? '') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div id="newsPrint">
                            <div class="news-view__main">
                                <div class="news-view__title">
                                    <h3>{{ _t($arxiv_vacancy->title) }}</h3>

                                    <div class="news-inner__item__date">
                                        <span>
                                            {{ $newsDate->format('d') }}
                                            {{ getMonthName($newsDate) }}
                                            {{ $newsDate->format('Y') }},
                                            {{ $newsDate->format('H:i') }}
                                        </span>
                                        <span>
                                            <i class="icon-view"></i> {{ $arxiv_vacancy->views }}
                                        </span>
                                    </div>
                                </div>

                                <div class="news-view__info">
                                    {!! _t($arxiv_vacancy->content) !!}
                                </div>

                                <div class="news-view__bottom">
                                    <div class="news-view__left">
                                        <span>{{ _t($p['share_your']->title ?? '') }}:</span>
                                        <script src="{{ asset('assets/public/js/share.js') }}"></script>
                                        <div class="ya-share2"
                                             data-curtain
                                             data-shape="round"
                                             data-services="telegram,facebook">
                                        </div>
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
        </div>
    </section>

    @if(!empty($all_images ?? null))
        <script>
            $(document).ready(function () {
                $("#news-carousel").owlCarousel({
                    items: 1,
                    slideSpeed: 300,
                    paginationSpeed: 400,
                    loop: {{ (count($all_images) > 1) ? 'true' : 'false' }},
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
        $(document).ready(function () {
            $('#btnPrint').on('click', function (e) {
                e.preventDefault();
                $('#newsPrint').printThis({
                    debug: false,
                    importCSS: false,
                    importStyle: false,
                    printContainer: true,
                    loadCSS: "{{ asset('assets/public/css/print.css') }}?v={{ time() }}",
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

    <style>
        .news-view__main {
            background: #F5F5F7;
            border-radius: 2px;
            padding: 40px 24px;
        }

        .mySide {
            background: #F5F5F7;
            border-radius: 2px;
            padding: 40px 24px;
        }

        .mySide h5 {
            margin-bottom: 20px;
        }

        .mySide .label h6 {
            margin-bottom: 10px;
        }

        .mySide .label a {
            display: block;
            margin-bottom: 1rem;
        }

        .online_platform {
            display: inline-block;
            padding: 8px 14px;
            background: #D3A102;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
        }

        .online_platform:hover {
            background: #b88d02;
            color: #fff;
            text-decoration: none;
        }
    </style>
</x-public-layout>
