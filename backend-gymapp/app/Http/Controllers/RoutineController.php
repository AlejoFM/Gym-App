<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Routine;
use App\Models\RoutinesWeekly;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $user_id)
    {
        $user_routine = Routine::where('user_id', $user_id)->get();
        if (!$user_routine){
            return "You have no routine available";
        };
        $user_routine->load(['routineExercise.exercise', 'routineExercise.volume']);
        return $user_routine;
    }

    public function myroutine()
    {
        $user = auth()->user();

        // Cargar las relaciones routine y routineExercise directamente
        $user->load(['routine.RoutineExercise.exercise', 'routine.RoutineExercise.TrainingVolume']);

        $routines = $user->routine;

        if ($routines->isNotEmpty()) {
            return response()->json([
                'user' => $routines,
            ]);
        } else {
            return response()->json([
                'message' => 'Usuario sin rutina asignada',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $routine = new Routine();
        $routine->train_day = $request->train_day;
        $routine->user_id = $request->user_id;
        $routine->save();

        return "User routine created succesfully";
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
