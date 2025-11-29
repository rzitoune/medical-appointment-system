<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSecretaryRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->user_type === 'secretary') {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
