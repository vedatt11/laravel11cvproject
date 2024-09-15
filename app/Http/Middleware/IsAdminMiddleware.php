<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'Yetkisiz Giriş'], 403);
        }

        // Check if the authenticated user is an admin
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Yetkisiz Giriş'], 403);
        }

        // Allow the request to proceed if the user is an admin
        return $next($request);

    }
}
