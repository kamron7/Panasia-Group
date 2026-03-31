<?php

use App\Models\Manage;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'manage_category'])->orderBy('sort_order')->get();

$model = new Manage();

foreach ($posts as $item) {
    $title = unserialize($item->title);

    $model->my_save([
        'title' => $title,
        'group' => 'm_category',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
