<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class Authenticate
{
    public function handle(Request $request, Closure $next, ?string $guard = null): mixed
    {
        // Minimal implementation: don't enforce auth in dev scaffold.
        return $next($request);
    }
}
