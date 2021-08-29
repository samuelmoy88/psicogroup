<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingDispute extends Model
{
    use HasFactory, FormatDates;

    protected $guarded = ['id'];

    const STATE_PENDING = 'pending';
    const STATE_IN_PROGRESS = 'in_progress';
    const STATE_RESOLVED = 'resolved';

    const CHANGE_DAYS_THRESHOLD = '-3 days';


    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function getStates()
    {
        return [
            self::STATE_PENDING => __('ratings.state_pending'),
            self::STATE_IN_PROGRESS => __('ratings.state_in_progress'),
            self::STATE_RESOLVED => __('ratings.state_resolved'),
        ];
    }

    public function getStateLabelAttribute()
    {
        return (new self)->getStates()[$this->state];
    }

    public function getCreatedByAttribute()
    {
        return $this->requested_by === PatientProfile::class
            ? $this->rating->patient->user->first_name . ' ' . $this->rating->patient->user->last_name
            : $this->rating->specialist->user->first_name . ' ' . $this->rating->specialist->user->last_name;
    }

    public function canBeChanged()
    {
        if ($this->state !== self::STATE_RESOLVED) {
            return true;
        }

        if ($this->state === self::STATE_RESOLVED && strtotime($this->updated_at) >= strtotime(self::CHANGE_DAYS_THRESHOLD)) {
            return true;
        }

        return  false;
    }
}
