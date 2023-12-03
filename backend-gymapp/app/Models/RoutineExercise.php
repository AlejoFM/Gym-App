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
    public function routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function volume()
    {
        return $this->belongsTo(TrainingVolume::class, 'volume_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
