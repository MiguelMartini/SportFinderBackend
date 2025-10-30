<?php

use App\Http\Controllers\API\AreasEsportivasController;
use App\Http\Controllers\API\ImagensAreasController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\ValidToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('users', [UsersController::class, 'index']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function(){
    // usuários
    Route::delete('users/{id}', [UsersController::class, 'destroy']); 
    Route::patch('users/edit/{id}', [UsersController::class, 'update']); 

    // areas esportivas
    Route::get('areas', [AreasEsportivasController::class, 'index']);
    Route::get('areas/{id}', [AreasEsportivasController::class, 'show']);
    Route::get('imagens', [ImagensAreasController::class, 'index']);

    Route::middleware(['role:admin'])->group(function(){
        Route::post('areas', [AreasEsportivasController::class, 'store']);
        Route::delete('areas/{id}', [AreasEsportivasController::class, 'destroy']);
        Route::patch('areas/edit/{id}', [AreasEsportivasController::class, 'update']);
        
    });
});