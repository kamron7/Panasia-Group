<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Auth_Logins;
use App\Models\IP;
use App\Models\Ip_admin;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
//        Auth_Logins::where('ip_address',request()->getClientIp())->update([ 'ban' => false]);
//        session(['ban_ip'=>'']);
        foreach (Ip_admin::gets(['sort' => 'asc']) as $item)
            if (\request()->getClientIp() != $item->ip_address) return url('/') . LANG;

        if ($login = Auth_Logins::get(['ip_address' => request()->getClientIp(), 'ban' => false])) {
            $ban = $login->ban_time;

            if (now()->isAfter($ban)) {
                session()->forget('ban_ip');
                $model = new Auth_Logins();
                $model->my_save(['ban' => false, 'attempt' => 25], $login->id);
            } else {
                $diff = now()->diff($ban);
                session(['ban_ip' => $diff->i + ($diff->s / 60)]);
            }
        }
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        if (getFilterData('captcha') !== session('captcha_code')) {
            throw ValidationException::withMessages([
                'captcha' => 'Коды безопасности не совпадают',
            ]);
        }
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('admin', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
