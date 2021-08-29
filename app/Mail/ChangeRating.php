<?php

namespace App\Mail;

use App\Models\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeRating extends Mailable
{
    use Queueable, SerializesModels;

    public Rating $rating;

    /**
     * Create a new message instance.
     *
     * @param Rating $rating
     */
    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->rating->patient->user->email)
            ->subject(__('rating-dispute.rating_change'))
            ->markdown('emails.users.change-rating', [
                'rating' => $this->rating,
                'url' => config('app.url') . route('account.feedback.show', $this->rating->id, false),
            ]);
    }
}
