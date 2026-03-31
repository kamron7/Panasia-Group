<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Docs;
use App\Models\Doctors;
use App\Models\Federations;
use App\Models\Manage;
use App\Models\Menu;
use App\Models\News;
use App\Models\Sports;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Models\Main;
use Illuminate\Routing\Redirector;

class MainController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function viewParams($post, $link = false): void
    {
        $this->metaParams($post);
        if ($post->group != 'announcement') {
            if ($link)
                $this->catParams($link);
            $this->getSidebar($this->data['cat2']);
        }
    }

    public function static($alias): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $post = $this->menu->getByAliasPublic($alias);

        if (!$alias or !$post) return go_to('/');

        $this->data['sel'] = $alias;
        session(['sel' => $alias]);
        $news = News::where('status', true)
            ->where('group', 'new')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $this->data['news'] = $news ?: collect();
        $this->data['files'] = $post->files;
        $this->data['docs'] = Docs::getsPublic(['group' => 'menu', 'cat_id' => $post->id]);

        $this->metaParams($post);
        $this->getSidebar($post);

        return view('public/main/static', $this->data);
    }

    public function manage_and_federations($alias): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $post = $alias == 'federation-doctors' ?
            Menu::getByInnerLinkPublic($alias) : Menu::getByAlias($alias);

        if (!$post) return redirect(url_p());
        $this->data['sel'] = $alias;
        session(['sel' => $alias]);

        $this->metaParams($post);
        if ($post->id == 21) {
            $this->data['m_category'] = Manage::getsPublic(['group' => 'm_category', 'sort' => 'ASC',]);
            $this->data['manage'] = Manage::getsPublic(['group' => 'staff', 'sort' => 'asc',]);
        } elseif ($post->id == 23) {
            $this->data['m_category'] = Doctors::getsPublic(['group' => 'd_category', 'sort' => 'ASC',]);
            $this->data['manage'] = Doctors::getsPublic(['group' => 'medics', 'sort' => 'asc', 'except' => 'short_content']);
        } else
            $this->data['manage'] = Manage::getsPublic(['group' => $alias, 'sort' => 'ASC',]);

        $this->getSidebar($post);

        return view('public/main/manage/index', $this->data);
    }

    public function federations($alias, $group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $post = Menu::getByInnerLinkPublic($alias);

        $this->getSidebar($post);
        $this->metaParams($post);

        $this->data['sel'] = $alias;
        if ($group == 'normal')
            $this->data['items'] = Federations::getsPublic(['group' => $group, 'sort' => 'asc', 'except' => 'content']);
        else {
            $this->data['item_cats'] = $cats = Federations::getsPublic(['group' => $group, 'sort' => 'asc']);
            $this->data['items'] = Federations::getsPublic(['group' => 'inner', 'sort' => 'asc', 'except' => 'content',
                'where_in' => ['cat_id' => $cats->pluck('id')->toArray()]])->groupBy('cat_id');

            $alias = 'federation_list';
        }
        return view("public/main/$alias/index", $this->data);
    }

    public function arena($alias): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $post = Menu::getByInnerLinkPublic($alias);

        $this->getSidebar($post);
        $this->metaParams($post);
        $this->data['sel'] = $alias;
        $alias = str_replace('-', '_', $alias);
        $data = Main::pagerPublic(['group' => $alias, 'except' => 'content', 'sort' => 'desc']);
        $this->data['items'] = $data->items();;
        $this->data['pager'] = $data->links();

        if ($alias != 'ioc_structure') $alias = 'arena';
        return view("public/main/$alias/index", $this->data);
    }

    public function announcement(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $this->data['sel'] = 'announcement';
        session(['sel' => 'announcement']);
        $data = Main::pagerPublic(['group' => 'announcement', 'except' => 'content', 'sort' => 'desc']);
        $this->data['items'] = $data->items();;
        $this->data['pager'] = $data->links();

        return view("public/main/announcement/index", $this->data);
    }

    public function arena_v($alias): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $post = Main::getByAliasPublic($alias);
        if (!$post) return go_to(url_p());
        $this->data['sel'] = $alias;
        $this->data['media'] = $post->files;
        session(['sel' => $alias]);
        $link = str_replace('_', '-', $post->group);
        $this->viewParams($post, $link);
        $body = 'arena';
        if ($post->group == 'announcement') $body = 'announcement';
        return view("public/main/$body/view", $this->data);
    }

    public function sports($alias, $cat = 0): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $post = Menu::getByInnerLinkPublic($alias);
        if (!$post) return redirect(url_p());

        $this->data['sel'] = $alias;
        if ($alias != 'youthful') {
            $this->data['items'] = Sports::getsPublic(['group' => 'items', 'cat_id' => $cat]);
            $this->data['items_cat'] = Sports::getById($cat);
        } else {
            $data = Main::pagerPublic(['group' => $alias, 'limit' => 9]);
            $this->data['items'] = Main::getsPublic(['group' => $alias]);
            $this->data['pager'] = $data['pager'];
        }

        $this->getSidebar($post);
        $this->metaParams($post);

        return view('public/main/sports/index', $this->data);
    }

    public function sports_v($alias): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $post = Sports::getByAliasPublic($alias);
        if (!$post) return go_to(url_p());
        $this->data['sel'] = $alias;
        session(['sel' => $alias]);
        $link = match ($post->cat_id) {
            1 => 'summer',
            2 => 'winter',
            51 => 'summer-asian',
            52 => 'winter-asian',
        };
        $this->viewParams($post, $link);

        return view('public/main/sports/view', $this->data);
    }

    public function olympians($group): Application|View|Factory|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $post = Menu::getByInnerLinkPublic($group);
        if (!$post) return redirect(url_p());

        $this->data['sel'] = $group;
        $data = Main::pagerPublic(['group' => $group, 'limit' => 9, 'except' => 'content']);
        $this->data['items'] = $data->items();
        $this->data['pager'] = $data->links();

        $this->getSidebar($post);
        $this->metaParams($post);

        return view('public/main/olympians/index', $this->data);
    }

    public function olympians_v($alias, $group): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $post = Main::getByAliasPublic($alias);
        if (!$post) return go_to(url_p());
        $this->data['sel'] = $alias;
        $this->data['group'] = $group;
        session(['sel' => $alias]);

        $this->viewParams($post, $group);

        return view('public/main/olympians/view', $this->data);
    }
}
