<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('routine_exercises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('routine_id');
            $table->unsignedBigInteger('exercise_id');
            $table->unsignedBigInteger('volume_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('routine_id')->references('id')->on('routines');
            $table->foreign('exercise_id')->references('id')->on('exercises');
            $table->foreign('volume_id')->references('id')->on('training_volumes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_exercise');
    }
};
