<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingVolume extends Model
{
    use HasFactory;
    protected $fillable = ["series", "repetitions"];

    public function RoutineExercise(){
        return $this->belongsTo(Exercise::class, "exercise_id");
    }

}
