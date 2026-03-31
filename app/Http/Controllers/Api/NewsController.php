<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\InterviewResources;
use App\Http\Resources\NewsResources;
use App\Http\Resources\NewsViewResources;
use App\Models\News;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\NewsCategoryResources;

class NewsController extends ApiController
{

    public function index(Request $request, $group): JsonResponse
    {
        $limit = (int)$request->query('limit', 6);
        $offset = (int)$request->query('offset', 0);

        $groups = [
            'news' => 'news',
            'events' => 'events',
        ];

        if (!array_key_exists($group, $groups)) {
            return response()->json(['error' => 'Invalid group'], 404);
        }

        $query = News::whereGroup($group)
            ->where('status', 1)
            ->whereJsonDoesntContain('title', [LANG => null])
            ->whereJsonDoesntContain('title', [LANG => '']);

        $total = $query->count();

        $items = $query->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get()
            ->filter(function ($item) {
                return trim(_t($item->title)) !== '';
            })->values();


        return response()->json([
            'data' => NewsResources::collection($items),
            'total' => $total,
            'meta' => [
                'limit' => $limit,
                'offset' => $offset,
            ]
        ]);
    }


    public function news_view($group, $alias): JsonResponse
    {
        $news = News::where(['group' => $group, 'alias' => $alias])->first();

        if (!$news) {
            return response()->json(['error' => 'News item not found'], 404);
        }

        $news->increment('views');

        return NewsViewResources::make($news)->response();
    }


//    public function category(Request $request, $alias): AnonymousResourceCollection
//    {
//        $pageSize = $request->query('page_size', 9);
//        $menuID = Menu::where('alias', $alias)->pluck('id')->first();
//
//        if (!$menuID) {
//            return response()->json(['error' => 'Category not found'], 404);
//        }
//
//        $news = News::where('cat_id', $menuID)->whereJsonDoesntContain('title', [LANG => null])->whereJsonDoesntContain('title', [LANG => ''])
//            ->orderBy('created_at', 'desc')
//            ->paginate($pageSize);
//
//        return NewsCategoryResources::collection($news);
//    }

    public function filterByDate(Request $request, $group): JsonResponse
    {
        $month = $request->query('month');
        $year = $request->query('year');

        $groups = [
            'news' => 'news',
            'events' => 'events',
        ];

        if (!array_key_exists($group, $groups)) {
            return response()->json(['error' => 'Invalid group'], 404);
        }

        if (!is_null($year)) {
            if (!is_numeric($year) || $year < 1900) {
                return response()->json(['error' => 'Invalid year'], 422);
            }
        }

        if (!is_null($month)) {
            if (!is_numeric($month) || $month < 1 || $month > 12) {
                return response()->json(['error' => 'Such month does not exist yet'], 422);
            }
        }

        $query = News::whereGroup($group)
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->when($month, fn($q) => $q->whereMonth('created_at', $month))
            ->whereJsonDoesntContain('title', [LANG => null])
            ->whereJsonDoesntContain('title', [LANG => '']);

        $items = $query->orderBy('created_at', 'desc')->get()
            ->filter(fn($item) => trim(_t($item->title)) !== '')
            ->values();

        return response()->json([
            'data' => NewsResources::collection($items),
            'count' => $items->count(),
            'filters' => [
                'month' => $month,
                'year' => $year,
            ]
        ]);
    }
}

