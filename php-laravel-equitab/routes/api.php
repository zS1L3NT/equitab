<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
        });
    });

    Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
        Route::get('/', [\App\Http\Controllers\Api\UserController::class, 'show']);
        Route::put('/', [\App\Http\Controllers\Api\UserController::class, 'update']);
    });
});
