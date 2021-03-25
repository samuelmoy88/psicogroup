<?php


namespace App\Traits;


use App\Http\Middleware\EnsureUserIsSpecialist;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\SpecialistProfile;
use App\Models\SpecialistProfileChanges;
use App\Models\User;

trait TrackChanges
{
    private $excludedFields = [
        'id',
        'created_at',
        'updated_at',
        'avatar',
        'is_verified',
        'prefix_id'
    ];

    public function trackChanges()
    {
        if (get_class($this) === User::class && !$this->profile->isSpecialist) {
            return;
        }

        if (get_class($this) === SpecialistProfile::class && !$this->user->isSpecialist) {
            return;
        }

        if ($this->isDirty()) {
            foreach ($this->getAttributes() as $attribute => $value) {
                if (in_array($attribute, $this->excludedFields) ||
                    $value === $this->getOriginal($attribute)
                ) continue;
                SpecialistProfileChanges::create([
                    'specialist_profile_id' => auth()->user()->profile->id,
                    'model' => get_class($this),
                    'field' => $attribute,
                    'old_value' => $this->getOriginal($attribute),
                    'new_value' => $value,
                    'state' => 'pending'
                ]);
            }
        }
    }
}
