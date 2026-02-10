<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exercise;

class Level extends Model
{
    protected $fillable = [
        'language_id',
        'title',
        'description',
        'order'
    ];

    // Un nivel tiene muchos ejercicios
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function getRouteKeyName()
    {
        return 'order';
    }
}
