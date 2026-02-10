<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $fillable = [
        'level_id',
        'type',
        'question',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Un ejercicio pertenece a un nivel
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
