<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    /**
     * The message model instance being broadcast.
     *
     * @var Message
     */
    public Message $message;

    /**
     * Create a new event instance.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array<int, Channel>
     */
    public function broadcastOn(): Channel|array
    {
        // broadcast to both sender and receiver channels so both users see the message in real-time
        return [
            new PrivateChannel('user.' . $this->message->sender_id),
            new PrivateChannel('user.' . $this->message->receiver_id),
        ];
    }

    /**
     * The data to broadcast with the event.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'content' => $this->message->content,
            'attachment_path' => $this->message->attachment_path,
            'attachment_type' => $this->message->attachment_type,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at?->toIso8601String() ?? ($this->message->created_at ? $this->message->created_at->format('Y-m-d\TH:i:s.u\Z') : null),
        ];
    }
}
