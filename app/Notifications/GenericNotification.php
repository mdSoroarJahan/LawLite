<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class GenericNotification extends Notification
{
    use Queueable;

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
        return ['database'];
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
}
