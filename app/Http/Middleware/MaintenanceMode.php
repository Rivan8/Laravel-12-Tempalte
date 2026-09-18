<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (filter_var(env('APP_MAINTENANCE_MODE', false), FILTER_VALIDATE_BOOL)
            && ! $request->is('up')) {
            return response()->view('maintenance', status: 503)
                ->header('Retry-After', '3600');
        }

        return $next($request);
    }
}
