<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         try {
            $user=Auth('api')->user();
            if(!$user){
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            // $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized','message'=>$e->getMessage()], 401);
        }

        return $next($request);
    }
}
