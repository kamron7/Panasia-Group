<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\VideoResources;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoControllers extends ApiController
{
    public function index(Request $request): AnonymousResourceCollection
    {

        $options = $request->get('options');
        $pageSize = $request->query('page_size', 10);


        if ($options === 'options') {
            $video = Video::orderBy('created_at', 'desc')->limit(3)->get();
        } else {
            $video = Video::orderBy('created_at', 'desc')->paginate($pageSize);
        }

        return VideoResources::collection($video)->additional(['request' => $request]);
    }

    public function video_view(Request $request, $alias): JsonResponse
    {
        $video = Video::where('alias', $alias)->first();

        if (!$video) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        return response()->json([
            'data' => VideoResources::make($video),
        ]);
    }
}
