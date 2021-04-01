<?php

namespace App\Models;

use App\Events\UpdatingSpecialist;
use App\Traits\FormatDates;
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
    use HasFactory, Notifiable, HasRoles, FormatDates, TrackChanges;

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
        'status'
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
    ];

    protected $with = ['profile'];

    protected $dispatchesEvents = [
        'updating' => UpdatingSpecialist::class
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
        return 'username';
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

    public function resetPassword($password = null)
    {
        if (!$password) {
            $password = Str::random(10);
        }

        $this->password = Hash::make($password);

        return $this->update();
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
}
