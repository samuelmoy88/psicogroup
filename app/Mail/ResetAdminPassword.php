<?php

namespace App\Mail;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetAdminPassword extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $password;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $password
     */
    public function __construct(User $user, string $password)
    {
        $this->user = $user;

        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('Contraseña reestablecida')
            ->markdown('emails.users.admin-password-reset',[
                'url' => route('config.users.show', ['user' => $this->user->id]),
            ]);
    }
}
