<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Rating extends Model
{
    use HasFactory, FormatDates;

    protected $guarded = ['id'];
    protected $with = ['patient', 'specialist', 'dispute'];

    public array $ratings = [1,2,3,4,5];

    public function feedback()
    {
        return $this->belongsToMany(
            RatingFeedback::class,
            'rating_rating_feedback',
            'rating_id',
            'rating_feedback_id'
        );
    }

    public function positiveFeedback()
    {
        return $this->feedback()->where('type', 'positive')->get();
    }

    public function negativeFeedback()
    {
        return $this->feedback()->where('type', 'negative')->get();
    }

    public function specialist()
    {
        return $this->belongsTo(
            SpecialistProfile::class,
            'specialist_profile_id',
            'id',
            'specialist_profiles'
        );
    }

    public function patient()
    {
        return $this->belongsTo(
            PatientProfile::class,
            'patient_profile_id',
            'id',
            'patient_profiles'
        );
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function new(Request $request, User $patient, User $doctor)
    {
        /*$this->rating = $request->get('rating');

        if ($request->get('feedback')) {
            $this->feedback = $request->get('feedback');
        }

        if ($request->get('consultation_id')) {
            $this->consultation_id = $request->get('consultation_id');
        }*/

        $this->fill($request->all());

        $this->patient()->associate($patient->profile);
        $this->specialist()->associate($doctor->profile);

        return $this->save();

    }

    public function dispute()
    {
        return $this->hasOne(RatingDispute::class);
    }

    public function edit(Request $request)
    {
        $this->fill($request->all());

        $this->can_change = 0;

        $this->has_been_changed = 1;

        $this->feedback()->sync($request->get('feedback_rating'));

        return $this->update();
    }
}
