<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token= JWTAuth::getToken();
            $user = JWTAuth::parseToken()->toUser($token);;

            if ($user->rol === 'admin') {
                return $next($request);
            }
        } catch (JWTException $e) {
            \Log::error("No se pudo verificar el token: " . $e->getMessage());
        }
        return response()->json(['message' => 'No tienes permiso para acceder a esta ruta'], 401);
    }
}
