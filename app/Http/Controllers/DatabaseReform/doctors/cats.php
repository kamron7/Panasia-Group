<?php

use App\Models\Doctors;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'federation_doctors'])->orderBy('sort_order')->get();

$model = new Doctors();

foreach ($posts as $item) {
    $title = unserialize($item->title);

    $model->my_save([
        'title' => $title,
        'group' => 'd_category',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,
    ]);
}
