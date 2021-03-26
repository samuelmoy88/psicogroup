<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecialistDashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'user' => auth()->user()
        ]);
    }
}