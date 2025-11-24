<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LawyerVerificationRequested;
use App\Models\LawyerCase;

class LawyerDashboardController extends Controller
{
    /**
     * Show lawyer dashboard with upcoming cases and AI assistant.
     */
    public function dashboard(Request $request): View|ViewFactory
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') {
            abort(403, 'Unauthorized.');
        }

        $lawyer = $user->lawyer;

        // Get upcoming cases (hearing date in the future or today)
        $upcomingCases = [];
        if ($lawyer) {
            $upcomingCases = LawyerCase::where('lawyer_id', $lawyer->id)
                ->where(function ($query) {
                    $query->whereDate('hearing_date', '>=', now())
                        ->orWhereNull('hearing_date');
                })
                ->whereIn('status', ['pending', 'in_progress'])
                ->orderBy('hearing_date', 'asc')
                ->orderBy('hearing_time', 'asc')
                ->limit(10)
                ->get();
        }

        return view('lawyers.dashboard', compact('user', 'lawyer', 'upcomingCases'));
    }

    /**
     * Show a simple list of appointments for the lawyer (placeholder).
     */
    public function appointments(Request $request): View|ViewFactory
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') abort(403);

        $lawyer = $user->lawyer;
        $appointments = [];
        if ($lawyer) {
            try {
                $query = \App\Models\Appointment::where('lawyer_id', $lawyer->id)->with('user');

                // Filter by status if provided
                if ($request->has('status') && $request->status != '') {
                    $query->where('status', $request->status);
                }

                $appointments = $query->orderBy('date', 'asc')
                    ->orderBy('time', 'asc')
                    ->get();
            } catch (\Throwable $e) {
                $appointments = [];
            }
        }

        return view('lawyers.appointments', compact('user', 'appointments'));
    }

    /**
     * Accept an appointment
     */
    public function acceptAppointment(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') abort(403);

        $lawyer = $user->lawyer;
        if (!$lawyer) {
            return redirect()->route('lawyer.appointments')->with('error', 'Lawyer profile not found.');
        }

        $appointment = \App\Models\Appointment::where('id', $id)
            ->where('lawyer_id', $lawyer->id)
            ->firstOrFail();

        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()->route('lawyer.appointments')->with('success', 'Appointment accepted successfully.');
    }

    /**
     * Reject an appointment
     */
    public function rejectAppointment(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') abort(403);

        $lawyer = $user->lawyer;
        if (!$lawyer) {
            return redirect()->route('lawyer.appointments')->with('error', 'Lawyer profile not found.');
        }

        $appointment = \App\Models\Appointment::where('id', $id)
            ->where('lawyer_id', $lawyer->id)
            ->firstOrFail();

        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('lawyer.appointments')->with('success', 'Appointment rejected.');
    }

    /**
     * Show and handle profile edit (minimal fields for demo).
     */
    public function editProfile(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') abort(403);

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:30',
                'city' => 'nullable|string|max:120',
                'expertise' => 'nullable|string|max:255',
                'documents' => 'nullable|array',
                'documents.*' => 'file|mimes:pdf,jpeg,png,jpg|max:5120',
            ]);

            $user->name = strval($data['name']);
            $user->phone = isset($data['phone']) ? strval($data['phone']) : $user->phone;
            $user->save();

            // Update or create lawyer row
            $lawyer = $user->lawyer;
            if (! $lawyer) {
                $lawyer = \App\Models\Lawyer::create(['user_id' => $user->id]);
            }
            $lawyer->city = isset($data['city']) ? strval($data['city']) : $lawyer->city;
            $lawyer->expertise = isset($data['expertise']) ? strval($data['expertise']) : $lawyer->expertise;

            // Handle uploaded documents (append to existing documents array)
            if ($request->hasFile('documents')) {
                $stored = [];
                foreach ($request->file('documents') as $file) {
                    if (! $file || ! $file->isValid()) continue;
                    $path = $file->store('lawyer_documents', 'public');
                    if ($path) $stored[] = $path;
                }

                $existing = is_array($lawyer->documents) ? $lawyer->documents : [];
                $lawyer->documents = array_values(array_merge($existing, $stored));
            }

            $lawyer->save();

            return redirect()->route('lawyer.dashboard')->with('status', 'Profile updated');
        }

        $lawyer = $user->lawyer;
        return view('lawyers.profile_edit', compact('user', 'lawyer'));
    }

    /**
     * Allow lawyer to request verification (sets verification_status to 'requested').
     */
    public function requestVerification(Request $request)
    {
        $user = $request->user();
        if (! $user || $user->role !== 'lawyer') abort(403);

        $lawyer = $user->lawyer;
        if (! $lawyer) {
            $lawyer = \App\Models\Lawyer::create(['user_id' => $user->id, 'verification_status' => 'requested']);
        } else {
            $lawyer->verification_status = 'requested';
            $lawyer->save();
        }

        // Notify all admin users so they can review the request
        try {
            $admins = \App\Models\User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new LawyerVerificationRequested($lawyer));
            }
        } catch (\Throwable $e) {
            // Don't block the request if notification fails; log in production
        }

        return redirect()->route('lawyer.dashboard')->with('status', 'Verification requested — an admin will review your documents');
    }
}
