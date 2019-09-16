<?php

namespace App\Units\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailSuccessfullyVerified extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  \App\Units\Auth\User  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('E-mail successfully verified'))
            ->greeting(Lang::get('Success 😃'))
            ->line('')
            ->line(Lang::get('Your email has been verified successfully. Now you can use all the system features! 🏆'));
    }
}
