<?php

namespace Database\Seeders;

use App\Models\Pantry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PantrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pantry::factory()->count(5)->create();
    }
}
