<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class LawyerDashboardController extends Controller
{
    /**
     * Show a minimal dashboard for lawyers.
     */
    public function dashboard(Request $request): View|ViewFactory
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') {
            abort(403, 'Unauthorized.');
        }

        return view('lawyers.dashboard', compact('user'));
    }
}
