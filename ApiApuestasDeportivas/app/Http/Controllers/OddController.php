<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odd;

class OddController extends Controller
{

    public function index()
    {
        $odds = Odd::all();

        return response()->json([
            'message'=> 'Listado de todas las cuotas',
            'data'=> $odds
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:eventos,id',
            'bet_type' => 'required|string|max:80',
            'odd_value' => 'required|numeric|min:1'
        ],[
            'event_id.required' => 'El evento es obligatorio',
            'event_id.exists' => 'El evento no existe',

            'bet_type.required' => 'El tipo de apuesta es obligatorio',
            'bet_type.string' => 'El tipo de apuesta debe ser texto',
            'bet_type.max' => 'El tipo de apuesta no puede superar 80 caracteres',

            'odd_value.required' => 'La cuota es obligatoria',
            'odd_value.numeric' => 'La cuota debe ser un número',
            'odd_value.min' => 'La cuota debe ser mayor o igual a 1'
        ]);

        $odd = Odd::create($validated);

        return response()->json([
            'message' => 'La cuota fue creada correctamente',
            'data'=> $odd
        ],201);
    }


    public function show($id)
    {
        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ],404);
        }

        return response()->json([
            'message' => "Cuota encontrada",
            'data'=> $odd
        ]);
    }


    public function update(Request $request, $id)
    {
        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ],404);
        }

        $validated = $request->validate([
            'event_id' => 'sometimes|exists:eventos,id',
            'bet_type' => 'sometimes|string|max:80',
            'odd_value' => 'sometimes|numeric|min:1'
        ]);

        $odd->update($validated);

        return response()->json([
            'message' => "La cuota fue actualizada correctamente",
            'data'=> $odd
        ]);
    }


    public function destroy($id)
    {
        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ],404);
        }

        $odd->delete();

        return response()->json([
            'message' => "La cuota fue eliminada correctamente"
        ]);
    }

}