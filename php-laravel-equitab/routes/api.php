<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::post('auth/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('auth/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

        Route::singleton('profile', \App\Http\Controllers\Api\ProfileController::class)->except('edit');

        Route::group(['prefix' => 'friends/requests'], function() {
            Route::get('/', [\App\Http\Controllers\Api\FriendRequestController::class, 'index']);
            Route::post('{friend}', [\App\Http\Controllers\Api\FriendRequestController::class, 'store']);
            Route::delete('{friend}', [\App\Http\Controllers\Api\FriendRequestController::class, 'destroy']);
        });

        Route::apiResource('friends', \App\Http\Controllers\Api\FriendController::class)->except(['store', 'update']);

        Route::group(['middleware' => [\App\Http\Middleware\EnsureBelongsToLedger::class]], function() {
            Route::apiResource('ledgers', \App\Http\Controllers\Api\LedgerController::class);
        });
    });
});
