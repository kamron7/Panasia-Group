<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/success', [GoogleController::class, 'success']);
Route::post('/error-send', [FormsController::class, 'errorSend'])->name('form.error');
Route::get('change_lang/{locale}', function ($locale) {
    if (in_array($locale, array_keys(getSiteLang()))) {
        $langs = implode('|', array_keys(getSiteLang()));
        if (($previous = URL::previousPath()) != '/') {
            $changeLang = preg_replace("/\/($langs)(\/|$)/", "/$locale$2", $previous);
            return go_to($changeLang);
        }
        return go_to("/$locale");
    }

    return redirect()->back();
})->name('change_lang');

Route::get('/captcha', [CaptchaController::class, 'generateCaptcha'])->name('captcha');
Route::get('/recap', [CaptchaController::class, 'recap'])->name('recap');
Route::post('u/action/calendar_plan', [HomeController::class, 'calendarPlan'])->name('calendar.plan');
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/public.php';

