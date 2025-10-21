<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification as NavModel; // DB notifications table created earlier (custom)

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 401);

        // Use Laravel's built-in notifications if available: $user->notifications
        $items = $user->notifications()->take(20)->get();

        return response()->json(['ok' => true, 'notifications' => $items]);
    }

    public function markRead(Request $request)
    {
        $id = $request->input('id');
        $user = $request->user();
        if (!$user) return response()->json(['error' => 'Unauthorized'], 401);

        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['ok' => true]);
        }

        return response()->json(['error' => 'Not found'], 404);
    }
}
