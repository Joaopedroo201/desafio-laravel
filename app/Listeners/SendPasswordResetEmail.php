<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PasswordResetRequested;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;


class SendPasswordResetEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetRequested $event): void
    {
        Mail::to($event->user->email)->send(
            new ResetPasswordMail($event->user, $event->token)
        );
    }
}
