<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\OddController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UserController;

// Autenticación
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/verify-otp', [AuthController::class,'verifyOtp']);

Route::middleware('auth:api')->group(function () {

    Route::get('/me', [AuthController::class,'me']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/refresh', [AuthController::class,'refresh']);

    // Eventos
    Route::get('/eventos', [EventController::class,'index']);
    Route::get('/eventos/{id}', [EventController::class,'show']);

    // Cuotas (odds)
    Route::get('/odds', [OddController::class,'index']);
    Route::get('/odds/{id}', [OddController::class,'show']);

    // Resultados
    Route::get('/results', [ResultController::class,'index']);
    Route::get('/results/{id}', [ResultController::class,'show']);

    // Saldo y apuestas del usuario
    Route::get('/my-balance', [UserController::class, 'getBalance']); 
    Route::get('/my-bets', [BetController::class, 'myBets']);

    // Apuestas
    Route::post('/bets', [BetController::class, 'placeBet']);
    Route::get('/bets/{id}', [BetController::class, 'show']);

    // Admin
    Route::middleware('role:admin')->group(function() {

        // Eventos
        Route::post('/eventos', [EventController::class,'store']);
        Route::put('/eventos/{id}', [EventController::class,'update']);
        Route::delete('/eventos/{id}', [EventController::class,'destroy']);

        // Cuotas (odds)
        Route::post('/odds', [OddController::class,'store']);
        Route::put('/odds/{id}', [OddController::class,'update']);
        Route::delete('/odds/{id}', [OddController::class,'destroy']);

        // Resultados
        Route::post('/results', [ResultController::class,'store']);
        Route::put('/results/{id}', [ResultController::class,'update']);
        Route::delete('/results/{id}', [ResultController::class,'destroy']);

        // Ajuste de saldo de usuarios
        Route::put('/users/{id}/balance', [UserController::class, 'adjustBalance']);
    });

});