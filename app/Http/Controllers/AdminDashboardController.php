<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard.index',[
            'user' => auth()->user()
        ]);
    }
}
