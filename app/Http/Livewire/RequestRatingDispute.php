<?php

namespace App\Http\Livewire;

use App\Models\PatientProfile;
use App\Models\Rating;
use App\Models\RatingDispute;
use App\Models\SpecialistProfile;
use Livewire\Component;

class RequestRatingDispute extends Component
{
    public string $modal = 'requestDispute';

    public Rating $rating;

    public string $reason = '';

    protected array $listeners = ['create'];

    public function mount($modal, Rating $rating)
    {
        $this->modal = $modal;

        $this->rating = $rating;
    }

    public function create()
    {
        $this->validate(
            ['reason' => 'required',],
            ['reason.required' => __('common.reason_required'),],
            ['reason' => __('common.reason')]
        );

        $dispute['requested_by'] = auth()->user()->isSpecialist ? SpecialistProfile::class : PatientProfile::class;
        $dispute['state'] = RatingDispute::STATE_PENDING;
        $dispute['user_feedback'] = $this->reason;

        $ratingDispute = new RatingDispute($dispute);

        $this->rating->dispute()->save($ratingDispute);

        session()->flash('message',__('ratings.dispute_created'));

        $this->dispatchBrowserEvent('disputeRequested');
    }


    public function render()
    {
        return view('livewire.request-rating-dispute');
    }
}
