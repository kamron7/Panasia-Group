<?php

use App\Models\Docs;
use App\Models\Feedback;
use App\Models\Products;
use App\Models\Region;
use App\Models\City;
use App\Models\Gallery;
use App\Models\Ip_admin;
use App\Models\Main;
use App\Models\Manage;
use App\Models\Opendata;
use App\Models\Polls;
use App\Models\Online;
use App\Models\Menu;
use App\Models\News;
use App\Models\Pages;
use App\Models\Site;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Jenssegers\Agent\Agent;

if (!function_exists('isCurrentRoute')) {
    function isCurrentRoute($route): bool
    {
        return Route::currentRouteName() == $route;
    }
}

if (!function_exists('char_lim')) {
    function char_lim($str, $limit)
    {
        if (mb_strlen($str) > $limit)
            $str = mb_substr($str, 0, $limit) . "...";
        return $str;
    }
}
if (!function_exists('getImgMainAllLang')) {
    function getImgMainAllLang($item, $getDocs = false)
    {
        $col = getColName($item);
        if (!$col) return null;

        if ($item->$col) {
            $files = $item->$col;

            foreach ($files as $file) {
                if ((int)$file->is_main === 1) {
                    return $getDocs ? $file : $file->url;
                }
            }

            if (!empty($files)) {
                $firstFile = reset($files);
                return $getDocs ? $firstFile : $firstFile->url;
            }
        }

        return null;
    }
}
if (!function_exists('switch_uri')) {
    function switch_uri($locale): string
    {
        $segments = Request::segments();

        if (!empty($segments) && in_array($segments[0], ['en', 'ar'])) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        return url(implode('/', $segments));
    }
}
if (!function_exists('getSiteLang')) {
    function getSiteLang(): array
    {
        return [
            'en' => 'English',
            // 'ar' => 'Arabic',
        ];
    }
}

if (!function_exists('to_date')) {
    function to_date($format, $date): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('normalize_pg_timestamp')) {

    function normalize_pg_timestamp($value, bool $fallbackToNow = false, int $minYear = 1900)
    {
        if (empty($value) || $value === '0000-00-00 00:00:00') {
            return $fallbackToNow ? now() : null;
        }

        try {
            $dt = Carbon::parse($value);
            if ($dt->year <= 0 || $dt->year < $minYear) {
                return $fallbackToNow ? now() : null;
            }
            return $dt;
        } catch (\Throwable $e) {
            return $fallbackToNow ? now() : null;
        }
    }
}

if (!function_exists('remove_tags')) {
    function remove_tags(?string $value): string
    {
        return trim(strip_tags($value ?? ''));
    }
}

if (!function_exists('remove_all')) {
    // strip tags + collapse whitespace
    function remove_all(?string $value): string
    {
        return trim(Str::squish(remove_tags($value)));
    }
}

if (!function_exists('safe_unserialize')) {
    function safe_unserialize(?string $value)
    {
        if (empty($value)) {
            return null;
        }
        $fixed = preg_replace_callback(
            '/s:(\d+):"(.*?)";/s',
            function ($matches) {
                return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
            },
            $value
        );
        $data = @unserialize($fixed);

        if ($data === false && $fixed !== 'b:0;') {
            return null;
        }

        return $data;
    }
}


if (!function_exists('a_lang')) {
    function a_lang($word, $lang = LANG): string
    {
        return __("admin.$word", locale: $lang);
    }
}

if (!function_exists('p_lang')) {
    function p_lang(string $word, ?string $lang = null): string
    {
        if (!$lang) {
            $lang = app()->getLocale();
        }

        if ($lang === 'uz-Latn') {
            $lang = 'oz';
        }

        return __("public.$word", [], $lang);
    }
}


if (!function_exists('old_lang')) {
    function old_lang($word): string
    {
        return __("old.$word", locale: 'ru');
    }
}

if (!function_exists('youtube_id_from_url')) {
    function youtube_id_from_url(?string $url): ?string
    {
        if (!$url) return null;

        $parts = parse_url($url);
        $host = $parts['host'] ?? '';
        $path = $parts['path'] ?? '';
        $query = [];
        parse_str($parts['query'] ?? '', $query);

        if (!empty($query['v'])) return $query['v'];

        if (stripos($host, 'youtu.be') !== false) {
            return trim($path, '/');
        }

        if (preg_match('~^/embed/([^/?]+)~', $path, $m)) return $m[1];

        if (preg_match('~^/shorts/([^/?]+)~', $path, $m)) return $m[1];

        if (preg_match('~[?&]v=([^&]+)~', $url, $m)) return $m[1];

        return null;
    }
}

if (!function_exists('h_lang')) {
    function h_lang($word, $lang = LANG): string
    {
        return __("handbook.$word", locale: $lang);
    }
}

if (!function_exists('delete_file')) {
    function delete_file($filepath): void
    {
        if (Storage::disk('public')->exists($filepath)) {
            Storage::disk('public')->delete($filepath);
        }
    }
}

