<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class TrackLiveVisitors
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $key = 'live_visitors';

        $visitors = Cache::get($key, []);

        $now = now();

        $visitors = array_filter($visitors, function ($timestamp) use ($now) {
            return $now->diffInMinutes($timestamp) < 1;
        });

        $visitors[$ip] = $now->toDateTimeString();

        Cache::put($key, $visitors, now()->addMinutes(1));

        return $next($request);
    }
}
