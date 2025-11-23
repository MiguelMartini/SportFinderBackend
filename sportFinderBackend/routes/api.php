<?php

use App\Http\Controllers\API\AreasEsportivasController;
use App\Http\Controllers\API\ImagensAreasController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\ValidToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function(){

    // usuários
    Route::delete('users/{id}', [UsersController::class, 'destroy']); 
    Route::patch('users/edit/{id}', [UsersController::class, 'update']); 
    Route::get('users/{id}', [UsersController::class, 'show']); 

    // areas esportivas
    Route::get('areas', [AreasEsportivasController::class, 'indexAll']);
    Route::get('areas/{id}', [AreasEsportivasController::class, 'show']);
    Route::get('imagens', [ImagensAreasController::class, 'index']);

    Route::middleware(['role:admin'])->group(function(){
        Route::get('areasadmin', [AreasEsportivasController::class, 'index']);
        Route::post('areas', [AreasEsportivasController::class, 'store']);
        Route::delete('areas/{id}', [AreasEsportivasController::class, 'destroy']);
        Route::patch('areas/edit/{id}', [AreasEsportivasController::class, 'update']);
        
    });
    Route::post('logout', [AuthController::class, 'logout']);
});