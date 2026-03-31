<?php

namespace Tests\Feature\Middleware;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Http\Middleware\SmartRouteGuard;
use Illuminate\Support\Facades\Log;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;

class SmartRouteGuardTest extends TestCase
{
    protected function createMiddleware(): SmartRouteGuard
    {
        // Use Laravel's cache system (switches to array driver automatically for tests)
        $rateLimiter = app(RateLimiter::class);
        return new SmartRouteGuard($rateLimiter);
    }

    /**
     * Test that known bots are blocked
     */
    public function test_blocks_known_bots()
    {
        $botUserAgents = [
            'Googlebot/2.1 (+http://www.google.com/bot.html)',
            'Mozilla/5.0 (compatible; Bingbot/2.0)',
            'HeadlessChrome/91.0.4472.124'
        ];

        foreach ($botUserAgents as $ua) {
            $request = Request::create('/test', 'GET');
            $request->headers->set('User-Agent', $ua);

            $response = $this->createMiddleware()->handle($request, fn() => response('OK'));
            $this->assertEquals(403, $response->getStatusCode(), "Failed to block: $ua");
        }
    }

    /**
     * Test that legitimate browsers are allowed
     */
    public function test_allows_legitimate_browsers()
    {
        $legitUserAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'PostmanRuntime/7.28.4'
        ];

        foreach ($legitUserAgents as $ua) {
            $request = Request::create('/test', 'GET');
            $request->headers->set('User-Agent', $ua);

            $response = $this->createMiddleware()->handle($request, fn() => response('OK'));
            $this->assertEquals(200, $response->getStatusCode(), "Falsely blocked: $ua");
        }
    }

    /**
     * Test that request data is logged
     */
    public function test_logs_request_data()
    {
        Log::shouldReceive('channel->info')
            ->once()
            ->withArgs(function ($message, $context) {
                return str_contains($context['url'], '/test-log') &&
                    $context['memory'] !== null;
            });

        $request = Request::create('/test-log', 'GET');
        $this->createMiddleware()->handle($request, fn() => response('OK'));
    }
}
