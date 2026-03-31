<?php

use App\Models\Main;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'ioc_structure'])->orderBy('sort_order')->get();

$model = new Main();

foreach ($posts as $item) {

    $title = unserialize($item->title);
    $content = unserialize($item->content);
    $content = $this->replaceUploads($content);
    $model->my_save([
        'title' => $title,
        'content' => $content,

        'group' => 'ioc_structure',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'description' => $item->description,
        'keywords' => $item->keywords,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
