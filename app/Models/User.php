<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'phone',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //relationships
    public function shoppingLists(): HasMany {
        return $this->hasMany(ShoppingList::class);
    }

    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }

    public function favorites(): BelongsToMany {
        return $this->belongsToMany(Recipe::class, 'favorites');
    }

    public function pantries(): BelongsToMany {
        return $this->belongsToMany(Ingredient::class, 'pantries')
            ->withPivot('amount', 'unit');
    }

    public function weeklyPlans(): BelongsToMany {
        return $this->belongsToMany(Recipe::class, 'weekly_plans');
    }

    public function likesFromPosts(): HasManyThrough {
        return $this->hasManyThrough(Like::class, Post::class);
    }

    public function commentsFromPosts(): HasManyThrough {
        return $this->hasManyThrough(Comment::class, Post::class);
    }
}
