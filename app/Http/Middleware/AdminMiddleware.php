<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is admin (type = 1)
        if (Auth::check() && Auth::user()->type == 1) {
            return $next($request);
        }

        // If not admin, show 403 forbidden error
        abort(403, 'Unauthorized access. Admin privileges required.');
    }
}