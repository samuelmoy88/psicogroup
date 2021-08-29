<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistRatingController extends Controller
{
    public function index()
    {
        return view('specialist.ratings.index', [
            'ratings' => auth()->user()->profile->ratings,
        ]);
    }

    public function show(User $uuid, Rating $rating)
    {
        return view('specialist.ratings.show', [
            'rating' => $rating,
            'patient' => $rating->patient,
            'doctor' => $rating->specialist
        ]);
    }

    public function update(Request $request, User $uuid, Rating $rating)
    {
        $request->validate([
            'specialist_reply' => 'required|string'
        ]);

        $rating->fill($request->all());

        $rating->save();

        return redirect(
            route('specialist.ratings.show', [
                'uuid' => $uuid->uuid,
                'rating' => $rating->id
            ])
        )->with('success', __('common.specialist_reply_created'));
    }
}
