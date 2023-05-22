<?php

if (! function_exists('userLikesRecipe')) {
    function userLikesRecipe($recipe) {
        return \Illuminate\Support\Facades\Auth::user()->favorites()->where('recipe_id', $recipe)->exists();
    }
}
