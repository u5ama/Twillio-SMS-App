<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Models\Driver;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class PlayersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard="players")
    {

        try {
            $user = \Auth::guard('player')->user();

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['success' => false, 'message' => 'Token is Invalid'], 400);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['success' => false, 'message' => 'Token is Expired'], 400);
            } else {
                return response()->json(['success' => false, 'message' => 'Authorization Token not found'], 400);
            }
        }
        return $next($request);
    }
}
