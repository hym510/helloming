<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AdminAuthenticate
{
    public function handle($request, Closure $next)
    {
        Auth::setDefaultDriver('admin');

        if (! Auth::check()) {
            return redirect()->action('Admin\AuthController@getLogin');
        }

        return $next($request);
    }
}
