<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoutineExercise;
use App\Models\TrainingVolume;
use Illuminate\Http\Request;

class TrainingVolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $exercise_id)
    {
        $routineExercise = RoutineExercise::where('exercise_id', $exercise_id)->first();

        if (!$routineExercise) {
            return response()->json(['message' => 'Ejercicio no encontrado en RoutineExercise'], 404);
        }

        $volumeId = $routineExercise->volume_id;

        $volume = TrainingVolume::find($volumeId);

        if (!$volume) {
            return response()->json(['message' => 'Volumen no encontrado en TrainingVolume'], 404);
        }

        return response()->json(['exercise' => $routineExercise->exercise, 'volume' => $volume]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $training_volume = new TrainingVolume();

        $training_volume->series = $request->series;
        $training_volume->repetitions = $request->repetitions;
        $training_volume->exercise_id = $request->exercise_id;

        $training_volume->save();

        return "Training volume created succesfully";
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
