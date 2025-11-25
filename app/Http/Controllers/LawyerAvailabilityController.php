<?php

namespace App\Http\Controllers;

use App\Models\LawyerAvailability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerAvailabilityController extends Controller
{
    /**
     * Display the lawyer's availability settings.
     */
    public function index()
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        if (!$lawyer) {
            return redirect()->route('lawyer.dashboard')->with('error', 'Lawyer profile not found.');
        }

        $availabilities = $lawyer->availabilities()->orderBy('day_of_week')->orderBy('start_time')->get();

        return view('lawyer.availability.index', compact('availabilities'));
    }

    /**
     * Store or update availability.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $lawyer = $user->lawyer;

        if (!$lawyer) {
            return redirect()->route('lawyer.dashboard')->with('error', 'Lawyer profile not found.');
        }

        $data = $request->validate([
            'schedule' => 'array',
            'schedule.*.day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule.*.start_time' => 'required|date_format:H:i',
            'schedule.*.end_time' => 'required|date_format:H:i|after:schedule.*.start_time',
            'schedule.*.is_active' => 'boolean',
        ]);

        // For simplicity, we can delete existing and recreate, or update smart.
        // Let's go with a full replace strategy for the submitted days or just handle add/remove in UI.
        // Actually, a common pattern is to submit the full schedule.

        // Let's assume the UI sends a list of slots.
        // We will clear existing slots and re-add them.
        // NOTE: This is destructive if not handled carefully.
        // Better approach: The UI allows adding/removing slots.

        // Let's implement a simpler "save all" approach for now.

        $lawyer->availabilities()->delete();

        if (isset($data['schedule'])) {
            foreach ($data['schedule'] as $slot) {
                $lawyer->availabilities()->create([
                    'day_of_week' => $slot['day_of_week'],
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'is_active' => $slot['is_active'] ?? true,
                ]);
            }
        }

        return redirect()->route('lawyer.availability.index')->with('success', 'Availability updated successfully.');
    }
}
