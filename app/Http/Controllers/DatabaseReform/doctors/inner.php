<?php

use App\Models\Doctors;
use Illuminate\Support\Facades\DB;

$posts_c = DB::connection('mysql')->table('posts')->where(['group' => 'federation_doctors'])->orderBy('sort_order')->get();
$posts = DB::connection('mysql')->table('posts')->where(['group' => 'doctors'])->orderBy('sort_order')->get()->groupBy('category_id');

$model = new Doctors();
$i = 0;
foreach ($posts_c as $cat) {

    try {
        $alias = substr($cat->alias, 0, 24);
        $new_cat = Doctors::getByAlias($alias)->id;
        $test = $posts[$cat->id];
    } catch (\Exception $ignored) {
        echo "<pre>";
        var_dump($cat, $i);
        echo "</pre>";

        die();
    }
    foreach ($test as $item) {
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
        $content = unserialize($item->short_content);
        $content = $this->replaceUploads($content);
        $model->my_save([
            'title' => $title,
            'short_content' => $content,

            'images' => $files,
            'group' => 'medics',
            'cat_id' => $new_cat,
//
            'created_at' => $item->created_on,
            'updated_at' => $item->updated_on,

            'status' => $item->status == 'active',
            'alias' => $item->alias,
        ]);
        $i++;
    }

}
