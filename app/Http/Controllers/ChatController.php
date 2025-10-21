<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Notifications\GenericNotification;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function send(Request $request)
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

        return response()->json(['ok' => true, 'message' => $message]);
    }

    public function history(Request $request, $withUserId)
    {
        $userId = $request->user()->id;
        $messages = Message::where(function ($q) use ($userId, $withUserId) {
            $q->where('sender_id', $userId)->where('receiver_id', $withUserId);
        })->orWhere(function ($q) use ($userId, $withUserId) {
            $q->where('sender_id', $withUserId)->where('receiver_id', $userId);
        })->orderBy('created_at')->get();

        return response()->json(['ok' => true, 'messages' => $messages]);
    }
}
