<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\PublicController;
use App\Models\Menu;
use App\Http\Resources\SportIMeditsinaResources;
use App\Models\News;
use App\Models\Video_materials;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends PublicController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sel_main'] = 'news';
    }

    public function index($alias = false): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if ($alias) {
            session(['sel' => $alias]);
            $this->data['sel'] = $alias;
            $post = Menu::getByAliasPublic($alias);
            $data = News::pagerPublic(['limit' => 15, 'cat_id' => $post->id]);
        } else {
            session(['sel' => 'news']);
            $this->data['sel'] = 'news';
            $data = News::pagerPublic(['limit' => 15, ['cat_id', '<>', '75']]);
            $post = Menu::getById(2);
        }
        $this->data['news'] = $data->items();;
        $this->data['pager'] = $data->onEachSide(2)->links();

        $this->getSidebar($post);
        $this->metaParams($post);

        return view('public/pages/news', $this->data);
    }

    public function view($alias): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (request()->segment(2) == 'news') $post = News::getByAliasPublic($alias);
        else $post = Video_materials::getByAliasPublic($alias);
        if (!$post) return go_to(url_p());

        $this->data['sel'] = $alias;
        session(['sel' => 'news']);
        $this->data['links'] = 'news';
        $this->data['inner_news'] = true;
        $this->data['sel_news'] = $post->group;
        $this->metaParams($post);

        $this->data['media'] = $post->images;
        if (request()->segment(2) == 'news')
            $this->data['cat2'] = $cat = Menu::getByIdPublic($post->cat_id);
        else
            $this->data['cat2'] = $cat = Menu::getByInnerLinkPublic($post->group);

        $this->getSidebar($cat ?? null);
        $this->updatePostView($post, request()->segment(2) == 'news' ? 'news' : 'video_materials');

        $body = request()->segment(2) == 'interview' ? 'interview_v' : 'news_view';

        return view("public/pages/$body", $this->data);
    }

    public function video_materials($group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session(['sel' => $group]);
        $this->data['sel'] = $group;
        $data = Video_materials::pagerPublic(['limit' => 15, 'group' => $group, 'orderBy' => 'created_at']);
        $post = Menu::getByInnerLinkPublic($group);
        $this->data['news'] = $data->items();;
        $this->data['pager'] = $data->onEachSide(2)->links();

        $body = $group == 'social-video' ? 'news' : 'video_materials';
        $this->data['type_social'] = true;

        $this->getSidebar($post);
        $this->metaParams($post);

        return view("public/pages/$body", $this->data);

    }
    
}
