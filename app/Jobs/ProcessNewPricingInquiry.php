<?php

namespace App\Jobs;

use App\Mail\NewPricingInquiryBackend;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNewPricingInquiry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $inquiryRequest;

    public ?User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $request, ?User $user = null)
    {
        $this->inquiryRequest = $request;

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new NewPricingInquiryBackend($this->inquiryRequest, $this->user));
    }
}
