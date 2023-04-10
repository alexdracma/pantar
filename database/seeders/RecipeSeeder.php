<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory()->count(5)->create();

        $ingredients = Ingredient::all();
        $faker = Faker::create();

        //seeding pivot table of recipe_ingredient
        foreach (Recipe::all() as $recipe) {
            $ingredient = $ingredients->random()->id;

            $recipe->ingredients()->attach($ingredient, [
                'amount' => $faker->randomDigitNotNull(),
                'unit' => $this->getRandomMetricUnit(),
            ]);
        }
    }

    private function getRandomMetricUnit() {
        $units = array("u", "mg", "g", "kg", "mL", "L");
        $randomIndex = array_rand($units);
        return $units[$randomIndex];
    }
}
