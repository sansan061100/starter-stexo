<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class JWTCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!$user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'code'   => 101, // means auth error in the api,
                    'response' => 'Authorization Token not found' // nothing to show
                ], 500);
            }
        } catch (TokenExpiredException $e) {
            // If the token is expired, then it will be refreshed and added to the headers
            try {
                $refreshed = FacadesJWTAuth::refresh(FacadesJWTAuth::getToken());
                $user = FacadesJWTAuth::setToken($refreshed)->toUser();

                return response()->json([
                    'token' => $refreshed
                ]);
            } catch (JWTException $e) {
                return response()->json([
                    'code'   => 103,
                    'response' => 'Token is Blacklist'
                ], 500);
            }
        } catch (JWTException $e) {
            return response()->json([
                'code'   => 101, // means auth error in the api,
                'response' => 'Token is Invalid' // nothing to show
            ], 500);
        }

        $outlet = getUser('outlet');
        $pelanggan = getUser('pelanggan');

        if ($outlet != null && getUri(2) == 'pelanggan') {
            return response()->json([
                'code'   => 101, // means auth error in the api,
                'response' => 'Dont have access' // nothing to show
            ], 500);
        }

        if ($pelanggan != null && getUri(2) == 'outlet') {
            return response()->json([
                'code'   => 101, // means auth error in the api,
                'response' => 'Dont have access' // nothing to show
            ], 500);
        }

        return  $next($request);
    }
}
