<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function create(User $patient, User $doctor)
    {
        return view('account.rating.create', [
            'patient' => $patient,
            'doctor' => $doctor
        ]);
    }

    public function store(User $patient, User $doctor, Request $request)
    {
        $rating = new Rating();

        $rating->new($request, $patient, $doctor);

        return redirect(route('account.feedback.show', [
            'rating' => $rating->id
        ]));
    }

    public function show(Rating $rating)
    {
        return view('account.rating.show', [
            'rating' => $rating,
            'patient' => $rating->patient,
            'doctor' => $rating->specialist,
        ]);
    }

    public function update(Request $request, Rating $rating)
    {
        if (auth()->user()->id !== $rating->patient->user->id) {
            return redirect()->back()->with('error', __('ratings.error_wrong_user'));
        }

        $rating->edit($request);

        return redirect()->back()->with('success', __('ratings.updated_success'));
    }
}
