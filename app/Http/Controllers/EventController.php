<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $eventos = Event::all();

        return response()->json([
            'message' => 'Listado de todos los eventos',
            'data' => $eventos
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'deporte' => 'required|string|max:100',
            'equipo_local' => 'required|string|max:100',
            'equipo_visitante' => 'required|string|max:100',
            'fecha' => 'required|date_format:Y-m-d H:i:s',
            'estado' => 'nullable|string|max:80'
        ]);

        $evento = Event::create($validated);

        return response()->json([
            'message' => 'Evento creado correctamente',
            'data' => $evento
        ], 201);
    }


    public function show($id)
    {
        $evento = Event::find($id);

        if (!$evento) {
            return response()->json([
                'message' => "No se encontró el evento con id ($id)"
            ], 404);
        }

        return response()->json([
            'message' => 'Evento encontrado',
            'data' => $evento
        ]);
    }


    public function update(Request $request, $id)
    {
        $evento = Event::find($id);

        if (!$evento) {
            return response()->json([
                'message' => "No se encontró el evento con id ($id)"
            ], 404);
        }

        $validated = $request->validate([
            'deporte' => 'sometimes|string|max:100',
            'equipo_local' => 'sometimes|string|max:100',
            'equipo_visitante' => 'sometimes|string|max:100',
            'fecha' => 'sometimes|date_format:Y-m-d H:i:s',
            'estado' => 'sometimes|string|max:80'
        ]);

        $evento->update($validated);

        return response()->json([
            'message' => 'Evento actualizado correctamente',
            'data' => $evento
        ]);
    }


    public function destroy($id)
    {
        $evento = Event::find($id);

        if (!$evento) {
            return response()->json([
                'message' => "No se encontró el evento con id ($id)"
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'message' => 'Evento eliminado correctamente'
        ]);
    }


    public function odds($id)
    {
        $event = Event::with('odds')->find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Evento no encontrado'
            ], 404);
        }

        return response()->json([
            'event' => $event->equipo_local . " vs " . $event->equipo_visitante,
            'odds' => $event->odds
        ]);
    }

}