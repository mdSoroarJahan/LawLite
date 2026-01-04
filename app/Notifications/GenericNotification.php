<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class GenericNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /** @var mixed */
    public $notifiable;

    /** @var string */
    protected $type;
    /** @var string */
    protected $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @param mixed $notifiable
     * @return array<int,string>
     */
    public function via($notifiable): array
    {
        // Persist to DB and broadcast in real-time
        return ['database', 'broadcast'];
    }

    /**
     * @param mixed $notifiable
     * @return array<string,mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
        ];
    }

    /**
     * Broadcast payload for real-time clients (Echo)
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => $this->type,
            'message' => $this->message,
        ]);
    }

    /**
     * Broadcast on the authenticated user's private channel
     */
    public function broadcastOn(): array
    {
        // Default Laravel notification channel: App.Models.User.{id}
        return [new PrivateChannel('App.Models.User.' . ($this->notifiable?->getKey() ?? ''))];
    }
}
