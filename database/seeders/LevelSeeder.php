<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $python = Language::where('slug', 'python')->first();

        $levels = [
            ['Variables', 'Uso de variables en Python'],
            ['Condicionales', 'if, else, elif'],
            ['Bucles', 'for y while'],
        ];

        foreach ($levels as $i => $level) {
            Level::create([
                'language_id' => $python->id,
                'title' => $level[0],
                'description' => $level[1],
                'order' => $i + 1
            ]);
        }
            }
}
