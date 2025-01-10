<?php

use App\Http\Middleware\JsonApiMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            JsonApiMiddleware::class
        ]);
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
                    'message' => 'You need to login before you can perform this action.'
                ],
            ], Response::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (AuthorizationException $e) {
            return response([
                'error' => [
                    'type' => 'Authorization Error',
                    'message' => 'You\'re logged in, but aren\'t authorized to perform this action.'
                ]
            ], Response::HTTP_FORBIDDEN);
        });

        $exceptions->render(function (NotFoundHttpException | RouteNotFoundException $e) {
            return response([
                'error' => [
                    'type' => 'Not Found Error',
                    'message' => 'The route you were looking for doesn\'t seem to be a valid one...',
                ]
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (Exception $e) {
            if (app()->hasDebugModeEnabled()) {
                return response([
                    'error' => [
                        'type' => 'Uncaught Error',
                        'class' => get_class($e),
                        'message' => $e->getMessage()
                    ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            } else {
                return response([
                    'error' => [
                        'type' => 'Server Error',
                        'message' => 'Ohno! There was an error on our end...'
                    ]
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    })->create();
