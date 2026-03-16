<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Models\Event;
use App\Models\Odd;
use Illuminate\Support\Facades\DB;
use App\Notifications\BetPlacedNotification;

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

        if ($event->estado !== 'programado') {
            return response()->json([
                'message' => 'No se puede apostar en un evento finalizado'
            ], 400);
        }

        $odd = Odd::where('event_id', $event->id)
                    ->where('bet_type', $request->tipo_apuesta)
                    ->first();

        if (!$odd) {
            return response()->json([
                'message' => 'Tipo de apuesta inválido'
            ], 400);
        }

        $amount = $request->amount;

       
        if ($user->balance < $amount) {
            return response()->json([
                'message' => 'Saldo insuficiente'
            ], 400);
        }

        $potentialWin = $amount * $odd->odd_value;

        $bet = DB::transaction(function () use ($user, $event, $request, $odd, $amount, $potentialWin) {

            // descontar balance
            $user->balance = $user->balance - $amount;
            $user->save();

            // crear apuesta
            return Bet::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'tipo_apuesta' => $request->tipo_apuesta,
                'amount' => $amount,
                'odds' => $odd->odd_value,
                'potential_win' => $potentialWin,
                'status' => 'pending'
            ]);

        });

        // notificación
        $user->notify(new BetPlacedNotification($amount, $potentialWin));

        return response()->json([
            'message' => 'Apuesta registrada correctamente',
            'bet' => $bet
        ]);
    }

    public function myBets()
    {
        $user = auth()->user();

        $bets = Bet::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Listado de tus apuestas',
            'data' => $bets
        ]);
    }
}