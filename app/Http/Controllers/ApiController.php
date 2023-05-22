<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    private Client $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function getRecipes(Request $request) {
        $dbRecipes = Recipe::query()
            ->select('*')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('title', 'like', '%' . strtolower($request->search) . '%')
            )
            ->get();

        if ($request->has('search')) {
            if (count($dbRecipes) < 20) {
                $apiRecipes = ($this->getRecipesFromApiWithQuery($this->client, $request->search))->results;
                $dbApiRecipesIds = $this->getApiRecipesIds($dbRecipes);

                $this->addApiRecipesToLocalDB($apiRecipes);

                foreach ($apiRecipes as $recipe) {
                    if (! in_array($recipe->id, $dbApiRecipesIds)) {
                        $dbRecipes[] = Recipe::firstWhere('api_id', $recipe->id);
                    }
                }
            }
        }

        return json_encode($dbRecipes);
    }

    public function getRecipesByIngredients(Request $request) {
        if ($request->has('ingredients')) {
            $apiRecipes = $this->getRecipesFromApiWithIngredients($this->client, $request->ingredients);

            $this->addApiRecipesToLocalDB($apiRecipes);

            $dbRecipes = [];

            foreach ($apiRecipes as $apiRecipe) {
                $dbRecipes[] = Recipe::firstWhere('api_id', $apiRecipe->id);
            }

            return json_encode($dbRecipes);
        }
    }

    public function getIngredients(Request $request) {
        $dbIngredients = Ingredient::query()
            ->select('*')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', '%' . strtolower($request->search) . '%')
            )
            ->take(15)
            ->get()
            ->toArray();

        if ($request->has('search')) {
            if (count($dbIngredients) < 15 ) {
                $apiIngredients = ($this->getIngredientsFromApiWithQuery($this->client, $request->search))->results;
                $dbIngredientsIds = $this->getModelIds($dbIngredients);

                $this->addApiIngredientsToLocalDB($apiIngredients); //Add the new-found ingredients to the local db

                foreach ($apiIngredients as $ingredient) {
                    if (! in_array($ingredient->id, $dbIngredientsIds)) {
                        $dbIngredients[] = Ingredient::find($ingredient->id);
                    }
                }
            }
        }

        return $dbIngredients;
    }

    public function getUserIngredients(Request $request) {

        if ($request->has('search')) {
            return DB::table('pantries')
                ->join('ingredients', 'pantries.ingredient_id', '=', 'ingredients.id')
                ->where('ingredients.name', 'like', '%' . strtolower($request->search) . '%')
                ->where('pantries.user_id', Auth::id())
                ->select('ingredients.*')
                ->take(15)
                ->get();

        }
        return Auth::user()->pantries()->take(15)->get();
    }

    public function addConversionToGrams(Request $request) {
        if ($request->has('unit') && $request->has('ingredient')) {

            $reqUnit = $request->get('unit');
            $reqIng = $request->get('ingredient');
            $unit = Unit::find($reqUnit);

            if (in_array(strtolower($unit->name), ['g', 'grams', 'gram'])) { //if the unit trying to convert to is already grams, refuse
                return json_encode('unit is already a gram');
            }

            $availableUnit = Ingredient::find($reqIng)->availableUnits()->firstWhere('unit_id', $reqUnit);

            if ( $availableUnit !== null) { //If the available unit is exists

                if ($availableUnit->pivot->amount_in_grams === null) { //if the conversion is not already set

                    $ingredient = Ingredient::find($reqIng);

                    $amount = $this->getConversionFromApi($this->client, $unit->name, $ingredient->name);

                    $ingredient->availableUnits()->updateExistingPivot($unit, ['amount_in_grams' => $amount]);

                    return json_encode('success');
                }

                return json_encode('conversion already exists');
            }
            return json_encode('the parameters given do not correspond to any available unit on the table');
        }
        return json_encode('missing arguments');
    }

    private function getConversionFromApi(Client $client, $unit, $ingredient) {
        $url = 'recipes/convert';
        $params = [
            'query' => [
                'ingredientName' => $ingredient,
                'apiKey' => config('api.apiKey'),
                'sourceAmount' => '1',
                'sourceUnit' => $unit,
                'targetUnit' => "grams"
            ]
        ];

        $answer = json_decode($client->get($url, $params)->getBody(), true)['answer'];
        $answerArray = explode(' ', $answer);

        end($answerArray); //move to the last position

        return prev($answerArray); //return the amount
    }

    private function getIngredientsFromApiWithQuery(Client $client, string $query) {
        $url = "food/ingredients/search";
        $params = [
            'query' => [
                'apiKey' => config('api.apiKey'),
                'query' => $query,
                'metaInformation' => 'true',
                'number' => '30',
            ]
        ];

        return json_decode($client->get($url, $params)->getBody());
    }

    private function getRecipesFromApiWithQuery(Client $client, string $query) {
        $url = "recipes/complexSearch";
        $params = [
            'query' => [
                'apiKey' => config('api.apiKey'),
                'query' => $query,
                'number' => '30',
                'sort' => 'popularity'
            ]
        ];

        return json_decode($client->get($url, $params)->getBody());
    }

    private function getRecipesFromApiWithIngredients(Client $client, $ingredients) {

        $url = "recipes/findByIngredients";
        $params = [
            'query' => [
                'apiKey' => config('api.apiKey'),
                'ingredients' => $this->getCommaSeparatedList($ingredients),
                'number' => '30',
            ]
        ];

        return json_decode($client->get($url, $params)->getBody());
    }

    private function getModelIds($models) {
        $ids = [];

        foreach ($models as $model) {
            $ids[] = $model['id'];
        }

        return $ids;
    }

    private function getApiRecipesIds($recipes) {
        $ids = [];

        foreach ($recipes as $recipe) {
            $ids[] = $recipe['api_id'];
        }

        return $ids;
    }

    private function addApiIngredientsToLocalDB($apiIngredients): void {

        foreach ($apiIngredients as $ingredient) {
            //Only add the ingredient to the local db if it doesn't exist in it already
            if (Ingredient::where('id', $ingredient->id)->first() === null) {
                $newIngredient = new Ingredient();
                $newIngredient->id = $ingredient->id;
                $newIngredient->name = $ingredient->name;
                $newIngredient->image = $ingredient->image;
                $newIngredient->save();

                if ($ingredient->possibleUnits === null) {
                    $ingredient->possibleUnits =
                        $this->getIngredientInformationFromApi($this->client, $ingredient->id)->possibleUnits;
                }

                //Update units table in db
                $this->addUnitsToLocalDB($ingredient->possibleUnits);

                //Add possible units
                foreach ($ingredient->possibleUnits as $possibleUnit) {

                    $newIngredient->availableUnits()->attach(Unit::where('name', $possibleUnit)->first());
                }
            }
        }
    }

    private function addApiRecipesToLocalDB($apiRecipes) {

        $addedRecipesIds = null;

        foreach ($apiRecipes as $recipe) {
            //Only add the recipe to the local db if it doesn't exist in it already
            if (Recipe::firstWhere('api_id', $recipe->id) === null) {
                $newRecipe = new Recipe();
                $newRecipe->api_id = $recipe->id;
                $newRecipe->title = $recipe->title;
                $newRecipe->image = $recipe->id . '-312x231.' . $recipe->imageType;
                //mandatory data, example only
                $newRecipe->servings = 1;
                $newRecipe->readyInMinutes = 1;
                $newRecipe->source = 'pantar.eu';
                //save
                $newRecipe->save();

                //add the new recipe to the array
                $addedRecipesIds[] = $recipe->id;
            }
        }

        if ($addedRecipesIds !== null) {   //Get the recipe information for all the recipes added

            $this->addRecipeInformationToLocalDB($addedRecipesIds);
        }
    }

    private function addUnitsToLocalDB($apiUnits): void {

        foreach ($apiUnits as $unit) {

            //Only add the Unit to the local DB if it doesn't exist in it already
            if (Unit::where('name', $unit)->first() === null) {
                $newUnit = new Unit();
                $newUnit->name = $unit;
                $newUnit->save();
            }
        }
    }

    private function addRecipeInformationToLocalDB($addedRecipesIds) {
        $recipesInformation =  $this->getRecipeInformationFromApi($this->client, $addedRecipesIds);

        foreach ($recipesInformation as $recipeInformation) {
            //add the extra information to the already existing recipe
            $dbRecipe = Recipe::firstWhere('api_id', $recipeInformation->id);
            $dbRecipe->servings = $recipeInformation->servings;
            $dbRecipe->readyInMinutes = $recipeInformation->readyInMinutes;
            $dbRecipe->source = $recipeInformation->sourceUrl;
            $dbRecipe->save();

            //add the ingredients to the db
            if ($dbRecipe->extendedIngredients !== null && count($dbRecipe->extendedIngredients) > 0) {

                //add the ingredients from the recipe to the DB if they don't exist in it already
                $this->addApiIngredientsToLocalDB($dbRecipe->extendedIngredients);

                foreach ($dbRecipe->extendedIngredients as $ingredient) {

                    $unit = Unit::firstWhere('name', $ingredient->unit);

                    if ($unit === null) { //if the unit is not on the db already, add it
                        $unit = new Unit();
                        $unit->name = $ingredient->unit;
                        $unit->save();
                    }

                    $dbRecipe->ingredients()
                        ->attach(Ingredient::find($ingredient->id), ['amount' => $ingredient->amount, 'unit' => $unit]);

                    //add the conversion of the unit to grams if not available yet
                    $request = request();
                    $request->merge(['unit' => $unit->id, 'ingredient' => $ingredient->id]);
                    $this->addConversionToGrams($request);

                }
            }

            //add the steps to the db
            if ($dbRecipe->analyzedInstructions !== null && count($dbRecipe->analyzedInstructions) > 0) {
                foreach ($dbRecipe->analyzedInstructions->steps as $instruction) {
                    $step = new Step();
                    $step->recipe_id = $dbRecipe->id;
                    $step->step = $instruction->number;
                    $step->data = $instruction->step;
                    $step->save();
                }
            }

        }
    }

    private function getRecipeInformationFromApi(Client $client, $recipesIds) {
        $url = "recipes/informationBulk";
        $params = [
            'query' => [
                'apiKey' => config('api.apiKey'),
                'ids' => $this->getCommaSeparatedList($recipesIds),
            ]
        ];

        return json_decode($client->get($url, $params)->getBody());
    }

    private function getIngredientInformationFromApi(Client $client, $ingredientId) {
        $url = "food/ingredients/" . $ingredientId . "/information";
        $params = [
            'query' => [
                'apiKey' => config('api.apiKey')
            ]
        ];

        return json_decode($client->get($url, $params)->getBody());
    }

    private function getCommaSeparatedList($toSeparate) {
        if (is_string($toSeparate)) {
            return $toSeparate;
        }
        return implode(',', $toSeparate);
    }
}
