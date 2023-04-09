<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //relationships
    public function shoppingLists() {
        return $this->hasMany(ShoppingList::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function favorites() {
        return $this->belongsToMany(Recipe::class, 'favorites');
    }

    public function pantries() {
        return $this->belongsToMany(Ingredient::class, 'pantries');
    }

    public function weeklyPlans() {
        return $this->belongsToMany(Ingredient::class, 'weeklyPlans');
    }
}
