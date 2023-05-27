<?php

if (! function_exists('userLikesRecipe')) {
    function userLikesRecipe($recipe) {
        return \Illuminate\Support\Facades\Auth::user()->favorites()->where('recipe_id', $recipe)->exists();
    }
}

if (! function_exists('ingredientIsInUserShoppingList')) {
    function ingredientIsInUserShoppingList($ingredient) {
        return \Illuminate\Support\Facades\Auth::user()->shoppingLists()->where('ingredient_id', $ingredient)->exists();
    }
}

if (! function_exists('recipeHasInformation')) {
    function recipeHasInformation($recipe) {
        return \App\Models\Recipe::find($recipe)->informationAdded;
    }
}

if (! function_exists('userHasIngredient')) {
    function userHasIngredient($ingredient) {
        return \Illuminate\Support\Facades\Auth::user()->pantries()->where('ingredient_id', $ingredient)->exists();
    }
}

if (! function_exists('getUserPantry')) {
    function getUserPantry($ingredient) {
        return \Illuminate\Support\Facades\Auth::user()->pantries()->firstWhere('ingredient_id', $ingredient);
    }
}

if (! function_exists('getIngredientTotalAmountInGrams')) {
    function getIngredientTotalAmountInGrams($ingredient, $unit, $amount) {
        return $amount * getIngredientAmountInGrams($ingredient, $unit);
    }
}

if (! function_exists('getIngredientAmountInGrams')) {
    function getIngredientAmountInGrams($ingredient, $unit) {

        $amountInGrams = \App\Models\Ingredient::find($ingredient)
            ->availableUnits()->firstWhere('unit_id', $unit);

        if ($amountInGrams === null) { //If unit is not available for some reason, make it now
            \App\Models\Ingredient::find($ingredient)->availableUnits()->attach($unit);

            $amountInGrams = \App\Models\Ingredient::find($ingredient)
                ->availableUnits()->firstWhere('unit_id', $unit);
        }

        if ($amountInGrams->pivot->amount_in_grams === null) {

            $intraClient = new \GuzzleHttp\Client(['base_uri' => config('app.url')]);
            $params = [
                'form_params' => [
                    'unit' => $unit,
                    'ingredient' => $ingredient
                ],
            ];
            $intraClient->post('api/conversion', $params);

            $amountInGrams = \App\Models\Ingredient::find($ingredient)
                ->availableUnits()->firstWhere('unit_id', $unit);
        }

        return $amountInGrams->pivot->amount_in_grams;
    }
}

if (! function_exists('getUnitNameById')) {
    function getUnitNameById($unit) {
        return \App\Models\Unit::find($unit)->name;
    }
}

if (! function_exists('getIngredientNameById')) {
    function getIngredientNameById($ingredient) {
        return \App\Models\Ingredient::find($ingredient)->name;
    }
}

if (! function_exists('getIngredientAvailableUnitsById')) {
    function getIngredientAvailableUnitsById($ingredient) {
        return \App\Models\Ingredient::find($ingredient)->availableUnits;
    }
}
