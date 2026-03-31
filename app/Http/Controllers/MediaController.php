<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Menu;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class MediaController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sel_main'] = 'news';
    }

    public function index($group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = getTables()[$group]::pagerPublic(['limit' => 12]);
        $this->data['items'] = $data->items();
        $this->data['pager'] = $data->links();
        $this->data['sel'] = $group;
        session(['sel' => 'media']);

        $this->data['title'] = p_lang('media');

        return view("public/media/index", $this->data);
    }

    public function view($alias, $group): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['sel'] = $alias;
        session(['sel' => $alias]);
        $table = getTables()[$group];

        $post = $table::getByAliasPublic($alias);
        if (!$post) return go_to(url_p());

        $this->metaParams($post);
        $col = getColName($post);
        $this->data['media'] = $post->$col;

        return view("public/media/{$group}_v", $this->data);
    }
}
