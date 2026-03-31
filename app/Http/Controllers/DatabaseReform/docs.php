//
//        $posts = DB::connection('mysql_old')
//            ->table('posts')
//            ->where(['group' => 'docs'])
//            ->orderBy('sort_order')
//            ->get();
//
//        $model = new Docs();
//        $model->truncate();
//
//        foreach ($posts as $item) {
//            try {
//                $media = DB::connection('mysql_old')
//                    ->table('media')
//                    ->where(['post_id' => $item->id])
//                    ->get();
//
//                $files = [];
//                if ($media) {
//                    $i = 0;
//                    foreach ($media as $file) {
//                        $files[] = [
//                            'id'         => $i,
//                            'url'        => $file->url,
//                            'ext'        => $file->file_ext,
//                            'size'       => $file->file_size,
//                            'is_main'    => $file->is_main,
//                            'sort_order' => $i++,
//                        ];
//                    }
//                }
//
//                $title   = unserialize($item->title);
//                $content = unserialize($item->content);
//                $content = $this->replaceUploads($content);
//
//                // Sanitize dates before saving
//                $createdAt = $this->sanitizeDatetime($item->created_on);
//                $updatedAt = $this->sanitizeDatetime($item->updated_on);
//
//                $model->my_save([
//                    'title'       => $title,
//                    'content'     => $content,
//                    'files'       => $files,
//                    'cat_id'      => $item->category_id,
//                    'id'      => $item->id,
//                    'group'       => 'analitik',
//                    'created_at'  => $createdAt,
//                    'updated_at'  => $updatedAt,
//                    'sort_order'  => $item->sort_order ?? 0,
//                    'status'      => $item->status == 'active',
//                    'alias'       => $item->alias,
//                ]);
//
//                // Optional: Log successful migration
//                \Log::info("Migrated document: {$item->id}");
//
//            } catch (\Exception $e) {
//                // Log the error and continue with next item
//                \Log::error("Failed to migrate document ID {$item->id}: " . $e->getMessage());
//                continue;
//            }
//        }
//





THIS ONE FOR ALL

//        $posts = DB::connection('mysql_old')
//            ->table('posts as d')
//            ->leftJoin('posts as p', 'd.category_id', '=', 'p.id')
//            ->where('d.group', 'docs')
//            ->orderBy('d.sort_order')
//            ->select('d.*', 'p.group as parent_group')
//            ->get();
//
//        $model = new Docs();
//        $model->truncate();
//
//        foreach ($posts as $item) {
//            try {
//                $media = DB::connection('mysql_old')
//                    ->table('media')
//                    ->where('post_id', $item->id)
//                    ->get();
//
//                $files = [];
//                if ($media) {
//                    $i = 0;
//                    foreach ($media as $file) {
//                        $files[] = [
//                            'id'         => $i,
//                            'url'        => $file->url,
//                            'ext'        => $file->file_ext,
//                            'size'       => $file->file_size,
//                            'is_main'    => $file->is_main,
//                            'sort_order' => $i++,
//                        ];
//                    }
//                }
//
//                // TITLE / CONTENT
//                $title   = @unserialize($item->title);
//                $content = @unserialize($item->content);
//
//                if (!is_array($title))   $title   = [];
//                if (!is_array($content)) $content = [];
//
//                $content = $this->replaceUploads($content);
//
//                // DATES
//                $createdAt = $this->sanitizeDatetime($item->created_on);
//                $updatedAt = $this->sanitizeDatetime($item->updated_on);
//
//                $docGroup = $item->parent_group ?: 'docs';
//
//                $model->my_save([
//                    'id'         => $item->id,              // keep the same doc id if you want
//                    'title'      => $title,
//                    'content'    => $content,
//                    'files'      => $files,
//
//                    'cat_id'     => $item->category_id,     // parent post id (e.g. 6423)
//                    'group'      => $docGroup,              // e.g. 'analitik'
//
//                    'created_at' => $createdAt,
//                    'updated_at' => $updatedAt,
//                    'sort_order' => $item->sort_order ?? 0,
//                    'status'     => $item->status == 'active',
//                    'alias'      => $item->alias,
//                ]);
//
//                \Log::info("Migrated doc: {$item->id} (group={$docGroup}, cat_id={$item->category_id})");
//
//            } catch (\Exception $e) {
//                \Log::error("Failed to migrate document ID {$item->id}: " . $e->getMessage());
//                continue;
//            }
//        }
