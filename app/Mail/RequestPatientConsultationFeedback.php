<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestPatientConsultationFeedback extends Mailable
{
    use Queueable, SerializesModels;

    public Consultation $consultation;

    /**
     * Create a new message instance.
     *
     * @param Consultation $consultation
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->consultation->patient->user->email)
            ->subject(__('common.feedback_request'))
            ->markdown('emails.users.request-patient-feedback',[
                'consultation' => $this->consultation,
                'url' => route('account.feedback.create', [
                    'patient' => $this->consultation->patient->user->uuid,
                    'doctor' => $this->consultation->specialist->user->uuid,
                ]),
            ]);
    }
}
