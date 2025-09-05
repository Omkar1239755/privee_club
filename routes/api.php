<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController};

// unauthorised routes
Route::post('register-user',[AuthController::class,'registerUSer']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
