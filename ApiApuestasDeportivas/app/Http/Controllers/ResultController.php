<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Bet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{

    public function index(){

        $resultados = Result::all();

        return response()->json([
            'message'=> 'Listado de todos los resultados',
            'data'=> $resultados,
        ]);
    }


    public function store(Request $request){

        $validated = $request->validate(
        [
            'event_id' => 'required|integer',
            'outcome' => 'required|string|max:100'
        ], 
        [
            'event_id.required' => 'El id del evento es obligatorio',
            'event_id.integer' => 'El id del evento debe ser un número',

            'outcome.required' => 'El resultado es obligatorio',
            'outcome.string' => 'El resultado debe ser una cadena de texto',
            'outcome.max' => 'El resultado no puede tener más de 100 caracteres'
        ]);

        DB::beginTransaction();

        try {

            $resultado = Result::create($validated);

            $apuestas = Bet::where('event_id', $validated['event_id'])->get();

            foreach($apuestas as $apuesta){

                if($apuesta->tipo_apuesta == $validated['outcome']){

                    $apuesta->status = 'ganada';

                    $apuesta->potential_win = $apuesta->amount * $apuesta->odds;


                    $usuario = User::find($apuesta->usuario_id);
                    if ($usuario) {
                        $usuario->balance += $ganancia;
                        $usuario->save();
                    }

                } else{

                    $apuesta->estado = 'perdida';
                    $apuesta->ganancia = 0;

                }

                $apuesta->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'El resultado ha sido registrado correctamente y las apuestas fueron procesadas',
                'data'=> $resultado,
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Ocurrió un error al registrar el resultado',
                'error' => $e->getMessage()
            ],500);
        }
    }


    public function show($id){

        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontro el resultado buscado con id ($id)"
            ],404);
        }

        return response()->json([
            'message' => "El resultado ha sido encontrado con id ($id)",
            'data'=> $resultado
        ]);
    }

    public function update(Request $request, string $id){

        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontro el resultado buscado con id ($id)"
            ],404);
        }

        $validated = $request->validate(
        [
            'event_id' => 'sometimes|integer',
            'outcome' => 'sometimes|string|max:100'
        ],
        [
            'event_id.integer' => 'El id del evento debe ser un número',

            'outcome.string' => 'El resultado debe ser una cadena de texto',
            'outcome.max' => 'El resultado no puede tener más de 100 caracteres'
        ]);

        $resultado->update($validated);

        return response()->json([
            'message' => "El resultado con id ($id) ha sido actualizado correctamente",
            'data'=> $resultado
        ]);
    }

    public function destroy(string $id){

        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontro el resultado buscado con id ($id)"
            ],404);
        }

        $resultado->delete();

        return response()->json([
            'message' => "El resultado con id ($id) ha sido eliminado correctamente"
        ]);
    }
}