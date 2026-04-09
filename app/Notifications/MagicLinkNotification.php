<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// Tambahkan "implements ShouldQueue" agar pengiriman masuk antrean
class MagicLinkNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // 1. Definisikan property token
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        // 2. Masukkan token dari Controller ke dalam property
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/login/verify/' . $this->token . '?email=' . urlencode($notifiable->email));

        return (new MailMessage)
            ->view('auth.link-magic', [ 
                'user' => $notifiable,
                'url'  => $url
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}