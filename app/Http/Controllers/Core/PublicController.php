<?php

namespace App\Http\Controllers\Core;

use App\Models\Main;
use App\Models\Menu;
use App\Models\News;
use App\Models\Pages;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\App;
use Jenssegers\Agent\Agent;
use App\Models\Polls;

class PublicController extends MyController
{
    protected News $news;
    protected Pages $pages;
    protected Menu $menu;

    public function __construct()
    {
        parent::__construct();

        $lang = App::getLocale() == 'uz-Latn' ? 'oz' : App::getLocale();
        AbstractPaginator::useBootstrapFive();
        if (!defined('LANG'))
            define('LANG', $lang);

        $this->news = new News();
        $this->pages = new Pages();
        $this->menu = new Menu();
        $this->data['p'] = Pages::gets(['status' => true])->keyBy('options');
        session(['p' => $this->data['p']]);
        $this->data['sel_menu'] = '';

//        $this->data['polls'] = Polls::getPublic(['sort' => 'asc']);
//        session(['polls' => $this->data['polls']]);
    }

    protected function updatePostView($post, $model = 'main'): void
    {
        if (session('ip_view') != $post->id) {
            session(['ip_view' => $post->id]);
            if (!request()->is('robot')) {
                getTables()[$model]->my_save(['views' => $post->views + 1], $post->id);
            }
        }
    }

    protected function listSidebar($id): void
    {
        if (!isset($this->data['cat']))
            $this->data['cat'] = Menu::getByIdPublic($id);
        $this->data['list'] = Menu::getsPublic(['cat_id' => $id, 'sort' => 'ASC']);
        foreach ($this->data['list'] as $item) {
            $this->data['sub'][] = Menu::getsPublic(['cat_id' => $item->id, 'sort' => 'ASC']);
        }
    }

    protected function getSidebar($post): void
    {
        $this->listSidebar($post->cat_id);
    }

    protected function getBanner($limit = 1, $limit2 = 6): void
    {
        $this->data['banner'] = Main::getsPublic(['limit' => $limit, 'group' => 'banner', 'options2' => '1']);
    }

    protected function fullParams($link, $sidebar = true): void
    {
        $post = Menu::getByInnerLinkPublic($link);
        $this->metaParams($post);
        if ($sidebar)
            $this->getSidebar($post);
    }

    protected function catParams($link): void
    {
        $this->data['cat2'] = $post = Menu::getByInnerLinkPublic($link);
        $this->data['cat'] = Menu::getByIdPublic($post->cat_id);
    }

    protected function metaParams($post): void
    {
        $this->data['post'] = $post;
        $this->data['title'] = $post->title;
        session(['post' => $post]);
        session(['title' => $post->title]);
        $params_arr = ['content', 'short_content', 'keywords', 'description'];
        foreach ($params_arr as $item)
            $this->hasParam($post, $item);
    }

    private function hasParam($post, $param): void
    {
        if (isset($post->$param)) {
            $this->data[$param] = $post->$param;
        }
    }
}
