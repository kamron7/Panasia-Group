<?php

use App\Models\Federations;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'federation_category', 'category_id' => '48'])->orderBy('sort_order')->get();

$model = new Federations();

foreach ($posts as $item) {

    $title = unserialize($item->title);

    $model->my_save([
        'title' => $title,

        'group' => 'international',
        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
    ]);
}
