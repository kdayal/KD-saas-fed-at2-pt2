<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description'];

    /**
     * The jokes that belong to the category.
     */
    public function jokes()
    {
        return $this->belongsToMany(Joke::class,'category_joke'); // Pivot table name 'category_joke' will be inferred
    }
}
