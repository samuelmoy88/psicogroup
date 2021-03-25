<?php

namespace App\Jobs;

use App\Models\AdminProfile;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyUserCreated implements ShouldQueue
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
        Mail::send(new UserCreated($this->user, $this->password));
    }
}
