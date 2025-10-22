<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Minimal implementation: don't enforce auth in dev scaffold.
        return $next($request);
    }
}
