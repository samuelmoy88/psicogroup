<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClinicProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\PhoneNumber;

class ClinicRegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register-clinic', [
            'specialistsVolume' => (new ClinicProfile())->specialistsVolume()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required',new PhoneNumber,'max:13','unique:users'],
            'password' => 'required|string|confirmed|min:8',
            'city' => 'required',
            'specialists_volume' => 'required',
        ]);

        $clinic = ClinicProfile::create([
            'city' => $request->city,
            'specialists_volume' => $request->specialists_volume,
        ]);

        Auth::login($user = $clinic->user()->create([
            'uuid' => (string) Str::uuid(),
            'username' => Str::slug($request->clinic_name),
            'first_name' => $request->clinic_name,
            'last_name' => '',
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        return redirect(route('clinic.edit', auth()->user()->uuid));
    }
}
