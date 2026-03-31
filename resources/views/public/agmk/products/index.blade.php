<x-public-layout>
    @include('includes.pages-breadcrumb')

    <section class="prod-page-section">
        <div class="container">
            <div class="row">

                <div class="col-lg-9 mb-5">
                    <div class="prod-grid-wrapper">
                        <div class="row">
                            @forelse($products as $item)
                                @php
                                    $news_date = \Carbon\Carbon::parse($item->created_at ?? $item->created_on);
                                @endphp

                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <a href="{{ url('products/'.$item->alias) }}" class="prod-card">
                                        <div class="prod-image-box">
                                            <img
                                                src="{{url_u(). 'products/'. getImgMain($item) }}"
                                                alt="{{ _t($item->title) }}"
                                                loading="lazy"
                                            >
                                            <div class="prod-overlay">
                                                <span class="btn-view"><i class="fa fa-arrow-right"></i></span>
                                            </div>
                                        </div>
                                        <div class="prod-info">
                                            <h5 class="prod-title">{{ _t($item->title) }}</h5>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="prod-empty-state">
                                        <i class="fa fa-cube"></i>
                                        <h3>{{ _t($p['not_found']->title ?? '') ?? 'No products found' }}</h3>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="pagination-main mt-4">
                        @if(isset($news) && $news instanceof \Illuminate\Contracts\Pagination\Paginator)
                            {{ $news->links('vendor.pagination.custom') }}
                        @endif
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="prod-sidebar-sticky">
                        @include('includes.sidebar')

                        @if(isset($news) && $news->count())
                            <div class="prod-sidebar-widget">
                                <h4 class="widget-title">{{ _t($p['last_news']->title ?? '') }}</h4>

                                <div class="widget-news-list">
                                    @foreach($news as $item)
                                        @php
                                            $news_date = \Carbon\Carbon::parse($item->created_at ?? $item->created_on);
                                        @endphp

                                        <a href="{{ url($item->group.'/'.$item->alias) }}" class="big-news-card">
                                            <div class="big-news-img">
                                                <img
                                                    src="{{url_u(). 'news/'. getImgMain($item) }}"
                                                    alt="{{ _t($item->title) }}"
                                                >
                                            </div>
                                            <div class="big-news-content">
                                                <h6 class="big-news-title">{{ \Illuminate\Support\Str::limit(_t($item->title), 90) }}</h6>
                                                <div class="big-news-meta">
                                                    <span><i class="fa fa-calendar"></i> {{ $news_date->format('d.m.Y') }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        :root {
            --prod-gold: #d3a102;
            --prod-blue: #003366;
            --prod-bg: #f5f6fa;
            --prod-card-bg: #ffffff;
            --prod-border: #e2e8f0;
            --prod-text: #2d3748;
        }


        .prod-card {
            display: block;
            background: var(--prod-card-bg);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            border: 1px solid #f0f0f0;
            text-decoration: none !important;
        }

        .prod-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            border-color: var(--prod-gold);
        }

        .prod-image-box {
            position: relative;
            width: 100%;
            padding-top: 85%; /* Aspect Ratio */
            background: #fff; /* White background ensures no gray bars */
            overflow: hidden;
            border-bottom: 1px solid #f0f0f0;
        }

        .prod-image-box img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 90%;  /* padding inside box */
            max-height: 90%; /* padding inside box */
            width: auto;
            height: auto;
            object-fit: contain; /* CRITICAL: Ensures image is NOT cropped */
            transition: transform 0.5s ease;
        }

        .prod-card:hover .prod-image-box img {
            transform: translate(-50%, -50%) scale(1.08); /* Zoom effect */
        }

        /* Overlay Effect */
        .prod-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 51, 102, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .prod-card:hover .prod-overlay {
            opacity: 1;
        }

        .btn-view {
            width: 40px;
            height: 40px;
            background: var(--prod-gold);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transform: scale(0.8);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(211, 161, 2, 0.4);
        }

        .prod-card:hover .btn-view {
            transform: scale(1);
        }

        .prod-info {
            padding: 20px;
            background: #fff;
        }

        .prod-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--prod-text);
            margin: 0;
            line-height: 1.4;
            transition: color 0.3s;
            text-align: center;
        }

        .prod-card:hover .prod-title {
            color: var(--prod-gold);
        }

        .prod-sidebar-widget {
            background: #fff;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: 1px solid #f0f0f0;

        }

        .widget-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--prod-blue);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .widget-news-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .big-news-card {
            display: block;
            text-decoration: none !important;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 20px;
        }

        .big-news-card:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .big-news-img {
            width: 100%;
            height: 200px;
            overflow: hidden;
            margin-bottom: 15px; /* Space between image and text */
            background-color: #f5f5f5;
        }

        .big-news-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .big-news-card:hover .big-news-img img {
            transform: scale(1.05);
        }

        .big-news-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--prod-text);
            line-height: 1.4;
            margin-bottom: 8px;
            transition: color 0.2s;
        }

        .big-news-card:hover .big-news-title {
            color: var(--prod-gold);
        }

        .big-news-meta {
            font-size: 0.9rem;
            color: #718096;
            font-weight: 500;
        }

        /* --- EMPTY STATE --- */
        .prod-empty-state {
            text-align: center;
            padding: 60px 0;
            color: #a0aec0;
        }
        .prod-empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .pagination-main {
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .prod-grid-wrapper {
                margin-bottom: 40px;
            }
        }
    </style>
</x-public-layout>
