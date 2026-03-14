<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odd;
use Illuminate\Support\Facades\Auth;

class OddController extends Controller
{

    public function index(){

        $odds = Odd::all();

        return response()->json([
            'message'=> 'Listado de todas las cuotas',
            'data'=> $odds
        ]);
    }


    public function store(Request $request){

        $validated = $request->validate(
        [
            'event_id' => 'required|exists:eventos,id',
            'bet_type' => 'required|string|max:80',
            'odd_value' => 'required|numeric|min:1'
        ],
        [
            'event_id.required' => 'El evento es obligatorio',
            'event_id.exists' => 'El evento no existe',

            'bet_type.required' => 'El tipo de apuesta es obligatorio',
            'bet_type.string' => 'El tipo de apuesta debe ser una cadena de texto',
            'bet_type.max' => 'El tipo de apuesta no puede superar 80 caracteres',

            'odd_value.required' => 'La cuota es obligatoria',
            'odd_value.numeric' => 'La cuota debe ser un número',
            'odd_value.min' => 'La cuota debe ser mayor a 1'
        ]);

        $odd = Odd::create($validated);

        return response()->json([
            'message' => 'La cuota fue creada correctamente',
            'data'=> $odd,
        ], 201);
    }


    public function show(string $id){

        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ], 404);
        }

        return response()->json([
            'message' => "La cuota fue encontrada con id ($id)",
            'data'=> $odd
        ]);
    }


    public function update(Request $request, string $id){

        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ], 404);
        }

        $validated = $request->validate(
        [
            'event_id' => 'sometimes|exists:eventos,id',
            'bet_type' => 'sometimes|string|max:80',
            'odd_value' => 'sometimes|numeric|min:1'
        ],
        [
            'event_id.exists' => 'El evento no existe',

            'bet_type.string' => 'El tipo de apuesta debe ser una cadena de texto',
            'bet_type.max' => 'El tipo de apuesta no puede superar 80 caracteres',

            'odd_value.numeric' => 'La cuota debe ser un número',
            'odd_value.min' => 'La cuota debe ser mayor que 1'
        ]);

        $odd->update($validated);

        return response()->json([
            'message' => "La cuota con id ($id) fue actualizada correctamente",
            'data'=> $odd
        ]);
    }


    public function destroy(string $id){

        $odd = Odd::find($id);

        if(!$odd){
            return response()->json([
                'message' => "No se encontró la cuota con id ($id)"
            ], 404);
        }

        $odd->delete();

        return response()->json([
            'message' => "La cuota con id ($id) fue eliminada correctamente"
        ]);
    }

}
