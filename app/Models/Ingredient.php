<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    use HasFactory;

    //relationships
    public function pantries(): HasMany {
        return $this->hasMany(Pantry::class);
    }

    public function availableUnits(): BelongsToMany {
        return $this->belongsToMany(Unit::class, 'availableUnits');
    }
}
