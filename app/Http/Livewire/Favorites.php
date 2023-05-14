<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Favorites extends Component
{
    use WireToast;
    public $userFavorites;
    public $shownFavorites;
    public $query = '';

    //livewire lifecycle
    public function updatedQuery() {
        $this->updateFavorites();
    }

    public function mount() {
        $this->fillArrays();
    }

    public function render()
    {
        return view('livewire.favorites');
    }

    //My functions
    private function updateFavorites() {
        $temp = [];
        foreach ($this->userFavorites as $recipe) {
            if (str_contains(strtoupper($recipe->title),strtoupper($this->query))) {
                array_push($temp, $recipe);
            }
        }
        $this->shownFavorites = $temp;
    }

    private function fillArrays() {
        $this->userFavorites = Auth::user()->favorites;
        $this->shownFavorites = clone $this->userFavorites;
    }

    public function removeFavorite($recipeId) { //removes the favorite from the user's list if it exists

        if (Auth::user()->favorites()->where('recipe_id', $recipeId)->exists()) {

            Auth::user()->favorites()->detach($recipeId);
            $this->fillArrays();
            toast()
                ->success('The recipe has been successfully removed from your favorites')
                ->push();
        }

    }
}
