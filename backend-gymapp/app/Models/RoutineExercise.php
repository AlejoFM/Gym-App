<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutineExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'routine_id',
        'exercise_id',
        'volume_id',
        'user_id',
    ];
    public function Routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }

    public function Exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function TrainingVolume()
    {
        return $this->hasOne(TrainingVolume::class, 'routine_exercise_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
