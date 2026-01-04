<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LawyerVerificationRequested extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lawyer;

    public function __construct($lawyer)
    {
        $this->lawyer = $lawyer;
    }

    public function getLawyer()
    {
        return $this->lawyer;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $userName = $this->lawyer->user->name ?? 'Unknown';
        return (new MailMessage)
            ->subject("Verification requested: {$userName}")
            ->greeting('Hello Admin,')
            ->line("A lawyer ({$userName}) has requested verification.")
            ->action('Review verification requests', url(route('admin.verification.index')))
            ->line('You can view uploaded documents and approve or reject the request.');
    }
}
