<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function comments() {
        return $this->belongsToMany(User::class, 'comments')->withPivot('content');
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
