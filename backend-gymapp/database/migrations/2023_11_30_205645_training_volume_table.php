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
        Schema::create('training_volumes', function (Blueprint $table) {
            $table->id();
            $table->integer('series');
            $table->integer('repetitions');
            $table->unsignedBigInteger('routine_exercise_id');
            $table->foreign('routine_exercise_id')->references('id')->on('exercises')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
