<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->user_type === 'administrator') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
