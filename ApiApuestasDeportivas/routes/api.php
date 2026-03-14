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

    Route::middleware(['auth:api','role:admin'])->group(function(){
        Route::post('/eventos', [EventController::class,'store']);
        Route::put('/eventos/{id}', [EventController::class,'update']);
        Route::delete('/eventos/{id}', [EventController::class,'destroy']);
        Route::get('/eventos', [EventController::class,'index']);
        Route::get('/eventos/{id}', [EventController::class,'show']);
    });

    Route::middleware(['auth:api'])->group(function(){
        Route::get('/eventos', [EventController::class,'index']);
        Route::get('/eventos/{id}', [EventController::class,'show']);
    });
        
});


