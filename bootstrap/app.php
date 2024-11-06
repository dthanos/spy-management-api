<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $exceptions->renderable(function (BadRequestHttpException $e, Request $request) {// Handling bad request exceptions
            return response()->json([
                'message' => $e->getMessage(),
                'error'   => 400,
            ], 400);
        });
        $exceptions->renderable(function (Exception $e, Request $request) {// Handling all exceptions
            return response()->json([
                'message' => $e->getMessage(),
                'error'   => $e->getCode(),
            ], 500);
        });
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Domain/Listeners',
    ])->create();
