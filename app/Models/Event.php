<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Para que Laravel use la tabla 'eventos'
    protected $table = 'eventos'; 

    protected $fillable = [
        'titulo',       // mapped to 'title' in JS
        'descripcion', 
        'fecha_inicio',  // mapped to 'start' in JS
        'fecha_fin',
        'lugar',
        'user_id'

    use HasFactory;

    protected $fillable = [
        'title',
        'start'
    ];
}





