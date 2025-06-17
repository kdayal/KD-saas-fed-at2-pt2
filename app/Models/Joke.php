<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import

class Joke extends Model
{
    use HasFactory, SoftDeletes; // Add SoftDeletes

    protected $fillable = [
        'user_id',
        'title',
        'content',
        
       
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     /**
     * The categories that belong to the joke.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class); // Pivot table name 'category_joke' will be inferred
    }
}


