<?php

use App\Models\Main;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'social'])->get();

$model = new Main();

foreach ($posts as $item) {
    $title = unserialize($item->title);

    $model->my_save([
        'title' => $title,
        'group' => 'social',
        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'options' => $item->option_1,
        'status' => $item->status == 'active',
        'alias' => $item->alias,
    ]);
}
