<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = $request->user();
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized.');
        }
        return $next($request);
    }
}
