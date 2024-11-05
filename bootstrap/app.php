<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Exception $e, Request $request) {// Handling all exceptions
            return response()->json([
                'message' => $e->getMessage(),
                'error'   => $e->getCode(),
            ], 400);
        });
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Domain/Listeners',
    ])->create();
