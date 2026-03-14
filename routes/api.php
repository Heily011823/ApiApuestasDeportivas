<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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