<?php

namespace App\Jobs;

use App\Mail\ResetAdminPassword;
use App\Models\AdminProfile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyAdminPasswordReset implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;

    public string $password;


    /**
     * Create a new job instance.
     *
     * @param AdminProfile $user
     * @param string $password
     */
    public function __construct(AdminProfile $user, string $password)
    {
        $this->user = $user->user;

        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new ResetAdminPassword($this->user, $this->password));
    }
}
