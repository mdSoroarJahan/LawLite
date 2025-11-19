<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Lawyer;
use App\Notifications\GenericNotification;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
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
        ]);

        $user = $request->user();
        if ($user === null) {
            return new JsonResponse(['ok' => false, 'message' => 'Unauthenticated'], 401);
        }

        $appointment = Appointment::create([
            'lawyer_id' => $data['lawyer_id'],
            'user_id' => $user->id,
            'date' => $data['date'],
            'time' => $data['time'],
            'status' => 'scheduled',
            'type' => $data['type'] ?? 'online',
            'notes' => $data['notes'] ?? null,
        ]);

        // notify the lawyer
        try {
            /** @var \App\Models\Lawyer|null $lawyer */
            $lawyer = Lawyer::find($data['lawyer_id']);
            if ($lawyer && $lawyer->user) {
                $lawyer->user->notify(new GenericNotification('appointment', 'You have a new appointment'));
            }
        } catch (\Exception $e) {
            // log
        }

        return new JsonResponse(['ok' => true, 'appointment' => $appointment]);
    }
}
