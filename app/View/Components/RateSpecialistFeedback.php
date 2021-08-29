<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RateSpecialistFeedback extends Component
{
    public Collection $positiveFeedback;

    public Collection $negativeFeedback;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->positiveFeedback = readPositiveRatingFeedbackFromCache();

        $this->negativeFeedback = readNegativeRatingFeedbackFromCache();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.rate-specialist-feedback');
    }
}
