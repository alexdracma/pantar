<?php

namespace Database\Factories;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    private function getIngredient(): string {

        $ingredients = ["Flour", "Sugar", "Salt",
            "Baking powder", "Baking soda", "Eggs", "Milk",
            "Butter", "Oil", "Yeast", "Vinegar", "Vanilla extract",
            "Cinnamon", "Nutmeg", "Ginger", "Garlic", "Onions",
            "Tomatoes", "Potatoes", "Carrots", "Celery", "Broccoli",
            "Chicken", "Beef", "Fish", "Shrimp", "Tofu", "Rice",
            "Pasta", "Beans", "Lentils"];

        $randomIndex = array_rand($ingredients);
        return $ingredients[$randomIndex];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->getIngredient()
        ];
    }
}
