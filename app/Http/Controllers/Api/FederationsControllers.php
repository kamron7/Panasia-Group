<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\FederationsResources;
use App\Models\Federations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FederationsControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
        $pageSize = $request->query('page_size', 10);
        $groups = [
            'normal' => 'normal',
            'asian' => 'asian',
            'international' => 'international',
        ];

        if (!array_key_exists($group, $groups)) {
            return response()->json(['error' => 'Invalid group'], 404);
        }

        $arr_group = Federations::with('children')->whereGroup($group)->paginate($pageSize);

        return FederationsResources::collection($arr_group)->response();
    }
}
