<?php

namespace App\Models;

use App\Http\Requests\CreateConsultationRequest;
use App\Jobs\NotifyConsultationRequest;
use App\Jobs\NotifyPatientConfirmedConsultationRequest;
use App\Jobs\NotifySpecialistPendingConsultation;
use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Consultation extends Model
{
    use HasFactory, FormatDates;

    protected $guarded = ['id'];

    protected $with = ['address', 'service', 'specialist'];

    public function verification()
    {
        return $this->hasOne(VerifyConsultation::class);
    }

    public function new(CreateConsultationRequest $request)
    {
        $this->fill($request->all());

        if (Auth::check() && auth()->user()->isPatient) {
            $this->patient_profile_id = auth()->user()->profile->id;
        }

        $this->save();

        $verification = new VerifyConsultation();
        $verification->generateToken();

        $this->verification()->save($verification);

        dispatch(new NotifyConsultationRequest($request->all(), $verification->token));

        return true;
    }

    public function notifyRequestConfirmation()
    {
        dispatch(new NotifyPatientConfirmedConsultationRequest($this));
        dispatch(new NotifySpecialistPendingConsultation($this));
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function service()
    {
        return $this->belongsTo(Services::class);
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

    public function clinic()
    {
        return $this->belongsTo(
            ClinicProfile::class,
            'clinic_profile_id',
            'id',
            'clinic_profiles'
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

    public function states()
    {
        return [
            'pending' => __('consultation.state_pending'),
            'contacted' => __('consultation.state_contacted'),
            'scheduled' => __('consultation.state_scheduled'),
            'cancelled' => __('consultation.state_cancelled'),
            'executed' => __('consultation.state_executed'),
        ];
    }

    public function getStateLabelAttribute()
    {
        return $this->attributes['state'] = $this->states()[$this->attributes['state']];
    }

    public function scopePending($query)
    {
        return $query->where('state', 'pending');
    }
}
