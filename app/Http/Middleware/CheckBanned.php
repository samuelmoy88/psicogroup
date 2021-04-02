<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckBanned
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
        if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $banned_days = now()->diffInDays(auth()->user()->banned_until);
            auth()->logout();

            if ($banned_days > 14) {
                $message = __('config.account_suspended') . '. ' . __('config.contact_admin');
            } else {
                $message = __('config.account_suspended_for') . ' ' . $banned_days.' '.__('config.'.Str::plural('day', $banned_days)) . '. ' . __('config.contact_admin');
            }

            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
