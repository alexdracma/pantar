<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\Steps;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Steps>
 */
class StepsFactory extends Factory
{
    protected $model = Steps::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $recipe_id = Recipe::all()->random()->id;

        return [
            'recipe_id' => $recipe_id,
            'step' => $faker->randomDigitNotNull(),
            'data' => $faker->sentence(22),
        ];
    }
}
