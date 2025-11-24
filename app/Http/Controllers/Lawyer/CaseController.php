<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\LawyerCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    /**
     * Display a listing of the cases
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        if (!$lawyer) {
            // Create lawyer profile if it doesn't exist
            $lawyer = \App\Models\Lawyer::create([
                'user_id' => $user->id,
                'verification_status' => 'pending'
            ]);
        }

        $query = LawyerCase::where('lawyer_id', $lawyer->id);

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $cases = $query->orderBy('hearing_date', 'asc')
            ->orderBy('hearing_time', 'asc')
            ->paginate(20);

        return view('lawyer.cases.index', compact('cases'));
    }

    /**
     * Show the form for creating a new case
     */
    public function create()
    {
        return view('lawyer.cases.create');
    }

    /**
     * Store a newly created case
     */
    public function store(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        if (!$lawyer) {
            return redirect()->route('lawyer.dashboard')->with('error', 'Lawyer profile not found');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'hearing_date' => 'nullable|date',
            'hearing_time' => 'nullable',
            'court_location' => 'nullable|string|max:255',
            'case_number' => 'nullable|string|max:100',
            'status' => 'required|in:pending,in_progress,completed,closed',
            'notes' => 'nullable|string',
        ]);

        $validated['lawyer_id'] = $lawyer->id;

        LawyerCase::create($validated);

        return redirect()->route('lawyer.cases.index')->with('success', 'Case created successfully!');
    }

    /**
     * Display the specified case
     */
    public function show($id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        return view('lawyer.cases.show', compact('case'));
    }

    /**
     * Show the form for editing the specified case
     */
    public function edit($id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        return view('lawyer.cases.edit', compact('case'));
    }

    /**
     * Update the specified case
     */
    public function update(Request $request, $id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_name' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_phone' => 'nullable|string|max:20',
            'hearing_date' => 'nullable|date',
            'hearing_time' => 'nullable',
            'court_location' => 'nullable|string|max:255',
            'case_number' => 'nullable|string|max:100',
            'status' => 'required|in:pending,in_progress,completed,closed',
            'notes' => 'nullable|string',
        ]);

        $case->update($validated);

        return redirect()->route('lawyer.cases.show', $case)->with('success', 'Case updated successfully!');
    }

    /**
     * Remove the specified case
     */
    public function destroy($id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        $case->delete();

        return redirect()->route('lawyer.cases.index')->with('success', 'Case deleted successfully!');
    }
}
