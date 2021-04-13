<?php

namespace App\Models;

use App\Events\UpdatingSpecialist;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Jobs\NotifySpecialistProfileChange;
use App\Traits\TrackChanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class SpecialistProfile extends Model
{
    use HasFactory, TrackChanges;

    protected $guarded = [
        'id',
        'avatar',
        'date_created'
    ];

    protected $dispatchesEvents = [
        'updating' => UpdatingSpecialist::class
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function prefix()
    {
        return $this->belongsTo(Prefix::class);
    }

    public function specialities()
    {
        return $this->belongsToMany(
            Speciality::class,
            'specialist_profiles_specialities',
            'specialist_profile_id',
            'speciality_id'
        );
    }

    public function diseases()
    {
        return $this->belongsToMany(
            Disease::class,
            'diseases_specialist_profiles',
            'specialist_profile_id',
            'disease_id'
        );//todo:ordenar patologias y estas cosas por el campo 'order'
    }

    public function services()
    {
        return $this->belongsToMany(
            Services::class,
            'services_specialist_profiles',
            'specialist_profile_id',
            'service_id'
        )->withPivot(['id','description','price','price_from','duration']);
    }

    public function changes()
    {
        return $this->hasMany(SpecialistProfileChanges::class);
    }

    public function patients()
    {
        return $this->hasManyThrough(
            User::class,
            Consultation::class,
            'patient_profile_id',
            'profile_id',
            'id',
            'id'
            )->where('profile_type', PatientProfile::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function getAvatarPathAttribute()
    {
        return asset($this->avatar ? Storage::disk('avatars')->url($this->avatar) : url('images/no-avatar.png'));
    }

    public function getPrefixLabelAttribute()
    {
        return Prefix::where('id', $this->prefix_id)->value('title');
    }

    public function storeAvatar($file)
    {
        $this->avatar = Str::random() . '.jpg';

        Storage::disk('avatars')->put(
            $this->avatar,
            ImageManagerStatic::make($file->getPathname())->encode('jpg')
        );

        $this->update();
    }

    public function commitChanges(UpdateSpecialistRequest $request)
    {
        if ($request->file('profile.avatar')) {
            $this->storeAvatar($request->file('profile.avatar'));
        }

        //Save profile changes
        $this->fill($request->profile);

        //Get the profile's user
        $user = User::where('profile_id', $this->id)
                ->where('profile_type', self::class)
                ->first();

        $user->fill($request->all());

        $this->toggleSpecialities($request->specialities);

        $this->toggleDiseases($request->diseases);

        if ($request->uneasiness) {
            foreach ($request->uneasiness as $id => $value) {
                $user->toggleUnease($id, $value);
            }
        }

        if ($this->isDirty() || $this->user->isDirty()) {
            $this->is_verified = 0;
        }

        //Save the user's changes
        $this->save();
        $this->user()->save($user);


        auth()->user()->refresh();
    }

    public function toggleSpecialities(array $specialities)
    {

        foreach ($specialities as $speciality => $value) {
            $this->toggleSpeciality($speciality, $value);
        }
    }

    public function toggleSpeciality($speciality_id, $value)
    {
        if (!$this->specialities->contains($speciality_id) && $value) {
            $this->specialities()->attach($speciality_id);
        }

        if ($this->specialities->contains($speciality_id) && $value == '0') {
            $this->specialities()->detach($speciality_id);
        }
    }

    public function toggleDiseases(array $diseases)
    {

        foreach ($diseases as $disease => $value) {
            $this->toggleDisease($disease, $value);
        }
    }

    public function toggleDisease($disease_id, $value)
    {
        if (!$this->diseases->contains($disease_id) && $value) {
            $this->diseases()->attach($disease_id);
        }

        if ($this->diseases->contains($disease_id) && $value == '0') {
            $this->diseases()->detach($disease_id);
        }
    }

    public function toggleService($service_id, $data)
    {
        if (!$this->services->contains($service_id) && isset($data['service_id'])) {
            $this->services()->attach($service_id, $data);
        }

        if ($this->services->contains($service_id) && !isset($data['service_id'])) {
            $this->services()->detach($service_id);
        }
    }

    public function verify()
    {
        $this->is_verified = 1;

        $this->save();
    }
}
