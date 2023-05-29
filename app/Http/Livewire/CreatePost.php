<?php

namespace App\Http\Livewire;

use App\Models\Ingredient;
use App\Models\Post;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;
use Usernotnull\Toast\Concerns\WireToast;

class CreatePost extends Component
{
    use WithFileUploads;
    use WireToast;

    public $photo;

    public $newPost;
    public $newRecipe;
    public $steps = [];
    public $stepCounter = 1;
    public $ingredientCounter = 1;

    public $ingredients = [];
    public $selectedIngredient;

    protected $rules = [
        'newRecipe.title' => 'required',
        'newRecipe.servings' => 'required|min:1',
        'newRecipe.readyInMinutes' => 'required|min:1',
        'newPost.slug' => 'required'
    ];

    public function mount() {
        $this->newPost = new Post();
        $this->newRecipe = new Recipe();
    }

    public function render()
    {
        return view('livewire.create-post');
    }

    public function setUnit($ingredient, $selectedUnit) {
        $this->ingredients[$ingredient]['selectedUnit'] = $selectedUnit;
    }
    public function updatedSelectedIngredient() {
        if ($this->selectedIngredient !== null) {
            $this->addIngredient();
        }
    }

    private function uploadPhoto() {
        $this->validate([
           'photo' => 'image'
        ]);

        return $this->photo->store('recipes', 'public');
    }

    private function addIngredient() {
        $this->ingredients[$this->ingredientCounter] =
            ['id' => $this->selectedIngredient, 'name' => getIngredientNameById($this->selectedIngredient),
                'availableUnits' => Unit::findMany(getIngredientAvailableUnitsById($this->selectedIngredient)),
                'amount' => null, 'selectedUnit' => null];
        $this->ingredientCounter++;
        $this->selectedIngredient = null;
    }

    public function addStep() {
        $this->steps[$this->stepCounter] = '';
        $this->stepCounter++;
    }

    public function createPost() {

        $imgRoute = 'recipes/recipe.png';

        if ($this->photo !== null) {
            $imgRoute = $this->uploadPhoto();
        }

        $this->newRecipe->image = $imgRoute;
        $this->newRecipe->source = 'pantar.eu';
        $this->newRecipe->informationAdded = true;
        $this->newRecipe->save();
        $this->newPost->user_id = Auth::id();
        $this->newPost->recipe_id = $this->newRecipe->id;
        $this->newPost->save();

        $counter = 0; //I'll use my own counter as the user might add empty steps
        foreach ($this->steps as $step => $data) {
            if (! empty(trim($data))) {
                $newStep = new Step();
                $newStep->recipe_id = $this->newRecipe->id;
                $newStep->step = $counter;
                $newStep->data = $data;
                $newStep->save();

                $counter++;
            }
        }

        foreach ($this->ingredients as $ingredient => $data) {

            if ($data['amount'] !== null && $data['selectedUnit'] !== null) {
                $this->newRecipe->ingredients()
                    ->attach(Ingredient::find($data['id']), [
                        'amount' => $data['amount'],
                        'unit' => $data['selectedUnit'],
                        'recipeIngredientName' => $data['name']
                    ]);
            }
        }

        toast()
            ->success('Your post was added successfully!')
            ->duration(3000)
            ->push();

        $this->close();
    }

    public function close() {
        $this->emit('close');
    }
}
