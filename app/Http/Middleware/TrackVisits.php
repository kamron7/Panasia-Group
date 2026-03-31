<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

class TrackVisits
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*') && !app()->runningInConsole()) {
            if (!session()->has('visit_logged')) {
                Visit::record();
                session(['visit_logged' => true]);
            }
        }

        return $next($request);
    }

}
