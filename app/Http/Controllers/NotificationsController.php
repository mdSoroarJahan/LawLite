<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification as NavModel; // DB notifications table created earlier (custom)
use Illuminate\Http\JsonResponse;

class NotificationsController extends Controller
{
    /** @return \Illuminate\Http\JsonResponse */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) return new JsonResponse(['error' => 'Unauthorized'], 401);

        // Use Laravel's built-in notifications if available: $user->notifications
        $items = $user->notifications()->take(20)->get();

        return new JsonResponse(['ok' => true, 'notifications' => $items]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markRead(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $user = $request->user();
        if (!$user) return new JsonResponse(['error' => 'Unauthorized'], 401);

        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return new JsonResponse(['ok' => true]);
        }

        return new JsonResponse(['error' => 'Not found'], 404);
    }
}