if (!function_exists('upload_file')) {
    function upload_file($file, $filepath, $newName)
    {
        $path = $file->storeAs($filepath, $newName, 'public');
//        if (in_array($file->clientExtension(), array('jpg', 'png', 'web', 'jpeg'))) {
//            $file = "storage/$filepath/$newName";
//            $img_size = getimagesize($file);
//            $width = $img_size[0];
//            $height = $img_size[1];
//
//            if ($width > 1000 or $height > 1000) {
//                $newSide = 1000;
//                $newSide2 = intval(($newSide / max($width, $height)) * min($width, $height));
//                if ($width > $height) {
//                    $newWidth = $newSide;
//                    $newHeight = $newSide2;
//                } else {
//                    $newWidth = $newSide2;
//                    $newHeight = $newSide;
//                }
//                Image::read($file)
//                    ->resize($newWidth, $newHeight)
//                    ->save($file, 80);
//            }
//        }
        return $path;
    }
}

if (!function_exists('getTables')) {
    function getTables(): array
    {
        return [
            'users' => new User(),
            'region' => new Region(),
            'city' => new City(),
            'polls' => new Polls(),
            'appeal' => new \App\Models\Appeal(),
            'news' => new News(),
            'products' => new Products(),
            'online' => new Online(),
            'pages' => new Pages(),
            'feedback' => new Feedback(),
            'main' => new Main(),
            'gallery' => new Gallery(),
            'video' => new Video(),
            'opendata' => new Opendata(),
            'menu' => new Menu(),
            'docs' => new Docs,
            'manage' => new Manage(),
            'site' => new Site(),
            'ip_admin' => new Ip_admin(),
        ];
    }
}

if (!function_exists('checkUserGroup')) {
    function checkUserGroup(): bool
    {
        return auth()->user()->role == 'admin';
    }
}


if (!function_exists('go_to')) {
    function go_to($url = null): RedirectResponse
    {
        return $url ? redirect()->to($url) : redirect()->back();
    }
}

if (!function_exists('_t')) {
    function _t($text, $lang = null, $change = false): string
    {
        if (!is_object($text) || !$text) {
            return '';
        }

        $lang = $lang ?: app()->getLocale();


        if ($lang === 'uz-Latn') {
            $lang = 'oz';
        }

        if (!empty($text->$lang)) {
            return $text->$lang;
        }

        $req = request()->segments();
        $isAdminView = (count($req) && $req[0] === 'admin' && !in_array('edit', $req, true));

        if ($isAdminView || $change) {
            foreach (array_keys(getSiteLang()) as $code) {
                if (!empty($text->$code)) {
                    return $text->$code;
                }
            }
        }

        return '';
    }
}


if (!function_exists('assets_p')) {
    function assets_p(): string
    {
        return asset('assets/public') . '/';
    }
}

if (!function_exists('assets_a')) {
    function assets_a(): string
    {
        return asset('assets/admin') . '/';
    }
}


if (!function_exists('url_a')) {
    function url_a(): string
    {
        return url('/') . '/' . LANG .'/admin/';
    }
}
if (!function_exists('url_p')) {
    function url_p(string $path = ''): string
    {
        $base = url('/');
        $path = ltrim($path, '/');
        return rtrim($base, '/') . '/' . LANG . ($path ? "/$path" : '');
    }
}


