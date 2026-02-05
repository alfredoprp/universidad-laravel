<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

Route::get('/calendar', [CalendarController::class, 'index']);
Route::post('/calendar', [CalendarController::class, 'store']);

