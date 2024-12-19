<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookLoanController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;


// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::get('users/check-email/{email}', [UserController::class, 'checkEmail']);
Route::put('users/reset-password', [UserController::class, 'resetPassword']);

// Protected routes
Route::middleware('auth:sanctum', 'throttle:60,1')->group(function () {
    
    Route::apiResource('books', BookController::class)->middleware('auth:sanctum');
    
    Route::prefix('loans')->group(function () {
        Route::get('/', [BookLoanController::class, 'index'])->middleware('auth:sanctum');
        Route::post('/borrow', [BookLoanController::class, 'borrowBook'])->middleware('auth:sanctum');
        Route::put('/{loan}/return', [BookLoanController::class, 'returnBook'])->middleware('auth:sanctum');
    });
    
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'getAll'])->middleware('auth:sanctum');
        Route::get('/{user}', [UserController::class, 'getById'])->middleware('auth:sanctum');
        Route::put('/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');
        Route::get('/email/{email}', [UserController::class, 'findByEmail'])->middleware('auth:sanctum');
        Route::delete('/{user}', [UserController::class, 'delete'])->middleware('auth:sanctum');
    });
});