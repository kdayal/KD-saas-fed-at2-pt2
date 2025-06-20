<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth; 

class Joke extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'body', // Assuming 'content' was renamed to 'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Relationship for interactions
    public function interactions()
    {
        return $this->hasMany(JokeInteraction::class);
    }

    // Helper to get likes count
    public function likesCount()
    {
        return $this->interactions()->where('type', 'like')->count();
    }

    // Helper to get dislikes count
    public function dislikesCount()
    {
        return $this->interactions()->where('type', 'dislike')->count();
    }

    //  if the currently authenticated user has liked this joke
    public function isLikedByAuthUser()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->interactions()
                    ->where('user_id', Auth::id())
                    ->where('type', 'like')
                    ->exists();
    }

    // Check if the currently authenticated user has disliked this joke
    public function isDislikedByAuthUser()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->interactions()
                    ->where('user_id', Auth::id())
                    ->where('type', 'dislike')
                    ->exists();
    }
}
