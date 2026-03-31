<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Core\ApiController;
use App\Http\Resources\ManageResources;
use App\Models\Manage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManageControllers extends ApiController
{
    public function index(Request $request, $group): JsonResponse
    {
//        $pageSize = $request->query('page_size', 10);
        $groups = [
            'predsedatel' => 'predsedatel',
            'generalnyj-sekretar' => 'generalnyj-sekretar',
            'zamestiteli-predsedatelja' => 'zamestiteli-predsedatelja',
            'sovetniki-predsedatelja' =>  'sovetniki-predsedatelja',
            'ispolnitelnyj-komitet' =>  'ispolnitelnyj-komitet',
            'direktora-departamentov' =>  'direktora-departamentov',
            'm_category' => 'm_category',

        ];

        $arr_group = Manage::with('children')->whereGroup($group)->where(['status' => true])->whereJsonDoesntContain('title', [LANG => null])->whereJsonDoesntContain('title', [LANG => ''])->orderBy('sort_order', 'asc')->get()->unique('id');

        if (!array_key_exists($group, $groups)) {
            return response()->json(['error' => 'Invalid group'], 404);
        }

        return ManageResources::collection($arr_group)->response();
    }

}
