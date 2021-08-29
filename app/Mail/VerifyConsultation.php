<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyConsultation extends Mailable
{
    use Queueable, SerializesModels;

    public array $user;

    public string $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $user, string $token)
    {
        $this->user = $user;

        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user['email'])
            ->subject('Solicitud de consulta')
            ->markdown('emails.users.verify-consultation', [
                'user' => $this->user,
                'token' => $this->token
            ]);
    }
}
