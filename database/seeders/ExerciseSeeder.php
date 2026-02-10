<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\Level;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        // Buscar niveles por orden
        $level1 = Level::where('order', 1)->first();
        $level2 = Level::where('order', 2)->first();
        $level3 = Level::where('order', 3)->first();

        // ===== Nivel 1 - Multiple Choice =====
        Exercise::create([
            'level_id' => $level1->id,
            'type' => 'multiple', // coincide con la vista
            'question' => '¿Cómo se crea una variable llamada edad con valor 20 en Python?',
            'options' => [
                'int edad = 20',
                'edad == 20',
                'edad = 20',
                'var edad = 20',
            ],
            'correct_answer' => 'edad = 20',
        ]);

        // ===== Nivel 2 - Fill Blank =====
        Exercise::create([
            'level_id' => $level2->id,
            'type' => 'fill', // coincide con la vista
            'question' => 'Completa el código para crear una variable llamada edad con valor 20.',
            'correct_answer' => 'edad = 20',
        ]);

        // ===== Nivel 3 - True / False =====
        Exercise::create([
            'level_id' => $level3->id,
            'type' => 'true_false', // coincide con la vista
            'question' => 'En Python es obligatorio declarar el tipo de una variable.',
            'correct_answer' => 'false',
        ]);
    }
}

