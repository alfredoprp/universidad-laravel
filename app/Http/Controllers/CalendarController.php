<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    // MOSTRAR CALENDARIO
    public function index()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id'    => $event->id,
                'title' => $event->titulo,
                'start' => $event->fecha_inicio,
                'end'   => $event->fecha_fin,
                'lugar' => $event->lugar,
            ];
        });

        return view('calendar', compact('events'));
    }

    // GUARDAR EVENTO
    public function store(Request $request)
    {
        Event::create([
            'titulo'       => $request->title,
            'fecha_inicio' => $request->start,
            'fecha_fin'    => $request->start,
            'lugar'        => $request->lugar ?? 'Aula Magna',
            'user_id'      => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    // ACTUALIZAR EVENTO
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $event->update([
            'titulo' => $request->title,
            'lugar'  => $request->lugar,
        ]);

        return response()->json(['success' => true]);
    }

    // ELIMINAR EVENTO
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $event->delete();

        return response()->json(['success' => true]);
    }
}





