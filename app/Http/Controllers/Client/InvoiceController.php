<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invoices = Invoice::where('user_id', $user->id)
            ->with('lawyer.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)
            ->with('lawyer.user')
            ->findOrFail($id);

        return view('client.invoices.show', compact('invoice'));
    }

    public function checkout($id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)
            ->where('status', 'unpaid')
            ->findOrFail($id);

        return view('client.invoices.checkout', compact('invoice'));
    }

    public function processPayment(Request $request, $id)
    {
        $user = Auth::user();
        $invoice = Invoice::where('user_id', $user->id)
            ->where('status', 'unpaid')
            ->findOrFail($id);

        // Simulate payment processing
        // In a real app, this would interact with Stripe/SSLCommerz

        $invoice->status = 'paid';
        $invoice->save();

        return redirect()->route('client.invoices.show', $id)->with('success', 'Payment successful! Invoice marked as paid.');
    }
}
