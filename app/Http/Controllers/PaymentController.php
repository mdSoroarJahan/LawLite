<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $val_id = $request->input('val_id'); // Validation ID from SSLCommerz

        // The 'value_a' field contains our internal reference ID (e.g., Appointment ID or Invoice ID)
        // Format: APPT_123 or INV_456
        $ref_id = $request->input('value_a');

        // In a real scenario, you should call the VALIDATION API here to verify the amount and status
        // For this demo, we assume success if we reached here with a valid transaction ID.

        if (strpos($ref_id, 'APPT_') === 0) {
            $appointmentId = substr($ref_id, 5);
            $appointment = Appointment::find($appointmentId);

            if ($appointment) {
                $appointment->update([
                    'payment_status' => 'paid',
                    'transaction_id' => $tran_id,
                ]);

                // Generate Invoice for the paid appointment
                Invoice::create([
                    'user_id' => $appointment->user_id,
                    'lawyer_id' => $appointment->lawyer_id,
                    'invoice_number' => 'INV-' . strtoupper(uniqid()),
                    'amount' => $appointment->amount ?? ($appointment->lawyer->hourly_rate ?? 500),
                    'due_date' => now(),
                    'status' => 'paid',
                    'description' => 'Consultation Fee - ' . $appointment->date . ' (' . $appointment->time . ')',
                ]);

                // Return view directly to handle SameSite cookie issues on cross-site POST
                return view('payment.success');
            }
        } elseif (strpos($ref_id, 'INV_') === 0) {
            $invoiceId = substr($ref_id, 4);
            $invoice = Invoice::find($invoiceId);

            if ($invoice) {
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'transaction_id' => $tran_id,
                ]);
                // Return view directly to handle SameSite cookie issues on cross-site POST
                return view('payment.success');
            }
        }

        return redirect('/')->with('error', 'Payment successful but order not found.');
    }

    public function fail(Request $request)
    {
        return redirect('/')->with('error', 'Payment failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        return redirect('/')->with('warning', 'Payment cancelled.');
    }

    public function ipn(Request $request)
    {
        // Handle Instant Payment Notification (Background check)
        // Log::info('IPN Received', $request->all());
    }
}
