<?php

namespace App\Mail;

use App\Http\Requests\PricingInquiryRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPricingInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public array $inquiryRequest;

    public ?User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $request, ?User $user = null)
    {
        $this->inquiryRequest = $request;

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->inquiryRequest['email'])
            ->subject(__('common.new_premium_inquiry_subject_to_client'))
            ->markdown('emails.inquiries.new-inquiry-to-client', [
                'request' => $this->inquiryRequest
            ]);
    }
}
