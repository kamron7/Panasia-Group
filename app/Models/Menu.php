<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Menu extends Base
{
    use HasFactory;

    protected $table = 'menu';
    protected $hidden = ['content'];

    public function __construct()
    {
        parent::__construct($this->table);
    }

    protected $fillable = [
        'cat_id',
        'id',
        'title', 'short_content', 'content',
        'inner_link', 'external_link',
        'files', 'sort_order',
        'status', 'alias',
        'keywords', 'description',
        'created_at', 'updated_at',

    ];

    protected $casts = [
        'cat_id' => 'integer',
        'files' => 'object',
        'title' => 'object',
        'content' => 'object',
        'status' => 'boolean',
        'short_content' => 'object',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public static function resolveLink($cat): string
    {
        $locale = app()->getLocale();

        if (!empty($cat->external_link)) {
            return $cat->external_link;
        } elseif (!empty($cat->inner_link)) {
            return url($locale . '/' . ltrim($cat->inner_link, '/'));
        } else {
            return url($locale . '/menu/' . $cat->alias);
        }
    }


    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'cat_id')->where('status', true)->orderBy('sort_order', 'asc');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'cat_id', 'id')->where('status', true);
    }

    private static function getMenuCats($items): array
    {
        if (!$items || !is_iterable($items)) {
            return [];
        }

        $itemsCollection = collect($items->toArray()); // Ensure Collection

        $items = $items->map(function ($item) use ($itemsCollection) {
            $item['sub_has'] = $itemsCollection->contains(fn($value) => $value['cat_id'] == $item->id);
            return $item;
        });

        $cats = [];
        foreach ($items as $cat) {
            $cats[$cat['cat_id']][] = $cat;
        }

        return $cats;
    }


    /* ADMIN */
    public static function MenuAdmin(): ?string
    {
        $items = self::gets(['sort' => 'asc']);
        $cats = self::getMenuCats($items);
        return self::buildMenuAdmin($cats, 0);
    }

    public static function buildMenuAdmin($cats, $parent_id, &$k = 0): ?string
    {
        if (is_array($cats) && isset($cats[$parent_id])) {
            $k++;
            if ($k > 3) {
                $k = 3;
            }
            if ($k == 1) $tree = ' <ul class="dd-list list_move list_move" id="mainNav">';
            else {
                $tree = '<ul class="dd-list list list_move" style="display: none">';
            }
            foreach ($cats[$parent_id] as $cat) {
                $move = 'Перемещать';
                $action_button =
                    '<div class="action-menu">
                        <button class="btn btn-mini move" data-toggle="tooltip" data-placement="right" title="' . $move . ' (' . _t($cat->title) . ')"><i class="fa fa-arrows"></i></button>
                        <div class="sort-order_form">
                            <form action="' . url_a() . "menu/sort_order_posts" . '" method="post" style="margin-bottom: -10px;">
                                <input type="text" name="sort_order" class="sort-order_input"  data-order_enter="' . $cat->id . '" value="' . ($cat->sort_order ?? '') . '" />
                                <input type="hidden" name="id" value="' . $cat->id . '" />
                            </form>
                        </div>
                    </div>';
                $checked = ($cat->status) ? 'checked="checked"' : '';
                $action =
                    '<div class="action">
                        <div class="action-buttons">
                            <div class="btn-group">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="status" class="onoffswitch-checkbox checkbox-onoff" id="myonoffswitch-' . $cat->id . '" ' . $checked . ' data-postid="' . $cat->id . '">
                                    <label class="onoffswitch-label" for="myonoffswitch-' . $cat->id . '">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                                <a href="' . url_a() . "menu/edit/$cat->id" . '" class="btn btn-small btn-info" title="Ред-ты"><i class="icon-edit icon-white"></i> </a>
                                <a href="' . url_a() . "menu/delete/$cat->id" . '" class="btn btn-small btn-danger" title="Удалить"><i class="icon-trash icon-white"></i> </a>
                            </div>
                        </div>
                    </div>';

                $sub = $cat['sub_has'];

                if ($cat->cat_id == 0) {
                    if ($sub) {
                        $link = '<li class="dd-item item has-sub" id="item-' . $cat->id . '" data-id="' . $cat->id . '" parent_id="' . $cat->cat_id . '" sort_id="' . $cat->sort_order . '">' . $action_button . '<a href="#!">' . _t($cat->title) . ' </a>' . $action;
                    } else {
                        $link = '<li class="dd-item item none-sub" id="item-' . $cat->id . '" data-id="' . $cat->id . '" parent_id="' . $cat->cat_id . '" sort_id="' . $cat->sort_order . '">' . $action_button . '<a href="#!">' . _t($cat->title) . '</a>' . $action;
                    }
                } else {
                    if ($sub) {
                        $link = '<li class="dd-item item has-sub" id="item-' . $cat->id . '" data-id="' . $cat->id . '" parent_id="' . $cat->cat_id . '" sort_id="' . $cat->sort_order . '">' . $action_button . '<a href="#!">' . _t($cat->title) . '</a>' . $action;
                    } else {
                        $link = '<li class="dd-item item none-sub" id="item-' . $cat->id . '" data-id="' . $cat->id . '" parent_id="' . $cat->cat_id . '" sort_id="' . $cat->sort_order . '">' . $action_button . '<a href="#!">' . _t($cat->title) . '</a>' . $action;
                    }
                }
                $tree .= $link;
                $tree .= self::buildMenuAdmin($cats, $cat->id, $k);
                $tree .= '';
            }
            $tree .= '</ul>';
            if ($parent_id !== 0) $tree .= '';
        } else {
            return null;
        }
        return $tree;
    }

    /* PUBLIC */
    public static function MenuPublic($menu = false): array
    {
        if (!$menu)
            $items = self::getsPublic(['sort' => 'asc']);
        else $items = $menu;
        $cats = self::getMenuCats($items);
        return [
            'main' => self::buildTreeMain($cats, 0),
            'footer' => self::buildTreeMainFooter($cats, 0),
            'mobile' => self::buildTreeMainMobile($cats, 0),
            'full' => self::buildTreeMainFull($cats, 0),
        ];
    }

    public static function buildTreeMainFooter(array $cats, int $parent_id, int &$k = 0): ?string
    {
        if (!isset($cats[$parent_id])) {
            return null;
        }

        $k++;
        if ($k > 3) $k = 3;

        $tree = $k === 1
            ? '<ul class="nav navbar-nav" id="footer-menu">'
            : '<ul class="dropdown-menu dropup">';

        foreach ($cats[$parent_id] as $cat) {
            $title = is_array($cat->title) ? $cat->title[LANG] ?? '' : _t($cat->title);
            $hasChildren = isset($cats[$cat->id]) && count($cats[$cat->id]);
            $hasDirectLink = !empty($cat->inner_link) || !empty($cat->external);
            $iconMenu = $hasChildren
                ? ($cat->category_id == 0 ? '<i class="fa fa-angle-up" aria-hidden="true"></i>' : '<i class="fa fa-angle-left" aria-hidden="true"></i>')
                : '';

            $nav_link = 'nav-link';
            $no_link = ($hasChildren && !$hasDirectLink) ? 'no-link' : '';

            $link1 = ($hasChildren && !$hasDirectLink) ? 'javascript:void(0);' : self::resolveLink($cat);

            $alias = $cat->alias;

            if ($cat->category_id == 0) {
                if ($cat->as_menu == 1) {
                    $tree .= '<li class="dropdown-submenu nav-item">';
                    $tree .= '<a data-alias="' . e($alias) . '" class="dropdown-item dropdown-toggle ' . $no_link . ' ' . $nav_link . '" href="' . $link1 . '">' . e($title) . $iconMenu . '</a>';
                } else {
                    $tree .= '<li class="dropdown nav-item">';
                    $tree .= '<a data-alias="' . e($alias) . '" class="dropdown-toggle1 ' . $no_link . ' ' . $nav_link . '" href="' . $link1 . '">' . e($title) . $iconMenu . '</a>';
                }
            } else {
                if ($cat->as_menu == 1) {
                    $tree .= '<li class="dropdown dropdown-submenu">';
                    $tree .= '<a class="dropdown-item dropdown-toggle1" href="' . $link1 . '">' . e($title) . $iconMenu . '</a>';
                } else {
                    $tree .= '<li class="dropdown nav-item-2">';
                    $tree .= '<a class="dropdown-item" href="' . $link1 . '">' . e($title) . $iconMenu . '</a>';
                }
            }

            $tree .= self::buildTreeMainFooter($cats, $cat->id, $k);
            $tree .= '</li>';
        }

        $tree .= '</ul>';

        return $tree;
    }

