<?php

namespace App\Libraries;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaLib
{

    public function __construct()
    {
        foreach (getTables() as $key => $item) {
            $this->$key = getTables()[$key];
        }
    }

    public function save($data): array
    {
        $user = auth()->user();
        $userId = $user ? $user->id : null;
        $banKey = 'upload_ban_until';
        $attemptsKey = 'upload_malicious_attempts';

        $now = now();
        if (session()->has($banKey)) {
            $banUntil = session($banKey);
            if ($now->lt($banUntil)) {
                $secondsLeft = $now->diffInSeconds($banUntil);
                return ['err' => "Вы заблокированы на загрузку файлов. Попробуйте через " . gmdate("i:s", $secondsLeft) . " минут."];
            } else {
                session()->forget($banKey);
                session()->forget($attemptsKey);
            }
        }
        $files = request()->file('userfile');
        if (!$files || empty($files)) {
            return ['err' => 'Файлы не загружены.'];
        }
        $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
        $pdfExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];

        foreach ($files as $file) {
            $ext = strtolower($file->getClientOriginalExtension());
            $isVideo = in_array($ext, $videoExtensions);
            $isImage = in_array($ext, $imageExtensions);
            $isPdf = in_array($ext, $pdfExtensions);

            if (!$isVideo && $this->containsMaliciousContent($file)) {
                $attempts = session($attemptsKey, 0) + 1;
                session([$attemptsKey => $attempts]);

                $leftAttempts = 3 - $attempts;

                if ($attempts >= 3) {
                    session([$banKey => $now->addMinutes(5)]);
                    session()->forget($attemptsKey);

                    return ['err' => 'Вы превысили лимит попыток загрузки вредоносных файлов. Блокировка на 5 минут.'];
                } else {
                    return ['err' => "Файл содержит потенциально вредоносный контент: " . $file->getClientOriginalName() .
                        ". Осталось попыток до блокировки: $leftAttempts"];
                }
            }

            if ($isVideo) {
                $sizeLimit = 52428800;
            } elseif ($isPdf) {
                $sizeLimit = 20971520;
            } else {
                $sizeLimit = 5242880;
            }

            if ($file->getSize() > $sizeLimit) {
                session()->flash('upload_error', 'Размер файла превышает лимит (' . round($sizeLimit / 1048576) . 'MB): ' . $file->getClientOriginalName());
                return ['err' => 'Размер файла превышает лимит (' . round($sizeLimit / 1048576) . 'MB): ' . $file->getClientOriginalName()];
            }

        }

        session()->forget($attemptsKey);
        session()->forget($banKey);
        $model = $data['model'];
        $id = 0;
        if ($data['type'] == 'create') {
            session()->forget($this->getSessionName($model));
        }
        if ($data['type'] == 'create') {
            $item_files = session($this->getSessionName($model), []);
        } else {
            $item = $this->$model::getById($data['post_id']);
            if (!$item) {
                return ['err' => 'Item not found'];
            }
            $col = getColName($item);
            if (!$col) {
                return ['err' => 'Ошибка: проверьте, соответствует ли таблица функции getColName'];
            }
            $item_files = $item->$col ?? [];
        }

        if ($item_files) {
            $ids = array_column((array)$item_files, 'id');
            $id = max($ids) + 1;
        }

        $new_data = [];

