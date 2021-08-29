<?php

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ShowSpecialistFeedback extends Component
{
    public Collection $positiveFeedback;

    public Collection $negativeFeedback;

    public ?Collection $ratingFeedback;

    /**
     * Create a new component instance.
     *
     * @param Collection $ratingFeedback
     */
    public function __construct(?Collection $ratingFeedback = null)
    {
        $this->positiveFeedback = readPositiveRatingFeedbackFromCache();

        $this->negativeFeedback = readNegativeRatingFeedbackFromCache();

        $this->ratingFeedback = $ratingFeedback;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.show-specialist-feedback');
    }
}
