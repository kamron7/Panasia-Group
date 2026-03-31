\<?php

use App\Models\Sports;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'olympic_games'])->orderBy('sort_order')->get();

$model = new Sports();
foreach ($posts as $item) {

    $title = unserialize($item->title);
    $content = unserialize($item->spec_type);
    $cat_title = unserialize($item->category_title);
    $content = $this->replaceUploads($content);
    $cat_title = $this->replaceUploads($cat_title);
    
    $model->my_save([
        'title' => $title,
        'content' => $content,
        'cat_title' => $cat_title,

        'group' => 'cats',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,
        'options' => $item->value_1,

        'status' => $item->status == 'active',
        'alias' => $item->alias,
    ]);
}
