<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;

class Recipes extends Component
{
    use WireToast;

    public $shownRecipes = [];
    public $query;
    public $showRecipe = false;
    public $recipeToShow;

    protected $listeners = ['ingredientSearch', 'closeRecipe', 'toggleLike'];

    public function updatedQuery() {
        if (! empty(trim($this->query))) {
            $this->shownRecipes = $this->getRecipesByQuery($this->query);
        }
    }

    public function render()
    {
        return view('livewire.recipes');
    }

    public function closeRecipe($memories) {
        $this->showRecipe = false;
        $this->shownRecipes = $memories;
    }

    public function ingredientSearch($ingredients) {
        $this->shownRecipes = $this->getRecipesByIngredients($ingredients);
    }

    public function toggleLike($recipeId, bool $comesFromDetail = false) {
        if (userLikesRecipe($recipeId)) {
            Auth::user()->favorites()->detach($recipeId);
            toast()
                ->success('The recipe has been successfully removed from your favorites')
                ->duration(3000)
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

    private function getRecipesByIngredients($ingredients) {
        $intraClient = new Client(['base_uri' => config('app.url')]);
        $url = "api/recipesingredients";
        $params = [
            'query' => [
                'ingredients' => $ingredients,
            ]
        ];

        return json_decode($intraClient->get($url, $params)->getBody());
    }

    private function getRecipesByQuery(string $query) {
        $intraClient = new Client(['base_uri' => config('app.url')]);
        $url = "api/recipes";
        $params = [
            'query' => [
                'search' => $query,
            ]
        ];

        return json_decode($intraClient->get($url, $params)->getBody());
    }

    public function showRecipe($recipeId) {
        if (! recipeHasInformation($recipeId)) {
            $intraClient = new Client(['base_uri' => config('app.url')]);
            $url = "api/recipeinformation/" . $recipeId;
            $intraClient->post($url);
        }

        $this->recipeToShow = $recipeId;
        $this->showRecipe = true;
    }
}
