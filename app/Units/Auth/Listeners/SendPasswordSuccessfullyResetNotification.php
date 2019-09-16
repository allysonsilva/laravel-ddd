<?php

namespace App\Units\Auth\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Units\Auth\Notifications\PasswordSuccessfullyReset as PasswordSuccessfullyResetNotification;

class SendPasswordSuccessfullyResetNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \Illuminate\Auth\Events\PasswordReset $event
     *
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        // Sends email that the password has been reset successfully
        $event->user->notify(new PasswordSuccessfullyResetNotification());
    }
}
