<?php

use App\Http\Controllers\Admin\CatsController;
use App\Http\Controllers\Admin\DocsController;
use App\Libraries\MediaLib;
use App\Http\Controllers\Admin\FeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TotalController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Core\AdminController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group([
    'prefix' => LaravelLocalization::setLocale() . "/admin",
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'verified']], function () {
    Route::get('/', [MainController::class, 'main'])->name('admin');

    $arr_group = ['main', 'docs', 'video_materials', 'federations', 'manage', 'doctors', 'news'];
    $arr_cats = ['manage', 'doctors', 'federations', 'sports', 'products'];

    foreach (array_keys(getTables()) as $item) {
        Route::get($item . '/delete/{id}', [AdminController::class, 'delete']);
        Route::post($item . '/sort_order_posts', [AdminController::class, 'sort_order_posts']);

        Route::get($item . '/status_ajax', [AdminController::class, 'status_ajax']);
        Route::match(['get', 'post'], $item . '/sort_order', [AdminController::class, 'sort_order']);
        Route::match(['get', 'post'], $item . '/check_alias', [AdminController::class, 'check_alias']);

        if (in_array($item, $arr_group)) continue;
        Route::get($item, [TotalController::class, 'index']);
        Route::get($item . '/edit/{id}', [TotalController::class, 'edit']);
        Route::patch($item . '/edit/{id}', [TotalController::class, 'update']);
//        if ($item == 'site') continue;
        Route::get($item . '/create', [TotalController::class, 'store']);
        Route::post($item . '/create/', [TotalController::class, 'create']);
        Route::get('opendata/table/{id}', [TotalController::class, 'opendataTable'])->name('admin.opendata.table');

    }

    // Group
    foreach ($arr_group as $item) {
        if ($item == 'docs') continue;
        Route::get($item . '/{group}', [GroupController::class, 'index'])->where('group', '[A-Za-z\-\_]+');
        Route::get($item . '/create/{group}', [GroupController::class, 'store'])->where('group', '[A-Za-z\-\_]+');
        Route::post($item . '/create/{group}', [GroupController::class, 'create'])->where('group', '[A-Za-z\-\_]+');
        Route::get($item . '/edit/{group}/{id}', [GroupController::class, 'edit'])->where('group', '[A-Za-z\-\_]+');
        Route::patch($item . '/edit/{group}/{id}', [GroupController::class, 'update'])->where('group', '[A-Za-z\-\_]+');
        Route::post($item. '/change-group', [GroupController::class, 'changeGroup'])->name('admin.main.change_group');
    }

    // Cats
    foreach ($arr_cats as $item) {
        Route::get($item . '/cats/{cat_id}', [CatsController::class, 'index'])->whereNumber(['cat_id']);
        Route::get($item . '/create/{cat_id}', [CatsController::class, 'store'])->whereNumber(['cat_id']);
        Route::post($item . '/create/{cat_id}', [CatsController::class, 'create'])->whereNumber(['cat_id']);
        Route::get($item . '/edit/{cat_id}/{id}', [CatsController::class, 'edit'])->whereNumber(['cat_id']);
        Route::patch($item . '/edit/{cat_id}/{id}', [CatsController::class, 'update'])->whereNumber(['cat_id']);
    }

    // Docs
    Route::get('docs/{group}/{cat_id}', [DocsController::class, 'index']);
    Route::get('docs/create/{group}/{cat_id}', [DocsController::class, 'store']);
    Route::post('docs/create/{group}/{cat_id}', [DocsController::class, 'create']);
    Route::get('docs/edit/{group}/{cat_id}/{id}', [DocsController::class, 'edit']);
    Route::patch('docs/edit/{group}/{cat_id}/{id}', [DocsController::class, 'update']);

    // Feedback
    Route::get('feedback', [FeedbackController::class, 'index']);
    Route::get('feedback/edit/{id}', [FeedbackController::class, 'edit']);
    Route::patch('feedback/edit/{id}', [FeedbackController::class, 'update']);

    // Media
    Route::post('media/save', [MediaController::class, 'save'])->name('admin.media.save');
    Route::match(['get', 'post'], 'media/delete/{model}/{post_id}/{id}', [MediaController::class, 'delete1']);
    Route::match(['get', 'post'], 'media/set_main/{model}/{post_id}/{id}', [MediaController::class, 'set_main']);
    Route::match(['get', 'post'], 'media/delete_all/{model}/{post_id}', [MediaController::class, 'delete_all']);
    Route::match(['get', 'post'], 'media/sort/{model}/{post_id}', [MediaController::class, 'sort']);
    Route::match(['get', 'post'], 'posts/delete_image/(:num)', [MediaController::class, 'delete_image/$1']);
    Route::get('media/get_media_data/{model}/{post_id}/{id}', [MediaController::class, 'get_media_data']);
    Route::post('media/update_media_data', [MediaController::class, 'update_media_data']);
    Route::post('media/update_media_image', [MediaController::class, 'update_media_image'])->name('admin.media.update_image');
    Route::post('media/update_lang/{model}/{post_id}/{id}', [MediaLib::class, 'update_lang']);
    Route::post('/media/svg-color', [MediaController::class, 'svgColor'])
        ->name('media.svgColor');
    Route::post('/media/video-thumbnail', [MediaController::class, 'videoThumbnail'])
        ->name('admin.media.video_thumbnail');
    Route::post('/media/video-thumbnail/get', [\App\Http\Controllers\Admin\MediaController::class, 'getVideoThumbnail'])
        ->name('admin.media.get_video_thumbnail');
    Route::post('/media/video-thumbnail/delete', [\App\Http\Controllers\Admin\MediaController::class, 'deleteVideoThumbnail'])
        ->name('admin.media.delete_video_thumbnail');

});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('media/get_media_data/{model}/{post_id}/{id}', [MediaLib::class, 'get_media_data']);
Route::post('media/update_media_data', [MediaLib::class, 'update_media_data']);
Route::post('/stats/reset', [TotalController::class, 'reset'])->name('stats.reset');

Route::get('osg-secret', function () {
    return redirect('/' . LaravelLocalization::getCurrentLocale() . '/admin');
});

