<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Facades\JWTAuth;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Accept-Language') != '') {
            $token = JWTAuth::getToken();
            if ($token) {
                $user = JWTAuth::parseToken()->authenticate();;
                $user->locale = $request->header('Accept-Language');
                $user->save();
            }
            App::setLocale($request->header('Accept-Language'));
        }

        return $next($request);
    }
}
