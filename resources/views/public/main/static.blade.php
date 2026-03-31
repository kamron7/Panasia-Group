<x-public-layout>
    @include('includes.pages-breadcrumb')


    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/public/virtual/form.css?v=' . time()) }}"/>
    <script src="{{ asset('assets/public/virtual/input.mask.js?v=0.1') }}"></script>

    <section class="news-view section">
        <div class="container">
            <div class="news-view__wrapper">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="news-view__main new_new" id="newsPrint">

                            <div class="news-view__title">
                                <h3>{{ _t($title) }}</h3>
                            </div>

                            <div class="content">

                                @php
                                    $mainImage = getImgMain($post);

                                    $otherImages = getImgNoMain($post);

                                    $totalImages = ($mainImage ? 1 : 0) + count($otherImages);
                                @endphp

                                @if ($totalImages > 0)
                                    <div class="news-view__image">
                                        <div class="owl-carousel owl-theme" id="news-carousel">


                                            @if ($mainImage)
                                                @php
                                                    $mainUrl = url_u() . 'menu/' . ltrim($mainImage, '/');
                                                @endphp
                                                <div class="item">
                                                    <div class="news-view__image">
                                                        <a href="{{ $mainUrl }}" data-fancybox="gallery">
                                                            <img src="{{ $mainUrl }}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            @foreach ($otherImages as $img)
                                                @php
                                                    $imgUrl = url_u() . 'menu/' . ltrim($img, '/');
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

                                @if (!empty(_t($post->short_content)))
                                    <div class="news-view__info mb-3">
                                        {!! _t($post->short_content) !!}
                                    </div>
                                @endif

                                @if (!empty($docs))
                                    <div class="docs mb-3">
                                        <ul>
                                            @foreach ($docs as $item)
                                                <li>
                                                    <a href="{{ url_u() . 'docs/' . getImgMain($item) }}"
                                                       data-toggle="tooltip"
                                                       title="{{ _t($item->title) }}">
                                                        <h4>
                                                            <i class="fa fa-file-pdf-o"></i>
                                                            {{ _t($item->title) }}
                                                        </h4>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="news-view__info">
                                    {!! _t($post->content) !!}
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

@if ($totalImages > 0)
    <script>
        $(document).ready(function () {
            $("#news-carousel").owlCarousel({
                items: 1,
                slideSpeed: 300,
                paginationSpeed: 400,
                loop: {{ $totalImages > 1 ? 'true' : 'false' }},
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
        $(".content a:has(img)").fancybox();

        $(".phone").inputmask({
            "mask": "+998 (dd) ddd-dd-dd"
        });
    });
</script>
