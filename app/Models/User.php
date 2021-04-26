<?php

namespace App\Models;

use App\Events\CacheSpecialist;
use App\Events\UpdatingSpecialist;
use App\Traits\FormatDates;
use App\Traits\Searchable;
use App\Traits\TrackChanges;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, FormatDates, TrackChanges, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'uuid',
        'status',
        'banned_until'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'banned_until' => 'datetime'
    ];

    protected $with = ['profile'];

    protected $dispatchesEvents = [
        'updating' => UpdatingSpecialist::class,
        'saved' => CacheSpecialist::class,
    ];

    protected $searchable = [
        'first_name',
        'last_name'
    ];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public function profile()
    {
        return $this->morphTo();
    }

    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'addresses_users',
            'user_id',
            'address_id'
        );
    }

    public function uneasiness()
    {
        return $this->belongsToMany(
            Unease::class,
            'uneasiness_users',
            'user_id',
            'uneasiness_id'
        )->withPivot('profile_type');
    }

    public function getIsSpecialistAttribute()
    {
        return $this->profile_type == SpecialistProfile::class;
    }

    public function getIsPatientAttribute()
    {
        return $this->profile_type == PatientProfile::class;
    }

    public function getIsAdminAttribute()
    {
        return $this->profile_type == AdminProfile::class;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function toggleRole(int $role_id, string $data)
    {
        if ($data != '0' && !$this->hasRole($role_id)) {
            $this->assignRole($role_id);
        }

        if ($data == '0' && $this->hasRole($role_id)) {
            $this->removeRole($role_id);
        }
    }

    public function toggleUnease(int $unease_id, $value)
    {
        $profile = $this->isSpecialist ? SpecialistProfile::class : PatientProfile::class;

        if (!$this->uneasiness->contains($unease_id) && $value) {
            $this->uneasiness()->attach($unease_id, ['profile_type' => $profile]);
        }

        if ($this->uneasiness->contains($unease_id) && $value == '0') {
            $this->uneasiness()->detach($unease_id);
        }
    }

    public function resetPassword($password = null)
    {
        if (!$password) {
            $password = Str::random(10);
        }

        $this->password = Hash::make($password);

        return $this->update();
    }

    public function saveToCache()
    {
        $data['full_name'] = $this->first_name . ' ' . $this->last_name;
        $data['uuid'] = $this->uuid;
        $data['username'] = $this->username;
        $data['status'] = $this->status;
        $data['banned_until'] = $this->banned_until;
        $data['prefix'] = $this->profile->prefixLabel;
        $data['license_number'] = $this->profile->license_number;
        $data['is_verified'] = $this->profile->is_verified;
        $data['avatar'] = $this->profile->avatarPath;
        $data['about'] = $this->profile->about;
        $data['has_online_consultation'] = false;

        if ($this->profile->services) {
            foreach ($this->profile->services as $service) {
                $data['services'][] = [
                    'title' => $service->title,
                    'description' => $service->pivot->description,
                    'price' => $service->pivot->price,
                    'price_from' => $service->pivot->price_from,
                ];
            }
        }

        if ($this->addresses) {
            $allServices = Services::all();
            foreach ($this->addresses as $address) {
                $services = [];
                $payments = [];
                $accessibility = [];

                if (count($address->services) > 0) {
                    foreach ($address->services as $service) {
                        $data['services'][] = [
                            'description' => $service->description,
                            'price' => $service->price,
                            'price_from' => $service->price_from,
                            'duration' => $service->duration,
                            'title' => $allServices->firstWhere('id', $service->service_id)->title
                        ];
                        $services[] = [
                            'description' => $service->description,
                            'price' => $service->price,
                            'price_from' => $service->price_from,
                            'duration' => $service->duration,
                            'title' => $allServices->firstWhere('id', $service->service_id)->title
                        ];
                    }
                }

                if (count($address->paymentMethods) > 0) {
                    foreach ($address->paymentMethods as $paymentMethod) {
                        $payments[] = $paymentMethod->title;
                    }
                }

                if (count($address->accessibility) > 0) {
                    foreach ($address->accessibility as $_accessibility) {
                        $accessibility[] = $_accessibility->title;
                    }
                }
                if ($address->consultation_type === 'online')
                    $data['has_online_consultation'] = true;
                    $data['addresses'][] = [
                        'clinic_name' => $address->clinic_name,
                        'title' => $address->title,
                        'street' => $address->street,
                        'city' => $address->city,
                        'country' => $address->country,
                        'zip_code' => $address->zip_code,
                        'address_indications' => $address->address_indications,
                        'web_site' => $address->web_site,
                        'consultation_type' => $address->consultation_type,
                        'accessibility' => $accessibility,
                        'services' => $services,
                        'payment_methods' =>  $payments,
                    ];
            }
        }

        if ($this->profile->specialities) {
            foreach ($this->profile->specialities as $speciality) {
                $data['specialities'][] = $speciality->title;
            }
        }

        if ($this->profile->diseases) {
            foreach ($this->profile->diseases as $disease) {
                $data['diseases'][] = $disease->title;
            }
        }

        return cache()->store(config('cache.default'))->set($this->uuid, collect($data), now()->addDays(5));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function scopeSpecialistProfile($query)
    {
        return $query->where('profile_type', SpecialistProfile::class)->where('status', 'active')->whereNull('banned_until');
    }
}
