<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Membership;
use App\Models\Project;
use App\Models\Routine;
use App\Models\RoutinesWeekly;
use App\Models\TrainingVolume;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'rol' => strtolower('Admin'),
         ]);

         Membership::factory(10)->create();
         Exercise::factory(4)->create();
         TrainingVolume::factory(4)->create();
         Routine::factory(9)->create();
         RoutinesWeekly::factory(4)->create();
    }
}
