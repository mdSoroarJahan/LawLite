<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerifiedLawyer
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();
        /** @var \App\Models\Lawyer|null $lawyer */
        $lawyer = $user ? $user->lawyer : null;
        if (!$user || $user->role !== 'lawyer' || !$lawyer || $lawyer->verification_status !== 'verified') {
            abort(403, 'Lawyer not verified.');
        }
        return $next($request);
    }
}
