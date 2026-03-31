<?php

use App\Models\Video_materials;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'social_rol'])->orderBy('sort_order')->get();

Video_materials::truncate();
$model = new Video_materials();

foreach ($posts as $item) {
    $title = unserialize($item->title);
    try {
        $content = unserialize($item->short_content);
    } catch (\Exception $ignored) {
        $content = [];
    }
    $video_code = unserialize($item->content_1);
    $content = $this->replaceUploads($content);
    $video_code = $this->replaceUploads($video_code);

    $model->my_save([
        'title' => $title,
        'content' => $content,
        'video_code' => $video_code,

        'group' => 'social-video',
        'img' => $item->video_img,

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,
        'keywords' => $item->keywords,
        'description' => $item->description,
        'views' => $item->views,

        'options' => $item->option == 'yes',
        'status' => $item->status == 'active',
        'alias' => $item->alias,
    ]);
}
