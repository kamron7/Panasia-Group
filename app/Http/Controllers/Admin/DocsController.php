<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Libraries\MediaLib;
use App\Models\Docs;
use App\Models\Main;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocsController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['sel'] = 'docs';
    }

    public function index($group, $cat_id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        session()->remove('sel_g');
        session(['sel' => 'docs']);
        $data = Docs::pager(['group' => $group, 'cat_id' => $cat_id, 'limit' => 30, 'sort' => request('sort')]);

        $this->data['posts'] = $data->items();
        $this->data['pager'] = $data->links();
        $this->data['cat'] = Main::getById($cat_id);
        $this->data['cat_id'] = $cat_id;
        $this->data['group'] = $group;

        return view('admin/group/index', $this->data);
    }

    public function store($group, $cat_id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['sel_g'] = $group;
        session()->forget('new_media');
//        $this->data['cat'] = getTables()[$group]::getById($cat_id);
        $this->data['cat'] = Main::getById($cat_id);
        $this->data['type'] = 'create';
        $this->data['cat_id'] = $cat_id;
        session()->flash('type', 'create');
        session()->forget('docs_media');

        return view("admin/save/$this->sel", $this->data);
    }

    public function create(Request $request, $group, $cat_id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $request->post();
        session(['sel' => 'docs']);
        $files = session()->pull('docs_media');
        if ($files)
            MediaLib::saveUpload($files, $this->sel);

        $data['files'] = $files;
        $data['cat_id'] = $cat_id;
        $data['group'] = $group;
        $this->model->my_save($data);

        return go_to(url_a() . "$this->sel/$group/$cat_id" . getPage());
    }

    public function edit($group, $cat_id, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        session(['sel' => 'docs']);

        $this->data['sel_g'] = $group;
//        $this->data['cat'] = getTables()[$group]::getById($cat_id);
        $this->data['cat'] = Main::getById($cat_id);
        $this->data['post'] = $item = Docs::getById($id);
        $this->data['cat_id'] = $cat_id;

        $name = getColName($item);
        session()->flash('post_id', $item->id);
        session()->flash('docs_media', $item->$name);
        $this->data['type'] = 'edit';

        return view("admin/save/$this->sel", $this->data);
    }

    public function update(Request $request, $group, $cat_id, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        session()->forget('docs_media');
        $this->model->my_save($request->post(), $id, true);
        return go_to(url_a() . "$this->sel/$group/$cat_id" . getPage());
    }
}
