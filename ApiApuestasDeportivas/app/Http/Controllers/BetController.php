<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Notifications\BetPlacedNotification;
use App\Models\Event;
use App\Models\Odd;
use Illuminate\Support\Facades\DB;

class BetController extends Controller
{
    public function placeBet(Request $request)
    {
        $user = auth()->user();

         if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $request->validate([
            'event_id' => 'required|exists:eventos,id',
            'tipo_apuesta' => 'required|string',
            'amount' => 'required|numeric|min:1'
        ]);

        $event = Event::findOrFail($request->event_id);
        
        $amount = $request->amount;
        
          $odd = Odd::where('event_id', $event->id)
                  ->where('bet_type', $request->tipo_apuesta)
                  ->first();


        if ($event->estado !== 'programado') {
            return response()->json([
                'message' => 'No se puede apostar en un evento finalizado.'
            ], 400);
        }

        $odd = Odd::where('event_id', $event->id)
                  ->where('bet_type', $request->tipo_apuesta)
                  ->first();

        if (!$odd) {
            return response()->json(['message' => 'Tipo de apuesta inválido.'], 400);
        }

        $potentialWin = $amount * $odd->odd_value;

        $bet = DB::transaction(function() use ($user, $request, $odd, $potentialWin, $event) {
            return Bet::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'tipo_apuesta' => $request->tipo_apuesta,
                'amount' => $request->amount,
                'odds' => $odd->odd_value,
                'potential_win' => $potentialWin,
                'status' => 'pending'
            ]);
        });

        // enviar notificación
        $user->notify(new BetPlacedNotification($amount, $potentialWin));

        return response()->json([
            "message" => "Apuesta registrada",
            "bet" => $bet
        ]);
    }

    public function myBets(){
        $user = auth()->user();
        $bets = $user->bets; // Si definiste relación 'bets' en User

        return response()->json([
            'message' => 'Listado de tus apuestas',
            'data' => $bets
        ]);
    }
}