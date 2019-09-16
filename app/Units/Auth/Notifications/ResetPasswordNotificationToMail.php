<?php

namespace App\Units\Auth\Notifications;

use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotificationToMail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @param  string  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function __invoke(object $notifiable, string $token): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), url(config('app.url').route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }
}
