<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $user = auth()->user();
            if (($user->rol) == "admin"){
                return User::all();
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        $data = $request->only('name', 'surname', 'email', 'password');

        $token = JWTAuth::getToken();
        $admin = JWTAuth::parseToken()->toUser($token);

        if($admin->can('create', User::class)){
            $user = new User();
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->email = $data['email'];
            $user->password = $data['password'];

            $user->save();
        }else{
            abort(403);
        }
        return ([
            'data' => [
                'user_data' => $user,
            ]
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::where('id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
