<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use App\Models\Unit;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use Illuminate\Support\Facades\Http;

class AddIngredientPopup extends Component
{
    use WireToast;
    public $showAddIngredientModal = false;
    public $selectedIngredient;
    public $availableUnits = [];
    public $selectedUnit;
    public $amount;

    public function render()
    {
        return view('livewire.elements.add-ingredient-popup');
    }

    public function updatedSelectedIngredient() {   //on selected ingredient changed
        $this->availableUnits = [];                 //reset the available units for the ingredient
        $this->selectedUnit = null;                 //reset the selected unit

        if ($this->selectedIngredient !== null) {   //if the selected ingredient is not null get its units
            $this->availableUnits = Ingredient::find($this->selectedIngredient)->availableUnits;
        }

    }

    public function addIngredient() {

        $toValidate = [
            [$this->selectedIngredient, 'An ingredient must be selected'],
            [$this->selectedUnit, 'A unit of measurement must be selected'],
            [$this->amount, 'An amount must be provided'],
        ];
        $isValidated = true;

        foreach ($toValidate as $field) {
            if ($field[0] === null) {
                toast()
                    ->danger($field[1])
                    ->duration(4000)
                    ->push();
                $isValidated = false;
            }
        }

        //implement user already has it
        if ($isValidated) {
            $this->addConversionToGrams($this->selectedUnit, $this->selectedIngredient); //add the conversion if it isnt there already

            if (userHasIngredient($this->selectedIngredient)) {
                $existing = getUserPantry($this->selectedIngredient);
                $userAmountInGrams = getIngredientTotalAmountInGrams($existing->id, $existing->pivot->unit , $existing->pivot->amount);
                $selectedAmountInGrams = getIngredientTotalAmountInGrams($this->selectedIngredient, $this->selectedUnit, $this->amount);
                $newUserTotalAmountInGrams = $selectedAmountInGrams + $userAmountInGrams;

                $newUserAmount = getUserPreferedAmountFromGrams($existing->id, $newUserTotalAmountInGrams);

                Auth::user()->pantries()->updateExistingPivot($existing->id, ['amount' => $newUserAmount]);

            } else {
                $ingredient = Ingredient::find($this->selectedIngredient);
                Auth::user()->pantries()->attach( $ingredient, ['amount' => $this->amount, 'unit' => $this->selectedUnit]);
            }

            $this->showAddIngredientModal = false;
            $this->emit('refreshIngredients'); //tell the pantry component to refresh itself
        }
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
}
