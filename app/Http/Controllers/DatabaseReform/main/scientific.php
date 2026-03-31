<?php

use App\Models\Main;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'scientific'])->orderBy('sort_order')->get();

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
    $cat_title = unserialize($item->category_title);
    $spec_type = unserialize($item->spec_type);

    $model->my_save([
        'title' => $title,
        'content' => $cat_title,
        'short_content' => $spec_type,

        'files' => $files,
        'group' => 'scientific',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'description' => $item->description,
        'keywords' => $item->keywords,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
