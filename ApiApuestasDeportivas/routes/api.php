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

