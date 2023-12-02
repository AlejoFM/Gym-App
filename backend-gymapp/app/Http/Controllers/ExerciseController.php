<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Routine;
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
        $volume = new TrainingVolume();
        $this->validate($request,[
            'user_id' => 'required',
            'routine_id' => 'required',
            'name' => 'required',
            'muscular_group' => 'required',
            'series' => 'required',
            'repetitions' => 'required',
        ]);
        $data = $request->only('user_id','routine_id', 'name', 'muscular_group', 'series', 'repetitions');
        $routine = Routine::find($data['routine_id']);
        $user = User::find($data['user_id']);

        $token = JWTAuth::getToken();
        $admin = JWTAuth::parseToken()->toUser($token);
        if ($admin->can('create', Exercise::class)){
            $exercise->name = $data['name'];
            $exercise->muscular_group = $data['muscular_group'];
            $volume->series = $data['series'];
            $volume->repetitions = $data['repetitions'];

            $exercise->save();
            $volume->exercise_id = $exercise->id;
            $volume->save();

            $routine->user_id = $user->id;
            $routine->exercise()->attach($exercise->id, ['volume_id' => $volume->id]);
        }else{
            abort(401);
        }
        return ([
            'data' => [
                'routine' => $routine,
                'exercise_data' => $exercise,
                'volume_data' => $volume,
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
