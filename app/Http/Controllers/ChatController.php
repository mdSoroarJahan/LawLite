<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Notifications\GenericNotification;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;

class ChatController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'receiver_id' => 'required|integer',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $data['receiver_id'],
            'content' => $data['content'],
        ]);

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
        $userId = $request->user()->id;
        $messages = Message::query()->where(function ($q) use ($userId, $withUserId) {
            /** @var \Illuminate\Database\Eloquent\Builder<\App\Models\Message> $q */
            $q->where('sender_id', $userId)->where('receiver_id', $withUserId);
        })->orWhere(function ($q) use ($userId, $withUserId) {
            /** @var \Illuminate\Database\Eloquent\Builder<\App\Models\Message> $q */
            $q->where('sender_id', $withUserId)->where('receiver_id', $userId);
        })->orderBy('created_at')->get();

        return new JsonResponse(['ok' => true, 'messages' => $messages]);
    }
}
