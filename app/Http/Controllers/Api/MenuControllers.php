<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\MenuResources;
use App\Http\Resources\MenuDetailResources;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuControllers extends ApiController
{
    public function menu(): AnonymousResourceCollection
    {
        $menu = Menu::with('children.children')
            ->where(['status' => true, 'cat_id' => 0])
            ->orderBy('sort_order', 'asc')
            ->get();

        $menu = $this->filterMenuWithTranslatedTitles($menu);
        return MenuResources::collection($menu);
    }


    private function filterMenuWithTranslatedTitles($menus)
    {
        return $menus->filter(function ($item) {
            $item->children = $item->children->filter(fn ($child) => trim(_t($child->title)) !== '');
            foreach ($item->children as $child) {
                $child->children = $child->children->filter(fn ($sub) => trim(_t($sub->title)) !== '');
            }
            return trim(_t($item->title)) !== '';
        });
    }


    public function index(Request $request, $category): JsonResponse
    {
        $menuItem = Menu::with(['children.children'])
            ->where('alias', $category)
            ->first();

        if (!$menuItem) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        return MenuDetailResources::make($menuItem)->response();
    }

    public function breadcrumbs($alias): JsonResponse
    {
        if ($alias == 'news'){
            $child = Menu::getByAliasORLinkPublic('sport-i-meditsina');
            if (!$child) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $parent = Menu::find($child->cat_id);
            $grandparent = $parent ? Menu::find($parent->cat_id) : null;


            $childSiblings = $parent ? $parent->children->map(fn($item) => [
                'id' => $item->id,
                'link' => $item->inner_link ?? $item->external_link,
                'title' => _t($item->title),
                'alias' => $item->alias,
            ])->keyBy('id')->toArray() : [];

            $parentSiblings = $grandparent ? $grandparent->children->where('id', '!=', $parent->id)->map(fn($item) => [
                'id' => $item->id,
                'link' => $item->inner_link ?? $item->external_link,
                'title' => _t($item->title),
                'alias' => $item->alias,
            ])->keyBy('id')->toArray() : [];

            $response['data']['child'] =   [
                'id' => $parent->id,
                'link' => $parent->inner_link ?? $parent->external_link,
                'title' => _t($parent->title),
                'alias' => $parent->alias,
                'siblings' => $childSiblings
            ];

            return response()->json($response);
        }else{
            $child = Menu::getByAliasORLinkPublic($alias);
            if (!$child) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $parent = Menu::find($child->cat_id);
            $grandparent = $parent ? Menu::find($parent->cat_id) : null;


            $childSiblings = $parent ? $parent->children->map(fn($item) => [
                'id' => $item->id,
                'link' => $item->inner_link ?? $item->external_link,
                'title' => _t($item->title),
                'alias' => $item->alias,
            ])->keyBy('id')->toArray() : [];

            $parentSiblings = $grandparent ? $grandparent->children->where('id', '!=', $parent->id)->map(fn($item) => [
                'id' => $item->id,
                'link' => $item->inner_link ?? $item->external_link,
                'title' => _t($item->title),
                'alias' => $item->alias,
            ])->keyBy('id')->toArray() : [];

            $response['data']['child'] =   [
                'id' => $child->id,
                'link' => $child->inner_link ?? $child->external_link,
                'title' => _t($child->title),
                'alias' => $child->alias,
                'siblings' => $childSiblings
            ];
            $response['data']['parent'] = [
                $parent ? [
                    'id' => $parent->id,
                    'link' => $parent->inner_link ?? $parent->external_link,
                    'title' => _t($parent->title),
                    'alias' => $parent->alias,
                    'siblings' => $parentSiblings
                ] : null
            ];
            $response['data']['grandparent'] = [
                $grandparent ? [
                    'id' => $grandparent->id,
                    'link' => $grandparent->inner_link ?? $grandparent->external_link,
                    'title' => _t($grandparent->title),
                    'alias' => $grandparent->alias,
                ] : null
            ];

            return response()->json($response);
        }

    }

}
