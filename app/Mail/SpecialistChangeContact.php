<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SpecialistChangeContact extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public string $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $body)
    {
        $this->user = $user;

        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->markdown('emails.specialists.contact-change',[
                'url' => config('app.url') . route('specialist.show', ['specialist' => $this->user->username, 'uuid' => $this->user->uuid], false),
            ]);
    }
}
