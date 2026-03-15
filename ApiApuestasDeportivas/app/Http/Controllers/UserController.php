<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Ajustar balance de un usuario
    public function adjustBalance(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => "Usuario no encontrado"
            ], 404);
        }

        $validated = $request->validate(
            [
                'balance' => 'required|numeric|min:0'
            ],
            [
                'balance.required' => 'El saldo es obligatorio',
                'balance.numeric' => 'El saldo debe ser un número',
                'balance.min' => 'El saldo no puede ser negativo'
            ]
        );

        // Actualizar balance
        $user->balance = $validated['balance'];
        $user->save();

        return response()->json([
            'message' => 'El saldo ha sido actualizado correctamente',
            'data' => $user
        ]);
    }

    // Consultar balance del usuario autenticado
    public function getBalance()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        return response()->json([
            'message' => 'Su saldo es:',
            'balance' => $user->balance
        ]);
    }
}