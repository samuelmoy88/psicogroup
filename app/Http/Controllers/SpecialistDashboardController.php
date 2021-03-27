<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class SpecialistDashboardController extends Controller
{
    public function __invoke()
    {
        return view('specialist.show-profile', [
            'specialist' => auth()->user(),
            'dbServices' => Services::all()
        ]);
    }
}
