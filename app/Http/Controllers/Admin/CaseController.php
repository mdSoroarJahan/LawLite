<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LawyerCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    /**
     * Display a listing of all cases from all lawyers.
     */
    public function index(Request $request)
    {
        $query = LawyerCase::with(['lawyer.user', 'client']);

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $cases = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.cases.index', compact('cases'));
    }

    /**
     * Display the specified case.
     */
    public function show($id)
    {
        $case = LawyerCase::with(['lawyer.user', 'client', 'documents', 'tasks'])->findOrFail($id);

        return view('admin.cases.show', compact('case'));
    }
}
