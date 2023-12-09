<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ["name", "muscular_group"];


    public function Routine(){
        return $this->belongsTo(Routine::class, 'routine_id', 'id');
    }
    public function RoutineExercise(){
        return $this->belongsToMany(RoutineExercise::class, 'routine_exercise', 'exercise_id');
    }

}
