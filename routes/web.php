<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\LevelController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (login requerido)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Calendario
    Route::get('/calendar', [CalendarController::class, 'index']);
    Route::post('/calendar', [CalendarController::class, 'store']);
    Route::put('/calendar/{id}', [CalendarController::class, 'update']);
    Route::delete('/calendar/{id}', [CalendarController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Sistema de niveles (Python)
    |--------------------------------------------------------------------------
    */

    // Mapa de niveles
    Route::get('/python', [LevelController::class, 'index'])
        ->name('python.map');

    // Ver un nivel específico
    Route::get('/python/level/{level}', [LevelController::class, 'show'])
        ->name('levels.show');

    // Progreso
     Route::post('/levels/{level}/next', [LevelController::class, 'nextStep'])
        ->name('levels.next');

    // ✅ COMPLETAR NIVEL
    Route::post('/python/level/{level}/complete', [LevelController::class, 'complete'])
        ->name('levels.complete');

    // Continuar Nivel
    Route::get('/continuar-aprendizaje', [LevelController::class, 'continue'])
        ->name('learning.continue');
    
    // Retroceder paso
    Route::post('/levels/{level}/prev', [LevelController::class, 'prevStep'])
        ->name('levels.prev');
});
/*
|--------------------------------------------------------------------------
| Auth routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';



