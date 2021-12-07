<?php

namespace App\Models;

use App\Events\CacheUser;
use App\Events\UpdatingSpecialist;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Jobs\NotifySpecialistProfileChange;
use App\Traits\Searchable;
use App\Traits\TrackChanges;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class SpecialistProfile extends Model
{
    use HasFactory, TrackChanges, Searchable;

    protected $guarded = [
        'id',
        'avatar',
        'date_created'
    ];

    protected $dispatchesEvents = [
        'updating' => UpdatingSpecialist::class
    ];

    protected $searchable = [
        'license_number'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function clinics()
    {
        return $this->belongsToMany(
            ClinicProfile::class,
            'clinic_specialists',
            'specialist_id',
            'clinic_id'
        )->with('user')->withPivot(['id','is_premium', 'state', 'invitation_token', 'started_by', 'created_at', 'updated_at']);
    }

    public function prefix()
    {
        return $this->belongsTo(Prefix::class);
    }

    public function specialities()
    {
        return $this->morphToMany(
            Speciality::class,
            'profile',
            'profiles_specialities',
            'profile_id',
            'speciality_id'
        );
    }

    public function diseases()
    {
        return $this->morphToMany(
            Disease::class,
            'profile',
            'diseases_profiles',
            'profile_id',
            'disease_id'
        );
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
        return User::patientProfile()
            ->join('patient_profiles', 'users.profile_id', '=', 'patient_profiles.id')
            ->join('consultations', 'consultations.patient_profile_id', '=', 'patient_profiles.id')
            ->where('consultations.specialist_profile_id', '=', $this->id)
            ->selectRaw('DISTINCT pg_users.*')
            ->get();
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class)->with('consultation');
    }

    public function education()
    {
        return $this->hasMany(SpecialistEducation::class)->orderBy('order');
    }

    public function publication()
    {
        return $this->hasMany(
            ProfilePublication::class,
            'profile_id',
            'id'
        )->where('profile_type', self::class)->orderBy('order');
    }

    public function awards()
    {
        return $this->hasMany(
            ProfileAward::class,
            'profile_id',
            'id'
        )->where('profile_type', self::class)->orderBy('order');
    }

    public function experiences()
    {
        return $this->hasMany(SpecialistExperience::class)->orderBy('start_year', 'DESC');
    }

    public function languages()
    {
        return $this->hasMany(
            ProfileLanguage::class,
            'profile_id',
            'id'
        )->where('profile_type', self::class)->orderBy('order');
    }

    public function certificates()
    {
        return $this->hasMany(SpecialistCertificate::class)->orderBy('order');
    }

    public function getAvatarPathAttribute()
    {
        return asset($this->avatar ? Storage::disk('avatars')->url($this->avatar) : 'images/no-avatar.png');
    }

    public function getPrefixLabelAttribute()
    {
        return Prefix::where('id', $this->prefix_id)->value('title');
    }

    public function storeAvatar($file)
    {
        $this->avatar = $this->user->uuid . '.jpg';

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
        /** @var User $user */
        $user = User::where('profile_id', $this->id)
                ->where('profile_type', self::class)
                ->first();

        $user->fill($request->all());

        if ($this->isPremium()) {
            // Social Media
            if ($request->get('social_media')) {
                $socialMediaData = [];
                foreach ($request->get('social_media') as $id => $url) {
                    if ($url) {
                        $socialMediaData[$id] = ['url' => $url];
                    }
                }
                $user->socialMedia()->sync($socialMediaData);
            }
            // Education
            if ($request->get('education')) {
                foreach ($request->get('education') as $key => $education) {
                    if (!$education['title']) continue;
                    $dbEducation = SpecialistEducation::updateOrCreate(
                        ['id' => $key, 'specialist_profile_id' => $this->id],
                        $education
                    );

                    $this->education()->save($dbEducation);
                }
            }
            if ($request->get('educationToDelete')) {
                foreach (explode(',', $request->get('educationToDelete')) as $education) {
                    $dbEducation = SpecialistEducation::find($education);
                    $dbEducation->delete();
                }
            }
            // Publication
            if ($request->get('publication')) {
                foreach ($request->get('publication') as $key => $publication) {
                    if (!$publication['title']) continue;
                    if ($publication['url']) {
                        $validator = Validator::make($publication, [
                            'url' => 'url'
                        ]);
                        if ($validator->fails()) {
                            return back()->withErrors($validator);
                        }
                    }
                    $publication['profile_type'] = self::class;
                    $dbPublication = ProfilePublication::updateOrCreate(
                        ['id' => $key, 'profile_id' => $this->id, 'profile_type' => self::class],
                        $publication
                    );

                    $this->publication()->save($dbPublication);
                }

            }
            if ($request->get('publicationsToDelete')) {
                foreach (explode(',', $request->get('publicationsToDelete')) as $publication) {
                    $dbPublication = ProfilePublication::find($publication);
                    $dbPublication->delete();
                }
            }
            // Awards
            if ($request->get('award')) {
                foreach ($request->get('award') as $key => $award) {
                    if (!$award['title']) continue;
                    $award['profile_type'] = self::class;
                    $dbAward = ProfileAward::updateOrCreate(
                        ['id' => $key, 'profile_id' => $this->id, 'profile_type' => self::class],
                        $award
                    );

                    $this->awards()->save($dbAward);
                }

            }
            if ($request->get('awardsToDelete')) {
                foreach (explode(',', $request->get('awardsToDelete')) as $award) {
                    $dbAward = ProfileAward::find($award);
                    $dbAward->delete();
                }
            }
            // Experience
            if ($request->get('experience')) {
                foreach ($request->get('experience') as $key => &$experience) {
                    if (!$experience['job_title']) continue;
                    if ($experience['start_month'] && $experience['start_year']) {
                        $experience['start_year'] = $experience['start_year'] . '-' .$experience['start_month'] . '-01';
                    }
                    if ($experience['end_month'] && $experience['end_year']) {
                        $experience['end_year'] = $experience['end_year'] . '-' .$experience['end_month'] . '-01';
                    }
                    $dbExperience = SpecialistExperience::updateOrCreate(
                        ['id' => $key, 'specialist_profile_id' => $this->id],
                        $experience
                    );

                    $this->experiences()->save($dbExperience);
                }

            }
            if ($request->get('experienceToDelete')) {
                foreach (explode(',', $request->get('experienceToDelete')) as $experience) {
                    $dbExperience = SpecialistExperience::find($experience);
                    $dbExperience->delete();
                }
            }
            // Certificate
            if ($request->get('certificate')) { //todo: validar que la fecha de caducidad sea mayor a la fecha de expedición
                foreach ($request->get('certificate') as $key => &$certificate) {
                    if (!$certificate['name']) continue;
                    if ($certificate['expedition_month'] && $certificate['expedition_year']) {
                        $certificate['expedition_date'] = $certificate['expedition_year'] . '-' .$certificate['expedition_month'] . '-01';
                    }
                    if ($certificate['expiration_month'] && $certificate['expiration_year']) {
                        $certificate['expiration_date'] = $certificate['expiration_year'] . '-' .$certificate['expedition_month'] . '-01';
                    }
                    $dbCertificate = SpecialistCertificate::updateOrCreate(
                        ['id' => $key, 'specialist_profile_id' => $this->id],
                        $certificate
                    );

                    $this->certificates()->save($dbCertificate);
                }

            }
            if ($request->get('certificateToDelete')) {
                foreach (explode(',', $request->get('certificateToDelete')) as $certificate) {
                    $dbCertificate = SpecialistCertificate::find($certificate);
                    $dbCertificate->delete();
                }
            }
            // Language
            if ($request->get('language')) {
                foreach ($request->get('language') as $key => $language) {
                    if (!$language['language']) continue;
                    if (!$this->languages->isEmpty() && $this->languages->contains('language',$language['language'])) continue;
                    $language['profile_type'] = self::class;
                    $dbLanguage = ProfileLanguage::updateOrCreate(
                        ['id' => $key, 'profile_id' => $this->id, 'profile_type' => self::class],
                        $language
                    );

                    $this->languages()->save($dbLanguage);
                }

            }
            if ($request->get('languageToDelete')) {
                foreach (explode(',', $request->get('languageToDelete')) as $language) {
                    $dbLanguage = ProfileLanguage::find($language);
                    $dbLanguage->delete();
                }
            }
        }

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

    public function pendingConsultations()
    {
        return $this->consultations->where('state', 'pending')->count();
    }

    public function recentChanges()
    {
        return $this->hasMany(SpecialistProfileChanges::class)->onlyRecentAndPending();
    }

    public function isPremium()
    {
        return (bool)$this->is_premium;
    }

    public function hasPremiumPerks()
    {
        return (bool) (
            $this->user()->socialMedia()->count() > 0
            || $this->education()->count() > 0
            || $this->publication()->count() > 0
            || $this->awards()->count() > 0
            || $this->experiences()->count() > 0
            || $this->languages()->count() > 0
        );
    }

    public function getLanguagesLabels()
    {
        return $this->languages->map(function ($language) {
            return languagesList()[$language->language];
        })->join(', ');
    }

    public function averageRating()
    {
        return round($this->ratings->avg('rating'), 0, PHP_ROUND_HALF_UP);
    }

    public function totalRating()
    {
        return $this->ratings->count();
    }

    public function canBeInClinic(User $clinic)
    {
        return !$this->clinics->contains('id', $clinic->profile_id);
    }
}
