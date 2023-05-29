<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;
use GuzzleHttp\Client;
use Livewire\Component;
use Exception;
use Usernotnull\Toast\Concerns\WireToast;

class Shopping extends Component
{
    use WireToast;
    public $shoppingList;
    public $runningOut;
    public $addingIngredient = false;
    public $availableUnits;
    public $selectedUnit;
    public $amount;
    public $selectedIngredient;
    public $pressedIngredient;
    public $checkedIngredients = [];

    public function test() {
        dd($this->checkedIngredients);
    }

    public function updatedSelectedIngredient() {

        if ($this->selectedIngredient !== null) {

            if (ingredientIsInUserShoppingList($this->selectedIngredient)) {
                $this->selectedIngredient = null;
                toast()
                    ->danger('That ingredient is already in your shopping list')
                    ->duration(4000)
                    ->push();
            } else {
                $this->openSelectIngredientAmountAndUnitPopup();
            }
        }
    }

    public function mount() {
        $this->setShoppingList(Auth::user()->shoppingLists);
        $this->runningOut = $this->getRunningOutIngredients();
    }

    public function render()
    {
        return view('livewire.shopping');
    }

    public function openSelectIngredientAmountAndUnitPopup($ingredient = null) {

        if ($ingredient === null) {
            $this->availableUnits = Ingredient::find($this->selectedIngredient)->availableUnits;
        } else {
            $this->pressedIngredient = $ingredient;
            $this->availableUnits = Ingredient::find($ingredient)->availableUnits;
        }

        $this->addingIngredient = true;
    }

    public function removeFromShoppingList(Ingredient $ingredient, $showToast = true) {
        Auth::user()->shoppingLists()->detach($ingredient);

        $this->setShoppingList(Auth::user()->shoppingLists); //refresh the pad
        $this->runningOut = $this->getRunningOutIngredients(); //refresh running out

        if ($showToast) {
            toast()
                ->success('The ' . $ingredient->name . ' was succesfully removed from your shopping list')
                ->duration(3500)
                ->push();
        }
    }
    public function selectUnitAndAmount() {

        try {
            if ($this->selectedUnit === null || $this->amount === null) {
                throw new Exception('Both fields are required');
            }

            if ($this->amount <= 0) {
                throw new Exception('The amount cannot be 0 or less');
            }

            $this->addToShoppingList();

            $this->selectedIngredient = null;
            $this->pressedIngredient = null;
            $this->selectedUnit = null;
            $this->amount = null;

        } catch (Exception $ex) {
            toast()
                ->danger($ex->getMessage())
                ->duration(4000)
                ->push();
        }
    }

    private function addToShoppingList() {

        if ($this->selectedIngredient !== null) {
            Auth::user()->shoppingLists()
                ->attach(Ingredient::find($this->selectedIngredient),
                    ['amount' => $this->amount, 'unit' => $this->selectedUnit]);
        } else {
            Auth::user()->shoppingLists()
                ->attach(Ingredient::find($this->pressedIngredient),
                    ['amount' => $this->amount, 'unit' => $this->selectedUnit]);

            $this->runningOut = $this->getRunningOutIngredients(); //refresh running out
        }

        $this->addingIngredient = false;
        $this->setShoppingList(Auth::user()->shoppingLists); //refresh the pad

        toast()
            ->success('The ingredient has been added to your list')
            ->duration(3000)
            ->push();
    }


    public function finishShopping() {

        foreach ($this->checkedIngredients as $id => $data) {
            if ($data) {
                $ingredient = Auth::user()->shoppingLists()->firstWhere('ingredient_id', $id)->pivot;

                $this->addConversionToGrams($ingredient->unit, $id); //add the conversion if it isnt there already

                if (userHasIngredient($id)) {
                    $existing = getUserPantry($id);
                    $userAmountInGrams = getIngredientTotalAmountInGrams($existing->id, $existing->pivot->unit ,
                        $existing->pivot->amount);
                    $selectedIngredientAmountInGrams = getIngredientTotalAmountInGrams($id,
                        $ingredient->unit, $ingredient->amount);
                    $newUserTotalAmountInGrams = $selectedIngredientAmountInGrams + $userAmountInGrams;

                    $newUserAmount = getUserPreferedAmountFromGrams($existing->id, $newUserTotalAmountInGrams);

                    Auth::user()->pantries()->updateExistingPivot($existing->id, ['amount' => $newUserAmount]);

                } else {
                    $ing = Ingredient::find($id);
                    Auth::user()->pantries()->attach( $ing, ['amount' => $ingredient->amount, 'unit' => $ingredient->unit]);
                }

                $this->removeFromShoppingList(Ingredient::find($id), false);
            }
        }

        $this->setShoppingList(Auth::user()->shoppingLists); //refresh the pad

        toast()
            ->success('Shopping successfully')
            ->duration(3000)
            ->push();
    }

    private function addConversionToGrams($unit, $ingredient) {
        $intraClient = new Client(['base_uri' => config('app.url')]);
        $params = [
            'form_params' => [
                'unit' => $unit,
                'ingredient' => $ingredient
            ],
        ];
        $intraClient->post('api/conversion', $params);
    }

    private function getRunningOutIngredients() {

        $ids = [];

        foreach (Auth::user()->pantries as $pantry) {
            //if the user has less than 80g of the ingredient and is not on the shopping list already, add it
            if (getIngredientTotalAmountInGrams($pantry->id, $pantry->pivot->unit, $pantry->pivot->amount) < 80
                && ! ingredientIsInUserShoppingList($pantry->id)) {

                $ids[] = $pantry->id;
            }
        }

        return Ingredient::findMany($ids);
    }

    private function setShoppingList($shoppingList) {
        $ingredients = [];

        foreach ($shoppingList as $ingredient) {
            $ingredients[] = ['id' => $ingredient->id, 'img' => $ingredient->getFullImgPath(), 'name' => $ingredient->name,
                'amount' => $ingredient->pivot->amount, 'unit' => getUnitNameById($ingredient->pivot->unit)];
        }

        $this->shoppingList = $ingredients;
    }
}
