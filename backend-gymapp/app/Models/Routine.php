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

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function exercise(){
        return $this->belongsToMany(Exercise::class, 'routine_exercise', 'routine_id', 'exercise_id')
            ->withPivot('volume_id');
    }
    public function trainingVolumes(){
        return $this->hasMany(TrainingVolume::class, 'training_volume_id', 'id');
    }
    public function routineExercise(){
        return $this->hasMany(RoutineExercise::class, 'routine_id', 'id');
    }
}
