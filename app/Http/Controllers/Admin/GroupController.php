<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Libraries\MediaLib;
use App\Models\Base;
use App\Models\Docs;
use App\Models\Doctors;
use App\Models\Federations;
use App\Models\Gallery;
use App\Models\Main;
use App\Models\Manage;
use App\Models\Menu;
use App\Models\News;
use App\Models\Sports;
use App\Models\Video;
use App\Models\Video_materials;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GroupController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, $group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session(['sel' => $this->sel]);
        if ($group === 'product') {
            $data = $this->model->pager(['limit' => $limit ?? 30, 'group' => $group, 'cat_id' => 0, 'sort' => $request->get('sort', 'desc')]);
        } else {
            $data = $this->model->pager(['limit' => $limit ?? 30, 'group' => $group, 'sort' => $request->get('sort', 'desc')]);
        }

        if ($this->sel == 'main') {
            session(['sel' => $group]);
            session(['sel_t' => $this->sel]);
            session()->remove('sel_g');
            $body = "admin/main/index";
        } else {
            session(['sel_g' => $group]);
            $body = "admin/group/index";
        }

        $this->data['posts'] = $data->items();
        $this->data['pager'] = $data->links();

        return view($body, $this->data);
    }

    public function store($group): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['sel_g'] = $group;
        $this->data['type'] = 'create';
        session()->flash('type', 'create');
        session()->forget('new_media');
        $body = "admin/save/$this->sel";
        if ($this->sel == 'main') {
            $body = "admin/save/$group";
            $this->data['sel'] = $group;
        }
        if (in_array($group, ['winter-asian', 'winter', 'summer-asian', 'summer', 'youthful']))
            $body = "admin/save/games";

        return view($body, $this->data);
    }

    public function edit($group, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        $this->data['sel_g'] = $group;
        session(['sel' => $this->sel]);
        $this->data['post'] = $item = $this->model->getById($id);
        $name = getColName($item);
        session()->flash('post_id', $item->id);
        session()->flash('media_files', $item->$name);

        $this->data['type'] = 'edit';
        $body = "admin/save/$this->sel";
        if (in_array($this->sel, ['main', 'news'])) {
            $body = "admin/save/$group";
            $this->data['sel'] = $group;
            session(['sel' => $group]);
        } else {
            session(['sel' => $this->sel]);
        }

        return view($body, $this->data);
    }

    public function update(Request $request, $group, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $request->post();
        $data['group'] = $group;

        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($group == 'publications') {
            $file = $this->uploadFile($group, $this->main);
            if (is_string($file)) $data['img'] = $file;
        }
        if ($group == 'social-video') {
            $file = $this->uploadFile($this->sel, $this->main);
            if (is_string($file)) $data['img'] = $file;
        }

        $this->model->my_save($data, $id, true);
        return go_to(url_a() . "$this->sel/$group" . getPage());
    }

    public function create(Request $request, $group): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $request->post();
        $data['group'] = $group;

        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($group == 'publications' || $group == 'video_materials') {
            $file = $this->uploadFile($group, $this->main);
            if (is_string($file)) $data['img'] = $file;
        }
        $files = session()->pull('media_files');
        if ($files) {
            $folder = $this->sel;
            if (in_array($this->sel, ['main', 'news'])) {
                $folder = $group;
            }
            MediaLib::saveUpload($files, $folder);
        }

        $data['images'] = $files;
        $data['files'] = $files;
        $id = $this->model->my_save($data);
        $this->saveDocs($id);
        return go_to(url_a() . "$this->sel/$group");
    }

    public function changeGroup(\Illuminate\Http\Request $request)
    {
        $id    = (int) $request->input('id');
        $group = $request->input('group');

        if (!$id || !in_array($group, ['vacancy', 'arxiv_vacancy'], true)) {
            return response()->json(['success' => false], 422);
        }

        $post = \App\Models\Main::find($id);

        if (!$post) {
            return response()->json(['success' => false], 404);
        }

        $post->group = $group;
        $post->save();

        return response()->json(['success' => true]);
    }

}
