<?php

namespace App\Http\Middleware;

use Auth;
use Json;
use Closure;
use App\Library\Redis\Redis;
use App\Models\{AuthenUser, User};

class ApiAuthenticate
{
    public function handle($request, Closure $next)
    {
        $userId = Redis::authtoken($request->header('AUTHTOKEN'));

        if (! $userId) {
            $user = User::where('auth_token', $request->header('AUTHTOKEN'))
                ->first(['id']);

            if (! $user) {
                return Json::error('Invalid auth token.', 104);
            }

            $userId = $user->id;
        }

        if (Redis::hget('user:'.$userId, 'activate') == 0) {
            return Json::error('User account has been frozen.', 114);
        }

        Auth::setUser(new AuthenUser($userId));

        return $next($request);
    }
}
