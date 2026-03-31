<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\RssController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OnlineController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\MgController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


//use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/captcha/image', [CaptchaController::class, 'generateCaptcha'])->name('captcha.image');
    Route::get('/captcha/recap', [CaptchaController::class, 'recap'])->name('captcha.recap');
    Route::post('/captcha/validate', function (\Illuminate\Http\Request $request) {
        $isValid = captcha_check($request->input('captcha'));
        return response()->json(['valid' => $isValid]);
    })->name('captcha.validate');
    Route::get('menu/{alias}', [MainController::class, 'static']);
    Route::post('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/about', [MgController::class, 'about']);
    Route::get('/partners', [MgController::class, 'partners']);
    Route::get('/investment-strategy', [MgController::class, 'investment_strategy']);
    Route::get('/upstream', [MgController::class, 'upstream']);
    Route::get('/logistics', [MgController::class, 'logistics']);
    Route::get('/refinery', [MgController::class, 'refinery']);
    Route::get('/fuel-retail', [MgController::class, 'fuel_retail']);
    Route::get('/team', [MgController::class, 'team']);
    Route::get('/geography', [MgController::class, 'geography']);
    Route::get('/contacts', [MgController::class, 'contacts']);
    Route::get('/projects', [MgController::class, 'projects']);
    Route::get('/services', [MgController::class, 'services']);
    Route::get('/sobranie', [MgController::class, 'sobranie']);
    Route::get('/sobranie/{alias}', [MgController::class, 'sobranie_view']);
    Route::get('/investment', [MgController::class, 'investment']);
    Route::get('/press-conference', [MgController::class, 'press_conference']);
    Route::get('/press-conference/{alias}', [MgController::class, 'press_conference_view']);
    Route::get('/investment/{alias}', [MgController::class, 'investment_view']);
    Route::get('/leadership/{alias}', [MgController::class, 'leadership_view']);
    Route::get('/tenders/{alias}', [MgController::class, 'tenders_view']);
    Route::get('/apparat/{alias}', [MgController::class, 'apparat_view']);
    Route::get('/metallurgija', [MgController::class, 'metallurgija']);
    Route::get('/auxiliary', [MgController::class, 'auxiliary']);
    Route::get('/transport', [MgController::class, 'transport']);
    Route::get('/analitik/{alias}', [MgController::class, 'analitik_view']);
    Route::get('/auxiliary/{alias}', [MgController::class, 'auxiliary_view']);
    Route::get('/metallurgija/{alias}', [MgController::class, 'metallurgija_view']);
    Route::get('/uppt/{alias}', [MgController::class, 'uppt_view']);
    Route::get('/transport/{alias}', [MgController::class, 'transport_view']);
    Route::get('/mining/{alias}', [MgController::class, 'mining_view']);
    Route::get('/complex/{alias}', [MgController::class, 'complex_view']);
    Route::get('/sitemap', [MgController::class, 'sitemap'])->name('sitemap');
    Route::get('/uppt', [MgController::class, 'uppt']);
    Route::get('/mining', [MgController::class, 'mining']);
    Route::get('/complex', [MgController::class, 'complex']);
    Route::get('/opendata', [MgController::class, 'opendata']);
    Route::get('/archive_vacancy', [MgController::class, 'archive_vacancy']);
    Route::get('/archive_vacancy/{alias}', [MgController::class, 'arxiv_vacancy_view']);
    Route::get('/opendata/{alias}', [MgController::class, 'opendata_view']);
    Route::get('/vacancy', [MgController::class, 'vacancy'])->name('vacancy.index');
    Route::get('/vacancy/{alias}', [MgController::class, 'vacancy_view']);
    Route::get('/faq', [MgController::class, 'faq']);
    Route::get('/products', [MgController::class, 'products']);
    Route::get('/products/{alias}', [MgController::class, 'products_view']);
    Route::get('/gallery/{alias}', [MgController::class, 'gallery_view']);
    Route::get('/video', [MgController::class, 'video']);
    Route::get('/news', [MgController::class, 'news']);
    Route::get('/smi', [MgController::class, 'smi']);
    Route::get('/vesty', [MgController::class, 'vesty']);
    Route::get('/smi/{alias}', [MgController::class, 'smi_view']);
    Route::get('/vesty/{alias}', [MgController::class, 'vesty_view']);
    Route::get('/news/{alias}', [MgController::class, 'news_view']);
    Route::get('/rss', [MgController::class, 'rss']);
    Route::get('/vote', [MgController::class, 'vote']);
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('u/action/calendar_plan', [HomeController::class, 'calendarPlan'])
        ->name('calendar.plan');
});
Route::post('/opendata/download-hit', [MgController::class, 'recordDownload'])->name('opendata.download_hit');
Route::get('rate/submit', [FormsController::class, 'submitRating'])->name('rate.submit');
Route::post('rate/submitComment', [FormsController::class, 'submitComment'])->name('rate.submitComment');
Route::post('/polls/vote', [FormsController::class, 'vote'])->name('polls.vote');
Route::post('/contact', [FormsController::class, 'contact'])->middleware('throttle:5,1')->name('form.contact');
