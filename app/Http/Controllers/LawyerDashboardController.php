<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LawyerVerificationRequested;
use App\Models\LawyerCase;
use App\Models\Invoice;

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
        $upcomingCases = collect([]);
        $totalEarnings = 0;
        $pendingInvoices = 0;
        $totalCases = 0;
        $activeCases = 0;
        $casesWon = 0;
        $casesLost = 0;

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

            $totalEarnings = Invoice::where('lawyer_id', $lawyer->id)->where('status', 'paid')->sum('amount');
            $pendingInvoices = Invoice::where('lawyer_id', $lawyer->id)->where('status', 'unpaid')->sum('amount');
            $totalCases = LawyerCase::where('lawyer_id', $lawyer->id)->count();
            $activeCases = LawyerCase::where('lawyer_id', $lawyer->id)->whereIn('status', ['pending', 'in_progress'])->count();
            $casesWon = LawyerCase::where('lawyer_id', $lawyer->id)->where('outcome', 'won')->count();
            $casesLost = LawyerCase::where('lawyer_id', $lawyer->id)->where('outcome', 'lost')->count();
        }

        return view('lawyers.dashboard', compact('user', 'lawyer', 'upcomingCases', 'totalEarnings', 'pendingInvoices', 'totalCases', 'activeCases', 'casesWon', 'casesLost'));
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

                $appointments = $query->orderBy('created_at', 'desc')
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

        // Auto-generate Jitsi link if online
        if ($appointment->type === 'online' && !$appointment->meeting_link) {
            $roomName = 'LawLite-' . $appointment->id . '-' . \Illuminate\Support\Str::random(8);
            $appointment->meeting_link = 'https://meet.jit.si/' . $roomName;
        }

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
     * Complete an appointment
     */
    public function completeAppointment(Request $request, $id): \Illuminate\Http\RedirectResponse
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

        $appointment->status = 'completed';
        $appointment->save();

        return redirect()->route('lawyer.appointments')->with('success', 'Appointment marked as completed.');
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
                'bar_council_id' => 'nullable|string|max:255',
                'education' => 'nullable|array',
                'experience' => 'nullable|array',
                'languages' => 'nullable|array',
                'profile_photo' => 'nullable|image|max:2048',
                'documents' => 'nullable|array',
                'documents.*' => 'file|mimes:pdf,jpeg,png,jpg|max:5120',
            ]);

            $user->name = strval($data['name']);
            $user->phone = isset($data['phone']) ? strval($data['phone']) : $user->phone;

            // Handle Profile Photo
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }
                $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
            }

            $user->save();

            // Update or create lawyer row
            $lawyer = $user->lawyer;
            if (! $lawyer) {
                $lawyer = \App\Models\Lawyer::create(['user_id' => $user->id]);
            }
            $lawyer->city = isset($data['city']) ? strval($data['city']) : $lawyer->city;
            $lawyer->expertise = isset($data['expertise']) ? strval($data['expertise']) : $lawyer->expertise;
            $lawyer->bar_council_id = isset($data['bar_council_id']) ? strval($data['bar_council_id']) : $lawyer->bar_council_id;

            // Handle JSON fields
            if (isset($data['education'])) $lawyer->education = $data['education'];
            if (isset($data['experience'])) $lawyer->experience = $data['experience'];
            if (isset($data['languages'])) $lawyer->languages = $data['languages'];

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
