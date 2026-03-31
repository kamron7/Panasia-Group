<?php

namespace App\Http\Controllers\Auth;

use App\Mail\PasswordChangeConfirmMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\RegisterCodeMail;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class NewLoginRegisterController extends Controller
{
    private const OTP_TTL_MIN = 15;
    private const PW_TTL_MIN = 15;   // minutes
    private const PW_MAX_TRIES = 6;
    private const OTP_MAX_TRIES = 6;

    private static function normEmail(?string $email): string
    {
        return Str::lower(trim((string)$email));
    }

    private static function key(Request $r, string $prefix, ?string $email = null): string
    {
        $e = self::normEmail($email ?? (string)$r->input('email'));
        return implode('|', [$prefix, $e ?: '-', $r->ip()]);
    }

    private static function hit(string $key, int $decaySeconds): void
    {
        RateLimiter::hit($key, $decaySeconds);
    }

    private static function blocked(string $key)
    {
        if (!RateLimiter::tooManyAttempts($key, 1)) {
            return null;
        }
        $secs = RateLimiter::availableIn($key);
        return response()->json(['ok' => false, 'message' => "Слишком часто. Попробуйте через {$secs}с."], 429);
    }


    public function start(Request $request)
    {
        $key = self::key($request, 'reg-start');
        if ($resp = self::blocked($key)) {
            return $resp;
        }
        self::hit($key, 30);

        $v = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->letters(), 'confirmed'],
        ], [], [
            'username' => 'Имя', 'email' => 'E-mail', 'password' => 'Пароль'
        ]);

        if ($v->fails()) {
            return response()->json(['ok' => false, 'message' => $v->errors()->first()], 422);
        }

        $data = $v->validated();
        $data['email'] = self::normEmail($data['email']);

        $existingKey = 'reg:idx:' . $data['email'];
        $oldToken = Cache::get($existingKey);

        $token = (string)Str::uuid();
        $code = (string)random_int(10000, 99999);

        $payload = [
            'username' => trim($data['username']),
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'password_plain' => $data['password'], // Store plain text password
            'code' => $code,
            'attempts' => 0,
            'ip' => $request->ip(),
            'ua' => (string)$request->userAgent(),
            'created_at' => CarbonImmutable::now()->toIso8601String(),
        ];

        $ttl = now()->addMinutes(self::OTP_TTL_MIN);
        Cache::put("reg:$token", $payload, $ttl);
        Cache::put($existingKey, $token, $ttl);
        if ($oldToken && $oldToken !== $token) {
            Cache::forget("reg:$oldToken");
        }

        try {
            // Queue the email (faster response; falls back to sync if no queue worker)
            Mail::to($data['email'])->queue(new RegisterCodeMail($code));
        } catch (\Throwable $e) {
            Cache::forget("reg:$token");
            Cache::forget($existingKey);
            return response()->json(['ok' => false, 'message' => 'Не удалось отправить письмо. Попробуйте позже.'], 500);
        }

        return response()->json(['ok' => true, 'token' => $token]);
    }


    public function verify(Request $request)
    {
        $key = self::key($request, 'reg-verify', $request->input('token'));
        if ($resp = self::blocked($key)) {
            return $resp;
        }
        self::hit($key, 5);

        $request->validate([
            'token' => ['required', 'string', 'size:36'],
            'code' => ['required', 'digits:5'],
        ], [], ['code' => 'Код']);

        $cacheKey = "reg:{$request->token}";
        $stash = Cache::get($cacheKey);
        if (!$stash) {
            return response()->json(['ok' => false, 'message' => 'Сессия регистрации истекла. Начните заново.'], 410);
        }

        if (($stash['attempts'] ?? 0) >= self::OTP_MAX_TRIES) {
            Cache::forget($cacheKey);
            Cache::forget('reg:idx:' . $stash['email']);
            return response()->json(['ok' => false, 'message' => 'Слишком много попыток. Начните заново.'], 429);
        }

        $code = preg_replace('/\D+/', '', (string)$request->code);
        if ($code !== $stash['code']) {
            $stash['attempts'] = ($stash['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $stash, now()->addMinutes(self::OTP_TTL_MIN));
            return response()->json(['ok' => false, 'message' => 'Неверный код.'], 422);
        }

        $email = $stash['email'];
        $existing = User::where('email', $email)->first();
        if ($existing) {
            Auth::login($existing);
            $request->session()->regenerate();
            Cache::forget($cacheKey);
            Cache::forget('reg:idx:' . $email);
            return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
        }

        $plainPassword = $stash['password_plain'] ?? null;

        $user = User::create([
            'username' => $stash['username'],
            'email' => $email,
            'password' => $stash['password_hash'],
            'pass' => $plainPassword,
            'email_verified_at' => now(),
            'role' => 'user',
        ]);

        event(new Registered($user));

        Cache::forget($cacheKey);
        Cache::forget('reg:idx:' . $email);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
    }


    public function resend(Request $request)
    {
        $key = self::key($request, 'reg-resend', $request->input('token'));
        if ($resp = self::blocked($key)) {
            return $resp;
        }
        self::hit($key, 45);

        $request->validate([
            'token' => ['required', 'string', 'size:36'],
        ]);

        $cacheKey = "reg:{$request->token}";
        $stash = Cache::get($cacheKey);
        if (!$stash) {
            return response()->json(['ok' => false, 'message' => 'Сессия регистрации истекла.'], 410);
        }

        $stash['code'] = (string)random_int(10000, 99999);
        Cache::put($cacheKey, $stash, now()->addMinutes(self::OTP_TTL_MIN));

        try {
            Mail::to($stash['email'])->queue(new RegisterCodeMail($stash['code']));
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => 'Не удалось отправить код.'], 500);
        }

        return response()->json(['ok' => true]);
    }


    public function login(Request $request)
    {
        $key = self::key($request, 'login');
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $secs = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Слишком много попыток. Попробуйте через {$secs}с."])->withInput();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string'],
        ]);

        $credentials['email'] = self::normEmail($credentials['email']);
        $remember = $request->boolean('remember');

        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            self::hit($key, 60);
            return back()->withErrors(['email' => 'Неверные учётные данные.'])->withInput();
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin-dashboard');
        }

        return redirect()->intended('/dashboard');
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/');
    }

    private static function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email, 2);
        $nameMasked = mb_substr($name, 0, 1) . str_repeat('•', max(1, mb_strlen($name) - 2)) . mb_substr($name, -1);
        $domainParts = explode('.', $domain);
        $domainMasked = mb_substr($domainParts[0], 0, 1) . '•' . mb_substr($domainParts[0], -1);
        return "{$nameMasked}@{$domainMasked}." . end($domainParts);
    }

    private static function findUserByLogin(string $login): ?User
    {
        $login = trim($login);
        if (str_contains($login, '@')) {
            $email = self::normEmail($login);
            return User::where('email', $email)->first();
        }
        return User::where('username', $login)->first();
    }

    public function pwStart(Request $request)
    {
        $key = self::key($request, 'pw-start', $request->input('login'));
        if ($resp = self::blocked($key)) { return $resp; }
        self::hit($key, 30);

        $request->validate([
            'login' => ['required', 'string', 'max:255'],
            'token' => ['nullable', 'string', 'size:36'],
        ]);

        if ($request->filled('token')) {
            $cacheKey = "pwd:{$request->token}";
            $stash = Cache::get($cacheKey);
            if (!$stash) {
                return response()->json(['ok' => false, 'message' => 'Сессия сброса истекла.'], 410);
            }
            $stash['code'] = (string)random_int(10000, 99999);
            $stash['verified'] = false;
            Cache::put($cacheKey, $stash, now()->addMinutes(self::PW_TTL_MIN));
            try {
                Mail::to($stash['email'])->queue(new PasswordChangeConfirmMail($stash['code']));
            } catch (\Throwable $e) {
                return response()->json(['ok' => false, 'message' => 'Не удалось отправить код.'], 500);
            }
            return response()->json(['ok' => true, 'token' => $request->token, 'to' => self::maskEmail($stash['email'])]);
        }

        $user = self::findUserByLogin((string)$request->input('login'));
        if (!$user) {
            return response()->json(['ok' => true, 'token' => Str::uuid()->toString(), 'to' => self::maskEmail('noreply@example.com')]);
        }

        $email = self::normEmail($user->email);
        $token = (string)Str::uuid();
        $code  = (string)random_int(10000, 99999);

        $payload = [
            'user_id'    => $user->id,
            'email'      => $email,
            'code'       => $code,
            'attempts'   => 0,
            'verified'   => false,
            'ip'         => $request->ip(),
            'ua'         => (string)$request->userAgent(),
            'created_at' => CarbonImmutable::now()->toIso8601String(),
        ];

        $ttl = now()->addMinutes(self::PW_TTL_MIN);
        Cache::put("pwd:$token", $payload, $ttl);
        Cache::put("pwd:idx:$email", $token, $ttl);

        try {
            Mail::to($email)->queue(new PasswordChangeConfirmMail($code));
        } catch (\Throwable $e) {
            Cache::forget("pwd:$token");
            Cache::forget("pwd:idx:$email");
            return response()->json(['ok' => false, 'message' => 'Не удалось отправить письмо. Попробуйте позже.'], 500);
        }

        return response()->json(['ok' => true, 'token' => $token, 'to' => self::maskEmail($email)]);
    }

    public function pwVerify(Request $request)
    {
        $key = self::key($request, 'pw-verify', $request->input('token'));
        if ($resp = self::blocked($key)) { return $resp; }
        self::hit($key, 5);

        $request->validate([
            'token' => ['required', 'string', 'size:36'],
            'code'  => ['required', 'digits:5'],
        ], [], ['code' => 'Код']);

        $cacheKey = "pwd:{$request->token}";
        $stash = Cache::get($cacheKey);
        if (!$stash) {
            return response()->json(['ok' => false, 'message' => 'Сессия сброса истекла. Начните заново.'], 410);
        }

        if (($stash['attempts'] ?? 0) >= self::PW_MAX_TRIES) {
            Cache::forget($cacheKey);
            Cache::forget('pwd:idx:' . $stash['email']);
            return response()->json(['ok' => false, 'message' => 'Слишком много попыток. Начните заново.'], 429);
        }

        $code = preg_replace('/\D+/', '', (string)$request->code);
        if ($code !== $stash['code']) {
            $stash['attempts'] = ($stash['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $stash, now()->addMinutes(self::PW_TTL_MIN));
            return response()->json(['ok' => false, 'message' => 'Неверный код.'], 422);
        }

        $stash['verified'] = true;
        Cache::put($cacheKey, $stash, now()->addMinutes(self::PW_TTL_MIN));

        return response()->json(['ok' => true]);
    }

    public function pwChange(Request $request)
    {
        $key = self::key($request, 'pw-change', $request->input('token'));
        if ($resp = self::blocked($key)) { return $resp; }
        self::hit($key, 5);

        $request->validate([
            'token'    => ['required', 'string', 'size:36'],
            'password' => [ 'required', Password::min(8)->mixedCase()->numbers()->letters(), 'confirmed' ],
        ], [], ['password' => 'Пароль']);

        $cacheKey = "pwd:{$request->token}";
        $stash = Cache::get($cacheKey);
        if (!$stash) {
            return response()->json(['ok' => false, 'message' => 'Сессия сброса истекла. Начните заново.'], 410);
        }
        if (!($stash['verified'] ?? false)) {
            return response()->json(['ok' => false, 'message' => 'Код не подтверждён.'], 422);
        }

        $user = User::find($stash['user_id'] ?? 0);
        if (!$user) {
            Cache::forget($cacheKey);
            Cache::forget('pwd:idx:' . ($stash['email'] ?? ''));
            return response()->json(['ok' => false, 'message' => 'Пользователь не найден.'], 404);
        }

        if (\Illuminate\Support\Facades\Hash::check((string)$request->password, $user->password)) {
            return response()->json([
                'ok' => false,
                'message' => 'Новый пароль не может совпадать со старым. Укажите другой.'
            ], 422);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make((string)$request->password);
        $user->save();

        Cache::forget($cacheKey);
        Cache::forget('pwd:idx:' . $stash['email']);

        return response()->json(['ok' => true, 'redirect' => url('/login-c')]);
    }



}
