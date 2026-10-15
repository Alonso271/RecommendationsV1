<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    protected $fillable = [
        'name',
        'description',
        'photo'
    ];

    public function userGenres(): HasMany
    {
        return $this->hasMany(UserGenre::class);
    }
}
