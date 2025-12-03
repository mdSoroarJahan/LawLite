<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Lawyer;
use App\Notifications\GenericNotification;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Services\Payment\SSLCommerz;

class AppointmentController extends Controller
{
    protected $sslcommerz;

    public function __construct(SSLCommerz $sslcommerz)
    {
        $this->sslcommerz = $sslcommerz;
    }
    /**
     * Get available slots for a lawyer on a specific date.
     */
    public function getSlots(Request $request, $lawyerId): JsonResponse
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = Carbon::parse($request->date);
        $dayOfWeek = strtolower($date->format('l')); // monday, tuesday...

        $lawyer = Lawyer::findOrFail($lawyerId);

        // Get availability for this day
        $availabilities = $lawyer->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->get();

        if ($availabilities->isEmpty()) {
            return new JsonResponse(['ok' => true, 'slots' => []]);
        }

        // Get existing appointments
        $existingAppointments = Appointment::where('lawyer_id', $lawyerId)
            ->where('date', $request->date)
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->pluck('time')
            ->map(function ($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        $slots = [];
        $duration = 30; // 30 minutes per slot

        foreach ($availabilities as $availability) {
            $start = Carbon::parse($availability->start_time);
            $end = Carbon::parse($availability->end_time);

            while ($start->copy()->addMinutes($duration)->lte($end)) {
                $checkTime = $start->format('H:i');
                $displayTime = $start->format('h:i A');

                // Check if slot is already booked
                if (!in_array($checkTime, $existingAppointments)) {
                    // Also check if it's in the past for today
                    if (!$date->isToday() || $start->gt(now())) {
                        $slots[] = $displayTime;
                    }
                }

                $start->addMinutes($duration);
            }
        }

        return new JsonResponse([
            'ok' => true,
            'slots' => $slots,
            'hourly_rate' => $lawyer->hourly_rate ?? 500 // Default if null
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function book(Request $request): JsonResponse
    {
        $data = (array) $request->validate([
            'lawyer_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'nullable|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();
        if ($user === null) {
            return new JsonResponse(['ok' => false, 'message' => 'Unauthenticated'], 401);
        }

        // Validate Availability
        $date = Carbon::parse($data['date']);
        $dayOfWeek = strtolower($date->format('l'));
        $time = Carbon::parse($data['time']);

        $lawyer = Lawyer::findOrFail($data['lawyer_id']);

        // Check if lawyer works on this day and time
        $isAvailable = $lawyer->availabilities()
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->whereTime('start_time', '<=', $time->format('H:i:s'))
            ->whereTime('end_time', '>=', $time->copy()->addMinutes(30)->format('H:i:s')) // Ensure slot fits
            ->exists();

        if (!$isAvailable) {
            // Fallback: If no availability is set at all for the lawyer, maybe allow? 
            // For Phase 2, we want to enforce it. But if they haven't set it up, it blocks everything.
            // Let's check if they have ANY availability set.
            if ($lawyer->availabilities()->exists()) {
                return new JsonResponse(['ok' => false, 'message' => 'Lawyer is not available at this time.'], 422);
            }
            // If no availability set, maybe allow for legacy/testing? 
            // Or strictly block. Let's strictly block to force usage.
            // return new JsonResponse(['ok' => false, 'message' => 'Lawyer has not set their availability.'], 422);
            // Actually, for transition, let's allow if NO availability is defined at all.
        }

        // Check for conflicts
        $conflict = Appointment::where('lawyer_id', $data['lawyer_id'])
            ->where('date', $data['date'])
            ->where('time', $time->format('H:i:s')) // Exact match for now (assuming 30 min slots)
            ->whereIn('status', ['scheduled', 'confirmed', 'pending'])
            ->exists();

        if ($conflict) {
            return new JsonResponse(['ok' => false, 'message' => 'This slot is already booked.'], 422);
        }

        // Calculate Payment
        $amount = $lawyer->hourly_rate ?? 500;
        $paymentStatus = 'pending';
        $transactionId = null;

        // Create appointment first with pending status
        $appointment = Appointment::create([
            'lawyer_id' => $data['lawyer_id'],
            'user_id' => $user->id,
            'date' => $data['date'],
            'time' => $time->format('H:i:s'),
            'status' => 'pending',
            'type' => $data['type'] ?? 'online',
            'notes' => $data['notes'] ?? null,
            'payment_status' => 'pending',
            'amount' => $amount,
            'payment_method' => $data['payment_method'],
            'transaction_id' => null,
        ]);

        // notify the lawyer
        try {
            if ($lawyer->user) {
                $lawyer->user->notify(new GenericNotification('appointment', 'You have a new appointment'));
            }
        } catch (\Exception $e) {
            // log
        }

        // If online payment, return redirect URL
        if (in_array($data['payment_method'], ['bkash', 'card', 'sslcommerz'])) {
            return new JsonResponse([
                'ok' => true,
                'appointment' => $appointment,
                'redirect_url' => route('payment.checkout', $appointment->id)
            ]);
        }

        return new JsonResponse(['ok' => true, 'appointment' => $appointment]);
    }

    public function paymentCheckout($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Security check
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($appointment->payment_status === 'paid') {
            return redirect()->route('appointments.index')->with('success', 'Payment already completed.');
        }

        return view('payment.mock_gateway', compact('appointment'));
    }

    public function paymentProcess($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // Initiate SSLCommerz Payment
        $paymentData = [
            'total_amount' => $appointment->lawyer->hourly_rate ?? 500,
            'currency' => 'BDT',
            'tran_id' => uniqid('APPT_'),
            'cus_name' => Auth::user()->name,
            'cus_email' => Auth::user()->email,
            'cus_phone' => Auth::user()->phone ?? '01700000000',
            'product_name' => 'Consultation with ' . $appointment->lawyer->user->name,
            'ref_id' => 'APPT_' . $appointment->id, // Internal Reference
        ];

        $result = $this->sslcommerz->initiatePayment($paymentData);

        if ($result['status'] === 'success') {
            return redirect($result['redirect_url']);
        } else {
            return back()->with('error', 'Payment initiation failed: ' . ($result['message'] ?? 'Unknown error'));
        }
    }

    /**
     * List user's appointments
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        $appointments = Appointment::where('user_id', $user->id)
            ->with('lawyer.user')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }
}
