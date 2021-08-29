<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientPendingConsultation extends Mailable
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
        return $this->to($this->consultation->email)
            ->subject(__('common.new_consultation_confirmed'))
            ->markdown('emails.users.pending-consultation', [
                'consultation' => $this->consultation
            ]);
    }
}
