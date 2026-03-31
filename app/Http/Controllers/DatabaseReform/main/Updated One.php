<?php

$posts = DB::connection('mysql')->table('posts')->where('group', 'social')->get();
$model = new Main();
//        Main::where('group', 'social')->delete();
//        $model->truncate();
dd($posts);
$menu = Main::gets(['group' => 'social', 'orderBy' => 'created_at', 'except' => ['content', 'short_content']]);
//        dd($menu);
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
    $fixed = preg_replace_callback(
        '/s:(\d+):"(.*?)";/s',
        function ($matches) {
            return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
        },
        $item->content
    );
    $content = unserialize($item->content);
//            $content_2 = unserialize($item->category_title);
//            $category_title = unserialize($item->category_title);
//            $category_title = $this->replaceUploads($category_title);
    $content = $this->replaceUploads($content);
//            $content_2 = $this->replaceUploads($content_2);
    $title = $this->replaceUploads($title);
    $short_content = unserialize($item->short_content);
    $short_content = $this->replaceUploads($short_content);
    $model->my_save([
        'short_content' => $short_content,
        'content' => $content,
//                'content_2' => $content_2,
        'files' => $files,
        'title' => $title,
        'group' => 'social',
        'created_at' => $item->created_on,
        'updated_at' => $item->updated_on,
//                'views' => $item->views,
        'options' => $item->option_1,
        'sort_order' => $item->sort_order,
        'status' => $item->status == 'active',
        'alias' => char_lim(trim($item->alias), 50),
    ]);
}
