<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ["name", "muscular_group"];


    public function routine(){
        return $this->belongsTo(Routine::class, 'routine_id', 'id');
    }
    public function routineExercise(){
        return $this->hasMany(RoutineExercise::class, 'exercise_id', 'id');
    }
    public function trainingVolume(){
        return $this->belongsTo(TrainingVolume::class, 'exercise_id');
    }

}
