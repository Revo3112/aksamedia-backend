<?php
// app/Http/Middleware/Guest.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('sanctum')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah login',
            ], 403);
        }

        return $next($request);
    }
}
