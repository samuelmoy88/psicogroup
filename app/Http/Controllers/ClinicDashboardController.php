<?php

namespace App\Http\Controllers;

use App\Models\Services;
use Illuminate\Http\Request;

class ClinicDashboardController extends Controller
{
    public function __invoke()
    {
        return view('clinic.show-profile', [
            'clinic' => auth()->user(),
            'dbServices' => Services::all()
        ]);
    }
}
