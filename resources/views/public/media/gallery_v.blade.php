<x-public-layout>
    <div class="pages-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url_p() ?>"><?= _t($p['home']->title ?? '') ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a
                            href="<?= url_p() . '/media' ?>"><?= _t($p['media']->title ?? '') ?></a></li>
                </ol>
            </nav>
        </div>
    </div>
    <style>
        .gallery-item__image::after {
            display: none;
        }
    </style>
    <section class="pages">
        <div class="container">
            <div class="title inner_title">
                <h1><?= _t($p['media']->title ?? '') ?></h1>
            </div>
            <div class="pages-content">
                <div class="row">
                    <div class="col-lg-9 col-md-12">
                        <div class="content">
                            <div class="content-body media-view">

                                <div class="gallery">
                                    <div class="content-title">
                                        <h3><?= _t($title) ?></h3>
                                    </div>
                                    <?= _t($post->content) ?>
                                    <div class="row">
                                        @foreach ($media as $item)
                                            <div class="col-xl-4 mb-4">
                                                <a href="<?= url_u() . "gallery/$item->url" ?>"
                                                   class="media-item" data-fancybox="gallery">
                                                    <img src="<?= url_u() . "gallery/$item->url" ?>" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="news-view__top news-view__date media-date">
                                    <span><i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ $post->created_at->day . ' ' . getMonthName($post->created_at) . ' ' . $post->created_at->year }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        @include('includes.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
