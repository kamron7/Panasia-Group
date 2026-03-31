<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use App\Models\Base;
use App\Models\Docs;
use App\Models\Doctors;
use App\Models\Federations;
use App\Models\Gallery;
use App\Models\Main;
use App\Models\Main as admin_main;
use App\Models\Manage;
use App\Models\Menu;
use App\Models\News;
use App\Models\Pages;
use App\Models\Site;
use App\Models\Sports;
use App\Models\Video;
use App\Models\Video_materials;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Polyfill\Mbstring\Mbstring;

class MainController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function main(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
//        $posts = DB::connection('mysql')->table('site')->limit(1000)->first();
//        $model = new Site();
//
//        $model->my_save(['title' => [], 'email' => $posts->email]);


//        $content = $this->replaceUploads($content);
//        $video_code = $this->replaceUploads($video_code);


        session(['sel' => 'main']);
        session()->remove('sel_g');

        return view('admin/index', $this->data);
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

    public function index($group): string
    {
        $data = Main::pager(['group' => $group, 'limit' => 12, 'sort' => request()->input('sort')]);

        return view("admin/$group/index", [
            'posts' => $data->items(),
            'pager' => $data->links(),
            'sel' => $group,
        ]);
    }
}
