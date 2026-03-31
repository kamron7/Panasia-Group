<?php

use App\Models\Main;
use Illuminate\Support\Facades\DB;

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'olympic_news', 'category_id' => '55'])->orderBy('sort_order')->get();

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
    $content = unserialize($item->content);
    $content = $this->replaceUploads($content);
    $model->my_save([
        'title' => $title,
        'content' => $content,

        'files' => $files,
        'group' => 'youthful',
        'options' => $item->option_2,

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'status' => $item->status == 'active',
        'alias' => $item->alias,

    ]);
}
