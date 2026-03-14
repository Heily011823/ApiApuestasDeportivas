<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;

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

