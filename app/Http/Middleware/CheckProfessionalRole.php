<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfessionalRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->user_type === 'professional') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
