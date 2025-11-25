<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LawyerCase;
use Illuminate\Support\Facades\Auth;

class UserCaseController extends Controller
{
    /**
     * Display a listing of the cases for the authenticated user.
     */
    public function index()
    {
        $user = Auth::user();
        $cases = LawyerCase::where('user_id', $user->id)
            ->with('lawyer.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.cases.index', compact('cases'));
    }

    /**
     * Display the specified case.
     */
    public function show($id)
    {
        $user = Auth::user();
        $case = LawyerCase::where('user_id', $user->id)
            ->with(['lawyer.user', 'documents'])
            ->findOrFail($id);

        return view('user.cases.show', compact('case'));
    }
}
