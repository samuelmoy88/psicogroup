<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;

class VerifyAccountController extends Controller
{
    public function __invoke()
    {
        event(new Registered(auth()->user()));

        return redirect()->back();
    }
}
