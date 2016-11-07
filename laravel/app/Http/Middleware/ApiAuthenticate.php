<?php

namespace App\Http\Middleware;

use Auth;
use Json;
use Redis;
use Closure;
use App\Models\AuthenUser;

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        $userId = Redis::hget('auth_tokens', $request->header('AUTHTOKEN'));

        if (! $userId) {
            return Json::error('Invalid auth token.', 104);
        }

        Auth::setUser(new AuthenUser($userId));

        return $next($request);
    }
}
