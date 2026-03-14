<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:api','role:admin'])->group(function(){

    Route::post('/odds',[OddBaseController::class,'store']);
    Route::get('/odds',[OddBaseController::class,'index']);
    Route::get('/odds/{id}',[OddBaseController::class,'show']);
    Route::put('/odds/{id}',[OddBaseController::class,'update']);
    Route::delete('/odds/{id}',[OddBaseController::class,'destroy']);

});

Route::middleware('auth:api')->group(function(){

    Route::get('/odds',[OddBaseController::class,'index']);
    Route::get('/odds/{id}',[OddBaseController::class,'show']);

});

