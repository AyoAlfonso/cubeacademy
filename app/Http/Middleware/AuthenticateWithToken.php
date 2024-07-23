<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateWithToken
{
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        $token = PersonalAccessToken::findToken($bearerToken);
        if ($token) {
            $request->setUserResolver(function () use ($token) {
                return $token->tokenable;
            });
            Auth::setUser($token->tokenable);
        }

        return $next($request);
    }
}
