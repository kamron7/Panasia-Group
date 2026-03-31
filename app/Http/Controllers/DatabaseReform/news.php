<?php

        $posts = \Illuminate\Support\Facades\DB::connection('mysql')->table('posts')->where(['group' => 'news'])->limit(1000)->offset(7000)->get();
        $model = new News();
        foreach ($posts as $item) {
//            dd($item->created_on);
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
            $alias = $item->alias;
            if ($test = News::getByAlias($alias)) {
                dd($item->id, $test->id);
            }
            $post_cat_id = DB::connection('mysql')->table('posts')->where(['id' => $item->category_id])->first()->alias ?? '-1';
            $post_cat_id = substr($post_cat_id, 0, 24);
            $cat_id = Menu::get(['alias' => $post_cat_id])->id ?? 0;
            $model->my_save([
                'title' => $title,
                'content' => $content,
                'video_code' => $video_code,
                'images' => $files,
                'cat_id' => $cat_id,
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
