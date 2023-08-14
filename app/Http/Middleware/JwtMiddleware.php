<?php

namespace App\Http\Middleware;

use App\CustomHelpers\ReturnBase;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ReturnBase::Error('Token is Invalid', 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return ReturnBase::Error('Token is Expired', 401);
            } else {
                return ReturnBase::Error('Authorization Token not found', 401);
            }
        }
        return $next($request);
    }
}
