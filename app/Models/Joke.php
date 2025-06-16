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
        'category',
       
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


