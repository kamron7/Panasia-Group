TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU
TOGIRLANGAN MENU

$posts = DB::connection('mysql_old')
->table('posts')
->where('group', 'menu')
->orderBy('sort_order')
->get();

$model = new Menu();
$model->truncate();

foreach ($posts as $item) {
// 1) Pull media for this menu item (exactly like in social import)
$media = DB::connection('mysql_old')
->table('media')
->where('post_id', $item->id)
->limit(1000)
->get();

$files = [];
if ($media->count()) {
$i = 0;
foreach ($media as $file) {
$files[] = [
'id'         => $i,
'url'        => $file->url,
'ext'        => $file->file_ext,
'size'       => $file->file_size,
'is_main'    => $file->is_main,
'sort_order' => $i++,
];
}
}

// 2) Text fields
$title         = unserialize($item->title);
$content       = unserialize($item->content);
$short_content = unserialize($item->short_content);

$content       = $this->replaceUploads($content);
$short_content = $this->replaceUploads($short_content);

// 3) Save into new Menu
$model->my_save([
'title'         => $title,
'content'       => $content,
'short_content' => $short_content,

// 👇 keep same tree as old posts
'cat_id'        => (int) $item->category_id,
'id'            => (int) $item->id,

// 👇 attach files
'files'         => $files,

'created_at'    => $item->created_on,
'updated_at'    => $item->updated_on,

'inner_link'    => $item->options,
'external_link' => $item->option_2,

'keywords'      => $item->keywords,
'description'   => $item->description,

'sort_order'    => $item->sort_order ?? 0,
'status'        => $item->status == 'active',
'alias'         => $item->alias,
]);
}

