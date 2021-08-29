<?php

namespace App\Models;

use App\Jobs\NotifyUserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function add(Request $request)
    {
        $password = Str::random(10);

        $admin = AdminProfile::create();

        $admin->user()->create([
            'uuid' => (string) Str::uuid(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'profile_type' => AdminProfile::class,
        ]);

        if ($request->roles) {
            $user = User::with('roles')->find($admin->user->id);
            foreach ($request->roles as $id => $value) {
                $user->toggleRole($id, $value);
            }
        }

        dispatch(new NotifyUserCreated($admin, $password));

        return $admin->id;
    }

    public function edit(Request $request)
    {

        $this->user->fill($request->all());

        foreach ($request->roles as $id => $value) {
            $this->user->toggleRole($id, $value);
        }

        return $this->user->save();
    }
}