        $relativePath = ($data['type'] !== 'create') ? "uploads/{$data['category']}" : "temp/{$data['category']}";
        $fullPath = storage_path("app/public/{$relativePath}");

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        foreach ($files as $file) {
            if ($file->isValid()) {
                $ext = strtolower($file->getClientOriginalExtension());
                $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
                $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
                $isImage = in_array($ext, $imageExtensions);
                $isVideo = in_array($ext, $videoExtensions);
                $isSvg = $ext === 'svg';
                $isGif = $ext === 'gif';
                $isPdf = $ext === 'pdf';

                try {
                    if ($isVideo) {
                        $newName = $file->hashName();
                        $storedPath = $file->storeAs("public/{$relativePath}", $newName);
                        if (!$storedPath) {
                            \Log::error("File storage failed", [
                                'file' => $newName,
                                'path' => "public/{$relativePath}",
                                'error' => error_get_last()
                            ]);
                            throw new \Exception("Не удалось загрузить файл");
                        }

                        $absolutePath = storage_path("app/{$storedPath}");
                        if (!file_exists($absolutePath)) {
                            \Log::error("File not found after storage", ['path' => $absolutePath]);
                            throw new \Exception("File not saved properly");
                        }

                        $fileSize = Storage::size($storedPath);
                    } elseif ($isImage) {
                        $originalName = $file->getClientOriginalName();
                        $base = pathinfo($originalName, PATHINFO_FILENAME);
                        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                        $newName = uniqid(Str::slug($base) . '_', true) . '.' . $ext;

                        $storedPath = $file->storeAs("public/{$relativePath}", $newName);
                        if (!$storedPath) {
                            throw new \Exception("Не удалось загрузить файл");
                        }
                        $fileSize = Storage::size($storedPath);

                    } else {
                        $originalName = $file->getClientOriginalName();
                        $base = pathinfo($originalName, PATHINFO_FILENAME);
                        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
                        $newName = uniqid(Str::slug($base) . '_', true) . '.' . $ext;

                        $storedPath = $file->storeAs("public/{$relativePath}", $newName);
                        if (!$storedPath) {
                            throw new \Exception("Не удалось загрузить файл");
                        }
                        if ($isPdf && $file->getMimeType() !== 'application/pdf') {
                            Storage::delete("public/{$relativePath}/{$newName}");
                            throw new \Exception("Invalid PDF file");
                        }


                        $fileSize = Storage::size($storedPath);
                    }

                    $filePath = storage_path("app/public/{$relativePath}/{$newName}");
                    if (!file_exists($filePath)) {
                        throw new \Exception("Файл не был правильно сохранен.");
                    }
                    if ($isPdf && $file->getMimeType() !== 'application/pdf') {
                        throw new \Exception("Invalid PDF file");
                    }
                    $new_data[] = (object)[
                        'id' => $id,
                        'sort_order' => $id++,
                        'url' => $newName,
                        'ext' => $ext,
                        'size' => $fileSize,
                        'is_main' => '0',
                        'uploaded_at' => now()->toDateTimeString(),
                        'ip' => request()->ip(),
                        'user_id' => $userId,
                        'type' => $isVideo ? 'video' : ($isImage ? 'image' : 'file'),
                        'lang' => request()->input('lang', 'all'),
                        'duration' => $isVideo ? ($meta['duration'] ?? null) : null,
                        'is_thumnail' => 0,
                        'is_preview' => 0,
                        'video_id' => null,

                    ];

                    \Log::debug('Media data flow:', [
                        'model' => $model,
                        'session_key' => $this->getSessionName($model),
                        'existing_files' => $item_files,
                        'new_files' => $new_data
                    ]);

                } catch (\Exception $e) {
                    error_log('File processing failed: ' . $e->getMessage());
                    continue;
                }
            }
        }

        $item_files = array_merge($item_files, $new_data);

        if ($data['type'] !== 'create') {
            $this->$model->my_save([$col => $item_files], $item->id);
        } else {
            session([$this->getSessionName($model) => $item_files]);
        }

