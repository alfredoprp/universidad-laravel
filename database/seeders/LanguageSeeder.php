<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;
use App\Models\Level;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $python = Language::create([
            'name' => 'Python',
            'slug' => 'python',
        ]);

        Level::create([
            'language_id' => $python->id,
            'title' => 'Variables en Python',
            'description' => 'Aprende a declarar y usar variables.',
            'order' => 1,
        ]);

        Level::create([
            'language_id' => $python->id,
            'title' => 'Condicionales',
            'description' => 'Uso de if, else y elif.',
            'order' => 2,
        ]);
    }
}

