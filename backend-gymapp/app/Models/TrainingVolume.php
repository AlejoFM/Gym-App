<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingVolume extends Model
{
    use HasFactory;
    protected $fillable = ["series", "repetitions"];

    public function exercise(){
        return $this->belongsTo(Exercise::class, "exercise_id", "id");
    }
    public function routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id', 'id');
    }

}
