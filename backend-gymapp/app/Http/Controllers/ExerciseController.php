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
