<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SpecialistRequestsToJoinClinic extends Mailable
{
    use Queueable, SerializesModels;

    public User $specialist;
    public User $user;
    private string $token;

    /**
     * Create a new message instance.
     *
     * @param User $specialist
     * @param User $user
     * @param string $token
     */
    public function __construct(User $specialist, User $user, string $token)
    {
        $this->specialist = $specialist;
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
        return $this->to($this->user->email)
            ->subject(__('specialists.clinic_invitation_subject'))
            ->markdown('emails.specialists.clinic-invite',[
                'user' => $this->user,
                'specialist' => $this->specialist,
                'url_accept' => Config::get('app.url') . route('clinics.specialist.accept', [
                        'uuid' => $this->user->uuid,
                        'token' => $this->token,
                    ], false),
                'url_reject' => Config::get('app.url') . route('clinics.specialist.reject', [
                        'uuid' => $this->user->uuid,
                        'token' => $this->token,
                    ], false),
            ]);
    }
}
