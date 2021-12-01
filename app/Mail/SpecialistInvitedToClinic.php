<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SpecialistInvitedToClinic extends Mailable
{
    use Queueable, SerializesModels;

    public User $clinic;
    public User $user;
    private string $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $clinic, User $user, string $token)
    {
        $this->clinic = $clinic;
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
            ->subject(__('clinics.clinic_invitation_subject'))
            ->markdown('emails.clinics.specialist-invite',[
                'user' => $this->user,
                'clinic' => $this->clinic,
                'url_accept' => Config::get('app.url') . route('specialist.clinics.accept', [
                    'uuid' => $this->user->uuid,
                    'token' => $this->token,
                ], false),
                'url_reject' => Config::get('app.url') . route('specialist.clinics.reject', [
                    'uuid' => $this->user->uuid,
                    'token' => $this->token,
                ], false),
            ]);
    }
}
