<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistProfileChanges extends Model
{
    use HasFactory, FormatDates;

    protected $guarded = ['id'];

    const STATE_PENDING = 'pending';
    const STATE_APPROVED = 'approved';
    const STATE_REJECTED = 'rejected';

    public function specialist()
    {
        return $this->belongsTo(SpecialistProfile::class, 'specialist_profile_id');
    }

    public function toggleState($state)
    {
        $this->state = $state;

        return $this->save();
    }

    public function scopeOnlyRecentAndPending($query)
    {
//        return $query->where('careated_at', '>=', date('Y-m-d H:i:s', strtotime('14 days ago')))->orWhere('state', 'pending');
        return $query->where(function ($q) {
            $q->orWhere('created_at', '>=', date('Y-m-d H:i:s', strtotime('14 days ago')))
                ->orWhere('state', 'pending');
        });
    }

    public function getCreatedAtAsHumanAttribute()
    {
        return $this->created_at->locale('es_ES')->diffForHumans();
    }


}
