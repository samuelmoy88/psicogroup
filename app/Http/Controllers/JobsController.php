<?php

namespace App\Http\Controllers;

use App\Jobs\NotifySpecialistAboutChange;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function enqueue(User $user, $body)
    {
        NotifySpecialistAboutChange::dispatchAfterResponse($user, $body);
    }
}
