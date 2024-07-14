<?php

use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\LinkImageController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::patch('/users/{user}', [UserController::class, 'update']);

    Route::post('/user-image', [UserImageController::class, 'store']);

    Route::get('/links', [LinkController::class, 'index']);
    Route::post('/link', [LinkController::class, 'store']);
    Route::patch('/links/{link}', [LinkController::class, 'update']);
    Route::delete('/links/{link}', [LinkController::class, 'destroy']);

    Route::post('/link-image/{link}', [LinkImageController::class, 'store']);

    // Route::get('themes', [ThemeController::class, 'index']);
    Route::patch('/themes', [ThemeController::class, 'update']);
});
