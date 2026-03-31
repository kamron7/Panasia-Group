<?php

use App\Models\Video;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'video'])->orderBy('sort_order')->limit(1000)->get();
$model = new Video();

foreach ($posts as $item) {

    $title = unserialize($item->title);
    $content = unserialize($item->content);
    $code = unserialize($item->content_1);

    $content = $this->replaceUploads($content);
    $code = $this->replaceUploads($code);

    $model->my_save([
        'title' => $title,
        'content' => $content,
        'code' => $code,

        'img' => $item->video_img,

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
