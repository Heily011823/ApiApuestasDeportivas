<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bet;
use App\Notifications\BetPlacedNotification;

class BetController extends Controller
{
    public function placeBet(Request $request)
    {
        $user = auth()->user();

        $amount = $request->amount;
        $odds = $request->odds;

        $potentialWin = $amount * $odds;

        $bet = Bet::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'odds' => $odds,
            'potential_win' => $potentialWin,
            'status' => 'pending'
        ]);

        // enviar notificación
        $user->notify(new BetPlacedNotification($amount, $potentialWin));

        return response()->json([
            "message" => "Apuesta registrada",
            "bet" => $bet
        ]);
    }
}