<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Routine;
use App\Models\RoutinesWeekly;
use App\Models\User;
use Illuminate\Http\Request;

class CompleteRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $user_id)
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $routineWeekly = RoutinesWeekly::where('user_id', $user->id)->first();

            if (!$routineWeekly) {
                return response()->json(['message' => 'Usuario sin rutina semanal asignada'], 404);
            }
            $routineDaily = Routine::where('user_id', $user->id)->get();

            return compact('user', 'routineWeekly', 'routineDaily');

        } catch (\Exception $e) {
            return $e;
        }
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
    public function show(string $id)
    {
        //
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
