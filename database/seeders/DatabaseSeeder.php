<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(IngredientSeeder::class);
        $this->call(RecipeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(PantrySeeder::class);
        $this->call(StepsSeeder::class);
        $this->call(WeeklyPlanSeeder::class);
        $this->call(ShoppingListSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
