<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\MainResources;
use App\Http\Resources\MainViewResources;
use App\Models\Main;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class
MainControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
        $pageSize = $request->query('page_size', 10);

        $exists = Main::where('group', $group)->exists();

        if (!$exists) {
            return response()->json(['error' => 'Invalid group'], 404);
        }

        $arr_group = Main::where('group', $group)
            ->where('status', 1)
            ->whereJsonDoesntContain('title', [LANG => null])
            ->whereJsonDoesntContain('title', [LANG => ''])
            ->orderBy('created_at', 'desc')
            ->paginate($pageSize);

        return MainResources::collection($arr_group, $group)->response();
    }


    public function main_view($group, $alias): JsonResponse
    {
        $news = Main::where(['group' => $group, 'alias' => $alias])->first();

        if (!$news) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json([
            'data' => MainViewResources::make($news),
        ]);
    }
    public function region_city(Request $request, $group, $id = null): JsonResponse
    {
        $pageSize = $request->query('page_size', 10);

        if ($group === 'region') {
            $regions = Main::where('group', 'region')
                ->where('status', 1)
                ->whereJsonDoesntContain('title', [LANG => null])
                ->whereJsonDoesntContain('title', [LANG => ''])
                ->orderBy('created_at', 'desc')
                ->paginate($pageSize);

            return MainResources::collection($regions, 'region')->response();
        }

        if ($group === 'city') {
            if (!$id) {
                return response()->json(['error' => 'Region ID is required for city listing'], 400);
            }

            $cities = Main::where('group', 'city')
                ->where('cat_id', $id)
                ->where('status', 1)
                ->whereJsonDoesntContain('title', [LANG => null])
                ->whereJsonDoesntContain('title', [LANG => ''])
                ->orderBy('created_at', 'desc')
                ->paginate($pageSize);

            return MainResources::collection($cities, 'city')->response();
        }

        return response()->json(['error' => 'Invalid group'], 404);
    }


}
