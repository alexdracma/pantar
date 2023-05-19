<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    //relationships
    public function pantries(): BelongsToMany {
        return $this->belongsToMany(User::class, 'pantries')->withPivot('amount', 'unit');
    }

    public function availableUnits(): BelongsToMany {
        return $this->belongsToMany(Unit::class, 'available_Units')->withPivot('amount_in_grams');
    }

    //My functions
    public function getFullImgPath(): string {
        $ingredientImgBaseUri = "https://spoonacular.com/cdn/ingredients_100x100/";
        return $ingredientImgBaseUri . $this->image;
    }
}
