<?php

namespace App\Units\Auth\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Units\Auth\Notifications\EmailSuccessfullyVerified as EmailSuccessfullyVerifiedNotification;

class SendEmailSuccessfullyVerifiedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param \Illuminate\Auth\Events\Verified $event
     *
     * @return void
     */
    public function handle(Verified $event)
    {
        $event->user->notify(new EmailSuccessfullyVerifiedNotification());
    }
}
