<?php

namespace App\View\Components;

use App\Models\Gallery;
use App\Models\Main;
use App\Models\Menu;
use App\Models\News;
use App\Models\Products;
use App\Models\Pages;
use App\Models\Site;
use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    public array $data = [];
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title;
    }

    public function render(): View
    {
        $this->data['title'] = $this->title ?? 'Default Title';

        // Fetch social data once
        $socialData = Main::getsPublic(['status' => true, 'group' => 'socials', 'orderBy' => 'sort_order', 'limit' => 100, 'except' => ['content', 'short_content']]);
        $this->data['s'] = $socialData->keyBy('id');
        $this->data['social'] = $socialData;
        $this->data['socials'] = $socialData;

        $this->data['g'] = Gallery::getsPublic(['except' => ['content', 'short_content'], 'limit' => 100])
            ->filter(fn($item) => !empty(_t($item->title) ?? null))
            ->keyBy('keywords');

        // Fetch news and sliders once
        $newsAndSliders = News::getsPublic(['limit' => 5, 'group'=>'news', 'orderBy' => 'created_at', 'except' => 'content']);
        $this->data['news'] = $newsAndSliders->take(3);
        $this->data['sliders'] = $newsAndSliders;

        // Fetch pages once
        $pagesData = Pages::getsPublic(['limit' => 500]);
        $this->data['pages'] = $pagesData;
        $this->data['p'] = $pagesData->keyBy('options');


        $this->data['clubs'] = Main::getsPublic([
            'status' => true,
            'group' => 'clubs',
            'orderBy' => 'sort_order',
            'except' => ['content', 'short_content'],
            'limit' => 100
        ])
            ->filter(fn($item) => !empty(_t($item->title) ?? null));

        $menuData = Menu::MenuPublic();
        $this->data['main_menu'] = $menuData['main'];
        $this->data['main_footer'] = $menuData['footer'];
        $this->data['menu_mobile'] = $menuData['mobile'];
        $this->data['menu_full'] = $menuData['full'];

        $menuItems = Menu::MenuPublic(true);

        $cats = [];

        if (!empty($menuItems)) {
            foreach ($menuItems as $cat) {
                if ($cat === null || !isset($cat->cat_id)) {
                    continue;
                }
                $cats[$cat->cat_id][] = $cat;
            }
        }

        $this->data['menu'] = $cats;

        $this->data['meta_global'] = Site::getById(1);
        $this->data['title'] = $this->title ?? 'Default Title';

        return view('layouts.public', $this->data);
    }
}
