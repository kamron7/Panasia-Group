<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if ($user->status == 0) {
                return redirect('/login')->with('error', 'Ваша учетная запись заблокирована. Пожалуйста, свяжитесь со службой поддержки.');
            }

            Auth::login($user);

            Session::put('google_name', $user->username);

            return redirect('/admin');
        }

        return redirect('/login')->with('error', 'Пользователь не зарегистрирован и не одобрен.');
    }

    public function success()
    {
        return redirect('/admin');
    }
}


