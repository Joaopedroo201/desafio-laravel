<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public string $token
    ) {}

    public function build(): self
    {
        $link = url('/reset-password') . '?token=' . $this->token . '&email=' . urlencode($this->user->email);

        return $this->subject('Redefinição de Senha')
                    ->view('emails.reset-password')
                    ->with([
                        'user' => $this->user,
                        'link' => $link,
                    ]);
    }    
    public function attachments(): array
    {
        return [];
    }
}
