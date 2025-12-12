<?php

use App\Http\Controllers\API\AreasEsportivasController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api-public')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum', 'throttle:api-auth'])->group(function(){
    Route::get('me', [AuthController::class, 'me']);

    // usuários
    Route::delete('users/{id}', [UsersController::class, 'destroy']); 
    Route::patch('users/edit/{id}', [UsersController::class, 'update']); 
    Route::get('users/{id}', [UsersController::class, 'show']); 

    // areas esportivas
    Route::get('areas', [AreasEsportivasController::class, 'indexAll']);
    Route::get('areas/{id}', [AreasEsportivasController::class, 'show']);

    Route::middleware(['role:admin', 'throttle:api-auth'])->group(function(){
        Route::get('areasadmin', [AreasEsportivasController::class, 'index']);
        Route::post('areas', [AreasEsportivasController::class, 'store']);
        Route::delete('areas/{id}', [AreasEsportivasController::class, 'destroy']);
        Route::patch('areas/edit/{id}', [AreasEsportivasController::class, 'update']);
        
    });
    Route::post('logout', [AuthController::class, 'logout']);
});