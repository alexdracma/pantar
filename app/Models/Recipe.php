<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    public function ingredients() {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient');
    }

    public function steps() {
        return $this->hasMany(Step::class);
    }

    //My functions
    public function getFullImgPath(): string {
        $ingredientImgBaseUri = "https://spoonacular.com/recipeImages/";
        return $ingredientImgBaseUri . $this->image;
    }
}
