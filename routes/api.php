<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthLogins;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\MenuControllers;
use App\Http\Controllers\Api\VirtualFormController;
use App\Http\Controllers\Api\ManageControllers;
use App\Http\Controllers\Api\GalleryControllers;
use App\Http\Controllers\Api\VideoControllers;
use App\Http\Controllers\Api\VideoMaterilasControllers;
use App\Http\Controllers\Api\FederationsControllers;
use App\Http\Controllers\Api\MainControllers;
use App\Http\Controllers\Api\DoctorsControllers;
use App\Http\Controllers\Api\SportsControllers;
use App\Http\Controllers\Api\PagesControllers;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Admin\MoxiecutController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::match(['get', 'post'], '/admin/moxiecut', [MoxiecutController::class, 'index']);
Route::group(['prefix' => 'v1'], function () {

    //News
    Route::get('press-center/filter/{group}', [NewsController::class, 'filterByDate']);
    Route::get('press-center/{group}', [NewsController::class, 'index']);
    Route::get('press-center/{group}/{alias}', [NewsController::class, 'news_view']);
//    Route::get('news/category/{alias}', [NewsController::class, 'category']);
//    Route::get('video-materials/{group}', [VideoMaterilasControllers::class, 'index']);
//    Route::get('interview/{alias}', [VideoMaterilasControllers::class, 'interview_view']);
//    Route::get('social-video/{alias}', [VideoMaterilasControllers::class, 'social_view']);

    //Menu
    Route::get('menu', [MenuControllers::class, 'menu']);
    Route::get('menu/{group}', [MenuControllers::class, 'index']);
    Route::get('breadcrumbs/{alias}', [MenuControllers::class, 'breadcrumbs']);

    //Manage
//    Route::get('manage/{group}', [ManageControllers::class, 'index']);
    Route::post('/virtual-form', [VirtualFormController::class, 'store']);
    Route::get('/virtual-form/{id}/{access_code}', [VirtualFormController::class, 'showByIdAndAccessCode']);
    Route::put('/virtual/{id}/status', [VirtualFormController::class, 'updateStatus']);
    //Doctors

    //Gallery
    Route::get('gallery', [GalleryControllers::class, 'gallery']);
    Route::get('gallery/{alias}', [GalleryControllers::class, 'gallery_view']);
    Route::get('video', [VideoControllers::class, 'index']);
    Route::get('video/{alias}', [VideoControllers::class, 'video_view']);

    //Main
    Route::get('main/{group}', [MainControllers::class, 'index']);
    Route::get('main/{group}/{alias}', [MainControllers::class, 'main_view']);
    Route::get('virtual/{group}/{id?}', [MainControllers::class, 'region_city']);

    //Federations
//    Route::get('federations/{group}', [FederationsControllers::class, 'index']);

    //Sports
//    Route::get('sports/{group}', [SportsControllers::class, 'index']);
//    Route::get('sports/list/{alias}', [SportsControllers::class, 'sports_list']);
//    Route::get('sports/view/{alias}', [SportsControllers::class, 'sports_view']);

    //Pages
    Route::get('pages', [PagesControllers::class, 'index']);

    //Search
    Route::get('search', [SearchController::class, 'search']);

});
