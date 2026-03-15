<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     */
    protected $dontReport = [
        //
    ];

    /**
     * Inputs que nunca se muestran en errores de validación.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registrar manejo de excepciones
     */
    public function register(): void
    {

        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json([
                'message' => 'Tu token ha expirado'
            ], 401);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}