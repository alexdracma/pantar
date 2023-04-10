<?php

namespace Database\Seeders;

use App\Models\Steps;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StepsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Steps::factory()->count(5)->create();
    }
}
