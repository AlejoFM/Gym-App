<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Mail\ResetPasswordMail;
use App\Mail\TestEmail;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    /**
     *
     *
     *
     */

    /**
     * @throws ValidationException
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(($request->password)),
            'token_update_date' => now(),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'admin' => $user,
            'token' => $token,
        ]);
    }


    public function login(LoginRequest $request){
        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return "Credenciales inválidas";
        }
        try {
            $token = JWTAuth::fromUser($user);
        }catch (JWTException $e){
            return $e;
        }
        return $token;
    }

    public function change_password(Request $request){

        $admin = Auth::guard('api')->user();
        $newPassword = $request->input('new_password');


        $admin->password = Hash::make($newPassword);
        $admin->token_update_date = now();

        $admin->save();

        return "Password successfully changed";
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $token = Str::random(60);
        $user->update(['password_reset_token' => $token]);


        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

        return response()->json(['message' => 'Correo electrónico de restablecimiento de contraseña enviado']);
    }

    public function resetPassword(Request $request, $token)
    {
        $user = Admin::where('password_reset_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token no válido'], 400);
        }


        $request->validate([
            'password' => 'required|min:8',
        ]);


        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'token_update_date' => now(),
        ]);

        return response()->json(['message' => 'Contraseña restablecida con éxito']);
    }


    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
