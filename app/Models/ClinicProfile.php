<?php

namespace App\Models;

use App\Http\Requests\UpdateClinicRequest;
use App\Jobs\SendClinicSpecialistInvitations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class ClinicProfile extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'avatar',
        'date_created'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function specialists()
    {
        return $this->belongsToMany(
            SpecialistProfile::class,
            'clinic_specialists',
            'clinic_id',
            'specialist_id'
        )->with('user')->withPivot(['id','is_premium', 'state', 'invitation_token', 'started_by', 'created_at', 'updated_at']);
    }

    public function activeSpecialists()
    {
        return $this->belongsToMany(
            SpecialistProfile::class,
            'clinic_specialists',
            'clinic_id',
            'specialist_id'
        )->where('state', ClinicSpecialist::SPECIALIST_STATE_ACCEPTED)
            ->with('user')
            ->withPivot(['is_premium', 'state', 'invitation_token', 'created_at', 'updated_at']);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class)->with('');
    }

    public function specialistsRatings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Consultation::class,
            'clinic_profile_id',
            'consultation_id',
            'id',
            'id'
        )->with('consultation');
    }

    public function activeSpecialistsRatings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Consultation::class,
            'clinic_profile_id',
            'consultation_id',
            'id',
            'id'
        )->join('clinic_specialists', function ($join) {
            $join->on('clinic_specialists.clinic_id', '=', 'consultations.clinic_profile_id');
            $join->on('consultations.specialist_profile_id', '=', 'clinic_specialists.specialist_id');
        })->where('clinic_specialists.state', ClinicSpecialist::SPECIALIST_STATE_ACCEPTED)
            ->with(['consultation', 'specialist', 'patient']);
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

    public function languages()
    {
        return $this->hasMany(
            ProfileLanguage::class,
            'profile_id',
            'id'
        )->where('profile_type', self::class)->orderBy('order');
    }

    public function specialistsVolume()
    {
        return [
            '1-5',
            '6-20',
            '21-50',
            '51-99',
            '100+',
        ];
    }

    public function pendingConsultations()
    {
        return $this->consultations->where('state', 'pending')->count();
    }

    public function getAvatarPathAttribute()
    {
        return asset($this->avatar ? Storage::disk('avatars')->url($this->avatar) : url('images/no-avatar-clinic.png'));
    }

    public function isPremium()
    {
        return (bool)$this->is_premium;
    }

    public function hasPremiumPerks()
    {
        return (bool) (
            $this->user()->socialMedia()->count() > 0
            || $this->publication()->count() > 0
            || $this->awards()->count() > 0
            || $this->languages()->count() > 0
        );
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

    public function commitChanges(UpdateClinicRequest $request)
    {
        if ($request->file('profile.avatar')) {
            $this->storeAvatar($request->file('profile.avatar'));
        }

        $this->fill($request->profile);

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

        }

        foreach ($request->specialities as $speciality => $value) {
            $this->toggleSpeciality($speciality, $value);
        }

        foreach ($request->diseases as $disease => $value) {
            $this->toggleDisease($disease, $value);
        }

        //Save the user's changes
        $this->save();
        $this->user()->save($user);

        auth()->user()->refresh();
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

    public function toggleSpeciality($speciality_id, $value)
    {
        if (!$this->specialities->contains($speciality_id) && $value) {
            $this->specialities()->attach($speciality_id);
        }

        if ($this->specialities->contains($speciality_id) && $value == '0') {
            $this->specialities()->detach($speciality_id);
        }
    }

    public function canSpecialistBeInvited(User $specialist)
    {
        return !$this->specialists->contains('id', $specialist->profile_id);
    }

    /*public function generateInvitationToken()
    {
        return sha1(Str::random(32) . microtime(true));
    }

    public function sendInvitations(User $user, string $token)
    {
        dispatch(new SendClinicSpecialistInvitations(
            $this->user,
            $user,
            $token
        ));
    }

    public function addSpecialist(User $user)
    {
        $token = $this->generateInvitationToken();
        $this->specialists()->attach([$user->profile->id => [
            'state' => ClinicSpecialist::SPECIALIST_STATE_PENDING,
            'invitation_token' => $token
        ]]);
        $this->sendInvitations($user, $token);
    }*/

    public function servicesViaSpecialists()
    {
        $query = DB::table((new Services())->getTable())
            ->distinct(['title'])
            ->join('services_specialist_profiles', 'services_specialist_profiles.service_id', '=', 'services.id')
            ->join('clinic_specialists', 'clinic_specialists.specialist_id', '=', 'services_specialist_profiles.specialist_profile_id')
            ->where('clinic_specialists.clinic_id', $this->id)
            ->get(['title']);

        return $query;
    }

    public function getLanguagesLabels()
    {
        return $this->languages->map(function ($language) {
            return languagesList()[$language->language];
        })->join(', ');
    }
}
