$posts = Main::all();

foreach ($posts as $post) {
$updated = false;
$files = $post->files ?? [];

foreach ($files as &$file) {
if (!isset($file->lang) || $file->lang === null || $file->lang === '') {
$file->lang = 'all';
$updated = true;
}
}

if ($updated) {
$post->files = $files;
$post->save();
}
}

$posts = Main::all();

foreach ($posts as $post) {
$updated = false;
$images = $post->images ?? [];

foreach ($images as &$image) {
if (!isset($image->lang) || $image->lang === null || $image->lang === '') {
$image->lang = 'all';
$updated = true;
}
}

if ($updated) {
$post->images = $images;
$post->save();
}
}
