<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){

        $eventos = Event::all();

        return response()->json([
            'message'=> 'Listado de todos los eventos',
            'data'=> $eventos
        ]);
    }

    public function store(Request $request){

        $validated = $request->validate(
        [
            'deporte' => 'required|string|max:100',
            'equipo_local' => 'required|string|max:100',
            'equipo_visitante' => 'required|string|max:100',
            'fecha' => 'required|string',
            'estado' => 'nullable|string|max:80'
        ], 
        [
            'deporte.required' => 'El deporte es obligatorio',
            'deporte.string' => 'El deporte debe ser una cadena de texto',
            'deporte.max' => 'El deporte no puede tener más de 100 caracteres',

            'equipo_local.required' => 'El equipo local es obligatorio',
            'equipo_local.string' => 'El equipo local debe ser una cadena de texto',
            'equipo_local.max' => 'El equipo local no puede tener más de 100 caracteres',

            'equipo_visitante.required' => 'El equipo visitante es obligatorio',
            'equipo_visitante.string' => 'El equipo visitante debe ser una cadena de texto',
            'equipo_visitante.max' => 'El equipo visitante no puede tener más de 100 caracteres',

            'fecha.required' => 'La fecha es obligatoria',
            'fecha.string' => 'La fecha debe ser una cadena de texto',

            'estado.string' => 'El estado debe ser una cadena de texto',
            'estado.max' => 'El estado no puede tener más de 80 caracteres'
        ]);

        $evento = Event::create($validated);

        return response()->json([
            'message' => 'El evento ha sido creado correctamente',
            'data'=> $evento,
        ], 201);
    }

    public function show($id){

    
        $evento = Event::find($id);

        if(!$evento){
            return response()->json([
                'message' => "No se encontro el evento buscado con id ($id)"
            ], 404);
        }

        return response()->json([
            'message' => "El evento ha sido encontrado con id ($id)",
            'data'=> $evento
        ]);
    }

    public function update(Request $request, string $id){

        $evento = Event::find($id);

        if(!$evento){
            return response()->json([
                'message' => "No se encontro el evento buscado con id ($id)"
            ], 404);
        }

        $validated = $request->validate([
            'deporte' => 'sometimes|string|max:100',
            'equipo_local' => 'sometimes|string|max:100',
            'equipo_visitante' => 'sometimes|string|max:100',
            'fecha' => 'sometimes|string',
            'estado' => 'sometimes|string|max:80'
        ], [
            'deporte.string' => 'El deporte debe ser una cadena de texto',
            'deporte.max' => 'El deporte no puede tener más de 100 caracteres',

            'equipo_local.string' => 'El equipo local debe ser una cadena de texto',
            'equipo_local.max' => 'El equipo local no puede tener más de 100 caracteres',

            'equipo_visitante.string' => 'El equipo visitante debe ser una cadena de texto',
            'equipo_visitante.max' => 'El equipo visitante no puede tener más de 100 caracteres',

            'fecha.string' => 'La fecha debe ser una cadena de texto',

            'estado.string' => 'El estado debe ser una cadena de texto',
            'estado.max' => 'El estado no puede tener más de 80 caracteres'
        ]);

        $evento->update($validated);

        return response()->json([
            'message' => "El evento con id ($id) ha sido actualizado correctamente",
            'data'=> $evento
        ]);

    }

    public function destroy(string $id){

        $evento = Event::find($id);

        if(!$evento){
            return response()->json([
                'message' => "No se encontro el evento buscado con id ($id)"
            ], 404);
        }

        $evento->delete();

        return response()->json([
            'message' => "El evento con id ($id) ha sido eliminado correctamente"
        ]);
    }
}