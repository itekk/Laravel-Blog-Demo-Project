<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsBlogger
{
    /**
     * Get the path that the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->user_type != 'blogger') {
            return redirect('/');
        }

        return $next($request);
    }
}
