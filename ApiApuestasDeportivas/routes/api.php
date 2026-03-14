<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
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

    // Eventos

    // Usuario logueado
    Route::get('me', [AuthController::class, 'me']);

    // Listar eventos
    Route::get('eventos', [EventController::class, 'index'])
        ->middleware('role:admin,usuario');

    // Ver evento por id
    Route::get('eventos/{id}', [EventController::class, 'show'])
        ->middleware('role:admin,usuario');

    // Crear evento
    Route::post('eventos', [EventController::class, 'store'])
        ->middleware('role:admin');

    // Actualizar evento
    Route::put('eventos/{id}', [EventController::class, 'update'])
        ->middleware('role:admin');

    // Eliminar evento
    Route::delete('eventos/{id}', [EventController::class, 'destroy'])
        ->middleware('role:admin');
        
});


