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
    public function index(string $routine_id)
    {
        $user = auth()->user();
        $routine_weekly = RoutinesWeekly::where('user_id', $user->id)->first();

        if (!$routine_weekly) {
            return response()->json(['error' => 'No routine weekly found for the user'], 404);
        }

        $routine_daily = Routine::find($routine_weekly->routine_id);

        if (!$routine_daily) {
            return response()->json(['error' => 'No routine found for the user'], 404);
        }

        if ($routine_daily->id == $routine_id) {
            return Routine::where('user_id', $user->id)->get();
        }

        return "You have no routine available";
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
