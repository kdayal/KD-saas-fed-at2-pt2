<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class JokeInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'joke_id',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function joke()
    {
        return $this->belongsTo(Joke::class);
    }
}
