<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\In;
use Livewire\Component;
use Exception;
use Usernotnull\Toast\Concerns\WireToast;

class Shopping extends Component
{
    use WireToast;
    public $shoppingList;
    public $runningOut;
    public $showSelectIngredientAmountAndUnitPopup = false;
    public $availableUnits;
    public $selectedUnit;
    public $amount;
    public $selectedIngredient;

    public function updatedSelectedIngredient() {
        if ($this->selectedIngredient !== null) {
            $this->openSelectIngredientAmountAndUnitPopup();
        }
    }

    public function mount() {
        $this->shoppingList = Auth::user()->shoppingLists;
        $this->runningOut = $this->getRunningOutIngredients();
    }

    public function render()
    {
        return view('livewire.shopping');
    }

    public function openSelectIngredientAmountAndUnitPopup() {
        $this->shoppingList = Auth::user()->shoppingLists;
        $this->availableUnits = Ingredient::find($this->selectedIngredient)->availableUnits;
        $this->showSelectIngredientAmountAndUnitPopup = true;
    }

    public function setSelectedIngredient($ingredient) {
        $this->shoppingList = Auth::user()->shoppingLists;
        $this->selectedIngredient = $ingredient;
    }

    public function removeFromShoppingList(Ingredient $ingredient) {
        Auth::user()->shoppingLists()->detach($ingredient);
        toast()
            ->success('The ' . $ingredient->name . ' was succesfully removed from your shopping list')
            ->duration(3500)
            ->push();
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

        } catch (Exception $ex) {
            toast()
                ->danger($ex->getMessage())
                ->duration(4000)
                ->push();
        }
    }

    private function addToShoppingList() {

        Auth::user()->shoppingLists()
            ->attach(Ingredient::find($this->selectedIngredient),
                ['amount' => $this->amount, 'unit' => $this->selectedUnit]);

        $this->showSelectIngredientAmountAndUnitPopup = false;

        toast()
            ->success('The ingredient has been added to your list')
            ->duration(3000)
            ->push();
    }


    public function finishShopping() {

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
}
