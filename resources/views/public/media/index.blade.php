<x-public-layout>
    <div class="pages-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url_p() ?>"><?= _t($p['home']->title ?? '') ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span>
                        <?= $title ?>
                    </span></li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="pages">
        <div class="container">
            <div class="title media">
                <h2><?= $title ?></h2>
                <ul>
                    <li class="<?= ($sel == 'gallery') ? 'active' : '' ?>">
                        <a href="<?= url_p() . '/media' ?>"><?= _t($p['media_photo']->title ?? '') ?></a>
                    </li>
                    <li class="<?= ($sel == 'video') ? 'active' : '' ?>">
                        <a href="<?= url_p() . '/video' ?>"><?= _t($p['media_video']->title ?? '') ?></a>
                    </li>
                </ul>
            </div>
            <div class="content" id="newsPrint">
                <div class="row">
                    @foreach ($items as $item)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="<?= url_p() ."/$sel/$item->alias" ?>" class="media__item">
                                <div class="media__item__image">
                                    <img src="<?= url_u() . "$sel/" . (($sel == 'gallery') ?
                                                        getImgMain($item) : $item->img) ?>" alt="">
                                </div>
                                <div class="media__item__info">
                                    <div class="media__item__info__inner">
                                        <p><?= _t($item->title) ?></p>
                                    </div>
                                </div>
                            </a>

                        </div>
                    @endforeach
                </div>
                @if ($pager)
                    {!! $pager !!}
                @endif
            </div>
        </div>
    </section>
</x-public-layout>
