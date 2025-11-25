<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Notifications\GenericNotification;
use App\Events\MessageSent;
use App\Events\AudioCallSignal;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;

class ChatController extends Controller
{
    /**
     * Handle WebRTC signaling
     */
    public function signal(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'signal' => 'required|array',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['ok' => false], 401);
        }

        broadcast(new AudioCallSignal(
            $request->signal,
            $user->id,
            $request->receiver_id,
            $user->name
        ))->toOthers();

        $message = null;
        $type = $request->signal['type'] ?? null;

        if ($type === 'offer') {
            $message = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'content' => 'Started an audio call',
                'attachment_type' => 'call_log'
            ]);
            broadcast(new MessageSent($message))->toOthers();
        } elseif ($type === 'reject') {
            $message = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'content' => 'Call declined',
                'attachment_type' => 'call_log'
            ]);
            broadcast(new MessageSent($message))->toOthers();
        } elseif ($type === 'end' && isset($request->signal['duration'])) {
            $duration = $request->signal['duration'];
            $content = $duration ? "Call ended - Duration: $duration" : "Call ended";

            $message = Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'content' => $content,
                'attachment_type' => 'call_log'
            ]);
            broadcast(new MessageSent($message))->toOthers();
        }

        return response()->json(['ok' => true, 'message' => $message]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'content' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        $user = $request->user();
        if ($user === null) {
            return new JsonResponse(['ok' => false, 'message' => 'Unauthenticated'], 401);
        }

        $data = [
            'sender_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'content' => $request->content ?? '',
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $data['attachment_path'] = $path;

            // Determine type
            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/')) {
                $data['attachment_type'] = 'image';
            } else {
                $data['attachment_type'] = 'file';
            }
        }

        if (empty($data['content']) && empty($data['attachment_path'])) {
            return new JsonResponse(['ok' => false, 'message' => 'Message cannot be empty'], 422);
        }

        $message = Message::create($data);

        // TODO: broadcast via Pusher/Echo
        try {
            event(new MessageSent($message));
        } catch (\Exception $e) {
            // ignore broadcast errors
        }
        try {
            $receiver = $message->receiver;
            if ($receiver) {
                $receiver->notify(new GenericNotification('message', 'You have a new message'));
            }
        } catch (\Exception $e) {
            // log but don't fail
        }

        return new JsonResponse(['ok' => true, 'message' => $message]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $withUserId
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request, $withUserId): JsonResponse
    {
        $user = $request->user();
        if ($user === null) {
            return new JsonResponse(['ok' => false, 'message' => 'Unauthenticated'], 401);
        }

        $userId = $user->id;
        $messages = Message::query()->where(function ($q) use ($userId, $withUserId) {
            /** @var \Illuminate\Database\Eloquent\Builder<\App\Models\Message> $q */
            $q->where('sender_id', $userId)->where('receiver_id', $withUserId);
        })->orWhere(function ($q) use ($userId, $withUserId) {
            /** @var \Illuminate\Database\Eloquent\Builder<\App\Models\Message> $q */
            $q->where('sender_id', $withUserId)->where('receiver_id', $userId);
        })->orderBy('created_at')->get();

        // Mark messages from the partner to the current user as read so unread counts update.
        try {
            Message::query()
                ->where('sender_id', $withUserId)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } catch (\Exception $e) {
            // Don't fail the request if marking read fails; continue returning history
        }

        $partner = User::find($withUserId);
        $isOnline = $partner ? $partner->isOnline() : false;
        $lastSeen = $partner ? $partner->last_seen_at : null;

        return new JsonResponse([
            'ok' => true,
            'messages' => $messages,
            'partner_status' => [
                'is_online' => $isOnline,
                'last_seen' => $lastSeen
            ]
        ]);
    }

    /**
     * Show inbox with list of conversations
     */
    public function inbox(Request $request): View
    {
        $user = $request->user();

        if ($user === null) {
            abort(401, 'Unauthenticated');
        }

        $search = $request->input('search');

        // Get all unique conversation partners
        $conversations = Message::query()
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
            })
            ->map(function ($messages) use ($user) {
                $latestMessage = $messages->first();
                $partnerId = $latestMessage->sender_id === $user->id ? $latestMessage->receiver_id : $latestMessage->sender_id;
                $partner = User::find($partnerId);
                $unreadCount = $messages->where('receiver_id', $user->id)->where('is_read', false)->count();

                return [
                    'partner' => $partner,
                    'latest_message' => $latestMessage,
                    'unread_count' => $unreadCount,
                ];
            });

        // Filter by search term if provided
        if ($search) {
            $conversations = $conversations->filter(function ($conversation) use ($search) {
                return $conversation['partner'] &&
                    stripos($conversation['partner']->name, $search) !== false;
            });
        }

        return view('chat.inbox', compact('conversations'));
    }
}
