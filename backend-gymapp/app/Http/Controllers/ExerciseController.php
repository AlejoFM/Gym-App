<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Routine;
use App\Models\RoutineExercise;
use App\Models\TrainingVolume;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $exercises = Exercise::with('trainingVolume')->get();

            return response()->json(['exercises' => $exercises], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $exercise = new Exercise();
        $this->validate($request,[
            'name' => 'required',
            'muscular_group' => 'required',

        ]);
        $data = $request->only('name', 'muscular_group');
        $token = JWTAuth::getToken();
        $admin = JWTAuth::parseToken()->toUser($token);
        if ($admin->can('create', Exercise::class)) {
            $exercise = Exercise::firstOrNew([
                'name' => $data['exercise_name'],
                'muscular_group' => $data['exercise_group'],
            ]);
        }else{
            abort(401);
        }

        return ([
            'data' => [
                'exercise_data' => $exercise,
            ]
    ]);
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
