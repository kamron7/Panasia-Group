<?php

namespace App\Http\Controllers\Core;

use App\Models\Main;
use App\Models\Menu;
use App\Models\News;
use App\Models\Pages;
use Illuminate\Support\Facades\App;
use Jenssegers\Agent\Agent;

class ApiController extends MyController
{
    public function __construct()
    {
        parent::__construct();


        $lang = request()->header('Accept-Language') ?? 'oz';

        if (!defined('LANG'))
            define('LANG', $lang);
    }
}
