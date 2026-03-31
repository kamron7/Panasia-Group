<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Libraries\MediaLib;
use App\Models\Base;
use App\Models\Manage;
use App\Models\Menu;
use App\Models\News;
use App\Models\Video_materials;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request, $cat_id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['cat'] = $cat = $this->model::getById($cat_id);
        session(['sel' => $this->sel]);
        session(['sel_g' => $cat->group]);

        $data = $this->model->pager(['limit' => $limit ?? 12, 'cat_id' => $cat_id, 'sort' => $request->get('sort', 'desc')]);
        $this->data['posts'] = $data->items();

        $this->data['pager'] = $data->links();

        return view('admin/cats/index', $this->data);
    }

    public function store($cat_id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $item = $this->model::findOrFail($cat_id);

        $this->data['type'] = 'create';
        session()->flash('type', 'create');
        session()->forget('new_media');
        if(in_array($item->group,['schools','schools_mag'])){
            $view = 'faculty';
        } elseif($item->group === 'lecturers_cat') {
            $view = 'lecturers';
        }
        else{
            $view = $item->group;
        }

        return view("admin/save/$view", $this->data);
    }

    public function edit($cat_id, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->data['post'] = $item = $this->model->getById($id);
        $name = getColName($item);
        session()->flash('post_id', $item->id);
        session()->flash('media_files', $item->$name);
        $this->data['type'] = 'edit';

        session(['sel' => $this->defaultGroupsImage()]);
        return view("admin/save/$item->group", $this->data);
    }

    public function update(Request $request, $cat_id, $id)
    {
        $data = $request->post();

        $data['cat_id'] = (int)$cat_id;
        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($request->has('cat_ids') && !empty($request->input('cat_ids'))) {
            $catIds = $request->input('cat_ids', []);
            $data['cat_ids'] = json_encode(array_map('intval', $catIds), JSON_NUMERIC_CHECK);
        } else {
            $data['cat_ids'] = null;
        }

        $data['group'] = $this->defaultGroups();
        $this->model->my_save($data, $id, true);

        return go_to(url_a() . "$this->sel/cats/$cat_id" . getPage());
    }

    public function create(Request $request, $cat_id)
    {
        $data = $request->post();

        $data['cat_id'] = (int)$cat_id;
        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($request->has('cat_ids') && !empty($request->input('cat_ids'))) {
            $catIds = $request->input('cat_ids', []);
            $data['cat_ids'] = json_encode(array_map('intval', $catIds), JSON_NUMERIC_CHECK);
        } else {
            $data['cat_ids'] = null;
        }

        $data['group'] = $this->defaultGroups();

        $files = session()->pull('new_media');
        if ($files) {
            $folder = $this->sel;
            MediaLib::saveUpload($files, $folder);
        }
        $data['images'] = $files;
        $data['files'] = $files;
        $this->model->my_save($data);

        return go_to(url_a() . "$this->sel/cats/$cat_id");
    }
    private function defaultGroups(): string
    {
        if ($this->sel === 'main') {
            $cat_id = request()->route('cat_id');
            if ($cat_id) {
                $cat = $this->model::getById($cat_id);

                if ($cat->group === 'schools' || $cat->group === 'schools_mag') {
                    return 'schools_item';
                }

                if ($cat->group === 'lecturers_cat') {
                    return 'lecturers_item';
                }

                return $cat->group;
            }

            return 'schools_item';
        }

        return 'schools_item';
    }
    private function defaultGroupsImage(): string
    {
        if ($this->sel === 'main') {
            $cat_id = request()->route('cat_id');
            if ($cat_id) {
                $cat = $this->model::getById($cat_id);

                if ($cat->group === 'schools' || $cat->group === 'schools_mag') {
                    return 'schools_item';
                }
                if ($cat->group === 'lecturers_cat') {
                    return 'lecturers_item';
                }
                return $cat->group;
            }

            return 'schools_item';
        }

        return 'schools_item';
    }

}
