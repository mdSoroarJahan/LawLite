<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification as NavModel; // DB notifications table created earlier (custom)
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationsController extends Controller
{
    /**
     * Show notifications page
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $notifications = $user->notifications()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Get notifications as JSON
     */
    public function getJson(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) return new JsonResponse(['error' => 'Unauthorized'], 401);

        $items = $user->notifications()->take(20)->get();

        return new JsonResponse(['ok' => true, 'notifications' => $items]);
    }

    /**
     * Mark a notification as read
     */
    public function markRead(Request $request, $id): mixed
    {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllRead(Request $request): mixed
    {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        $user->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read');
    }

    /**
     * Mark notification as read and redirect to target
     */
    public function readAndRedirect(Request $request, $id): RedirectResponse
    {
        $user = $request->user();
        if (!$user) return redirect()->route('login');

        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();

            // Determine redirect URL based on type
            $type = $notification->data['type'] ?? '';

            if ($type === 'appointment') {
                return redirect()->route($user->role === 'lawyer' ? 'lawyer.appointments' : 'appointments.index');
            } elseif ($type === 'message') {
                return redirect()->route('messages.inbox');
            }
        }

        return back();
    }
}
