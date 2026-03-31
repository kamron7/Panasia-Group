<?php

use App\Models\Video_materials;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'interview'])->orderBy('sort_order')->get();

$model = new Video_materials();

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
    try {
        $content = unserialize($item->content);
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

        'images' => $files,
        'group' => 'interview',

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
