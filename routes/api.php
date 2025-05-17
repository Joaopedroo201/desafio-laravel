<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgot']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/admin', [AdminUserController::class, 'index']);
        Route::get('/admin/metrics', [AdminUserController::class, 'metrics']);
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);
    });

    Route::middleware('admin')->group(function () {
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });
});
