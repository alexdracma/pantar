<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class SearchFromPantry extends Component
{
    use WireToast;

    public $showSelectIngredientModal = false;
    public $selectedIngredients = [];

    public function render()
    {
        return view('livewire.elements.search-from-pantry');
    }

    public function search() {
        if (count($this->selectedIngredients) > 0) {
            $this->showSelectIngredientModal = false;
            $this->emit('ingredientSearch', $this->selectedIngredients);
        } else {
            toast()
                ->danger('You must select at least one ingredient for the search')
                ->duration(4000)
                ->push();
        }
    }
}
