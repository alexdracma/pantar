<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use App\Models\Recipe;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class FinishRecipe extends Component
{
    use WireToast;

    public $showFinishRecipeModal = false;
    public Recipe $recipeToFinish;
    public $amount;

    public function mount(Recipe $recipeToFinish) {
        $this->recipeToFinish = $recipeToFinish;
        $this->amount = $recipeToFinish->servings;
    }

    public function render()
    {
        return view('livewire.elements.finish-recipe');
    }

    public function finishRecipe() {
        try {
            if ($this->amount === null) {
                throw new Exception('You must indicate the servings');
            }

            if ($this->amount < 1) {
                throw new Exception('You must have prepared this recipe for at least 1 person');
            }

            if ($this->amount > 100) {
                throw new Exception("There's no way you made this recipe for more than 100 people");
            }

            $this->deleteIngredientsFromUserPantry($this->recipeToFinish->ingredients,
                $this->recipeToFinish->servings, $this->amount);

            $this->showFinishRecipeModal = false;

            toast()
                ->success('Enjoy your meal!')
                ->duration(3000)
                ->push();

            $this->emit('close');

        } catch (Exception $ex) {
            toast()
                ->danger($ex->getMessage())
                ->duration(4000)
                ->push();
        }
    }

    private function deleteIngredientsFromUserPantry($ingredients, $recipeServings, $cookedServings) {

        //get the information from the ingredients that are both on the recipe and the pantry

        foreach ($ingredients as $ingredient) {

            if (userHasIngredient($ingredient->id)) {

                $pantry = getUserPantry($ingredient->id)->pivot;
                $recipeAmount = $ingredient->pivot->amount;
                $recipeUnitInGrams = getIngredientAmountInGrams($ingredient->id, $ingredient->pivot->unit);
                $userPreferredUnitInGrams = getIngredientAmountInGrams($pantry->ingredient_id, $pantry->unit);

                $amountCookedInGrams = $recipeAmount / $recipeServings * $cookedServings * $recipeUnitInGrams;
                $userHasAvailableOfIngredientInGrams = $pantry->amount * $userPreferredUnitInGrams;

                //delete from their pantry
                $newAvailable = $userHasAvailableOfIngredientInGrams - $amountCookedInGrams;
                if ($newAvailable <= 0) {
                    Auth::user()->pantries()->detach(Ingredient::find($ingredient->id));
                    //IMPLEMENT ADD TO SHOPPING LIST
                    toast()
                        ->info("You've run out of " . $ingredient->name .
                            ", its been automatically added to your shopping list")
                        ->duration(4000)
                        ->push();
                } else {
                    $newAvailableInUserPreferred = $newAvailable / $userPreferredUnitInGrams;
                    $pantry->amount = $newAvailableInUserPreferred;
                    $pantry->save();
                }
            }
        }
    }
}
