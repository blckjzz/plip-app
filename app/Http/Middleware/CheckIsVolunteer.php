<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsVolunteer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role->id == 2) {
                return $next($request);
            }
            abort(403, 'YOU MUST BE AN VOLUNTEER USER TO PERFORM THIS ACTION!');
        }

    }
}
