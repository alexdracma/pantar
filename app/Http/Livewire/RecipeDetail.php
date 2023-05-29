<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use Exception;

class RecipeDetail extends Component
{

    use WireToast;

    public Recipe $shownRecipe;
    public Unit $shownUnit;
    public $memory;
    public $userLikes;
    public $isPost = false;
    public $post;
    public $commenting = false;
    public $comment;

    protected $listeners = ['updateLikes', 'close'];

    public function mount(Recipe $recipe, $memory) {
        $this->shownRecipe = $recipe;
        $this->memory = $memory;
        $this->userLikes = userLikesRecipe($recipe->id);

        if ($recipe->api_id === null) {
            $this->isPost = true;
            $this->post = Post::firstWhere('recipe_id', $recipe->id);
        }
    }

    public function addPostComment() {

        try {

            if (empty(trim($this->comment))) {
                throw new Exception('The comment must not be empty!');
            }

            $this->post->comments()->attach(Auth::user(), ['content' => $this->comment]);
            $this->commenting = false;
            $this->post = $this->post->fresh();

            toast()
                ->success('Thank you for your feedback')
                ->duration(3000)
                ->push();

        } catch (Exception $ex) {
            toast()
                ->danger($ex->getMessage())
                ->duration(4000)
                ->push();
        }
    }

    public function togglePostLike() {
        if (userLikesPost($this->post->id)) {
            $this->post->likes()->detach();
            toast()
                ->success('Your like was successfully removed')
                ->duration(4000)
                ->push();
        } else {
            $this->post->likes()->attach(Auth::user());
            toast()
                ->success('Thanks for your feedback!')
                ->duration(4000)
                ->push();
        }
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
}
