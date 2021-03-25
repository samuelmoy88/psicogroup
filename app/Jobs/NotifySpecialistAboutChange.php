<?php

namespace App\Jobs;

use App\Mail\SpecialistChangeContact;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifySpecialistAboutChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    protected string $body;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string|null $body
     */
    public function __construct(User $user, ?string $body)
    {
        $this->user = $user;

        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Mail::send(new SpecialistChangeContact($this->user, $this->body));
    }
}
