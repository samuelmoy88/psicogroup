<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyPatientChangeRating;
use Livewire\Component;
use App\Models\RatingDispute;

class ChangeRatingDisputeState extends Component
{
    public RatingDispute $dispute;

    public string $newState = '';

    protected $listeners = ['updateState', 'allowChange',];

    public function mount(RatingDispute $dispute)
    {
        $this->dispute = $dispute;

        $this->newState = $this->dispute->state;
    }

    public function render()
    {
        return view('livewire.change-rating-dispute-state');
    }

    public function updateState()
    {
        $this->dispute->state = $this->newState;

        if ($this->dispute->save()) {
            session()->flash('success', __('rating-dispute.state_change_success'));
        }

        $this->dispatchBrowserEvent('stateUpdated');
    }

    public function allowChange()
    {
        $this->dispute->rating->can_change = 1;

        if ($this->dispute->rating->save()) {
            session()->flash('success', __('rating-dispute.can_be_changed'));
            dispatch(new NotifyPatientChangeRating($this->dispute->rating));
        }
    }
}
