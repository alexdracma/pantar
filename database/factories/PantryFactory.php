<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Pantry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pantry>
 */
class PantryFactory extends Factory
{
    protected $model = Pantry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = Faker::create();
        $ingredient_id = Ingredient::all()->random()->id;
        $user_id = User::all()->random()->id;

        return [
            'ingredient_id' => $ingredient_id,
            'user_id' => $user_id,
            'amount' => $faker->randomFloat(1),
            'unit' => $this->getRandomMetricUnit(),
        ];
    }

    private function getRandomMetricUnit() {
        $units = array("u", "mg", "g", "kg", "mL", "L");
        $randomIndex = array_rand($units);
        return $units[$randomIndex];
    }
}
