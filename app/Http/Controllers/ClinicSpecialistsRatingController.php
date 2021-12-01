<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicSpecialistsRatingController extends Controller
{
    public function index()
    {
        return view('clinic.ratings.index', [
            'ratings' => auth()->user()->profile->specialistsRatings
        ]);
    }

    public function show(User $uuid, Rating $rating)
    {
        return view('clinic.ratings.show', [
            'rating' => $rating,
            'patient' => $rating->patient,
            'doctor' => $rating->specialist
        ]);
    }
}
