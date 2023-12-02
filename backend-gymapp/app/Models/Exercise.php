<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = ["name", "muscular_group"];

    public function trainingVolume(){
        return $this->hasMany(TrainingVolume::class, 'exercise_id', 'id');
    }

    public function routine(){
        return $this->belongsTo(Routine::class, 'exercise_id', 'id');
    }
}
