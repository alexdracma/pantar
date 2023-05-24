<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use App\Models\Unit;
use Livewire\Component;

class RecipeDetail extends Component
{

    public Recipe $shownRecipe;
    public Unit $shownUnit;
    public $memory;
    public $userLikes;

    protected $listeners = ['updateLikes', 'close'];

    public function mount(Recipe $recipe, $memory) {
        $this->shownRecipe = $recipe;
        $this->memory = $memory;
        $this->userLikes = userLikesRecipe($recipe->id);
    }

    public function updateLikes() {
        $this->userLikes = userLikesRecipe($this->shownRecipe->id);
    }
    public function render()
    {
        return view('livewire.recipe-detail');
    }

    public function close() {
        $this->emit('closeRecipe', $this->memory);
    }

    public function toggleLike() {
        $this->emit('toggleLike', $this->shownRecipe->id, true);
    }

    public function getUnitName($unit) {
        return Unit::find($unit)->name;
    }
}
