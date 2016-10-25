<?php

namespace App\Http\Middleware;

use Json;
use Redis;
use Closure;

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        $userId = Redis::hget('auth_tokens', $request->header('AUTHTOKEN'));

        if (! $userId) {
            return Json::error('Invalid auth token.', 104);
        }

        $request->userId = $userId;

        return $next($request);
    }
}
