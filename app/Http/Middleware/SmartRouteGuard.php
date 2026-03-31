<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class SmartRouteGuard
{
    public function __construct(
        protected RateLimiter $limiter
    ) {}

    // Throttle configurations
    protected array $throttleRules = [
        'global' => [
            'max_attempts' => 100,
            'decay_minutes' => 1,
        ],
        'search' => [
            'max_attempts' => 20,
            'decay_minutes' => 1,
        ],
        'form-send' => [ // Your form routes
            'max_attempts' => 3,
            'decay_minutes' => 5,
        ],
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // 1. Dynamic Throttling
        if ($this->shouldThrottle($request)) {
            return $this->throttleResponse($request);
        }

        // 2. Bot Detection
        if ($this->isSuspiciousBot($request)) {
            return response()->json(['error' => 'Access restricted'], 403);
        }

        // 3. Log request data
        $start = microtime(true);
        $response = $next($request);
        $this->logRequest($request, $start);

        return $response;
    }

    protected function shouldThrottle(Request $request): bool
    {
        foreach ($this->throttleRules as $key => $rule) {
            if ($key === 'global' || Str::contains($request->route()?->getName() ?? '', $key)) {
                $key = $this->resolveThrottleKey($request, $key);
                return $this->limiter->tooManyAttempts($key, $rule['max_attempts']);
            }
        }
        return false;
    }

    protected function throttleResponse(Request $request): Response
    {
        $retryAfter = $this->limiter->availableIn(
            $this->resolveThrottleKey($request, 'global')
        );

        return response()->json([
            'error' => 'Too many requests',
            'retry_after' => $retryAfter,
        ], 429);
    }

    protected function resolveThrottleKey(Request $request, string $type): string
    {
        return sha1(
            $request->ip() .
            $request->userAgent() .
            ($request->route()?->getName() ?? '') .
            $type
        );
    }

    protected function isSuspiciousBot(Request $request): bool
    {
        $agent = new Agent();
        $userAgent = strtolower($request->userAgent() ?? '');

        $botIndicators = ['bot', 'crawl', 'spider', 'headless', 'phantom', 'puppeteer'];

        return $agent->isRobot() || Str::contains($userAgent, $botIndicators);
    }

    protected function logRequest(Request $request, float $startTime): void
    {
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);

        app('log')->channel('requests')->info('Route accessed', [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route' => $request->route()?->getName(),
            'duration_ms' => $executionTime,
            'memory' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB',
        ]);
    }
}
