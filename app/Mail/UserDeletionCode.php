<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDeletionCode extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $code;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;

        $this->code = $token;
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
            ->markdown('emails.users.deletion-code', [
                'user' => $this->user,
                'token' => $this->code
            ]);
    }
}
