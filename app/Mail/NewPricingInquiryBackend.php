<?php

namespace App\Mail;

use App\Http\Requests\PricingInquiryRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class NewPricingInquiryBackend extends Mailable
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
        $url = '';
        if (!is_null($this->user)) {
            $url = Config::get('app.url') . route('clinic.show', ['medical_center' => $this->user->username, 'uuid' => $this->user->uuid], false);
            if ($this->user->isSpecialist) {
                $url = Config::get('app.url') . route('specialist.show', ['specialist' => $this->user->username, 'uuid' => $this->user->uuid], false);
            }
        }

        return $this->to('samuel.moy@mac.com')
            ->subject(__('common.new_premium_inquiry_subject'))
            ->markdown('emails.inquiries.new-inquiry-to-us', [
                'request' => $this->inquiryRequest,
                'user' => $this->user,
                'url' => $url
            ]);
    }
}
