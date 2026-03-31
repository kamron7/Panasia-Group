<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\GalleryResources;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryControllers extends ApiController
{
    public function gallery(Request $request): AnonymousResourceCollection
    {
        $pageSize = $request->query('page_size', 10);
        $options = $request->query('options');

        $gallery = ($options === 'options')
            ? Gallery::orderBy('created_at', 'desc')->limit(3)->get()
            : Gallery::orderBy('created_at', 'desc')->paginate($pageSize);

        return GalleryResources::collection($gallery);
    }

    public function gallery_view($alias): JsonResponse
    {
        $news = Gallery::where(['alias' => $alias])->first();

        return GalleryResources::make($news)->response();
    }
    
}

