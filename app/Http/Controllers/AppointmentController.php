<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Lawyer;
use App\Notifications\GenericNotification;

class AppointmentController extends Controller
{
    public function book(Request $request)
    {
        $data = $request->validate([
            'lawyer_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'lawyer_id' => $data['lawyer_id'],
            'user_id' => $request->user()->id,
            'date' => $data['date'],
            'time' => $data['time'],
            'status' => 'scheduled',
            'type' => $data['type'] ?? 'online',
            'notes' => $data['notes'] ?? null,
        ]);

        // notify the lawyer
        try {
            $lawyer = Lawyer::find($data['lawyer_id']);
            if ($lawyer && $lawyer->user) {
                $lawyer->user->notify(new GenericNotification('appointment', 'You have a new appointment'));
            }
        } catch (\Exception $e) {
            // log
        }

        return response()->json(['ok' => true, 'appointment' => $appointment]);
    }
}
