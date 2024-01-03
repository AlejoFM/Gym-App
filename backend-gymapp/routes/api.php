<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//TODO: Hacer los endpoints y controladores necesarios.
//TODO: Hacer la lógica para que en la ruta de ejercicios, apareza primero el grupo muscular y luego rediriga a una vista
// con todos los ejercicios correspondientes a ese grupo.
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/register', [TokenController::class, 'register']);
    Route::post('/login', [TokenController::class, 'login']);
    Route::post('/refresh', [TokenController::class, 'refresh']);
    Route::get('/user-profile', [TokenController::class, 'userProfile']);

});
Route::group(['middleware' => 'auth.jwt'],function ($router) {

    Route::group(['middleware' => 'auth.admin'], function ($router){


    Route::post('/dashboard/users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::get('/dashboard/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/dashboard/users/{id}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::delete('/dashboard/users', [\App\Http\Controllers\UserController::class, 'deleteRoutine']);

    Route::get('/dashboard/user_routine/{user_id}', [\App\Http\Controllers\CompleteRoutineController::class, 'index']);
    Route::put('/dashboard/exercise', [\App\Http\Controllers\CompleteRoutineController::class, 'updateRoutineUser']);

    Route::get('/dashboard/muscular_group', [\App\Http\Controllers\ExerciseController::class, 'showMuscularGroup']);
    Route::get('/dashboard/muscular_group/{muscular_group_name}', [\App\Http\Controllers\ExerciseController::class, 'showMuscularGroupExercises']);
    Route::post('/dashboard/muscular_group/', [\App\Http\Controllers\ExerciseController::class, 'createNewExercise']);
    Route::put('/dashboard/muscular_group/', [\App\Http\Controllers\ExerciseController::class, 'updateExerciseName']);

    Route::post('/dashboard/generateroutine/', [\App\Http\Controllers\CompleteRoutineController::class,'generateRoutine']);
    Route::get('/dashboard/exercise', [\App\Http\Controllers\ExerciseController::class, 'index']);
    Route::post('/dashboard/exercise', [\App\Http\Controllers\ExerciseController::class, 'store']);
    Route::delete('/dashboard/exercise', [\App\Http\Controllers\ExerciseController::class, 'deleteExercise']);

    Route::get('/dashboard/exercise/volume/{exercise_id}', [\App\Http\Controllers\TrainingVolumeController::class, 'index']);
    Route::post('/dashboard/exercise/volume', [\App\Http\Controllers\TrainingVolumeController::class, 'store']);
    Route::put('/dashboard/exercise/volume', [\App\Http\Controllers\TrainingVolumeController::class, 'update']);
    });

    Route::get('/routinetest/{user_id}', [\App\Http\Controllers\CompleteRoutineController::class, 'index']);

    Route::get('/myroutine', [\App\Http\Controllers\RoutineController::class, 'myroutine']);
    Route::post('/logout', [TokenController::class, 'logout']);
    Route::post('/change_password', [TokenController::class, 'change_password']);
    Route::post('/forgot-password', [TokenController::class, 'sendPasswordResetEmail']);
    Route::post('/reset-password/{token}', [TokenController::class, 'resetPassword']);
});
