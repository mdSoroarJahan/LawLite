<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerifiedLawyer
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'lawyer' || !$user->lawyer || $user->lawyer->verification_status !== 'verified') {
            abort(403, 'Lawyer not verified.');
        }
        return $next($request);
    }
}
