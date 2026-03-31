<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;
use function Symfony\Component\Translation\t;

class Base extends Model
{
    protected $table; // Declare the table property

    public function __construct($table = 'main')
    {
        $this->table = $table;
        parent::__construct();
    }

    public function setTable($table): void
    {
        $this->table = $table;
    }

    public static function gets($arr = array(), $public = false, $gets = true)
    {
        return self::queryParam($arr, $public, $gets)->get();
    }

    public static function paginatePublic(array $arr = []): LengthAwarePaginator
    {
        $perPage = $arr['limit'] ?? ($arr['paginate'] ?? 15);

        $arr['limit'] = $perPage;

        $paginator = self::queryParam($arr, true, gets: false, paginate: true);

        return $paginator;
    }

    public static function has_alias($alias, $post_id): object|array|null
    {
        return self::query()->where('alias', $alias)->whereNotIn('id', array($post_id))->get()->first();
    }

    public static function getsPublic($arr = array()): Collection|array
    {
        return self::gets($arr, true);
    }

    public static function get($arr = array(), $public = false)
    {
        return static::gets($arr, $public, false)->first();
    }


    public static function count($where, $all = false): int|string
    {
        if ($all)
            return static::query()->count();
        return static::query()->where($where)->count();
    }

    public function my_save($data, $id = false, $edit = false): int|string
    {
        if ($id) {
            if ($edit)
                $data['status'] = isset($data['status']);
            $data = $this->fill($data)->getAttributes();

            $this->newQuery()->where('id', $id)->update($data);
        } else {
            $data['status'] = $data['status'] ?? true;
            $data['created_at'] = $data['created_at'] ?? now();
            $data['updated_at'] = $data['created_at'] ?? now();
            $data = $this->fill($data)->getAttributes();
            $id = $this->newQuery()->insertGetId($data);
            $new = $this->fill(['sort_order' => $id])->getAttributes();
            if ($new)
                $this->newQuery()->where('id', $id)->update($new);
            return $id;
        }
        return '';
    }

    public static function getPublic($arr = array())
    {
        return static::get($arr, true);
    }

    public static function getByAlias($alias)
    {
        return static::queryParam(['alias' => $alias], false)->first();
    }

    public static function getByAliasPublic($alias)
    {
        return static::queryParam(['alias' => $alias], true)->first();
    }

    public static function getByAliasORLinkPublic($alias)
    {
        $post = static::queryParam(['alias' => $alias], true)->first();
        if (!$post) {
            $post = static::queryParam(['inner_link' => $alias], true)->first();
        }

        return $post;
    }

    public static function getByInnerLink($link)
    {
        return static::queryParam(['inner_link' => $link], false)->first();
    }

    public static function getByInnerLinkPublic($link)
    {
        return static::queryParam(['inner_link' => $link], true)->first();
    }

    public static function getById($id)
    {
        return static::queryParam(['id' => $id], false)->first();
    }

    public static function getByIdPublic($id)
    {
        return static::queryParam(['id' => $id], true)->first();
    }

    public static function pager($arr, $public = false): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder|null
    {
        return self::queryParam($arr, $public, paginate: true);
    }

    public static function pagerPublic($arr): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder
    {
        return self::pager($arr, true);
    }

    protected static function queryParam($arr, $public, $gets = false, $paginate = false): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder
    {
        $delete_keys = array('orderBy', 'sort', 'limit', 'offset', 'select', 'like', 'except', 'where_in', 'likeSearch');
        $where = array_diff_key($arr, array_flip($delete_keys));

        $data = [
            'orderBy' => $arr['orderBy'] ?? 'sort_order',
            'sort' => $arr['sort'] ?? 'DESC',
                        'limit' => $arr['limit'] ?? '100',
            'offset' => $arr['offset'] ?? '0',
            'select' => $arr['select'] ?? '*',
            'like' => $arr['like'] ?? false,
            'likeSearch' => $arr['likeSearch'] ?? false,
            'where_in' => $arr['where_in'] ?? false,
            'except' => $arr['except'] ?? '',
        ];
        if ($data['orderBy'] == 'sort_order') {
            $fills = collect(self::query()->getModel()->getFillable());
            if ($fills->search('sort_order') < -1)
                $data['orderBy'] = 'id';
        }

        return self::builderSettings($data, $where, $public, $gets, $paginate);
    }

    protected static function builderSettings($data, $where, $public = false, $gets = true, $paginate = false): \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder
    {
        $query = static::query();

        if ($data['select'] != '*') {
            $data['select'] = str_replace(' ', '', $data['select']);
            $data['select'] = explode(',', $data['select']);
        } elseif ($gets) {
            $fills = collect(self::query()->getModel()->getFillable());
            if (self::query()->getModel()->getTable() != 'pages') {
                $delete_keys = collect(['content', 'short_content', 'html_content']);
                $delete_keys = $delete_keys->flip()->forget($data['except'])->flip();
                $data['select'] = $fills->flip()->forget($delete_keys)->flip()->toArray();

                if (in_array('created_at', array_keys(self::query()->getModel()->getCasts())))
                    $data['select'][] = 'created_at';

                $data['select'][] = 'id';
            }
        }
        $query->select($data['select']);

        if ($data['like'])
            foreach ($data['like'] as $key => $item)
                if (is_array($item))
                    $query->whereAny($item, 'like', "%$key%");
                else
                    $query->where($key, 'like', "%$item%");

        if ($data['likeSearch']) {
            $query->where(function ($query) use ($data) {
                foreach ($data['likeSearch'] as $key => $item) {
                    if (is_array($item))
                        $query->where(function ($subQuery) use ($item, $key) {
                            foreach ($item as $subItem)
                                $subQuery->orWhereRaw("$subItem::jsonb->>'" . LANG . "' LIKE ?", ["%$key%"]);
                        });
                    else
                        $query->orWhereRaw("$key::jsonb->>'" . LANG . "' LIKE ?", ["%$item%"]);
                }
            });
        }

        if ($data['where_in'])
            foreach ($data['where_in'] as $key => $item)
                $query->whereIn($key, $item);

        if ($public) {
            $lang = app()->getLocale();
            $path = '$.' . $lang;

            $query->where('status', true)
                ->whereRaw(
                    "COALESCE(JSON_UNQUOTE(JSON_EXTRACT(title, ?)), '') <> ''",
                    [$path]
                );
        }



        if ($where)
            $query->where($where);

        if ($gets or $paginate) {
            $query->orderBy($data['orderBy'], $data['sort']);
            if ($gets)
                $query->limit($data['limit']);
            if ($paginate)
                return $query->paginate($data['limit']);
        }

        return $query;
    }

}
