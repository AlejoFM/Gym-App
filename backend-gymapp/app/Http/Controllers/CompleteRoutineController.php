<?php

namespace App\Http\Controllers;

use App\Enums\RoutineDaysEnums;
use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Models\Routine;
use App\Models\RoutineExercise;
use App\Models\RoutinesWeekly;
use App\Models\TrainingVolume;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompleteRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // TODO: Que solo el usuario autenticado con el id, pueda ver su contenido.
    public function index(string $user_id)
    {

        try {
            $user_routine = Routine::where('user_id', $user_id)->first();
            if (!$user_routine){
                return "You have no routine available";
            };
            $user_routine->load(['RoutineExercise.Exercise', 'RoutineExercise.TrainingVolume']);
            return $user_routine;
        }catch (\Exception $e){
            return $e;
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function generateRoutine(Request $request){

        $volume = new TrainingVolume();
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'training_day' => ['required', Rule::enum(RoutineDaysEnums::class)],
            'exercise_id' => 'required',
            'exercise_repetitions' => 'required',
            'exercise_series' => 'required',
        ],[
            'user_id.exists' => "This user dont exists"
        ]);
        $data = $request->only('user_id','training_day','exercise_id', 'exercise_repetitions', 'exercise_series');
        $user = User::find($data['user_id']);
        $routine = Routine::firstOrNew([ 'user_id'=>$user->id, 'train_day' => $data['training_day']]);
        $exercise = Exercise::find($data['exercise_id']);

        $token = JWTAuth::getToken();
        $admin = JWTAuth::parseToken()->toUser($token);

        if ($admin->can('create', Exercise::class)){

            $volume->series = $data['exercise_series'];
            $volume->repetitions = $data['exercise_repetitions'];

            $volume->exercise_id = $exercise->id;
            $volume->save();

            $routine->train_day = $request->training_day;
            $routine->user_id = $user->id;
            $routine->save();
            $routineExercise = new RoutineExercise([
                'routine_id' => $routine->id,
                'exercise_id' => $exercise->id,
                'volume_id' => $volume->id,
                'user_id' => $user->id,
            ]);
            $routineExercise->save();
        }else{
            abort(401);
        }
        return ([
            'data' => [
                'routine' => $routine,
                'routine_full_information' => $routineExercise,
                'exercise_data' => $exercise,
                'volume_data' => $volume,
            ]
        ]);
    }
    public function store(Request $request)
    {
        $exercise = new Exercise();
        $volume = new TrainingVolume();
        $this->validate($request,[
            'routine_id' => 'required',
            'exercise_id' => 'required',
            'volume_id' => 'required',
            'user_id' => 'required',
        ]);
        $data = $request->only('user_id','routine_id','volume_id', 'user_id');
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

    public function updateRoutine(Request $request, $routine_id){

        $user_routine = Routine::findOrFail($routine_id);

        $user_routine->load(['routineExercise.volume', 'routineExercise.exercise']);
        $routineId = $user_routine->routineExercise->pluck('id')->toArray();

        $routineExercises = RoutineExercise::whereIn('id', $routineId)->pluck('exercise_id')->toArray();
        $routine_exercise_name = Exercise::whereIn('id', $routineExercises)->get();
        $routineExercises  = $request->exercisename;

        $routineExercises_volume = RoutineExercise::whereIn('id', $routineId)->pluck('volume_id')->toArray();
        $routine_exercise_volume = TrainingVolume::whereIn('id', $routineExercises_volume)->get();

        return $routine_exercise_volume;
    }
}