//    MOBILE
    public static function buildTreeMainMobile(array $cats, int $parent_id, int $level = 0): ?string
    {
        if (!isset($cats[$parent_id]) || !is_array($cats[$parent_id])) {
            return null;
        }

        $html = '<ul class="m-nav level-' . (int)$level . '" role="menu">';

        foreach ($cats[$parent_id] as $cat) {
            $title = _t($cat->title);

            $hasChildren   = isset($cats[$cat->id]) && is_array($cats[$cat->id]) && count($cats[$cat->id]);
            $hasDirectLink = !empty($cat->inner_link) || !empty($cat->external);
            $href          = ($hasChildren && !$hasDirectLink) ? '#' : self::resolveLink($cat);

            $liClass = 'm-item' . ($hasChildren ? ' has-children' : '');
            $html .= '<li class="' . e($liClass) . '">';

            // Just link (no toggle anymore)
            $html .= '<a class="m-link" href="' . e($href) . '" data-alias="' . e($cat->alias) . '">'
                . e($title) .
                '</a>';

            // Directly render children (no wrapper, no hidden)
            if ($hasChildren) {
                $html .= self::buildTreeMainMobile($cats, $cat->id, $level + 1) ?? '';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public static function buildTreeMainFull(array $cats, int $parent_id, int &$k = 0): ?string
    {
        if (!isset($cats[$parent_id])) {
            return null;
        }

        $k++;
        if ($k > 3) $k = 3;

        $tree = $k === 1 ? '<ul class="accordion">' : '<ul class="inner">';

        foreach ($cats[$parent_id] as $cat) {
            $title = _t($cat->title);
            $hasChildren = isset($cats[$cat->id]) && count($cats[$cat->id]);
            $hasDirectLink = !empty($cat->inner_link) || !empty($cat->external);

            $nav_link = ($hasChildren && !$hasDirectLink) ? 'nav-link' : '';
            $no_link = ($hasChildren && !$hasDirectLink) ? 'no-link' : '';
            $nav_sub = $hasChildren ? 'nav-submenu' : '';
            $toggleClass = ($hasChildren && !$hasDirectLink) ? 'toggle' : '';

            $link1 = ($hasChildren && !$hasDirectLink) ? 'javascript:void(0);' : self::resolveLink($cat);

            $dataAlias = $cat->alias ?? ($cat->option_2 ?? '');
            $dataAttr = 'data-alias="' . e($dataAlias) . '"';

            $aClass = trim("$nav_link $no_link $toggleClass");

            $tree .= '<li class="' . $nav_sub . '">';
            $tree .= '<a href="' . $link1 . '" class="' . $aClass . '" ' . $dataAttr . '>';
            $tree .= e($title);
            $tree .= '</a>';

            $tree .= self::buildTreeMainFull($cats, $cat->id, $k);
            $tree .= '</li>';
        }

        $tree .= '</ul>';

        return $tree;
    }


    public static function buildTreeMain(array $cats, int $parent_id, int $level = 0): ?string
    {
        if (!isset($cats[$parent_id])) return null;

        $html = '';

        foreach ($cats[$parent_id] as $cat) {
            $title = is_array($cat->title) ? ($cat->title[LANG] ?? '') : _t($cat->title);
            $href  = self::ciLikeLink($cat);
            $hasChildren = isset($cats[$cat->id]) && count($cats[$cat->id]) > 0;

            if ($level === 0) {
                if ($hasChildren) {
                    $html .= '<div class="nav-dd-wrap">';
                    $html .= '<a href="' . e($href) . '" class="nav-dd-trigger">'
                           . e($title)
                           . '<svg class="nav-caret" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>'
                           . '</a>';
                    $html .= '<div class="nav-dd">';
                    $html .= self::buildTreeMain($cats, (int)$cat->id, 1) ?? '';
                    $html .= '</div>';
                    $html .= '</div>';
                } else {
                    $html .= '<a href="' . e($href) . '">' . e($title) . '</a>';
                }
            } else {
                $html .= '<a href="' . e($href) . '" class="nav-dd-item">' . e($title) . '</a>';
                if ($hasChildren) {
                    $html .= self::buildTreeMain($cats, (int)$cat->id, $level + 1) ?? '';
                }
            }
        }

        return $html;
    }

    private static function ciLikeLink($cat): string
    {
        $locale = app()->getLocale();

        if ((int)$cat->cat_id === 999) {
            return url("$locale/news/category/{$cat->alias}");
        }
        if ((int)$cat->id === 99999) {
            return url("$locale/products/category/asosiy-mahsulotlar");
        }

        if (!empty($cat->external_link)) {
            return $cat->external_link;
        }
        if (!empty($cat->inner_link)) {
            return url($locale . '/' . ltrim($cat->inner_link, '/'));
        }
        return url("$locale/menu/{$cat->alias}");
    }



}
