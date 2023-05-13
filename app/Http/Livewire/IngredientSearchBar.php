<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use Livewire\Component;

class IngredientSearchBar extends Component
{
    public function render()
    {
        return view('livewire.elements.ingredient-search-bar');
    }
}
