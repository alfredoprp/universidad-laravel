<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        // Traer los eventos y mapear los nombres para FullCalendar
        $events = Event::all()->map(function($event) {
            return [
                'id'    => $event->id,      // Sin esto no se puede editar/borrar
                'title' => $event->titulo,
                'start' => $event->fecha_inicio,
                'end'   => $event->fecha_fin,
                'lugar' => $event->lugar,   // Para que aparezca en el modal de edicion
            ];
        });

        return view('calendar', compact('events'));
    }

    // Guardar (?
    public function store(Request $request)
    {
        Event::create([
            'titulo'       => $request->title,
            'fecha_inicio' => $request->start,
            'fecha_fin'    => $request->start, 
            'lugar'        => $request->lugar ?? 'Aula Magna',
            'user_id'      => auth()->id(), // Aqui se guarda quien creó el evento


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

    // Actualizar
    public function update(Request $request, $id) {
        $event = \App\Models\Event::findOrFail($id);

        // Pasa primero por validar: ¿Es el dueño/propietario?
        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'No puedes editar lo que no es tuyo'], 403);
        }

        // Solo si es el propietario, actualizamos
        $event->update([
            'titulo' => $request->title,
            'lugar' => $request->lugar
        ]);

        return response()->json(['success' => true]);
    }

    // Eliminar
    public function destroy($id) {
        $event = \App\Models\Event::findOrFail($id);

        // Pasa primero por una validacion
        if ($event->user_id !== auth()->id()) {
            return response()->json(['error' => 'No puedes borrar lo que no es tuyo'], 403);
        }

        // Solo si es el propietario, borramos
        $event->delete();

        return response()->json(['success' => true]);
    }

}



