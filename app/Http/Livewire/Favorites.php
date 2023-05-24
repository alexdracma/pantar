<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Favorites extends Component
{
    use WireToast;
    public $userFavorites;
    public $shownFavorites;
    public $query = '';
    public $showRecipe = false;
    public $recipeToShow;

    protected $listeners = ['closeRecipe', 'toggleLike' => 'toggleFavorite'];

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

    public function closeRecipe($memories) {
        $this->showRecipe = false;
        $this->shownFavorites = $memories;
    }

    private function fillArrays() {
        $this->userFavorites = Auth::user()->favorites;
        $this->shownFavorites = clone $this->userFavorites;
    }

    public function showRecipe($recipeId) {
        //dd($this->shownFavorites);
        if (! recipeHasInformation($recipeId)) {
            $intraClient = new Client(['base_uri' => config('app.url')]);
            $url = "api/recipeinformation/" . $recipeId;
            $intraClient->post($url);
        }

        $this->recipeToShow = $recipeId;
        $this->showRecipe = true;
    }

    public function toggleFavorite($recipeId, bool $comesFromDetail = false) { //removes the favorite from the user's list if it exists

        if (Auth::user()->favorites()->where('recipe_id', $recipeId)->exists()) {

            Auth::user()->favorites()->detach($recipeId);

            if (! $comesFromDetail) {
                $this->fillArrays();
            }

            toast()
                ->success('The recipe has been successfully removed from your favorites')
                ->push();
        } else {
            Auth::user()->favorites()->attach($recipeId);
            toast()
                ->success('The recipe has been successfully added to your favorites')
                ->duration(3000)
                ->push();
        }

        if ($comesFromDetail) {
            $this->emit('updateLikes');
        }
    }
}
