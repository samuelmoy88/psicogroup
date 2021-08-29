<?php

namespace App\Jobs;

use App\Mail\VerifyConsultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class NotifyConsultationRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $user;

    public string $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $user, string $token)
    {
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
        Mail::send(new VerifyConsultation($this->user, $this->token));
    }
}
