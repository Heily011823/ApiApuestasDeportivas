<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\BetController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/verify-code',[AuthController::class,'verifyCode']);

Route::middleware('auth:api')->group(function () {

    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/refresh',[AuthController::class,'refresh']);

    // apostar
    Route::post('/bets', [BetController::class, 'placeBet']);

});

Route::middleware('auth:api')->group(function () {

    // Usuario autenticado
    Route::get('me', [AuthController::class, 'me']);

    // Ver eventos
    Route::get('eventos', [EventoController::class, 'index'])
        ->middleware('role:admin,usuario');

    // Ver evento por id
    Route::get('eventos/{id}', [EventoController::class, 'show'])
        ->middleware('role:admin,usuario');

    // Crear evento
    Route::post('eventos', [EventoController::class, 'store'])
        ->middleware('role:admin');

    // Actualizar evento
    Route::put('eventos/{id}', [EventoController::class, 'update'])
        ->middleware('role:admin');

    // Eliminar evento
    Route::delete('eventos/{id}', [EventoController::class, 'destroy'])
        ->middleware('role:admin');

});


