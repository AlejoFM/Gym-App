<?php

namespace App\Models;

use App\Enums\RoutineDaysEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;
    //TODO: Hacer los enums correspondientes para el projecto.
    protected $casts = ["train_day" => RoutineDaysEnums::class];
    protected $fillable = ['user_id'];

    public function User(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function Exercise(){
        return $this->belongsToMany(Exercise::class, 'routine_exercises', 'routine_id', 'exercise_id');
    }

    public function RoutineExercise(){
        return $this->hasMany(RoutineExercise::class, 'routine_id');
    }

}
