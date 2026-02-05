<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    // MOSTRAR CALENDARIO
    public function index()
    {
        $events = Event::all();
        return view('calendar', compact('events'));
    }

    // GUARDAR EVENTO
    public function store(Request $request)
    {
        Event::create([
            'title' => $request->title,
            'start' => $request->start
        ]);

        return response()->json(['success' => true]);
    }
}



