<?php

use App\Models\Manage;
use Illuminate\Support\Facades\DB;

$posts_c = DB::connection('mysql')->table('posts')->where(['group' => 'manage_category'])->latest('sort_order')->get();
$new_posts = Manage::gets(['group' => 'm_category']);
$max_id = $new_posts->max('id');

$model = new Manage();
foreach ($posts_c->skip(1) as $cat) {
    $alias = $cat->alias;
    $new_cat = $new_posts->firstWhere('alias', $alias);
    $model->my_save(['sort_order' => $max_id--], $new_cat->id);
}
