<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\CatsResources;
use App\Models\Menu;
use App\Models\Sports;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SportsControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
        $options = $request->get('options');
        $pageSize = $request->query('page_size', 10);
        $groups = [
            'cats' => CatsResources::class,
        ];

        if ($options) {
            $news = Sports::where(['cat_id'=>1]) ->orderBy('created_at', 'desc')
                ->limit(7)
                ->get();
        } else {
            $news = Sports::with('children')->orderBy('created_at')
                ->whereGroup($group)
                ->paginate($pageSize);
        }

        if (isset($groups[$group])) {

            $resourceClass = $groups[$group];

            return $resourceClass::collection($news)->response();
        }

        return response()->json(['error' => 'Invalid link'], 404);
    }

    public function sports_list(Request $request,$alias): JsonResponse
    {
        $pageSize = $request->query('page_size', 10);
        $post = Menu::getByInnerLinkPublic($alias);
        $cats = [
            'olimpic-summer' => 1,
            'olimpic-winter' => 2
        ];

        if (isset($cats[$alias])) {
            $cat_id = $cats[$alias];
        }else{
            return response()->json(['error' => 'Invalid Category ID'], 404);
        }
        $news = Sports::where(['group' => 'items','cat_id' => $cat_id])->get();
        return CatsResources::collection($news)->response();
    }

    public function sports_view($alias): JsonResponse
    {
        $news = Sports::where(['alias' => $alias])->first();

        return CatsResources::make($news)->response();
    }

}


