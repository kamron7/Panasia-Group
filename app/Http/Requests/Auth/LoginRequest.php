<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth_Logins;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            $model = new Auth_Logins();

            if ($login = Auth_Logins::get(['ip_address' => request()->getClientIp()])) {
                if ($login->attempt == 2) {
                    $ban_time = now()->addMinutes(5);
                    $model->my_save(['ban' => true, 'ban_time' => $ban_time], $login->id);
                    session(['ban_ip' => $ban_time->format('d.m.Y H:i:s')]);
                }
                $model->my_save(['attempt' => $login->attempt + 1], $login->id);
            } else
                $model->my_save(['ip_address' => request()->getClientIp(), 'attempt' => 1, 'ban_time' => now()]);

            throw ValidationException::withMessages([
                'username' => 'Не правильный логин или пароль',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
