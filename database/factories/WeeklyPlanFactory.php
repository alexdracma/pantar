<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use App\Models\WeeklyPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WeeklyPlan>
 */
class WeeklyPlanFactory extends Factory
{

    protected $model = WeeklyPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = Faker::create();
        $user_id = User::all()->random()->id;
        $recipe_id = Recipe::all()->random()->id;

        return [
            'user_id' => $user_id,
            'recipe_id' => $recipe_id,
            'date' => $faker->date('Y-m-d'),
            'timeOfDay' => $faker->numberBetween(1, 3),
        ];
    }
}
