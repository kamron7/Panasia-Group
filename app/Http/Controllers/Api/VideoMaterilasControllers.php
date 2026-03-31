<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Models\Video_Materials;
use App\Http\Resources\VideoMaterialsResources;
use App\Http\Resources\VideoMaterialsViewResources;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoMaterilasControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
        $pageSize = $request->query('page_size', 9);
        $options = $request->query('options');

        if ($options === 'options') {
            $arr_group = Video_Materials::whereGroup($group)->whereJsonDoesntContain('title', [LANG => null])->whereJsonDoesntContain('title', [LANG => ''])->orderBy('created_at', 'desc')->limit(3)->get();
        } else {
            $arr_group = Video_Materials::whereGroup($group)->whereJsonDoesntContain('title', [LANG => null])->whereJsonDoesntContain('title', [LANG => ''])->orderBy('created_at', 'desc')->paginate($pageSize);
        }

        if (!empty($arr_group)) {
            return VideoMaterialsResources::collection($arr_group)->response();
        }else{
            return response()->json(['error' => 'Invalid link'], 404);
        }

    }

    public function social_view($alias): JsonResponse
    {
        $news = Video_Materials::where('alias', $alias)->first();

        if (!$news) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $news->increment('views');

        return VideoMaterialsViewResources::make($news)->response();
    }

    public function interview_view($alias): JsonResponse
    {
        $news = Video_Materials::where('alias', $alias)->first();

        if (!$news) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $news->increment('views');

        return VideoMaterialsViewResources::make($news)->response();
    }

}

