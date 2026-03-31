<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\DCategoryResources;
use App\Models\Doctors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorsControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
        $pageSize = $request->query('page_size', 10);
        $groups = [
            'd_category' => DCategoryResources::class,
        ];

        if (!isset($groups[$group])) {
            return response()->json(['error' => 'Invalid link'], 404);
        }

        $arr_group = Doctors::with('children')->whereGroup($group)->paginate($pageSize);
        $resourceClass = $groups[$group];

        return $resourceClass::collection($arr_group)->response();
    }

}
