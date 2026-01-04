<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of all invoices from all lawyers.
     */
    public function index(Request $request)
    {
        $query = Invoice::with(['lawyer.user', 'client']);

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $invoices = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Display the specified invoice.
     */
    public function show($id)
    {
        $invoice = Invoice::with(['lawyer.user', 'client'])->findOrFail($id);

        return view('admin.invoices.show', compact('invoice'));
    }
}
