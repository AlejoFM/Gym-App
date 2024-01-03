<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Routine;
use App\Models\RoutineExercise;
use App\Models\TrainingVolume;
use App\Models\User;
use http\Env\Response;
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
            $exercises = Exercise::all();

            return response()->json(['exercises' => $exercises], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function showMuscularGroupExercises($muscular_group_name){
        try {
            $muscular_group = Exercise::where('muscular_group', $muscular_group_name)->get();
            return response()->json(['data' => $muscular_group], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
    public function createNewExercise(Request $request){
        try {

            $newExercise = new Exercise();
            $newExercise->muscular_group = $request->exerciseData['muscular_groups_name'];
            $newExercise->name = $request->exerciseData['name'];
            $newExercise->save();

            return response()->json(['data' => $newExercise], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function updateExerciseName(Request $request){
            $exercisesNames = $request->input('ExerciseNames');
        try {
            foreach ($exercisesNames as $name) {
                Exercise::where('id', $name['id'])->first()->update(['name' => $name['name']]);
            }
            return \response()->json(['data' => $exercisesNames]);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function showMuscularGroup(){

        try {
        $muscular_group = Exercise::all('muscular_group');
        return response()->json(['muscular_group' => $muscular_group], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:exercises',
            'muscular_group' => 'required',
        ]);

        $exercise = Exercise::create([
            'name' => $request->input('name'),
            'muscular_group' => $request->input('muscular_group'),
        ]);

        return response()->json(['message' => 'Exercise created successfully', 'exercise' => $exercise], 201);
    }
    public function deleteExercise(Request $request){
        return RoutineExercise::where('id', $request->exerciseId)->delete();
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
    public function update(Request $request)
    {
        $exercises = $request->input('updatedExercises');
        foreach ($exercises as $exercise){
            RoutineExercise::where(['id' => $exercise['routineExerciseId']])->first()->update(['exercise_id' => $exercise['updatedExerciseId']]);
            TrainingVolume::where(['id' => $exercise['updatedExerciseVolumeId']])->first()->update(['repetitions' => $exercise['updatedExerciseRepetitions'], 'series' => $exercise['updatedExerciseSeries']]);
        }
        return response()->json(['data' => $exercises]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
