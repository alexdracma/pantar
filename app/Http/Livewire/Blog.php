<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Recipe;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Usernotnull\Toast\Concerns\WireToast;

class Blog extends Component
{
    use WireToast;

    public $posts;
    public $query;
    public $showRecipe = false;
    public $recipeToShow;
    public $creatingPost = false;

    protected $listeners = ['close', 'closeRecipe', 'toggleLike'];

    public function mount() {
        $this->posts = $this->getPosts();
    }

    public function updatedQuery() {
        $this->getPostsByQuery($this->query);
    }

    public function render()
    {
        return view('livewire.blog');
    }

    public function showRecipe($id) {
        $this->recipeToShow = Recipe::find($id);
        $this->showRecipe = true;
    }

    public function closeRecipe($memory) {
        $this->posts = $memory;
        $this->showRecipe = false;
    }

    public function close() {
        $this->creatingPost = false;
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

    private function getPostsByQuery(string $query) {
        if (! empty(trim($query))) {
            $intraClient = new Client(['base_uri' => config('app.url')]);
            $url = "api/postsrecipes";
            $params = [
                'query' => [
                    'search' => $query
                ]
            ];

            $recipeIds = $this->getRecipesIds(json_decode($intraClient->get($url, $params)->getBody()));

            $posts = [];

            foreach ($recipeIds as $recipe) {
                $posts[] = Post::firstWhere('recipe_id', $recipe);
            }

            $this->posts = $posts;
        }
    }

    private function getPosts($memory = null) {
        if ($memory === null) {
            return Post::inRandomOrder()->take(20)->get();
        }


    }

    private function getRecipesIds($recipes) {
        $ids = [];
        foreach ($recipes as $recipe) {
            $ids[] = $recipe->id;
        }
        return $ids;
    }
}
