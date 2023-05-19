<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Pantry;
use Illuminate\Support\Facades\DB;

class Userpantry extends Component
{
    public $userIngredients;
    public $shownIngredients;
    public $query;

    public $showIngredientModal = false;
    public $modalIngredientData;

    protected $listeners = ['refreshIngredients'];

    //livewire lifecycle
    public function updatedQuery(): void {
        $this->updateIngredients();
    }

    public function refreshIngredients(): void {
        $this->mount();
    }

    public function mount(): void {
        $this->userIngredients = Auth::user()->pantries; //load user pantries
        $this->shownIngredients = clone $this->userIngredients;
    }

    public function render()
    {
        return view('livewire.userpantry');
    }

    //My functions
    public function updateIngredients(): void {
        $temp = [];
        foreach ($this->userIngredients as $ingredient) {
            if (str_contains(strtoupper($ingredient->name),strtoupper($this->query))) {
                array_push($temp, $ingredient);
            }
        }
        $this->shownIngredients = $temp;
    }

    public function showIngredient($ingredientId): void {
        $this->showIngredientModal = true;
        $this->setModalIngredientData($ingredientId);
    }

    private function setModalIngredientData($id): void {
        $ingredientWithPivot = Auth::user()->pantries()->firstWhere('ingredient_id', $id);
        $data = [
            'name' => $ingredientWithPivot->name,
            'imgPath' => $ingredientWithPivot->getFullImgPath(),
            'amount' => $ingredientWithPivot->pivot->amount,
            'unit' => Unit::find($ingredientWithPivot->pivot->unit)->name
        ];
        $this->modalIngredientData = $data;
    }

}
