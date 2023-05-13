<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddIngredientPopup extends Component
{
    public $showAddIngredientModal = false;
    public function render()
    {
        return view('livewire.elements.add-ingredient-popup');
    }

    public function addIngredient() {

    }
}
