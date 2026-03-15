<?php

// app/Http/Controllers/ResultController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Bet;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function simularResultado(Request $request, $event_id)
    {
        $request->validate([
            'outcome' => 'required|string|in:home,away,draw'
        ]);

        $evento = Event::findOrFail($event_id);

        DB::transaction(function() use ($evento, $request) {
            $resultado = Result::create([
                'event_id' => $evento->id,
                'outcome' => $request->outcome,
            ]);

            $apuestas = Bet::where('event_id', $evento->id)
                           ->where('status', 'pending')
                           ->get();

            foreach ($apuestas as $apuesta) {
                $usuario = User::find($apuesta->user_id);

                if ($apuesta->bet_type === $request->outcome) {
                    $ganancia = $apuesta->amount * $apuesta->odds;
                    $apuesta->status = 'won';
                    $apuesta->winnings = $ganancia;

                    $usuario->balance += $ganancia;
                } else {
                    $apuesta->status = 'lost';
                    $apuesta->winnings = 0;
                }

                $apuesta->save();
                $usuario->save();
            }

            $evento->status = 'finished';
            $evento->save();
        });

        return response()->json([
            'message' => 'Resultado guardado y apuestas procesadas correctamente'
        ]);
    }
}