<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class LoggedInValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            $token= JWTAuth::parseToken();
            $token->authenticate();
            $payload = $token->getPayload();
            $tokenUpdateDate = $token->user()['token_update_date'];
            $tokenUpdate = new Carbon($tokenUpdateDate);

            $request->headers->set('X-Requested-With', 'XMLHttpRequest');
            if ($payload->get('iat') >= $tokenUpdate->getTimestamp()) {
                return $next($request);

            }
            return response()->json(['message' => 'Fecha de token inválida']);
        } catch (JWTException $e) {
            \Log::error('Error al manejar el token JWT: ' . $e->getMessage());
            return response()->json(['message' => 'No tienes la sesión iniciada'],401);
        }
        return response()->json(['message' => 'No tienes la sesión iniciada'],401);
    }
}
