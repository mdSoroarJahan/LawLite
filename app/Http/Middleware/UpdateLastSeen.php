<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            /** @var \App\Models\User $user */
            $user = \Illuminate\Support\Facades\Auth::user();
            // Update cache for fast "is online" check (valid for 5 minutes)
            \Illuminate\Support\Facades\Cache::put('user-is-online-' . $user->id, true, now()->addMinutes(5));

            // Update database for "last seen" timestamp
            // We can throttle this to avoid too many DB writes, e.g., only update if > 5 min ago
            // But for now, let's just update it.
            $user->last_seen_at = now();
            $user->save();
        }
        return $next($request);
    }
}
