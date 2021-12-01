<?php

namespace App\Jobs;

use App\Mail\SpecialistRequestsToJoinClinic;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSpecialistClinicInvitations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $specialist;
    public User $user;
    public string $token;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new SpecialistRequestsToJoinClinic($this->specialist, $this->user, $this->token));
    }
}
