<?php

namespace App\Http\Livewire;

use App\Models\PremiumPlan;
use Livewire\Component;

class PremiumPlanFeatures extends Component
{
    public PremiumPlan $premiumPlan;

    public int $featuresCounter = 0;

    protected $listeners = ['addFeature', 'removeFeature'];

    public array $removedFeaturesList;

    public function mount(PremiumPlan $premiumPlan): void
    {
        $this->premiumPlan = $premiumPlan;

        $this->removedFeaturesList = [];
    }

    public function hydratePremiumPlan(): void
    {
        if ($this->removedFeaturesList && $this->premiumPlan->features) {
            foreach ($this->removedFeaturesList as $featureId) {
                $this->premiumPlan->features = $this->premiumPlan->features->filter(function ($feature) use ($featureId) {
                    return $feature->id != $featureId;
                });
            }
        }
    }

    public function addFeature(): void
    {
        if ($this->featuresCounter < 0) {
            $this->featuresCounter = 1;
        } else {
            $this->featuresCounter++;
        }

        $this->dispatchBrowserEvent('loadCkeditor');
    }

    public function removeFeature(?int $featureId = null): void
    {
        if ($featureId && !$this->premiumPlan->features->isEmpty()) {
            $this->premiumPlan->features = $this->premiumPlan->features->filter(function ($feature) use ($featureId) {
                return $feature->id != $featureId;
            });
            $this->removedFeaturesList[] = $featureId;
        } else {
            $this->featuresCounter--;
        }

        if ($this->featuresCounter < 0) {
            $this->featuresCounter = 1;
        }
        $this->dispatchBrowserEvent('loadCkeditor');
    }

    public function render()
    {
        return view('livewire.premium-plan-features');
    }
}
