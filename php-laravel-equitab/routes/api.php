<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

        Route::singleton('user', \App\Http\Controllers\Api\UserController::class)->except('edit');

        Route::group(['prefix' => 'friends/requests'], function() {
            Route::get('/', [\App\Http\Controllers\Api\FriendRequestController::class, 'index']);
            Route::post('{friend}', [\App\Http\Controllers\Api\FriendRequestController::class, 'store']);
            Route::delete('{friend}', [\App\Http\Controllers\Api\FriendRequestController::class, 'destroy']);
        });

        Route::apiResource('friends', \App\Http\Controllers\Api\FriendController::class)->except(['store', 'update']);
    });
});
