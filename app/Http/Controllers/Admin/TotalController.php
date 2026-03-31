<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Libraries\MediaLib;
use App\Models\Opendata;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;
use App\Models\Pages;
use App\Models\User;
use App\Models\News;
use App\Models\Docs;
use App\Models\Video;
use App\Models\Region;
use Illuminate\Support\Facades\Http;
use App\Models\Gallery;
use App\Models\Main;
use App\Models\City;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Strings;

class TotalController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Reset session selection
        session()->remove('sel_g');
        session(['sel' => $this->sel]);

        // MENU branch
        if ($this->sel == 'menu') {
            $this->data['menu_admin'] = Menu::MenuAdmin();

            // USERS branch
        } elseif ($this->sel == 'users') {
            $this->data['posts'] = User::all();

            // OPENDATA branch
        } elseif ($this->sel == 'opendata') {

            $sort = request('sort', 'desc');

            $query = Opendata::query()
                ->whereColumn('alias', 'options');

            $data = $query->orderBy('sort_order', $sort)
                ->paginate(15);

            $this->data['posts'] = $data->items();
            $this->data['pager'] = $data->appends(request()->except('page'))->links();

            // Build archive map
            $archiveMap = [];
            $archives = Main::where('group', 'archive_data')->get();
            foreach ($archives as $arch) {
                $titleArray = is_string($arch->title)
                    ? json_decode($arch->title, true)
                    : (array)$arch->title;

                $key = $titleArray['ru'] ?? null;
                if ($key) {
                    $archiveMap[$key] = $arch->id;
                }
            }
            $this->data['archiveMap'] = $archiveMap;

            // PAGES branch
        } elseif ($this->sel == 'pages') {

            $query = Pages::query();

            if ($title = request('title')) {
                $query->whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($title) . '%']);
            }

            // Sort by created_at
            $sort = request('sort', 'desc');
            $data = $query->orderBy('created_at', $sort)
                ->paginate(15);

            $this->data['posts'] = $data->items();
            $this->data['pager'] = $data->appends(request()->except('page'))->links();

            // OTHER branches
        } else {

            $query = $this->model->query();

            if (in_array($this->sel, ['request', 'virtual', 'feedback']) && request()->has('region')) {
                $query->where('region', request('region'));
            }

            $data = $this->model->pager([
                'limit' => 30,
                'sort' => request('sort', 'desc')
            ]);

            $this->data['posts'] = $data->items();
            $this->data['pager'] = $data->appends(request()->except('page'))->links();
        }

        return view('admin/total/index', $this->data);
    }



    public function store(): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {


        session(['sel' => $this->sel]);
        $this->data['type'] = 'create';
        session()->flash('type', 'create');
        session()->forget('new_media');
        return view("admin/save/$this->sel", $this->data);
    }

    public function edit($id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {

        session(['sel' => $this->sel]);

        if ($this->sel == 'site') session()->forget('sel');
        $this->data['post'] = $item = $this->model->getById($id);
        $name = getColName($item);
        session()->flash('post_id', $item->id);
        session()->flash('media_files', $item->$name);

        $this->data['type'] = 'edit';
        $this->data['sel'] = $this->sel;
        return view("admin/save/$this->sel", $this->data);
    }

    public function update(Request $request, $id): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $request->post();
        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($this->sel == 'video') {
            $file = $this->uploadFile($this->sel, $this->model, $id);
            if (is_string($file)) $data['img'] = $file;
        }
        if ($this->sel == 'users')
            if ($data['password'] == '0')
                unset($data['password']);
            else $data['pass'] = $data['password'];

        $this->model->my_save($data, $id, true);
        if ($this->sel == 'site') return go_to(url_a() . "site/edit/1");
        return go_to(url_a() . $this->sel . getPage());
    }

    public function create(Request $request): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $data = $request->post();
        if ($request->has('lang')) {
            $data['lang'] = $request->input('lang');
        }
        if ($this->sel == 'video') {
            $file = $this->uploadFile($this->sel, $this->model);
            if (is_string($file)) $data['img'] = $file;
        }

        $files = session()->pull('media_files');

        if ($files) {
            $folder = $this->sel;
            MediaLib::saveUpload($files, $folder);
        }

        $data['images'] = $files;
        $data['files'] = $files;
        $id = $this->model->my_save($data);
        $this->saveDocs($id);
        return go_to(url_a() . $this->sel);
    }

    private function replaceUploads($data)
    {
        $search2 = 'src="/uploads/';
        $replace = 'src="/storage/uploads/';
        if ($data)
            foreach ($data as $key => $val)
                $data[$key] = str_replace($search2, $replace, $val);
        return $data;
    }

    public function reset()
    {
        try {
            Visit::truncate();
            Cache::forget('live_visitors');

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function opendataTable($id)
    {
        $post  = Opendata::findOrFail($id);

        $alias = $post->options;
        $lang  = app()->getLocale();

        $token = '634fbf6f7a564ebe17bb32e4';

        $url = "https://data.egov.uz/apiPartner/Partner/WebService"
            . "?token={$token}"
            . "&name={$alias}"
            . "&offset=0"
            . "&limit=100"
            . "&lang={$lang}";

        $context = stream_context_create([
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ]);

        $json = @file_get_contents($url, false, $context);
        $data = json_decode($json, true);

        $rows    = $data['result']['data'] ?? [];
        $columns = !empty($rows) ? array_keys($rows[0]) : [];

        $meta = Opendata::where('alias', $alias)->get()->keyBy('options');

        $currentMaxSort = $meta->max('sort_ordder') ?? 0;

        foreach ($columns as $col) {
            if (!$meta->has($col)) {
                $currentMaxSort++;

                $metaRow = Opendata::create([
                    'alias'       => $alias,
                    'options'     => $col,
                    'title'       => [
                        'ru' => null,
                        'uz' => null,
                        'oz' => $col,
                        'en' => null,
                    ],
                    'sort_ordder' => $currentMaxSort,
                    'status'      => true,
                ]);

                $meta->put($col, $metaRow);
            }
        }

        $this->data['post']    = $post;
        $this->data['rows']    = $rows;
        $this->data['columns'] = $columns;
        $this->data['meta']    = $meta;
        $this->data['sel']     = 'opendata';

        return view('admin/opendata/table', $this->data);
    }

}