        return $new_data;
    }

    private function processImageToWebP(string $sourcePath, string $destinationPath, int $maxWidth = 1200, int $quality = 85): ?string
    {
        list($originalWidth, $originalHeight, $type) = getimagesize($sourcePath);

        $newWidth = $originalWidth;
        $newHeight = $originalHeight;

        if ($maxWidth && $originalWidth > $maxWidth) {
            $ratio = $originalHeight / $originalWidth;
            $newWidth = $maxWidth;
            $newHeight = (int)round($maxWidth * $ratio);
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                throw new \Exception("Unsupported image type");
        }

        if (!$image) {
            throw new \Exception("Failed to create image resource");
        }

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        $result = imagewebp($newImage, $destinationPath, $quality);
        imagedestroy($newImage);
        imagedestroy($image);

        if (!$result) {
            throw new \Exception("Failed to save WebP image");
        }

        return $destinationPath;
    }

    private function containsMaliciousContent($file): bool
    {
        if (!$file->isValid()) {
            return true;
        }
        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
            'pdf', 'doc', 'docx', 'xls', 'xlsx',
            'mp4', 'mov', 'avi', 'mkv', 'webm'
        ];

        $allowedMimeTypes = [
            'image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-matroska', 'video/webm'
        ];

        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType();

        if (!in_array($extension, $allowedExtensions) || !in_array($mimeType, $allowedMimeTypes)) {
            return true;
        }

        if (preg_match('/\.(php|phtml|phar|js|exe|dll|bat|cmd|sh|py|pl)\.[a-z0-9]+$/i', $file->getClientOriginalName())) {
            return true;
        }

        if (str_starts_with($mimeType, 'image/') || str_starts_with($mimeType, 'video/')) {
            return false;
        }

        $content = file_get_contents($file->getRealPath(), false, null, 0, 1048576);

        $dangerousPatterns = [
            '/<\?php/i',
            '/<script[^>]*>.*?<\/script>/is',
            '/javascript\s*:/i',
            '/onerror\s*=/i',
            '/eval\s*\(/i',
            '/base64_decode\s*\(/i',
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }


    private function isMaliciousImage(string $filePath): bool
    {
        try {
            $imageInfo = getimagesize($filePath);
            if (!$imageInfo) return true;

            $width = $imageInfo[0] ?? 0;
            $height = $imageInfo[1] ?? 0;

            if ($width > 10000 || $height > 10000) {
                return true;
            }

            if (function_exists('exif_read_data') && in_array($imageInfo[2], [IMAGETYPE_JPEG, IMAGETYPE_TIFF_II, IMAGETYPE_TIFF_MM])) {
                $exif = @exif_read_data($filePath);
                if ($exif) {
                    foreach ($exif as $key => $value) {
                        if (is_string($value) && preg_match('/<\?php/i', $value)) {
                            return true;
                        }
                    }
                }
            }

            return false;
        } catch (\Exception $e) {
            return true;
        }
    }

    public function delete($model, $post_id, $id): void
    {
        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
            $folder = 'uploads/';
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
            $folder = 'temp/';
        }

        $updatedMedia = [];
        $deleted = false;

        foreach ($media as $file) {
            if ($file->id == $id) {
                $filePath = "$model/$file->url";
                if (file_exists(storage_path("app/public/$folder$filePath"))) {
                    unlink(storage_path("app/public/$folder$filePath"));
                }
                $deleted = true;
                continue;
            }
            $updatedMedia[] = $file;
        }

        if ($deleted) {
            $updatedMedia = array_values($updatedMedia); // Re-index array

            if ($post_id != -1) {
                $this->$model->my_save([$col => $updatedMedia], $item->id);
            } else {
                session([$this->getSessionName($model) => $updatedMedia]);
            }
        }

        echo 'deleted';
    }

    public function delete_all($model, $post_id): void
    {
        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
            $folder = 'uploads/';
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
            $folder = 'temp/';
        }

        foreach ($media as $file) {
            $filePath = "$model/$file->url";
            $fullPath = storage_path("app/public/$folder$filePath");
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        if ($post_id != -1) {
            $this->$model->my_save([$col => []], $item->id);
        } else {
            session()->forget($this->getSessionName($model));
        }
    }

    public function set_main($id, $model, $post_id)
    {
        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $item->$col ?? [];
        } else {
            $media = session($this->getSessionName($model));
        }

        $media = array_map(function ($file) {
            return is_object($file) ? $file : (object)$file;
        }, $media);

        foreach ($media as $file) {
            if (!isset($file->type)) {
                $ext = strtolower(pathinfo($file->url, PATHINFO_EXTENSION));
                $file->type = in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' :
                    (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file');
            }
        }

        foreach ($media as $file) {
            $file->is_main = ($file->id == $id) ? '1' : '0';
        }

        $media = array_values($media);

        if ($post_id != -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }


        return response()->json([
            'success' => true,
            'main_id' => $id
        ]);
    }


    public function sort($model, $post_id, $items): void
    {
        if (is_string($items)) {
            $decoded = json_decode($items, true);
        } elseif (is_array($items)) {
            $decoded = $items;
        } else {
            \Log::warning('Invalid sort payload', ['items' => $items]);
            return;
        }

        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
        }

        $sortMap = [];
        foreach ($decoded as $it) {
            $sortMap[$it['id']] = $it['sort_order'];
        }

        foreach ($media as $file) {
            if (isset($sortMap[$file->id])) {
                $file->sort_order = $sortMap[$file->id];
            }
        }

        usort($media, fn($a, $b) => $a->sort_order <=> $b->sort_order);

        if ($post_id != -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }
    }


    public function getSessionName($model): string
    {
        return $model == 'docs' ? 'docs_media' : 'media_files';
    }

    public static function saveUpload($files, $folder): void
    {
        foreach ($files as $item) {
            $source = "temp/{$folder}/{$item->url}";
            $destination = "uploads/{$folder}/{$item->url}";

            if (!Storage::exists("public/uploads/{$folder}")) {
                Storage::makeDirectory("public/uploads/{$folder}", 0755, true);
            }

            if (!Storage::exists("public/$source")) {
                \Log::error("Source file not found during saveUpload", [
                    'source' => $source,
                    'destination' => $destination,
                    'item' => $item
                ]);
                continue;
            }

            try {
                $success = Storage::move("public/$source", "public/$destination");

                if (!$success) {
                    \Log::error("Failed to move file during saveUpload", [
                        'source' => $source,
                        'destination' => $destination
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error("Exception during saveUpload: " . $e->getMessage(), [
                    'source' => $source,
                    'destination' => $destination
                ]);
            }
        }
    }

    public static function deleteOldTemporaryFiles(): void
    {
        $expirationTime = Carbon::now()->subDay();
        $files = Storage::disk('public')->allFiles('temp');

        foreach ($files as $file) {
            $fileCreatedAt = Storage::disk('public')->lastModified($file);

            if (Carbon::createFromTimestamp($fileCreatedAt)->lt($expirationTime)) {
                Storage::disk('public')->delete($file);
            }
        }
    }

    public function update_media_data()
    {
        $request = request();
        $model = $request->input('model');
        $post_id = $request->input('post_id');
        $media_id = $request->input('media_id');

        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
        }

        $updated = false;

        foreach ($media as &$file) {
            if ($file->id == $media_id) {
                if ($file->type === 'video') {
                    return response()->json(['success' => false, 'message' => 'Video metadata cannot be edited']);
                }

                $file->name = $request->input('file_name', pathinfo($file->url, PATHINFO_FILENAME));
                $file->alt = $request->input('alt_text', '');
                $file->title = $request->input('title', '');
                $file->description = $request->input('description', '');
                $updated = true;
                break;
            }
        }

        if ($updated) {
            if ($post_id != -1) {
                $this->$model->my_save([$col => $media], $item->id);
            } else {
                session([$this->getSessionName($model) => $media]);
            }
            return response()->json(['success' => true, 'message' => 'Data updated successfully']);
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    public function update_media_image()
    {
        $request = request();
        $model = $request->input('model');
        $post_id = $request->input('post_id');
        $media_id = $request->input('media_id');
        $category = $request->input('category', '');

        if (!$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'No image file received']);
        }

        // Check if the file is a video
        $item = $this->$model::getById($post_id);
        $col = getColName($item);
        $media = $item->$col ?? [];

        foreach ($media as $file) {
            if ($file->id == $media_id && $file->type === 'video') {
                return response()->json(['success' => false, 'message' => 'Videos cannot be edited']);
            }
        }

        $image = $request->file('image');
        $isTemporary = ($post_id == -1);
        $folder = $isTemporary ? 'temp' : 'uploads';
        $storagePath = "{$folder}/{$category}";

        if ($isTemporary) {
            $media = session($this->getSessionName($model), []);
        } else {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $item->$col ?? [];
        }

        $updatedMedia = null;
        $newUrl = null;

        foreach ($media as &$file) {
            if ($file->id == $media_id) {
                $originalExt = strtolower(pathinfo($file->url, PATHINFO_EXTENSION));
                $isGif = ($originalExt === 'gif');

                $oldPath = "public/{$storagePath}/{$file->url}";
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }

                $newName = pathinfo($file->url, PATHINFO_FILENAME) . '.' . ($isGif ? 'gif' : 'webp');

                $ext = strtolower($image->getClientOriginalExtension());
                $newName = pathinfo($file->url, PATHINFO_FILENAME) . '.' . $ext;
                $storedPath = $image->storeAs("public/{$storagePath}", $newName);
                if (!$storedPath) {
                    return response()->json(['success' => false, 'message' => 'Failed to store image file']);
                }

                $file->url = $newName;
                $file->ext = $ext;
                $file->size = Storage::size("public/{$storagePath}/{$newName}");

                $updatedMedia = $file;
                $newUrl = Storage::url("{$storagePath}/{$newName}") . '?t=' . time();
                break;
            }
        }

        if ($updatedMedia) {
            if ($isTemporary) {
                session([$this->getSessionName($model) => $media]);
            } else {
                $this->$model->my_save([$col => $media], $item->id);
            }

            return response()->json([
                'success' => true,
                'new_url' => $newUrl,
                'media_id' => $media_id,
                'media' => $updatedMedia
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    public function get_media_data($model, $post_id, $id)
    {
        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $item->$col ?? [];
        } else {
            $media = session($this->getSessionName($model));
        }

        foreach ($media as &$file) {
            $file = (object)$file;
            if (!isset($file->type)) {
                $ext = strtolower(pathinfo($file->url, PATHINFO_EXTENSION));
                $file->type = in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' :
                    (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file');
            }
        }
        foreach ($media as $file) {
            if ($file->id == $id) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'is_image' => $file->type === 'image',
                        'is_video' => $file->type === 'video',
                        'is_file' => $file->type === 'file'
                    ]
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    private function normalizeMediaItems($items)
    {
        return array_map(function ($item) {
            $obj = is_object($item) ? $item : (object)$item;

            if (!isset($obj->type)) {
                $ext = strtolower(pathinfo($obj->url, PATHINFO_EXTENSION));
                $obj->type = in_array($ext, ['mp4', 'webm', 'mov']) ? 'video' :
                    (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file');
            }

            return $obj;
        }, $items);
    }

    public static function filterByLanguage($mediaItems, $language = null)
    {
        if (empty($language)) {
            return $mediaItems;
        }

        return array_filter($mediaItems, function ($item) use ($language) {
            return !isset($item->lang) || $item->lang === 'all' || $item->lang === $language;
        });
    }

    public function update_lang($model, $post_id, $id)
    {
        $validLanguages = ['all', 'ru', 'en', 'oz', 'uz'];
        $lang = request()->input('lang', 'all');

        if (!in_array($lang, $validLanguages)) {
            return response()->json(['success' => false, 'message' => 'Invalid language']);
        }

        if ($post_id != -1) {
            $item = $this->$model::getById($post_id);
            $col = getColName($item);
            $media = $item->$col ?? [];
        } else {
            $media = session($this->getSessionName($model), []);
        }

        foreach ($media as &$file) {
            if ($file->id == $id) {
                $file->lang = $lang;
                break;
            }
        }

        if ($post_id != -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }

        return response()->json(['success' => true]);
    }

    public function update_media_svg_color()
    {
        $request = request();
        $model = $request->input('model');
        $postId = (int)$request->input('post_id', -1);
        $mediaId = (int)$request->input('media_id');
        $category = $request->input('category', '');
        $color = trim((string)$request->input('color', ''));
        $target = $request->input('target', 'both'); // 'fill' | 'stroke' | 'both'

        if (!$this->isValidHexColor($color)) {
            return response()->json(['success' => false, 'message' => 'Invalid color'], 422);
        }
        if (!in_array($target, ['fill', 'stroke', 'both'], true)) {
            $target = 'both';
        }

        // Load media list (temp or persisted)
        if ($postId !== -1) {
            $item = $this->$model::getById($postId);
            if (!$item) return response()->json(['success' => false, 'message' => 'Item not found'], 404);

            $col = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
            $folderRoot = 'uploads';
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
            $folderRoot = 'temp';
        }

        // Find the SVG
        $fileRef = null;
        foreach ($media as &$m) {
            if ((int)$m->id === $mediaId) {
                $ext = strtolower(pathinfo($m->url, PATHINFO_EXTENSION));
                if ($ext !== 'svg') {
                    return response()->json(['success' => false, 'message' => 'Only SVG files can be recolored'], 400);
                }
                $fileRef = &$m;
                break;
            }
        }
        if (!$fileRef) {
            return response()->json(['success' => false, 'message' => 'File not found'], 404);
        }

        $storagePath = "public/{$folderRoot}/{$category}/{$fileRef->url}";
        if (!\Storage::exists($storagePath)) {
            return response()->json(['success' => false, 'message' => 'SVG not found on disk'], 404);
        }

        // Read contents
        $svg = \Storage::get($storagePath);

        // Edit colors safely
        try {
            $svgEdited = $this->recolorSvgContents($svg, $color, $target);
        } catch (\Exception $e) {
            \Log::error('SVG recolor failed', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to recolor SVG'], 500);
        }

        // Save back
        \Storage::put($storagePath, $svgEdited);

        // Bust caches on the client
        $newUrl = \Storage::url("{$folderRoot}/{$category}/{$fileRef->url}") . '?t=' . time();

        // Persist updated media list if needed
        if ($postId !== -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }

        return response()->json([
            'success' => true,
            'new_url' => $newUrl,
            'media_id' => $mediaId,
            'color' => $color,
            'target' => $target,
        ]);
    }

    private function recolorSvgContents(string $svg, string $hexColor, string $target = 'both'): string
    {
        // Parse safely (don’t expand entities)
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $old = libxml_use_internal_errors(true);
        $loaded = $dom->loadXML($svg, LIBXML_NONET | LIBXML_COMPACT | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_use_internal_errors($old);
        if (!$loaded) {
            throw new \Exception('Invalid SVG XML');
        }

        // Sanitize script/on* stuff
        $this->stripDangerousFromSvgDom($dom);

        $xpath = new \DOMXPath($dom);

        // 1) Rewrite class-based rules inside <style> blocks
        foreach ($xpath->query('//style') as $styleNode) {
            /** @var \DOMElement $styleNode */
            $css = $styleNode->textContent ?? '';

            if ($target !== 'stroke') {
                // replace any non-'none' fill and 'currentColor'
                $css = preg_replace('/(?i)(fill\s*:\s*)(?!none\b)[^;]+(?=;)/', '$1' . $hexColor, $css);
                $css = preg_replace('/(?i)fill\s*:\s*currentColor\b/', 'fill: ' . $hexColor, $css);
            }
            if ($target !== 'fill') {
                $css = preg_replace('/(?i)(stroke\s*:\s*)(?!none\b)[^;]+(?=;)/', '$1' . $hexColor, $css);
                $css = preg_replace('/(?i)stroke\s*:\s*currentColor\b/', 'stroke: ' . $hexColor, $css);
            }
            // keep CSS as text content (not CDATA) to stay simple
            while ($styleNode->firstChild) $styleNode->removeChild($styleNode->firstChild);
            $styleNode->appendChild($dom->createTextNode($css));
        }

        // 2) Walk all elements and update inline styles + attributes
        $nodes = $xpath->query('//*');
        foreach ($nodes as $el) {
            if (!($el instanceof \DOMElement)) continue;

            $name = strtolower($el->nodeName);
            // don’t recolor paint servers; we’ll keep gradients intact
            if (in_array($name, ['lineargradient', 'radialgradient', 'pattern', 'mask', 'clippath'], true)) {
                continue;
            }

            $style = $el->getAttribute('style');

            if ($target !== 'stroke') {
                // inline style fill
                if ($style !== '') {
                    $style = preg_replace('/(?i)(fill\s*:\s*)(?!none\b)[^;]+/', '$1' . $hexColor . ' !important', $style);
                    $style = preg_replace('/(?i)fill\s*:\s*currentColor\b/', 'fill: ' . $hexColor . ' !important', $style);
                }
                // if no inline fill is present, add one (wins over class rules)
                if (!preg_match('/(?i)\bfill\s*:/', (string)$style)) {
                    // don’t force if author explicitly said "none" or gradient url(...)
                    $attr = strtolower(trim($el->getAttribute('fill')));
                    if ($attr !== 'none' && strpos($attr, 'url(') === false) {
                        $style = rtrim($style, ';') . '; fill: ' . $hexColor . ' !important;';
                    }
                }
                // also set presentation attribute when it’s there and not 'none' or gradient
                $attr = strtolower(trim($el->getAttribute('fill')));
                if ($attr !== '' && $attr !== 'none' && strpos($attr, 'url(') === false) {
                    $el->setAttribute('fill', $hexColor);
                }
            }

            if ($target !== 'fill') {
                // inline style stroke
                if ($style !== '') {
                    $style = preg_replace('/(?i)(stroke\s*:\s*)(?!none\b)[^;]+/', '$1' . $hexColor . ' !important', $style);
                    $style = preg_replace('/(?i)stroke\s*:\s*currentColor\b/', 'stroke: ' . $hexColor . ' !important', $style);
                }
                if (!preg_match('/(?i)\bstroke\s*:/', (string)$style)) {
                    $attr = strtolower(trim($el->getAttribute('stroke')));
                    if ($attr !== 'none' && strpos($attr, 'url(') === false) {
                        $style = rtrim($style, ';') . '; stroke: ' . $hexColor . ' !important;';
                    }
                }
                $attr = strtolower(trim($el->getAttribute('stroke')));
                if ($attr !== '' && $attr !== 'none' && strpos($attr, 'url(') === false) {
                    $el->setAttribute('stroke', $hexColor);
                }
            }

            if ($style !== '') {
                $el->setAttribute('style', trim($style));
            }
        }

        // 3) Support "currentColor"
        $svgEl = $dom->getElementsByTagName('svg')->item(0);
        if ($svgEl instanceof \DOMElement) {
            $svgEl->setAttribute('style',
                trim(rtrim($svgEl->getAttribute('style'), ';') . "; color: {$hexColor};")
            );
        }

        // 4) Final override to catch class-only, <use>, <symbol>, and sprites.
        //    Preserve 'none' and gradients.
        $rules = [];
        if ($target !== 'stroke') {
            $rules[] = '*:not([fill="none"]):not([fill^="url("]):not([style*="fill:url("]){fill:' . $hexColor . ' !important;}';
        }
        if ($target !== 'fill') {
            $rules[] = '*:not([stroke="none"]):not([stroke^="url("]):not([style*="stroke:url("]){stroke:' . $hexColor . ' !important;}';
        }
        if ($rules) {
            $styleNode = $dom->createElement('style', implode('', $rules));
            $styleNode->setAttribute('type', 'text/css');
            $svgEl?->appendChild($styleNode);
        }

        // Return just the <svg> element
        return $dom->saveXML($dom->documentElement);
    }


    private function replaceStyleColor(string $style, string $hexColor, string $target): string
    {
        // normalize: remove spaces around colons/semicolons minimally
        // Replace fill/stroke values but keep other properties intact.
        if ($target !== 'stroke') {
            // fill: <anything not 'none'>
            $style = preg_replace('/(?i)(fill\s*:\s*)(?!none\b)[^;]+/', '$1' . $hexColor, $style);
        }
        if ($target !== 'fill') {
            $style = preg_replace('/(?i)(stroke\s*:\s*)(?!none\b)[^;]+/', '$1' . $hexColor, $style);
        }
        return $style;
    }

    private function stripDangerousFromSvgDom(\DOMDocument $dom): void
    {
        $xpath = new \DOMXPath($dom);

        // Remove <script> nodes
        foreach ($xpath->query('//script') as $n) {
            $n->parentNode?->removeChild($n);
        }

        // Remove on* event attributes (onload, onclick, etc.)
        foreach ($xpath->query('//*') as $el) {
            if (!($el instanceof \DOMElement)) continue;
            $rm = [];
            foreach ($el->attributes ?? [] as $attr) {
                if (stripos($attr->name, 'on') === 0) {
                    $rm[] = $attr->name;
                }
                if (in_array(strtolower($attr->name), ['href', 'xlink:href'], true) &&
                    preg_match('/^https?:/i', $attr->value)) {
                    $rm[] = $attr->name;
                }
            }
            foreach ($rm as $name) $el->removeAttribute($name);
        }
    }

    private function isValidHexColor(string $color): bool
    {
        return (bool)preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $color);
    }

    private function extractVideoPosterAndMeta(string $absoluteVideoPath, string $publicRelativeDir, string $baseName): array
    {
        $posterName = $baseName . '.jpg';
        $posterStoragePath = "public/{$publicRelativeDir}/{$posterName}";
        $posterAbsPath = storage_path("app/{$posterStoragePath}");

        if (!file_exists(dirname($posterAbsPath))) {
            mkdir(dirname($posterAbsPath), 0755, true);
        }

        $ffmpeg = \FFMpeg\FFMpeg::create();
        $ffprobe = \FFMpeg\FFProbe::create();

        $duration = (float)$ffprobe->format($absoluteVideoPath)->get('duration');
        $streams = $ffprobe->streams($absoluteVideoPath)->videos()->first();
        $width = $streams ? $streams->get('width') : null;
        $height = $streams ? $streams->get('height') : null;

        $video = $ffmpeg->open($absoluteVideoPath);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(1));
        $frame->save($posterAbsPath);

        return [
            'poster_name' => $posterName,
            'poster_url' => \Storage::url(str_replace('public/', '', $posterStoragePath)),
            'duration' => $duration,
            'width' => $width,
            'height' => $height,
        ];
    }

    public function upload_video_thumbnail()
    {
        $request   = request();
        $model     = $request->input('model');
        $postId    = (int)$request->input('post_id', -1);
        $videoId   = (int)$request->input('video_media_id');
        $category  = (string)$request->input('category', '');
        $imageFile = $request->file('thumbnail');

        if (!$imageFile || !$imageFile->isValid()) {
            return response()->json(['success' => false, 'message' => 'No valid image file received'], 422);
        }

        $imageExtensions = ['jpg','jpeg','png','gif','webp','svg'];
        $ext = strtolower($imageFile->getClientOriginalExtension());
        if (!in_array($ext, $imageExtensions, true)) {
            return response()->json(['success' => false, 'message' => 'Unsupported thumbnail format'], 415);
        }

        // Load media list
        $folderRoot = $postId !== -1 ? 'uploads' : 'temp';
        if ($postId !== -1) {
            $item = $this->$model::getById($postId);
            if (!$item) return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            $col   = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
        }

        // find the target video
        $videoRef = null;
        foreach ($media as &$m) {
            if ((int)$m->id === $videoId) { $videoRef = &$m; break; }
        }
        if (!$videoRef) return response()->json(['success' => false, 'message' => 'Video media not found'], 404);
        if (($videoRef->type ?? null) !== 'video') {
            return response()->json(['success' => false, 'message' => 'Target media is not a video'], 400);
        }

        // remove existing thumbnail for THIS video
        $replacedId = null;
        $updated = [];
        foreach ($media as $mm) {
            if (($mm->is_thumnail ?? 0) && (int)($mm->video_id ?? 0) === $videoId) {
                $p = "public/{$folderRoot}/{$category}/{$mm->url}";
                if (\Storage::exists($p)) \Storage::delete($p);
                $replacedId = (int)$mm->id;
                continue; // drop it
            }
            $updated[] = $mm;
        }
        $media = $updated;

        // new id
        $maxId = 0; foreach ($media as $mm) $maxId = max($maxId, (int)$mm->id);
        $newId = $maxId + 1;

        // store new thumb
        $storagePath = "public/{$folderRoot}/{$category}";
        $base = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeBase = \Illuminate\Support\Str::slug($base) ?: 'thumb';
        $newName = uniqid($safeBase . '_', true) . '.' . $ext;

        $storedPath = $imageFile->storeAs($storagePath, $newName);
        if (!$storedPath) return response()->json(['success' => false, 'message' => 'Failed to store thumbnail file'], 500);

        $sizeBytes = \Storage::size($storedPath);
        $publicUrl = \Storage::url(str_replace('public/', '', "{$storagePath}/{$newName}"));

        $thumbMedia = (object)[
            'id'          => $newId,
            'sort_order'  => $newId,
            'url'         => $newName,
            'ext'         => $ext,
            'size'        => $sizeBytes,
            'is_main'     => '0',
            'uploaded_at' => now()->toDateTimeString(),
            'ip'          => request()->ip(),
            'user_id'     => optional(auth()->user())->id,
            'type'        => 'image',
            'lang'        => $videoRef->lang ?? 'all',
            'is_thumnail' => 1,
            'is_preview'  => 1,
            'video_id'    => $videoId,
        ];
        $media[] = $thumbMedia;

        // assign poster back to video
        $videoRef->poster     = $newName;
        $videoRef->poster_url = $publicUrl;

        // persist
        if ($postId !== -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Thumbnail uploaded',
            'video_id'    => $videoId,
            'poster_url'  => $publicUrl . '?t=' . time(),
            'thumb_media' => $thumbMedia,
            'replaced_id' => $replacedId, // tell UI which <li> to remove
        ]);
    }

    public function get_video_thumbnail()
    {
        $request  = request();
        $model    = $request->input('model');
        $postId   = (int)$request->input('post_id', -1);
        $videoId  = (int)$request->input('video_media_id');
        $category = (string)$request->input('category', '');
        $folderRoot = $postId !== -1 ? 'uploads' : 'temp';

        $media = $postId !== -1
            ? $this->normalizeMediaItems(optional($this->$model::getById($postId))->{getColName($this->$model::getById($postId))} ?? [])
            : $this->normalizeMediaItems(session($this->getSessionName($model), []));

        foreach ($media as $m) {
            if (($m->is_thumnail ?? 0) && (int)($m->video_id ?? 0) === $videoId) {
                $url = \Storage::url("{$folderRoot}/{$category}/{$m->url}") . '?t=' . time();
                return response()->json([
                    'success' => true,
                    'thumb'   => [
                        'id'  => (int)$m->id,
                        'url' => $url,
                        'ext' => $m->ext ?? pathinfo($m->url, PATHINFO_EXTENSION),
                    ]
                ]);
            }
        }
        return response()->json(['success' => true, 'thumb' => null]);
    }

    public function delete_video_thumbnail()
    {
        $request  = request();
        $model    = $request->input('model');
        $postId   = (int)$request->input('post_id', -1);
        $videoId  = (int)$request->input('video_media_id');
        $category = (string)$request->input('category', '');

        if (!$model || !$category || !$videoId) {
            return response()->json(['success' => false, 'message' => 'Missing required fields'], 422);
        }

        // Load media list
        $folderRoot = $postId !== -1 ? 'uploads' : 'temp';
        if ($postId !== -1) {
            $item = $this->$model::getById($postId);
            if (!$item) return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            $col   = getColName($item);
            $media = $this->normalizeMediaItems($item->$col ?? []);
        } else {
            $media = $this->normalizeMediaItems(session($this->getSessionName($model), []));
        }

        $removedThumbId = null;
        $updated = [];
        foreach ($media as $m) {
            // remove ONLY the thumbnail that belongs to this video
            if (($m->is_thumnail ?? 0) && (int)($m->video_id ?? 0) === $videoId) {
                $p = "public/{$folderRoot}/{$category}/{$m->url}";
                if (\Storage::exists($p)) \Storage::delete($p);
                $removedThumbId = (int)$m->id;
                continue; // drop this thumb from the list
            }
            $updated[] = $m;
        }
        $media = $updated;

        // Also clear poster fields on the video entry (optional, if you store them)
        foreach ($media as $m) {
            if ((int)$m->id === $videoId && ($m->type ?? '') === 'video') {
                unset($m->poster, $m->poster_url);
                break;
            }
        }

        // Persist
        if ($postId !== -1) {
            $this->$model->my_save([$col => $media], $item->id);
        } else {
            session([$this->getSessionName($model) => $media]);
        }

        return response()->json([
            'success'          => true,
            'message'          => 'Thumbnail deleted',
            'video_id'         => $videoId,
            'removed_thumb_id' => $removedThumbId,
        ]);
    }


}
