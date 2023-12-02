<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;
    protected $fillable = ["train_day"];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function exercise(){
        return $this->hasMany(Exercise::class, 'exercise_id', 'id');
    }
    public function trainingVolumes(){
        return $this->hasMany(TrainingVolume::class, 'training_volume_id', 'id');
    }
    public function routinesWeekly(){
        return $this->belongsTo(RoutinesWeekly::class, 'routine_id', 'id');
    }
}
