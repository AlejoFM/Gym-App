<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoutinesWeekly;
use App\Models\User;
use Illuminate\Http\Request;

class RoutineWeeklyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return RoutinesWeekly::where('user_id', $user->id)->get();

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
