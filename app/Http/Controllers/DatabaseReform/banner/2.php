<?php

use App\Models\Main;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'banner1'])->orderBy('sort_order')->get();

$model = new Main();

foreach ($posts as $item) {
    $media = DB::connection('mysql')->table('media')->where(['post_id' => $item->id])->limit(1000)->get();
    $files = [];

    if ($media) {
        $i = 0;
        foreach ($media as $file) {
            $files[] = [
                'id' => $i,
                'url' => $file->url,
                'ext' => $file->file_ext,
                'size' => $file->file_size,
                'is_main' => $file->is_main,
                'sort_order' => $i++,
            ];
        }
    }
    $title = unserialize($item->title);

    $model->my_save([
        'title' => $title,

        'files' => $files,
        'group' => 'banner',
        'cat_id' => 2,

        'options' => $item->options,
        'options2' => $item->option_2,

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
