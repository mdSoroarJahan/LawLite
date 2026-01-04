<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $lawyer = Auth::user()->lawyer;
        if (!$lawyer) abort(403);

        $query = Invoice::where('lawyer_id', $lawyer->id)->with('client');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $invoices = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('lawyer.invoices.index', compact('invoices'));
    }

    public function create()
    {
        // Get list of clients (users who have appointments or cases with this lawyer)
        $lawyer = Auth::user()->lawyer;

        // Simple approach: Get all users for now, or ideally filter by interaction
        // For MVP, let's just get users who have messaged or booked
        // Or just allow searching by email in the form.
        // Let's pass empty list and use AJAX or simple email input for now to be fast.

        return view('lawyer.invoices.create');
    }

    public function store(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $validated = $request->validate([
            'client_email' => 'required|email|exists:users,email',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'description' => 'required|string',
        ]);

        $client = User::where('email', $validated['client_email'])->first();

        $invoice = Invoice::create([
            'lawyer_id' => $lawyer->id,
            'user_id' => $client->id,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount' => $validated['amount'],
            'due_date' => $validated['due_date'],
            'description' => $validated['description'],
            'status' => 'unpaid'
        ]);

        return redirect()->route('lawyer.invoices.show', $invoice)->with('success', 'Invoice created successfully');
    }

    public function show($id)
    {
        $lawyer = Auth::user()->lawyer;
        $invoice = Invoice::where('lawyer_id', $lawyer->id)->with('client')->findOrFail($id);
        return view('lawyer.invoices.show', compact('invoice'));
    }

    public function markAsPaid($id)
    {
        $lawyer = Auth::user()->lawyer;
        $invoice = Invoice::where('lawyer_id', $lawyer->id)->findOrFail($id);

        $invoice->update(['status' => 'paid']);

        return back()->with('success', 'Invoice marked as paid');
    }
}
