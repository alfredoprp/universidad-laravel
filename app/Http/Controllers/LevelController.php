<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Level;
use App\Models\UserLevel;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    // ================= MAPA =================
    public function index()
    {
        $language = Language::where('slug', 'python')->firstOrFail();

        $levels = Level::where('language_id', $language->id)
            ->orderBy('order')
            ->get();

        $userLevels = UserLevel::where('user_id', Auth::id())
            ->pluck('status', 'level_id')
            ->toArray();

        foreach ($levels as $level) {
            if ($level->order === 1) {
                $userLevels[$level->id] = $userLevels[$level->id] ?? 'unlocked';
                continue;
            }

            $prev = $levels->firstWhere('order', $level->order - 1);

            if (
                $prev &&
                isset($userLevels[$prev->id]) &&
                $userLevels[$prev->id] === 'completed' &&
                !isset($userLevels[$level->id])
            ) {
                $userLevels[$level->id] = 'unlocked';
            }
        }

        return view('levels.map', compact('levels', 'userLevels'));
    }

    // ================= SHOW =================
   public function show(Level $level)
    {
        $userLevel = UserLevel::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'level_id' => $level->id,
            ],
            [
                'status' => 'unlocked',
                'step' => 0
            ]
        );

        $exercise = null;

        if ($userLevel->step == 3) {
            $exercise = $level->exercises()->first();
        }

        return view('levels.show', [
            'level' => $level,
            'step' => (int) $userLevel->step,
            'exercise' => $exercise
        ]);
    }

    // ================= NEXT STEP =================
    public function nextStep(Level $level)
    {
        $userLevel = UserLevel::where('user_id', Auth::id())
            ->where('level_id', $level->id)
            ->firstOrFail();

        if ($userLevel->step < 3) {
            $userLevel->increment('step');
        }

        return redirect()->route('levels.show', $level);
    }
    // ================= PREVIOUS STEP =================
    public function prevStep(Level $level)
    {
        $userLevel = UserLevel::where('user_id', Auth::id())
            ->where('level_id', $level->id)
            ->firstOrFail();

        if ($userLevel->step > 0) {
            $userLevel->decrement('step');
        }

        return redirect()->route('levels.show', $level);
    }


    // ================= COMPLETE =================
    public function complete(Level $level)
    {
        request()->validate([
            'answer' => 'required'
        ]);

        $userLevel = UserLevel::where('user_id', Auth::id())
            ->where('level_id', $level->id)
            ->firstOrFail();

        $exercise = $level->exercises()->first();

        if (request('answer') !== $exercise->correct_answer) {
            return back()->with('error', 'Respuesta incorrecta');
        }

        $userLevel->update([
            'status' => 'completed',
            'step' => 3,
        ]);

        return redirect()->route('python.map')
            ->with('success', 'Nivel completado 🎉');
    }

    // ================= CONTINUE =================
    public function continue()
    {
        $userLevel = UserLevel::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->first();

        if (!$userLevel) {
            return redirect()->route('python.map');
        }

        $level = Level::findOrFail($userLevel->level_id);

        return redirect()->route('levels.show', $level);
    }

}


