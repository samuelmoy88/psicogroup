<?php

namespace App\Mail;

use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $password;

    /**
     * Create a new job instance.
     *
     * @param AdminProfile $user
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
            ->subject('Bienvenido al equipo de '. config('app.name').'!')
            ->markdown('emails.users.user-created',[
                'url' => Config::get('app.url') . route('config.users.show', ['user' => $this->user->id], false),
            ]);
    }
}
