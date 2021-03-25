<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordValidationController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request)
    {
        $request->validated();

        return response()->json([], 200);
    }
}
