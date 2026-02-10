<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // pa q no confunda events con eventos y pueda guardar de acuerdo a la tabla
    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'fecha_inicio',
        'fecha_fin',
        'lugar',
        'user_id',
    ];
}





