<?php

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\ValidToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('users', [UsersController::class, 'index']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function(){
    Route::delete('users/{id}', [UsersController::class, 'destroy']); 
    Route::patch('users/edit/{id}', [UsersController::class, 'update']); 
});