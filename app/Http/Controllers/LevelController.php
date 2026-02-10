<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Level;
use App\Models\UserLevel;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index()
{
    $language = Language::where('slug', 'python')->firstOrFail();

    $levels = Level::where('language_id', $language->id)
        ->orderBy('order')
        ->get();

    $userLevels = UserLevel::where('user_id', Auth::id())
        ->pluck('status', 'level_id');

    // Forzar nivel 1 desbloqueado
    foreach ($levels as $level) {
        if ($level->order == 1) {
            $userLevels[$level->id] = 'unlocked';
        }
    }

    return view('levels.map', compact('levels', 'userLevels'));
}

}

