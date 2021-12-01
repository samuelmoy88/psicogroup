<?php

namespace App\Jobs;

use App\Mail\SpecialistInvitedToClinic;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendClinicSpecialistInvitations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $clinic;
    public User $user;
    public string $token;

    /**
     * Create a new job instance.
     *
     * @param User $clinic
     * @param User $user
     * @param string $token
     */
    public function __construct(User $clinic, User $user, string $token)
    {
        $this->clinic = $clinic;
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new SpecialistInvitedToClinic($this->clinic, $this->user, $this->token));
    }
}
