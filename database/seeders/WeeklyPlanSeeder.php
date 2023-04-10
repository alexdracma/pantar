<?php

namespace Database\Seeders;

use App\Models\WeeklyPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeeklyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WeeklyPlan::factory()->count(5)->create();
    }
}
