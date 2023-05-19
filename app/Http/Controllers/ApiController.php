<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    //private $apiKey = \Config::get('ap')aaa
    private $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function getRecipes(Request $request) {
        return Recipe::query()
            ->select('*')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('title', 'like', '%' . strtolower($request->search) . '%')
            )
            ->get();
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

                $this->addApiIngredientsToLocalDB($apiIngredients); //Add the new found ingredients to the local db

                foreach ($apiIngredients as $ingredient) {
                    if (! in_array($ingredient->id, $dbIngredientsIds)) {
                        array_push($dbIngredients, Ingredient::find($ingredient->id));
                    }
                }
            }
        }

        return $dbIngredients;
    }

    public function addConversionToGrams(Request $request) {
        if ($request->has('unit') && $request->has('ingredient')) {

            $reqUnit = $request->get('unit');
            $reqIng = $request->get('ingredient');
            $unit = Unit::find($reqUnit);

            if (in_array(strtolower($unit->name), ['g', 'grams', 'gram'])) { //if the unit tryng to convert to is alrady grams, refuse
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

    public function test(Request $req) {
        $ingredient = Ingredient::find($req->get('ingredient'))->name;
        $unit = Unit::find($req->get('unit'))->name;
        return $this->getConversionFromApi($this->client, $unit, $ingredient);
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

        return prev($answerArray); //return the ammount
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

        $answer = json_decode($client->get($url, $params)->getBody());
        return $answer;
    }

    private function getModelIds($models) {
        $ids = [];

        foreach ($models as $model) {
            array_push($ids, $model['id']);
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

                //Update units table in db
                $this->addUnitsToLocalDB($ingredient->possibleUnits);

                //Add possible units
                foreach ($ingredient->possibleUnits as $possibleUnit) {

                    $newIngredient->availableUnits()->attach(Unit::where('name', $possibleUnit)->first());
                }
            }
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
}
