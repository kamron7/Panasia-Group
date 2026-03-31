<?php

$posts = DB::connection('mysql')->table('posts')->where(['group' => 'pages'])->limit(1000)->get();
$model = new Pages();

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
    $short_content = unserialize($item->short_content);
    $html_content = unserialize($item->content_html);

    $content = $this->replaceUploads($content);
    $short_content = $this->replaceUploads($short_content);
    $html_content = $this->replaceUploads($html_content);

    $model->my_save([
        'title' => $title,
        'content' => $content,
        'short_content' => $short_content,
        'html_content' => $html_content,

        'files' => $files,

        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,

        'options' => $item->options,
        'status' => $item->status == 'active',
    ]);
}
