<?php

namespace App\Http\Middleware;

use App\Providers\AppServiceProvider;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAdminUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && auth()->user()->isAdmin) {
            return redirect(config('app.admin_backend') . RouteServiceProvider::DASHBOARD);
        }
        return $next($request);
    }
}
