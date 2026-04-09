<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MagicLinkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/login/verify/' . $this->token . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->view('auth.link-magic', [ 
                'user' => $notifiable,
                'url'  => $url
        ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}