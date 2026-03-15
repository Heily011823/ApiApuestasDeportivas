<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Bet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{

    public function index()
    {
        $resultados = Result::all();

        return response()->json([
            'message'=> 'Listado de todos los resultados',
            'data'=> $resultados
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:eventos,id',
            'outcome' => 'required|string|max:100'
        ]);

        DB::beginTransaction();

        try {

            $resultado = Result::create($validated);

            $apuestas = Bet::where('event_id', $validated['event_id'])->get();

            foreach($apuestas as $apuesta){

                if($apuesta->tipo_apuesta == $validated['outcome']){

                    $apuesta->status = 'ganada';

                    $ganancia = $apuesta->amount * $apuesta->odds;

                    $apuesta->potential_win = $ganancia;

                    $usuario = User::find($apuesta->user_id);

                    if($usuario){
                        $usuario->saldo += $ganancia;
                        $usuario->save();
                    }

                } else{

                    $apuesta->status = 'perdida';
                    $apuesta->potential_win = 0;

                }

                $apuesta->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Resultado registrado y apuestas procesadas',
                'data'=> $resultado
            ],201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Error al registrar el resultado',
                'error' => $e->getMessage()
            ],500);
        }
    }


    public function show($id)
    {
        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontró el resultado con id ($id)"
            ],404);
        }

        return response()->json([
            'message' => 'Resultado encontrado',
            'data'=> $resultado
        ]);
    }


    public function update(Request $request, $id)
    {
        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontró el resultado con id ($id)"
            ],404);
        }

        $validated = $request->validate([
            'event_id' => 'sometimes|exists:eventos,id',
            'outcome' => 'sometimes|string|max:100'
        ]);

        $resultado->update($validated);

        return response()->json([
            'message' => 'Resultado actualizado correctamente',
            'data'=> $resultado
        ]);
    }


    public function destroy($id)
    {
        $resultado = Result::find($id);

        if(!$resultado){
            return response()->json([
                'message' => "No se encontró el resultado con id ($id)"
            ],404);
        }

        $resultado->delete();

        return response()->json([
            'message' => 'Resultado eliminado correctamente'
        ]);
    }

}