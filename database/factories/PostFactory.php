<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $faker = Faker::create();
        $recipe_id = Recipe::all('id')->random()->id;
        $user_id = User::all('id')->random()->id;

        return [
            'recipe_id' => $recipe_id,
            'user_id' => $user_id,
            'slug' => $faker->sentence(20),
        ];
    }
}