if (!function_exists('url_u')) {
    function url_u($type = 'edit'): string
    {
        if ($type == 'create')
            return asset('storage') . '/temp/';
        return asset('storage') . '/uploads/';
    }
}
if (!function_exists('getFilterData')) {
    function getFilterData($data): float|object|int|bool|array|string|null
    {
        $data = request($data);
        if (is_array($data))
            return filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}
if (!function_exists('getImgThumb')) {
    function getImgThumb($item, $getDocs = false, $lang = null, $fallback = false)
    {
        $col = getColName($item);
        if (!$col || empty($item->$col)) return null;

        $files = $item->$col;
        $lang  = $lang ?? app()->getLocale();

        $files = array_values(array_filter($files, function ($file) use ($lang) {
            return isset($file->lang) && ($file->lang === $lang || $file->lang === 'all');
        }));

        $flagNames = ['is_thumbnail', 'is_thumnail', 'is_thimnail', 'is_thumb', 'thumbnail'];

        foreach ($files as $file) {
            foreach ($flagNames as $flag) {
                if (isset($file->$flag) && (int)$file->$flag === 1) {
                    return $getDocs ? $file : $file->url;
                }
            }
        }

        if ($fallback && !empty($files)) {
            $first = reset($files);
            return $getDocs ? $first : $first->url;
        }

        return null;
    }
}

if (!function_exists('getImgMain')) {
    function getImgMain($item, $getDocs = false, $lang = null)
    {
        $col = getColName($item);
        if (!$col) return null;

        if ($item->$col) {
            $files = $item->$col;

            $lang = $lang ?? app()->getLocale();

            $files = array_filter($files, function ($file) use ($lang) {
                return isset($file->lang) && ($file->lang === $lang || $file->lang === 'all');
            });

            foreach ($files as $file) {
                if ((int)$file->is_main === 1) {
                    return $getDocs ? $file : $file->url;
                }
            }

            if (!empty($files)) {
                $firstFile = reset($files);
                return $getDocs ? $firstFile : $firstFile->url;
            }
        }

        return null;
    }
}

if (!function_exists('getAllImages')) {

    function getAllImages($item, bool $getDocs = true, ?string $lang = null): array
    {
        $col = getColName($item);
        if (!$col || empty($item->$col)) {
            return [];
        }

        $files = $item->$col;
        $lang  = $lang ?? app()->getLocale();

        $files = array_filter($files, function ($file) use ($lang) {
            return isset($file->lang) && ($file->lang === $lang || $file->lang === 'all');
        });

        if ($getDocs) {
            return array_values($files);
        }

        return array_values(array_map(function ($file) {
            return $file->url ?? null;
        }, $files));
    }
}


if (!function_exists('getImgNoMain')) {
    function getImgNoMain($item, $getUrls = true, $lang = null)
    {
        $col = getColName($item);
        if (!$col || !$item->$col) return [];

        $files = $item->$col;
        $lang = $lang ?? app()->getLocale();

        $files = array_filter($files, function ($file) use ($lang) {
            return isset($file->lang) && ($file->lang === $lang || $file->lang === 'all');
        });

        $nonMainFiles = [];
        foreach ($files as $file) {
            if ((int)$file->is_main === 0) {
                $nonMainFiles[] = $getUrls ? $file->url : $file;
            }
        }

        return $nonMainFiles;
    }
}

if (!function_exists('countAllFiles')) {
    function countAllFiles($item, $lang = null)
    {
        $col = getColName($item);
        if (!$col || !$item->$col) return 0;

        $lang = $lang ?? app()->getLocale();
        $files = $item->$col;

        $filteredFiles = array_filter($files, function ($file) use ($lang) {
            return isset($file->lang) && ($file->lang === $lang || $file->lang === 'all');
        });

        return count($filteredFiles);
    }
}

// Нужен при сохранении медиа
function getColName($item): ?string
{
    if (!$item || !is_object($item) || !method_exists($item, 'getAttributes')) {
        return null;
    }

    $cols = ['images', 'files'];
    $attrs = array_keys($item->getAttributes());

    foreach ($cols as $col) {
        if (in_array($col, $attrs)) return $col;
    }

    return null;
}


if (!function_exists('removeTags')) {
    function removeTags($html): string
    {
        if ($html) {
            $text = strip_tags($html);
            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }
        return '';
    }
}

if (!function_exists('getPosts')) {
    function getPosts($id, $column = 'content')
    {
        $post = \App\Models\Main::find($id);
        return $post ? $post->$column : null;
    }
}
if (!function_exists('getPages')) {
    function getPages($id, $column = 'content')
    {
        $post = \App\Models\Pages::find($id);
        return $post ? $post->$column : null;
    }
}

if (!function_exists('removeAll')) {
    function removeAll($st): array|string
    {
        return str_replace(array("'", "\""), "", $st);
    }
}

if (!function_exists('getVideoCode')) {
    function getVideoCode($item): string
    {
        $lang = LANG;
        if ($lang == 'oz') $lang = 'uz';
        return match ($item->type) {
            0 => '',
            1 => 'https://www.youtube.com/embed/' . $item->code->$lang,
            2 => 'https://mover.uz/video/embed/' . $item->code->$lang,
            3 => url_u() . 'video/' . $item->code->$lang,
        };
    }
}

if (!function_exists('getMenuLink')) {
    function getMenuLink($item): array|string
    {
        if ($item->inner_link)
            $link = url_p() . $item->inner_link;
        elseif ($item->external_link)
            $link = url_p() . $item->external_link;
        else
            $link = url_p() . "menu/$item->alias";
        return $link;
    }
}

if (!function_exists('getDocsKey')) {
    function getDocsKey(): int
    {
        if (session()->has('docs_key')) return session('docs_key');

        $key = rand(-10000, -1);
        session(['docs_key' => $key]);
        return $key;
    }
}

if (!function_exists('getPage')) {
    function getPage(): string
    {
        $page = request('page');
        return ($page and $page > 1) ? "?page=$page" : '';
    }
}

if (!function_exists('isRobot')) {
    function isRobot(): bool
    {
        $agent = new Agent();
        return $agent->isRobot();
    }
}

if (!function_exists('getMenuLinks')) {
    function getMenuLinks($item): array
    {
        if ($item->inner_link) {
            $link = url_p() . "/$item->inner_link";
            $active = $item->inner_link;
        } elseif ($item->external_link) {
            $link = $item->external_link;
            $active = $item->external_link;
        } else {
            $link = url_p() . "/menu/$item->alias";
            $active = $item->alias;
        }

        return ['active' => $active, 'link' => $link];
    }
}
