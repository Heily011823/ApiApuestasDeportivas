<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BetController;
use App\Http\Controllers\OddController;
use App\Http\Controllers\ResultController;


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

    Route::middleware(['auth:api','role:admin'])->group(function(){

        // Eventos
        Route::post('/eventos', [EventController::class,'store']);
        Route::put('/eventos/{id}', [EventController::class,'update']);
        Route::delete('/eventos/{id}', [EventController::class,'destroy']);
        Route::get('/eventos', [EventController::class,'index']);
        Route::get('/eventos/{id}', [EventController::class,'show']);

        // Cuotas
        Route::post('/odds',[OddController::class,'store']);
        Route::get('/odds',[OddController::class,'index']);
        Route::get('/odds/{id}',[OddController::class,'show']);
        Route::put('/odds/{id}',[OddController::class,'update']);
        Route::delete('/odds/{id}',[OddController::class,'destroy']);

        // Resultados
        Route::get('/results', [ResultController::class, 'index']);
        Route::post('/results', [ResultController::class, 'store']);
        Route::get('/results/{id}', [ResultController::class, 'show']);
        Route::put('/results/{id}', [ResultController::class, 'update']);
        Route::delete('/results/{id}', [ResultController::class, 'destroy']);

    });

    Route::middleware(['auth:api'])->group(function(){

        // Eventos
        Route::get('/eventos', [EventController::class,'index']);
        Route::get('/eventos/{id}', [EventController::class,'show']);

        // Cuotas
        Route::get('/odds',[OddController::class,'index']);
        Route::get('/odds/{id}',[OddController::class,'show']);


        // Resultados
        Route::get('/results', [ResultController::class, 'index']);
        Route::get('/results/{id}', [ResultController::class, 'show']);

    });
        
});


