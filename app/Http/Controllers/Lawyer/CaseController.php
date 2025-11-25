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

        // Try to link client by email
        if (!empty($validated['client_email'])) {
            $client = \App\Models\User::where('email', $validated['client_email'])->first();
            if ($client) {
                $validated['user_id'] = $client->id;
            }
        }

        $case = LawyerCase::create($validated);

        return redirect()->route('lawyer.cases.show', $case)->with('success', 'Case created successfully!');
    }

    /**
     * Display the specified case
     */
    public function show($id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->with(['documents', 'client'])->findOrFail($id);

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
            'outcome' => 'nullable|string|in:won,lost,settled,dismissed,other',
            'notes' => 'nullable|string',
        ]);

        // Try to link client by email
        if (!empty($validated['client_email'])) {
            $client = \App\Models\User::where('email', $validated['client_email'])->first();
            if ($client) {
                $validated['user_id'] = $client->id;
            }
        }

        $case->update($validated);

        return redirect()->route('lawyer.cases.show', $case)->with('success', 'Case updated successfully!');
    }

    public function uploadDocument(Request $request, $id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        $request->validate([
            'document' => 'required|file|max:10240', // 10MB max
            'file_name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('case_documents', 'public');

            \App\Models\CaseDocument::create([
                'lawyer_case_id' => $case->id,
                'file_path' => $path,
                'file_name' => $request->file_name,
                'uploaded_by' => Auth::id(),
            ]);

            return back()->with('success', 'Document uploaded successfully.');
        }

        return back()->with('error', 'No file uploaded.');
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

    /**
     * Store a newly created task
     */
    public function storeTask(Request $request, $id)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $case->tasks()->create([
            'title' => $request->title,
            'due_date' => $request->due_date,
        ]);

        return back()->with('success', 'Task added successfully.');
    }

    /**
     * Update the specified task
     */
    public function updateTask(Request $request, $id, $taskId)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);
        $task = $case->tasks()->findOrFail($taskId);

        $task->update([
            'is_completed' => $request->has('is_completed'),
        ]);

        return back()->with('success', 'Task updated.');
    }

    /**
     * Remove the specified task
     */
    public function destroyTask($id, $taskId)
    {
        $lawyer = Auth::user()->lawyer;
        $case = LawyerCase::where('lawyer_id', $lawyer->id)->findOrFail($id);
        $task = $case->tasks()->findOrFail($taskId);

        $task->delete();

        return back()->with('success', 'Task deleted.');
    }
}
