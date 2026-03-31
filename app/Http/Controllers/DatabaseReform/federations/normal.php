<?php

use App\Models\Federations;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'sports_federations'])->orderBy('sort_order')->get();

$model = new Federations();

foreach ($posts as $item) {

    $title = unserialize($item->title);
    $content = unserialize($item->content);
    $content = $this->replaceUploads($content);
    $model->my_save([
        'title' => $title,
        'content' => $content,

        'group' => 'normal',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,
    ]);
}
