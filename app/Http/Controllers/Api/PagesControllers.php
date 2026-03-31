<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PagesControllers extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $pages = Pages::where(['status' => true])->get();

        $formattedData = [];

        foreach ($pages as $page) {
            $formattedData[$page->options] = _t($page->title);
        }

        return response()->json($formattedData);
    }
}
