<?php

use App\Models\Manage;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'manage', 'category_id' => '24'])->orderBy('sort_order')->get();

$model = new Manage();

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
    $content = unserialize($item->category_title);
    $video_code = unserialize($item->content_1);
    $content = $this->replaceUploads($content);
    $video_code = $this->replaceUploads($video_code);

    $model->my_save([
        'title' => $title,
        'post' => $content,
        'reception' => $video_code,

        'images' => $files,
        'group' => 'ispolnitelnyj-komitet',

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'phone' => $item->value_1,
        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
