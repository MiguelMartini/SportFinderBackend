<?php

use App\Http\Controllers\API\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get('users', [UsersController::class, 'index']);
Route::post('users', [UsersController::class, 'store']); 
Route::patch('users/edit/{id}', [UsersController::class, 'update']); 