<x-public-layout>
    @include('includes.pages-breadcrumb')

    @php
        $news_date = \Carbon\Carbon::parse($products->created_at ?? $products->created_on ?? now());

        // Main image
        $mainRel = getImgMain($products);
        $mainUrl = $mainRel
            ? url_u() . 'products/' . ltrim($mainRel, '/')
            : asset('assets/public/images/avatar.png');

        // Thumbs
        $thumbRel = getImgNoMain($products, true);
        $thumbRel = is_array($thumbRel) ? array_values($thumbRel) : [];
        $thumbRel = array_slice($thumbRel, 0, 4);
    @endphp

    <section class="pd-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">
                    <div class="pd-card">
                        <div class="row">

                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="pd-gallery">
                                    <div class="pd-main-image-box">
                                        <img id="mainProductImage" src="{{ $mainUrl }}" alt="{{ _t($products->title) }}">
                                    </div>

                                    @if(count($thumbRel))
                                        <div class="pd-thumbs-row">
                                            @foreach($thumbRel as $idx => $relUrl)
                                                @php $thumbUrl = url_u().'products/'.ltrim($relUrl, '/'); @endphp
                                                <button type="button" class="pd-thumb-btn">
                                                    <img class="pd-thumb-img" src="{{ $thumbUrl }}" alt="Thumbnail {{ $idx }}">
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="pd-info-content">
                                    <h1 class="pd-title">{{ _t($products->title) }}</h1>
                                    <div class="pd-divider"></div>

                                    @if(_t($products->content3 ?? null))
                                        <div class="pd-spec-item">
                                            <span class="pd-label">{{ _t($p['standart']->title ?? 'Standard') }} : </span>
                                            <div class="pd-value">{!! _t($products->content3) !!}</div>
                                        </div>
                                    @endif

                                    @if(_t($products->content4 ?? null))
                                        <div class="pd-spec-item">
                                            <span class="pd-label">{{ _t($p['p_p']->title ?? 'Properties') }} : </span>
                                            <div class="pd-value">{!! _t($products->content4) !!}</div>
                                        </div>
                                    @endif

                                    @if(_t($products->content5 ?? null))
                                        <div class="pd-spec-item">
                                            <span class="pd-label">{{ _t($p['usage']->title ?? 'Usage') }} : </span>
                                            <div class="pd-value">{!! _t($products->content5) !!}</div>
                                        </div>
                                    @endif

                                    @if(_t($products->content ?? null))
                                        <div class="pd-spec-item">
                                            <span class="pd-label">{{ _t($p['shakli']->title ?? 'Form') }} : </span>
                                            <div class="pd-value">{!! _t($products->content) !!}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if(_t($products->content2 ?? null))
                                <div class="col-12 mt-4">
                                    <div class="pd-full-desc">
                                        <h4 class="pd-desc-title">{{_t($p['more_inf']->title ?? '')}}</h4>
                                        <div class="pd-desc-body">
                                            {!! _t($products->content2) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="pd-related-section">
                        <h3 class="pd-related-title">{{ _t($p['shu']->title ?? 'Related Products') }}</h3>
                        <div class="owl-carousel owl-theme product__carousel">
                            @foreach($product as $item)
                                @php
                                    $relMainRel = getImgMain($item);
                                    $relatedImgUrl = $relMainRel ? url_u().'products/'.ltrim($relMainRel, '/') : asset('assets/public/images/avatar.png');
                                @endphp
                                <div class="item">
                                    <a href="{{ $item->alias }}" class="pd-related-card">
                                        <div class="pd-related-img">
                                            <img src="{{ $relatedImgUrl }}" alt="{{ _t($item->title) }}">
                                        </div>
                                        <div class="pd-related-info">
                                            <h6>{{ _t($item->title) }}</h6>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="pd-sidebar-sticky">
                        @include('includes.sidebar')
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            const $mainImg = $('#mainProductImage');

            $('.pd-thumb-btn').on('click', function () {
                const $btn   = $(this);
                const $thumb = $btn.find('.pd-thumb-img');

                const mainSrc  = $mainImg.attr('src');
                const thumbSrc = $thumb.attr('src');

                $mainImg.fadeOut(150, function() {
                    $mainImg.attr('src', thumbSrc).fadeIn(150);
                });
                $thumb.attr('src', mainSrc);
            });

            @if(isset($product) && count($product))
            $('.product__carousel').owlCarousel({
                items: 3,
                margin: 20,
                loop: {{ count($product) > 3 ? 'true' : 'false' }},
                nav: true,
                dots: false,
                autoplay: true,
                smartSpeed: 600,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                responsive: {
                    0:   {items: 1},
                    576: {items: 2},
                    992: {items: 3}
                }
            });
            @endif
        });
    </script>

    {{-- CSS STYLES --}}
    <style>
        :root {
            --pd-gold: #d3a102;
            --pd-blue: #003366;
            --pd-bg: #f5f6fa;
            --pd-card-bg: #ffffff;
            --pd-border: #e2e8f0;
            --pd-text: #2d3748;
        }

        .pd-card {
            background: var(--pd-card-bg);
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .pd-main-image-box {
            width: 100%;
            height: 400px;
            overflow: hidden;
            border: 1px solid var(--pd-border);
            margin-bottom: 15px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pd-main-image-box img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .pd-thumbs-row {
            display: flex;
            gap: 10px;
        }

        .pd-thumb-btn {
            border: 1px solid var(--pd-border);
            background: #fff;
            padding: 0;
            width: 153px;
            height: 153px;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.2s;
        }

        .pd-thumb-btn:hover {
            border-color: var(--pd-gold);
            transform: translateY(-2px);
        }

        .pd-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pd-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--pd-blue);
            margin-bottom: 15px;
        }

        .pd-divider {
            height: 1px;
            background: var(--pd-border);
            margin-bottom: 20px;
        }

        .pd-spec-item {
            margin-bottom: 15px;
        }

        .pd-label {
            display: block;
            font-size: 0.85rem;
            text-transform: uppercase;
            color: #718096;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .pd-value {
            font-size: 1rem;
            color: var(--pd-text);
            font-weight: 500;
        }

        .pd-full-desc {
            background: #f8fafc;
            padding: 20px;
            border: 1px solid var(--pd-border);
        }

        .pd-desc-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--pd-blue);
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .pd-desc-body {
            color: #4a5568;
            line-height: 1.6;
        }

        .pd-related-section {
            margin-top: 40px;
        }

        .pd-related-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--pd-blue);
            margin-bottom: 20px;
        }

        .pd-related-card {
            display: block;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-decoration: none !important;
            transition: transform 0.3s;
            border: 1px solid var(--pd-border);
        }

        .pd-related-card:hover {
            border-color: var(--pd-gold);
        }

        .pd-related-img {
            height: 200px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .pd-related-img img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .pd-related-info {
            padding: 15px;
            text-align: center;
        }

        .pd-related-info h6 {
            font-size: 0.95rem;
            color: var(--pd-text);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pd-sidebar-sticky {
            position: sticky;
            top: 20px;
            margin-bottom: 98px;
        }

        .owl-theme .owl-nav [class*=owl-] {
            background: var(--pd-gold) !important;
            color: #fff !important;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            line-height: 30px;
            padding: 0;
            font-size: 14px;
        }
    </style>
</x-public-layout>
