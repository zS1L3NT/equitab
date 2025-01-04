<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return response([
                'error' => [
                    'type' => 'Validation Error',
                    'message' => $e->getMessage(),
                    'fields' => $e->errors()
                ]
            ], Response::HTTP_BAD_REQUEST);
        });

        $exceptions->render(function (AuthenticationException $e) {
            return response([
                'error' => [
                    'type' => 'Authentication Error',
                    'message' => 'You need to be logged in to perform this action.'
                ],
            ]);
        });
    })->create();
