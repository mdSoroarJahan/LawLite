<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin only.');
        }
        return $next($request);
    }
}
